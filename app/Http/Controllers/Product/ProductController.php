<?php

namespace App\Http\Controllers\Product;


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
use Illuminate\Support\Str;  // ✅ only once
use Picqer\Barcode\BarcodeGeneratorHTML;
use GuzzleHttp\Client;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::all();

        $totalSellable = $products->where('quantity', '>', 0)->count();
        $totalWorthSales = $products->sum(fn($product) => $product->quantity * $product->selling_price);
        $totalWorthCost = $products->sum(fn($product) => $product->quantity * $product->buying_price);

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
            $request->merge(['code' => $this->generateUniqueCode()]);
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

            if ($request->hasFile('product_image')) {
                $file = $request->file('product_image');
                $filename = hexdec(uniqid()).'.'.$file->getClientOriginalExtension();

                if ($file->isValid()) {
                    $file->storeAs('products/', $filename, 'public');
                    $product->update(['product_image' => $filename]);
                } else {
                    DB::rollBack();
                    return back()->withErrors(['product_image' => 'Invalid image file']);
                }
            }

            DB::commit();

            return $request->expectsJson()
                ? response()->json(['success' => true, 'product' => $product])
                : redirect()->back()->with('success', 'Product has been created with code: '.$product->code);

        } catch (\Exception $e) {
            DB::rollBack();
            return $request->expectsJson()
                ? response()->json(['success' => false, 'message' => $e->getMessage()], 500)
                : back()->withErrors(['error' => 'Something went wrong: '.$e->getMessage()]);
        }
    }

    private function generateUniqueCode()
    {
        do {
            $code = 'PC'.strtoupper(uniqid());
        } while (Product::where('code', $code)->exists());

        return $code;
    }

    public function show(Product $product)
    {
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
            if ($product->product_image) {
                Storage::disk('public')->delete('products/'.$product->product_image);
            }

            $file = $request->file('product_image');
            $fileName = hexdec(uniqid()).'.'.$file->getClientOriginalExtension();
            $file->storeAs('products/', $fileName, 'public');

            $product->update(['product_image' => $fileName]);
        }

        return redirect()->route('products.index')->with('success', 'Product has been updated!');
    }

    public function destroy(Product $product)
    {
        if ($product->product_image) {
            Storage::disk('public')->delete('products/'.$product->product_image);
        }

        $product->delete();

        return redirect()->route('products.index')->with('success', 'Product has been deleted!');
    }

    public function search(Request $request)
    {
        $search = $request->query('search');

        $products = Product::query()
            ->when($search, fn($query, $search) => $query->where('name', 'like', "%{$search}%")
                ->orWhere('code', 'like', "%{$search}%"))
            ->take(10)
            ->get(['id', 'name', 'code', 'buying_price', 'selling_price', 'quantity', 'product_image']);

        $products = $products->map(fn(Product $product) => [
            'id' => $product->id,
            'name' => $product->name,
            'code' => $product->code,
            'buying_price' => $product->buying_price,
            'selling_price' => $product->selling_price,
            'quantity' => $product->quantity,
            'product_image_url' => $product->product_image
                ? asset('storage/products/'.$product->product_image)
                : asset('assets/img/products/default.webp'),
        ]);

        return response()->json(['success' => true, 'products' => $products]);
    }


    public function sync(Request $request)
    {
        $userId = auth()->id();

        // 1️⃣ Fetch integration
        $integration = DB::table('user_integrations')
            ->where('user_id', $userId)
            ->where('platform', 'woocommerce')
            ->first();

        if (!$integration) {
            return back()->withErrors(['error' => 'Integration not found for your account.']);
        }

        // 2️⃣ Map columns
        $columnsMap = [
            'api_url' => 'store_name',
            'api_key' => 'api_key',
            'api_secret' => 'api_secret',
        ];

        $apiUrl = $integration->{$columnsMap['api_url']} ?? null;
        $apiKey = $integration->{$columnsMap['api_key']} ?? null;
        $apiSecret = $integration->{$columnsMap['api_secret']} ?? null;

        // Ensure full URL
        if ($apiUrl && !str_starts_with($apiUrl, 'http')) {
            $apiUrl = 'https://' . $apiUrl;
        }

        if (!$apiUrl || !$apiKey || !$apiSecret) {
            return back()->withErrors(['error' => 'Integration credentials are missing or incorrect.']);
        }

        try {
            // 3️⃣ WooCommerce API
            $endpoint = rtrim($apiUrl, '/') . '/wp-json/wc/v3/products?per_page=100';

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $endpoint);
            curl_setopt($ch, CURLOPT_USERPWD, $apiKey . ':' . $apiSecret);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // dev only
            $response = curl_exec($ch);

            if (curl_errno($ch)) {
                throw new \Exception('cURL error: ' . curl_error($ch));
            }

            curl_close($ch);

            $products = json_decode($response, true);

            if (!$products || !is_array($products)) {
                throw new \Exception('Invalid response from WooCommerce.');
            }

            // 4️⃣ Save products
            foreach ($products as $p) {
                $slug = Str::slug($p['name'] ?? 'Unnamed');

                // Ensure slug uniqueness
                $slugOriginal = $slug;
                $counter = 1;
                while (Product::where('slug', $slug)->exists()) {
                    $slug = $slugOriginal . '-' . $counter;
                    $counter++;
                }

                // Fetch first product image if exists
                $productImageUrl = $p['images'][0]['src'] ?? null;

                Product::updateOrCreate(
                    ['code' => $p['sku'] ?? $p['id']],
                    [
                        'name' => $p['name'] ?? 'Unnamed',
                        'slug' => $slug,
                        'quantity' => isset($p['stock_quantity']) ? (int)$p['stock_quantity'] : 0,
                        'selling_price' => isset($p['price']) ? (float)$p['price'] : 0,
                        'buying_price' => isset($p['regular_price']) ? (float)$p['regular_price'] : 0,
                        'quantity_alert' => 0, // default value for NOT NULL column
                        'product_image' => $productImageUrl, // save image URL
                    ]
                );
            }

            return back()->with('success', 'Products synced successfully with images!');

        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Sync failed: ' . $e->getMessage()]);
        }
    }
}