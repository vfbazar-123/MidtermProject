<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Models\Transaction;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    /**
     * Display a listing of all transactions.
     */
    public function index()
    {
        $transactions = Transaction::with('account')
                                   ->orderBy('transaction_date', 'desc')
                                   ->paginate(20);
        return view('transactions.index', compact('transactions'));
    }

    /**
     * Show the form for creating a new transaction.
     */
    public function create()
    {
        $accounts = Account::where('status', 'active')->get();
        return view('transactions.create', compact('accounts'));
    }

    /**
     * Store a newly created transaction in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'account_id' => 'required|exists:accounts,id',
            'transaction_type' => 'required|in:debit,credit',
            'amount' => 'required|numeric|min:0.01',
            'description' => 'nullable|string|max:1000',
            'reference_number' => 'nullable|string|unique:transactions',
            'transaction_date' => 'required|date',
            'status' => 'required|in:pending,completed,cancelled'
        ]);

        $account = Account::find($validated['account_id']);

        // Update account balance
        if ($validated['transaction_type'] === 'credit') {
            $account->balance += $validated['amount'];
        } else {
            $account->balance -= $validated['amount'];
        }

        $account->save();

        Transaction::create($validated);

        return redirect()->route('transactions.index')
                        ->with('success', 'Transaction created successfully.');
    }

    /**
     * Display the specified transaction.
     */
    public function show(Transaction $transaction)
    {
        $transaction->load('account');
        return view('transactions.show', compact('transaction'));
    }

    /**
     * Show the form for editing the specified transaction.
     */
    public function edit(Transaction $transaction)
    {
        $accounts = Account::where('status', 'active')->get();
        return view('transactions.edit', compact('transaction', 'accounts'));
    }

    /**
     * Update the specified transaction in storage.
     */
    public function update(Request $request, Transaction $transaction)
    {
        // Prevent updating completed or cancelled transactions
        if (in_array($transaction->status, ['completed', 'cancelled'])) {
            return redirect()->route('transactions.show', $transaction)
                            ->with('error', 'Cannot update completed or cancelled transactions.');
        }

        $validated = $request->validate([
            'account_id' => 'required|exists:accounts,id',
            'transaction_type' => 'required|in:debit,credit',
            'amount' => 'required|numeric|min:0.01',
            'description' => 'nullable|string|max:1000',
            'reference_number' => 'nullable|string|unique:transactions,reference_number,' . $transaction->id,
            'transaction_date' => 'required|date',
            'status' => 'required|in:pending,completed,cancelled'
        ]);

        // Revert old transaction from account balance
        $oldAccount = $transaction->account;
        if ($transaction->transaction_type === 'credit') {
            $oldAccount->balance -= $transaction->amount;
        } else {
            $oldAccount->balance += $transaction->amount;
        }
        $oldAccount->save();

        // Apply new transaction to account balance
        if ($validated['account_id'] !== $transaction->account_id) {
            $newAccount = Account::find($validated['account_id']);
        } else {
            $newAccount = $oldAccount;
        }

        if ($validated['transaction_type'] === 'credit') {
            $newAccount->balance += $validated['amount'];
        } else {
            $newAccount->balance -= $validated['amount'];
        }
        $newAccount->save();

        $transaction->update($validated);

        return redirect()->route('transactions.show', $transaction)
                        ->with('success', 'Transaction updated successfully.');
    }

    /**
     * Remove the specified transaction from storage.
     */
    public function destroy(Transaction $transaction)
    {
        $account = $transaction->account;

        // Revert the transaction from account balance
        if ($transaction->transaction_type === 'credit') {
            $account->balance -= $transaction->amount;
        } else {
            $account->balance += $transaction->amount;
        }
        $account->save();

        $transaction->delete();

        return redirect()->route('transactions.index')
                        ->with('success', 'Transaction deleted successfully.');
    }

    /**
     * Get transactions by account.
     */
    public function byAccount(Account $account)
    {
        $transactions = $account->transactions()
                               ->orderBy('transaction_date', 'desc')
                               ->paginate(20);
        return view('transactions.account', compact('account', 'transactions'));
    }
}
