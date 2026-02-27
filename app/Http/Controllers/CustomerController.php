<?php

namespace App\Http\Controllers;

use App\Http\Requests\Customer\StoreCustomerRequest;
use App\Http\Requests\Customer\UpdateCustomerRequest;
use App\Models\Customer;
use App\Models\CustomerCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CustomerController extends Controller
{
    public function index()
    {
        return view('customers.index');
    }

    public function create()
    {
        return view('customers.create', [
            'customerCategories' => CustomerCategory::all(),
        ]);
    }

    public function store(StoreCustomerRequest $request)
    {
        $customer = Customer::create($request->all());

        /**
         * Handle upload an image
         */
        if ($request->hasFile('photo')) {
            $file = $request->file('photo');
            $filename = hexdec(uniqid()).'.'.$file->getClientOriginalExtension();

            $file->storeAs('customers/', $filename, 'public');
            $customer->update([
                'photo' => $filename,
            ]);
        }

        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'customer' => $customer,
            ]);
        }

        return redirect()
            ->route('customers.index')
            ->with('success', 'New customer has been created!');
    }

    public function show(Customer $customer)
    {
        $customer->loadMissing(['quotations', 'orders'])->get();

        return view('customers.show', [
            'customer' => $customer,
        ]);
    }

    public function edit(Customer $customer)
    {
        return view('customers.edit', [
            'customer' => $customer,
            'customerCategories' => CustomerCategory::all(),
        ]);
    }

    public function customerCategoryIndex(Request $request)
    {
        $categories = CustomerCategory::query()
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

    public function customerCategoryStore(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|min:3|unique:customer_categories,name',
        ]);

        $category = CustomerCategory::create([
            'name' => $validated['name'],
            'slug' => Str::slug($validated['name']),
        ]);

        return response()->json([
            'success' => true,
            'category' => $category,
        ]);
    }

    public function customerCategoryDestroy(CustomerCategory $customerCategory)
    {
        $customerCategory->delete();

        return response()->json([
            'success' => true,
        ]);
    }

    public function update(UpdateCustomerRequest $request, Customer $customer)
    {
        //
        $customer->update($request->except('photo'));

        if ($request->hasFile('photo')) {

            // Delete Old Photo
            if ($customer->photo) {
                unlink(public_path('storage/customers/').$customer->photo);
            }

            // Prepare New Photo
            $file = $request->file('photo');
            $fileName = hexdec(uniqid()).'.'.$file->getClientOriginalExtension();

            // Store an image to Storage
            $file->storeAs('customers/', $fileName, 'public');

            // Save DB
            $customer->update([
                'photo' => $fileName,
            ]);
        }

        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'customer' => $customer,
            ]);
        }

        return redirect()
            ->route('customers.index')
            ->with('success', 'Customer has been updated!');
    }

    public function destroy(Customer $customer)
    {
        if ($customer->photo) {
            unlink(public_path('storage/customers/').$customer->photo);
        }

        $customer->delete();

        return redirect()
            ->back()
            ->with('success', 'Customer has been deleted!');
    }
}
