<?php

namespace App\Http\Controllers;

use App\Http\Requests\Supplier\StoreSupplierRequest;
use App\Http\Requests\Supplier\UpdateSupplierRequest;
use App\Models\Supplier;
use App\Models\SupplierCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class SupplierController extends Controller
{
    public function index()
    {
        $suppliers = Supplier::all();

        return view('suppliers.index', [
            'suppliers' => $suppliers,
        ]);
    }

    public function create()
    {
        $supplierCategories = SupplierCategory::all();

        return view('suppliers.create', [
            'supplierCategories' => $supplierCategories,
        ]);
    }

    public function store(StoreSupplierRequest $request)
    {
        $supplier = Supplier::create($request->all());

        /**
         * Handle upload an image
         */
        if ($request->hasFile('photo')) {
            $file = $request->file('photo');
            $filename = hexdec(uniqid()).'.'.$file->getClientOriginalExtension();

            $file->storeAs('suppliers/', $filename, 'public');
            $supplier->update([
                'photo' => $filename,
            ]);
        }

        return redirect()
            ->route('suppliers.index')
            ->with('success', 'New supplier has been created!');
    }

    public function show(Supplier $supplier)
    {
        $supplier->loadMissing('purchases')->get();

        return view('suppliers.show', [
            'supplier' => $supplier,
        ]);
    }

    public function edit(Supplier $supplier)
    {
        $supplierCategories = SupplierCategory::all();

        return view('suppliers.edit', [
            'supplier' => $supplier,
            'supplierCategories' => $supplierCategories,
        ]);
    }

    public function update(UpdateSupplierRequest $request, Supplier $supplier)
    {
        $data = $request->except('photo');
        $data['status'] = $request->has('status') ? 1 : 0;

        $supplier->update($data);

        /**
         * Handle upload image with Storage.
         */
        if ($request->hasFile('photo')) {

            // Delete Old Photo
            if ($supplier->photo) {
                unlink(public_path('storage/suppliers/').$supplier->photo);
            }

            // Prepare New Photo
            $file = $request->file('photo');
            $fileName = hexdec(uniqid()).'.'.$file->getClientOriginalExtension();

            // Store an image to Storage
            $file->storeAs('suppliers/', $fileName, 'public');

            // Save DB
            $supplier->update([
                'photo' => $fileName,
            ]);
        }

        return redirect()
            ->route('suppliers.index')
            ->with('success', 'Supplier has been updated!');
    }

    public function destroy(Supplier $supplier)
    {
        /**
         * Delete photo if exists.
         */
        if ($supplier->photo) {
            unlink(public_path('storage/suppliers/').$supplier->photo);
        }

        $supplier->delete();

        return redirect()
            ->route('suppliers.index')
            ->with('success', 'Supplier has been deleted!');
    }

    public function supplierCategoryIndex(Request $request)
    {
        $categories = SupplierCategory::query()
            ->when($request->query('search'), function ($query, $search) {
                $query->where('name', 'like', "%{$search}%");
            })
            ->latest()
            ->get(['id', 'name']);

        return response()->json([
            'success' => true,
            'categories' => $categories,
        ]);
    }

    public function supplierCategoryStore(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|min:3|unique:supplier_categories,name',
        ]);

        $category = SupplierCategory::create([
            'name' => $validated['name'],
            'slug' => Str::slug($validated['name']),
        ]);

        return response()->json([
            'success' => true,
            'category' => $category,
        ]);
    }

    public function supplierCategoryDestroy(SupplierCategory $supplierCategory)
    {
        $supplierCategory->delete();

        return response()->json([
            'success' => true,
        ]);
    }
}
