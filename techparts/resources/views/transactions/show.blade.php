@extends('layouts')

@section('title', 'Transaction Details - MyStore')

@section('content')
<div class="container-fluid px-3 px-md-5 mt-4">
    <div class="row mb-4">
        <div class="col">
            <h1 style="color: #EE4D2D; font-weight: 700;">💰 Transaction Details</h1>
        </div>
        <div class="col text-end">
            <a href="{{ route('transactions.edit', $transaction) }}" class="btn btn-sm" style="background-color: #FFA500; color: white; border: none;">✏️ Edit</a>
            <a href="{{ route('transactions.index') }}" class="btn btn-sm btn-secondary">← Back to Transactions</a>
        </div>
    </div>

    @if($message = Session::get('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert" style="border-left: 4px solid #28a745;">
            {{ $message }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="row mb-4">
        <div class="col-md-6">
            <div class="card" style="border-top: 4px solid #EE4D2D; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
                <div class="card-body">
                    <h6 class="card-title text-muted">Account</h6>
                    <p class="fs-5">
                        <a href="{{ route('accounts.show', $transaction->account) }}" style="color: #EE4D2D; text-decoration: none; font-weight: 600;">
                            {{ $transaction->account->account_name }}
                        </a>
                    </p>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card" style="border-top: 4px solid #FFA500; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
                <div class="card-body">
                    <h6 class="card-title text-muted">Transaction Type</h6>
                    <p class="fs-5">
                        @if($transaction->transaction_type === 'credit')
                            <span class="badge bg-success">✓ Credit (Deposit)</span>
                        @else
                            <span class="badge bg-danger">✕ Debit (Withdrawal)</span>
                        @endif
                    </p>
                </div>
            </div>
        </div>
    </div>

    <div class="row mb-4">
        <div class="col-md-6">
            <div class="card" style="border-top: 4px solid #28a745; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
                <div class="card-body">
                    <h6 class="card-title text-muted">Amount</h6>
                    <p class="fs-5 fw-bold">
                        @if($transaction->transaction_type === 'credit')
                            <span style="color: #28a745;">+₱{{ number_format($transaction->amount, 2) }}</span>
                        @else
                            <span style="color: #EE4D2D;">-₱{{ number_format($transaction->amount, 2) }}</span>
                        @endif
                    </p>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card" style="border-top: 4px solid #EE4D2D; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
                <div class="card-body">
                    <h6 class="card-title text-muted">Status</h6>
                    <p class="fs-5">
                        @if($transaction->status === 'completed')
                            <span class="badge bg-success">✓ Completed</span>
                        @elseif($transaction->status === 'pending')
                            <span class="badge" style="background-color: #FFA500; color: white;">⧖ Pending</span>
                        @else
                            <span class="badge bg-danger">✕ Cancelled</span>
                        @endif
                    </p>
                </div>
            </div>
        </div>
    </div>

    <div class="row mb-4">
        <div class="col-md-6">
            <div class="card" style="border-top: 4px solid #0d6efd; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
                <div class="card-body">
                    <h6 class="card-title text-muted">Transaction Date</h6>
                    <p class="fs-5">{{ $transaction->transaction_date->format('F d, Y h:i A') }}</p>
                </div>
            </div>
        </div>
        @if($transaction->reference_number)
            <div class="col-md-6">
                <div class="card" style="border-top: 4px solid #6c757d; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
                    <div class="card-body">
                        <h6 class="card-title text-muted">Reference Number</h6>
                        <p class="fs-5 font-monospace">{{ $transaction->reference_number }}</p>
                    </div>
                </div>
            </div>
        @endif
    </div>

    @if($transaction->description)
        <div class="card mb-4">
            <div class="card-header" style="background: linear-gradient(135deg, #EE4D2D 0%, #E64C3C 100%); color: white;">
                <h6 class="mb-0">Description</h6>
            </div>
            <div class="card-body">
                <p>{{ $transaction->description }}</p>
            </div>
        </div>
    @endif

    <div class="card mb-4">
        <div class="card-header" style="background: linear-gradient(135deg, #FFA500 0%, #FF8C00 100%); color: white;">
            <h6 class="mb-0">Additional Information</h6>
        </div>
        <div class="card-body">
            <p>
                <strong>Created:</strong> {{ $transaction->created_at->format('F d, Y h:i A') }}<br>
                <strong>Last Updated:</strong> {{ $transaction->updated_at->format('F d, Y h:i A') }}
            </p>
        </div>
    </div>

    <div class="d-grid gap-2 d-sm-flex justify-content-sm-end mb-4">
        <form action="{{ route('transactions.destroy', $transaction) }}" method="POST" style="display:inline;">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this transaction?')">🗑️ Delete Transaction</button>
        </form>
    </div>
</div>
@endsection
