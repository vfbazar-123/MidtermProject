@extends('layouts')

@section('title', 'Edit Transaction - MyStore')

@section('content')
<div class="container-fluid px-3 px-md-5 mt-4">
    <div class="row mb-4">
        <div class="col">
            <h1 style="color: #EE4D2D; font-weight: 700;">✏️ Edit Transaction</h1>
        </div>
        <div class="col text-end">
            <a href="{{ route('transactions.show', $transaction) }}" class="btn btn-secondary" style="background-color: #6c757d; border: none;">
                ← Back to Transaction
            </a>
        </div>
    </div>

    @if($message = Session::get('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert" style="border-left: 4px solid #EE4D2D;">
            {{ $message }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header" style="background: linear-gradient(135deg, #FFA500 0%, #FF8C00 100%); color: white;">
                    <h5 class="mb-0">Transaction Information</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('transactions.update', $transaction) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label for="account_id" class="form-label fw-bold">Account *</label>
                            <select class="form-select @error('account_id') is-invalid @enderror" 
                                    id="account_id" name="account_id" required style="border: 1px solid #ddd;">
                                <option value="">Select Account</option>
                                @foreach($accounts as $account)
                                    <option value="{{ $account->id }}" 
                                            {{ old('account_id', $transaction->account_id) == $account->id ? 'selected' : '' }}>
                                        {{ $account->account_name }} (₱{{ number_format($account->balance, 2) }})
                                    </option>
                                @endforeach
                            </select>
                            @error('account_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="transaction_type" class="form-label fw-bold">Transaction Type *</label>
                            <select class="form-select @error('transaction_type') is-invalid @enderror" 
                                    id="transaction_type" name="transaction_type" required style="border: 1px solid #ddd;">
                                <option value="">Select Type</option>
                                <option value="credit" {{ old('transaction_type', $transaction->transaction_type) === 'credit' ? 'selected' : '' }}>✓ Credit (Deposit)</option>
                                <option value="debit" {{ old('transaction_type', $transaction->transaction_type) === 'debit' ? 'selected' : '' }}>✕ Debit (Withdrawal)</option>
                            </select>
                            @error('transaction_type')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="amount" class="form-label fw-bold">Amount *</label>
                            <input type="number" step="0.01" class="form-control @error('amount') is-invalid @enderror" 
                                   id="amount" name="amount" value="{{ old('amount', $transaction->amount) }}" required 
                                   style="border: 1px solid #ddd;">
                            @error('amount')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="transaction_date" class="form-label fw-bold">Transaction Date *</label>
                            <input type="date" class="form-control @error('transaction_date') is-invalid @enderror" 
                                   id="transaction_date" name="transaction_date" 
                                   value="{{ old('transaction_date', $transaction->transaction_date->format('Y-m-d')) }}" required 
                                   style="border: 1px solid #ddd;">
                            @error('transaction_date')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="reference_number" class="form-label fw-bold">Reference Number</label>
                            <input type="text" class="form-control @error('reference_number') is-invalid @enderror" 
                                   id="reference_number" name="reference_number" 
                                   value="{{ old('reference_number', $transaction->reference_number) }}" style="border: 1px solid #ddd;">
                            @error('reference_number')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="description" class="form-label fw-bold">Description</label>
                            <textarea class="form-control @error('description') is-invalid @enderror" 
                                      id="description" name="description" rows="3" style="border: 1px solid #ddd;">{{ old('description', $transaction->description) }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="status" class="form-label fw-bold">Status *</label>
                            <select class="form-select @error('status') is-invalid @enderror" 
                                    id="status" name="status" required style="border: 1px solid #ddd;">
                                <option value="pending" {{ old('status', $transaction->status) === 'pending' ? 'selected' : '' }}>⧖ Pending</option>
                                <option value="completed" {{ old('status', $transaction->status) === 'completed' ? 'selected' : '' }}>✓ Completed</option>
                                <option value="cancelled" {{ old('status', $transaction->status) === 'cancelled' ? 'selected' : '' }}>✕ Cancelled</option>
                            </select>
                            @error('status')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-grid gap-2 d-sm-flex justify-content-sm-end">
                            <button type="submit" class="btn btn-primary" style="background: linear-gradient(135deg, #FFA500 0%, #FF8C00 100%); border: none; font-weight: 600;">
                                💾 Update Transaction
                            </button>
                            <a href="{{ route('transactions.show', $transaction) }}" class="btn btn-secondary" style="background-color: #6c757d; border: none;">
                                Cancel
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
