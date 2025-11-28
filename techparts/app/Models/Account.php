<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Account extends Model
{
    use HasFactory;

    protected $fillable = [
        'account_number',
        'account_name',
        'account_type',
        'balance',
        'status',
        'description'
    ];

    protected $casts = [
        'balance' => 'decimal:2',
    ];

    /**
     * Get the transactions associated with this account.
     */
    public function transactions()
    {
        return $this->hasMany(Transaction::class, 'account_id');
    }

    /**
     * Get the total debit amount for this account.
     */
    public function getTotalDebit()
    {
        return $this->transactions()
            ->where('transaction_type', 'debit')
            ->sum('amount');
    }

    /**
     * Get the total credit amount for this account.
     */
    public function getTotalCredit()
    {
        return $this->transactions()
            ->where('transaction_type', 'credit')
            ->sum('amount');
    }
}
