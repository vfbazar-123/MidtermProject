<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Account;
use App\Models\Transaction;

class AccountSeeder extends Seeder
{
    /**
     * Run the database seeders.
     */
    public function run(): void
    {
        // Create sample accounts
        $cashAccount = Account::create([
            'account_number' => 'ACC-001-CASH',
            'account_name' => 'Main Cash Account',
            'account_type' => 'Cash',
            'balance' => 50000.00,
            'status' => 'active',
            'description' => 'Primary cash register account'
        ]);

        $bankAccount = Account::create([
            'account_number' => 'ACC-002-BANK',
            'account_name' => 'Business Bank Account',
            'account_type' => 'Bank',
            'balance' => 150000.00,
            'status' => 'active',
            'description' => 'Main business checking account'
        ]);

        $creditAccount = Account::create([
            'account_number' => 'ACC-003-CC',
            'account_name' => 'Corporate Credit Card',
            'account_type' => 'Credit Card',
            'balance' => 25000.00,
            'status' => 'active',
            'description' => 'Corporate credit card account'
        ]);

        // Create sample transactions
        Transaction::create([
            'account_id' => $cashAccount->id,
            'transaction_type' => 'credit',
            'amount' => 5000.00,
            'description' => 'Opening balance - Cash sale',
            'reference_number' => 'CASH-001',
            'transaction_date' => now()->subDays(5),
            'status' => 'completed'
        ]);

        Transaction::create([
            'account_id' => $bankAccount->id,
            'transaction_type' => 'credit',
            'amount' => 10000.00,
            'description' => 'Initial deposit',
            'reference_number' => 'DEP-001',
            'transaction_date' => now()->subDays(4),
            'status' => 'completed'
        ]);

        Transaction::create([
            'account_id' => $cashAccount->id,
            'transaction_type' => 'debit',
            'amount' => 1000.00,
            'description' => 'Office supplies purchase',
            'reference_number' => 'EXP-001',
            'transaction_date' => now()->subDays(3),
            'status' => 'completed'
        ]);

        Transaction::create([
            'account_id' => $creditAccount->id,
            'transaction_type' => 'credit',
            'amount' => 8000.00,
            'description' => 'Purchase - Parts inventory',
            'reference_number' => 'PUR-001',
            'transaction_date' => now()->subDays(2),
            'status' => 'pending'
        ]);
    }
}
