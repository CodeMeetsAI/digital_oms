<?php

namespace App\Http\Controllers\Product;

use App\Http\Controllers\Controller;
use App\Http\Requests\Product\StoreProductRequest;
use App\Http\Requests\Product\UpdateProductRequest;
use App\Models\Bundle;
use App\Models\Category;
use App\Models\Product;
use App\Models\Unit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Picqer\Barcode\BarcodeGeneratorHTML;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::all();

        $totalSellable = $products->where('quantity', '>', 0)->count();
        $totalWorthSales = $products->sum(function ($product) {
            return $product->quantity * $product->selling_price;
        });
        $totalWorthCost = $products->sum(function ($product) {
            return $product->quantity * $product->buying_price;
        });

        $categories = Category::all(['id', 'name']);
        $units = Unit::all(['id', 'name']);

        return view('products.index', [
            'totalSellable' => $totalSellable,
            'totalWorthSales' => $totalWorthSales,
            'totalWorthCost' => $totalWorthCost,
            'categories' => $categories,
            'units' => $units,
        ]);
    }

    public function create(Request $request)
    {
        $categories = Category::all(['id', 'name']);
        $units = Unit::all(['id', 'name']);

        if ($request->has('category')) {
            $categories = Category::whereSlug($request->get('category'))->get();
        }

        if ($request->has('unit')) {
            $units = Unit::whereSlug($request->get('unit'))->get();
        }

        return view('products.create', [
            'categories' => $categories,
            'units' => $units,
        ]);
    }

    public function store(StoreProductRequest $request)
    {
        $existingProduct = Product::where('code', $request->get('code'))->first();

        if ($existingProduct) {
            $newCode = $this->generateUniqueCode();

            $request->merge(['code' => $newCode]);
        }

        try {
            DB::beginTransaction();

            $product = Product::create($request->all());

            $product->simpleInventory()->create([
                'hs_code' => $request->hs_code,
                'product_type' => $request->product_type,
                'mrp_exclusive_tax' => $request->has('mrp_exclusive_tax'),
                'third_schedule' => $request->has('third_schedule'),
                'mrp' => $request->mrp,
                'weight' => $request->weight,
                'quantity_sync' => $request->has('quantity_sync'),
                'barcode' => $request->barcode,
            ]);

            /**
             * Handle image upload
             */
            if ($request->hasFile('product_image')) {
                $file = $request->file('product_image');
                $filename = hexdec(uniqid()).'.'.$file->getClientOriginalExtension();

                // Validate file before uploading
                if ($file->isValid()) {
                    $file->storeAs('products/', $filename, 'public');
                    $product->update([
                        'product_image' => $filename,
                    ]);
                } else {
                    DB::rollBack();

                    return back()->withErrors(['product_image' => 'Invalid image file']);
                }
            }

            DB::commit();

            if ($request->expectsJson()) {
                return response()->json([
                    'success' => true,
                    'product' => $product,
                ]);
            }

            return redirect()
                ->back()
                ->with('success', 'Product has been created with code: '.$product->code);

        } catch (\Exception $e) {
            DB::rollBack();
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Something went wrong while creating the product.',
                ], 500);
            }

            return back()->withErrors(['error' => 'Something went wrong while creating the product: '.$e->getMessage()]);
        }
    }

    // Helper method to generate a unique product code
    private function generateUniqueCode()
    {
        do {
            $code = 'PC'.strtoupper(uniqid());
        } while (Product::where('code', $code)->exists());

        return $code;
    }

    public function show(Product $product)
    {
        // Generate a barcode
        $generator = new BarcodeGeneratorHTML;

        $barcode = $generator->getBarcode($product->code, $generator::TYPE_CODE_128);

        return view('products.show', [
            'product' => $product,
            'barcode' => $barcode,
        ]);
    }

    public function edit(Product $product)
    {
        return view('products.edit', [
            'categories' => Category::all(),
            'units' => Unit::all(),
            'product' => $product,
        ]);
    }

    public function update(UpdateProductRequest $request, Product $product)
    {
        $product->update($request->except('product_image'));

        if ($request->hasFile('product_image')) {

            // Delete old image if exists
            if ($product->product_image) {
                Storage::disk('public')->delete('products/'.$product->product_image);
            }

            // Prepare new image
            $file = $request->file('product_image');
            $fileName = hexdec(uniqid()).'.'.$file->getClientOriginalExtension();

            // Store new image to public storage
            $file->storeAs('products/', $fileName, 'public');

            // Save new image name to database
            $product->update([
                'product_image' => $fileName,
            ]);
        }

        return redirect()
            ->route('products.index')
            ->with('success', 'Product has been updated!');
    }

    public function destroy(Product $product)
    {
        /**
         * Delete photo if exists.
         */
        if ($product->product_image) {
            Storage::disk('public')->delete('products/'.$product->product_image);
        }

        $product->delete();

        return redirect()
            ->route('products.index')
            ->with('success', 'Product has been deleted!');
    }

    public function search(Request $request)
    {
        $search = $request->query('search');

        $products = Product::query()
            ->when($search, function ($query, $search) {
                $query->where('name', 'like', "%{$search}%")
                    ->orWhere('code', 'like', "%{$search}%");
            })
            ->take(10)
            ->get(['id', 'name', 'code', 'buying_price', 'selling_price', 'quantity', 'product_image']);

        $products = $products->map(function (Product $product) {
            return [
                'id' => $product->id,
                'name' => $product->name,
                'code' => $product->code,
                'buying_price' => $product->buying_price,
                'selling_price' => $product->selling_price,
                'quantity' => $product->quantity,
                'product_image_url' => $product->product_image
                    ? asset('storage/products/'.$product->product_image)
                    : asset('assets/img/products/default.webp'),
            ];
        });

        return response()->json([
            'success' => true,
            'products' => $products,
        ]);
    }

    public function storeBundle(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'sku' => 'nullable|string|max:255|unique:products,code',
            'sku_autogenerate' => 'nullable|in:on,off,1,0,true,false',
            'selling_price' => 'required|numeric|min:0',
            'category_id' => 'nullable|exists:categories,id',
            'unit_id' => 'nullable|exists:units,id',
            'description' => 'nullable|string',
            'quantity_sync' => 'nullable|in:on,off,1,0,true,false',
            'product_image' => 'nullable|image|max:2048',
            'selected_products' => 'required',
        ]);

        $selectedProducts = json_decode($validated['selected_products'], true);

        if (! is_array($selectedProducts) || count($selectedProducts) === 0) {
            return response()->json([
                'success' => false,
                'message' => 'Please add at least one product.',
            ], 422);
        }

        $items = collect($selectedProducts)->map(function ($item) {
            return [
                'id' => $item['id'] ?? null,
                'quantity' => $item['quantity'] ?? null,
            ];
        });

        if ($items->contains(fn ($item) => empty($item['id']) || empty($item['quantity']) || (int) $item['quantity'] < 1)) {
            return response()->json([
                'success' => false,
                'message' => 'Bundle items are invalid.',
            ], 422);
        }

        $sku = $validated['sku'] ?? null;
        $autogenerate = filter_var($validated['sku_autogenerate'] ?? false, FILTER_VALIDATE_BOOLEAN);

        if (! $sku && ! $autogenerate) {
            return response()->json([
                'success' => false,
                'message' => 'SKU is required unless autogenerate is checked.',
            ], 422);
        }

        if ($autogenerate && ! $sku) {
            $sku = 'BND-'.strtoupper(Str::random(8));
        }

        $productIds = $items->pluck('id')->values()->all();
        $products = Product::whereIn('id', $productIds)->get(['id', 'buying_price']);
        $productsById = $products->keyBy('id');

        $totalCost = 0;
        foreach ($items as $item) {
            $product = $productsById->get((int) $item['id']);
            if (! $product) {
                return response()->json([
                    'success' => false,
                    'message' => 'One or more products were not found.',
                ], 422);
            }
            $totalCost += ($product->buying_price * (int) $item['quantity']);
        }

        DB::beginTransaction();

        try {
            $product = Product::create([
                'name' => $validated['name'],
                'slug' => Str::slug($validated['name']),
                'code' => $sku,
                'quantity' => 0,
                'buying_price' => $totalCost,
                'selling_price' => $validated['selling_price'],
                'quantity_alert' => 0,
                'category_id' => $validated['category_id'] ?? null,
                'unit_id' => $validated['unit_id'] ?? null,
                'notes' => $validated['description'] ?? null,
            ]);

            if ($request->hasFile('product_image')) {
                $file = $request->file('product_image');
                $filename = hexdec(uniqid()).'.'.$file->getClientOriginalExtension();
                $file->storeAs('products/', $filename, 'public');
                $product->update(['product_image' => $filename]);
            }

            $bundle = Bundle::create([
                'product_id' => $product->id,
                'quantity_sync' => filter_var($validated['quantity_sync'] ?? true, FILTER_VALIDATE_BOOLEAN),
                'total_cost' => $totalCost,
            ]);

            foreach ($items as $item) {
                $bundle->products()->attach($item['id'], ['quantity' => $item['quantity']]);
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'product' => $product,
            ]);
        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'success' => false,
                'message' => 'Error creating bundle.',
            ], 500);
        }
    }
}
