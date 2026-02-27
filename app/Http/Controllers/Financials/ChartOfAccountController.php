<?php

namespace App\Http\Controllers\Financials;

use App\Http\Controllers\Controller;
use App\Models\ChartOfAccount;
use Illuminate\Http\Request;

class ChartOfAccountController extends Controller
{
    public function index()
    {
        $activeCount = ChartOfAccount::where('status', true)->count();
        $inactiveCount = ChartOfAccount::where('status', false)->count();
        $totalBalance = ChartOfAccount::sum('balance');

        return view('financials.chart-of-accounts.index', [
            'activeCount' => $activeCount,
            'inactiveCount' => $inactiveCount,
            'totalBalance' => $totalBalance,
        ]);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'nullable|string|max:50',
            'type' => 'required|in:Asset,Liability,Equity,Revenue,Expense',
            'description' => 'nullable|string',
            'balance' => 'nullable|numeric',
            'status' => 'boolean',
            'payment_mode' => 'nullable|string',
            'assigned_user' => 'nullable|string',
        ]);

        // Checkbox handling for status
        $validatedData['status'] = $request->has('status');

        ChartOfAccount::create($validatedData);

        return redirect()->route('financials.chart-of-accounts')->with('success', 'Account Created Successfully.');
    }

    public function update(Request $request, $id)
    {
        $account = ChartOfAccount::findOrFail($id);

        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'nullable|string|max:50',
            'type' => 'required|in:Asset,Liability,Equity,Revenue,Expense',
            'description' => 'nullable|string',
            'balance' => 'nullable|numeric',
            'status' => 'boolean',
            'payment_mode' => 'nullable|string',
            'assigned_user' => 'nullable|string',
        ]);

        $validatedData['status'] = $request->has('status');

        $account->update($validatedData);

        return redirect()->route('financials.chart-of-accounts')->with('success', 'Account Updated Successfully.');
    }

    public function destroy($id)
    {
        ChartOfAccount::findOrFail($id)->delete();

        return redirect()->route('financials.chart-of-accounts')->with('success', 'Account Deleted Successfully.');
    }
}
