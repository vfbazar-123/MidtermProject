<?php

namespace App\Http\Controllers;

use App\Models\Account;
use Illuminate\Http\Request;

class AccountController extends Controller
{
    /**
     * Display a listing of all accounts.
     */
    public function index()
    {
        $accounts = Account::paginate(15);
        return view('accounts.index', compact('accounts'));
    }

    /**
     * Show the form for creating a new account.
     */
    public function create()
    {
        return view('accounts.create');
    }

    /**
     * Store a newly created account in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'account_number' => 'required|string|unique:accounts',
            'account_name' => 'required|string|max:255',
            'account_type' => 'required|string|in:Cash,Bank,Credit Card',
            'balance' => 'required|numeric|min:0',
            'status' => 'required|in:active,inactive,closed',
            'description' => 'nullable|string'
        ]);

        Account::create($validated);

        return redirect()->route('accounts.index')
                        ->with('success', 'Account created successfully.');
    }

    /**
     * Display the specified account with its transactions.
     */
    public function show(Account $account)
    {
        $account->load(['transactions' => function($query) {
            $query->orderBy('transaction_date', 'desc');
        }]);
        return view('accounts.show', compact('account'));
    }

    /**
     * Show the form for editing the specified account.
     */
    public function edit(Account $account)
    {
        return view('accounts.edit', compact('account'));
    }

    /**
     * Update the specified account in storage.
     */
    public function update(Request $request, Account $account)
    {
        $validated = $request->validate([
            'account_number' => 'required|string|unique:accounts,account_number,' . $account->id,
            'account_name' => 'required|string|max:255',
            'account_type' => 'required|string|in:Cash,Bank,Credit Card',
            'balance' => 'required|numeric|min:0',
            'status' => 'required|in:active,inactive,closed',
            'description' => 'nullable|string'
        ]);

        $account->update($validated);

        return redirect()->route('accounts.show', $account)
                        ->with('success', 'Account updated successfully.');
    }

    /**
     * Remove the specified account from storage.
     */
    public function destroy(Account $account)
    {
        if ($account->transactions()->exists()) {
            return redirect()->route('accounts.index')
                            ->with('error', 'Cannot delete account with existing transactions.');
        }

        $account->delete();

        return redirect()->route('accounts.index')
                        ->with('success', 'Account deleted successfully.');
    }
}
