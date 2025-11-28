@extends('layouts')

@section('title', $account->account_name . ' - MyStore')

@section('content')
<div class="container-fluid px-3 px-md-5 mt-4">
	<div class="row mb-4">
		<div class="col">
			<h1 style="color: #EE4D2D; font-weight: 700;">💳 {{ $account->account_name }}</h1>
		</div>
		<div class="col text-end">
			<a href="{{ route('accounts.edit', $account) }}" class="btn btn-sm" style="background-color: #FFA500; color: white; border: none;">✏️ Edit</a>
			<a href="{{ route('accounts.index') }}" class="btn btn-sm btn-secondary">← Back to Accounts</a>
		</div>
	</div>

	@if($message = Session::get('success'))
		<div class="alert alert-success alert-dismissible fade show" role="alert" style="border-left: 4px solid #28a745;">
			{{ $message }}
			<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
		</div>
	@endif

	<div class="row mb-4">
		<div class="col-md-3">
			<div class="card" style="border-top: 4px solid #EE4D2D; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
				<div class="card-body">
					<h6 class="card-title text-muted">Account Number</h6>
					<p class="fs-5 fw-bold" style="color: #EE4D2D;">{{ $account->account_number }}</p>
				</div>
			</div>
		</div>
		<div class="col-md-3">
			<div class="card" style="border-top: 4px solid #FFA500; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
				<div class="card-body">
					<h6 class="card-title text-muted">Account Type</h6>
					<p class="fs-5"><span class="badge" style="background-color: #FFA500; color: white;">{{ $account->account_type }}</span></p>
				</div>
			</div>
		</div>
		<div class="col-md-3">
			<div class="card" style="border-top: 4px solid #28a745; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
				<div class="card-body">
					<h6 class="card-title text-muted">Current Balance</h6>
					<p class="fs-5 fw-bold" style="color: #28a745;">₱{{ number_format($account->balance, 2) }}</p>
				</div>
			</div>
		</div>
		<div class="col-md-3">
			<div class="card" style="border-top: 4px solid #EE4D2D; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
				<div class="card-body">
					<h6 class="card-title text-muted">Status</h6>
					<p class="fs-5">
						@if($account->status === 'active')
							<span class="badge bg-success">✓ Active</span>
						@elseif($account->status === 'inactive')
							<span class="badge" style="background-color: #FFA500; color: white;">⊘ Inactive</span>
						@else
							<span class="badge bg-danger">✕ Closed</span>
						@endif
					</p>
				</div>
			</div>
		</div>
	</div>

	@if($account->description)
		<div class="card mb-4">
			<div class="card-header" style="background: linear-gradient(135deg, #EE4D2D 0%, #E64C3C 100%); color: white;">
				<h6 class="mb-0">Description</h6>
			</div>
			<div class="card-body">
				<p>{{ $account->description }}</p>
			</div>
		</div>
	@endif

	<div class="card">
		<div class="card-header d-flex justify-content-between align-items-center flex-wrap gap-2" style="background: linear-gradient(135deg, #EE4D2D 0%, #E64C3C 100%); color: white;">
			<h5 class="mb-0">📊 Transactions</h5>
			<a href="{{ route('transactions.create') }}?account_id={{ $account->id }}" class="btn btn-sm btn-light" style="color: #EE4D2D; font-weight: 600;">➕ Add Transaction</a>
		</div>
		<div class="card-body">
			@if($account->transactions->isEmpty())
				<p class="text-muted text-center" style="padding: 20px;">No transactions yet.</p>
			@else
				<div class="table-responsive">
					<table class="table table-hover">
						<thead style="background: linear-gradient(135deg, #EE4D2D 0%, #E64C3C 100%); color: white;">
							<tr>
								<th>Date</th>
								<th>Type</th>
								<th>Amount</th>
								<th>Description</th>
								<th>Reference</th>
								<th>Status</th>
								<th>Actions</th>
							</tr>
						</thead>
						<tbody>
							@foreach($account->transactions as $transaction)
								<tr>
									<td>{{ $transaction->transaction_date->format('M d, Y') }}</td>
									<td>
										@if($transaction->transaction_type === 'credit')
											<span class="badge bg-success">✓ Credit</span>
										@else
											<span class="badge bg-danger">✕ Debit</span>
										@endif
									</td>
									<td class="fw-bold">
										@if($transaction->transaction_type === 'credit')
											<span style="color: #28a745;">+₱{{ number_format($transaction->amount, 2) }}</span>
										@else
											<span style="color: #EE4D2D;">-₱{{ number_format($transaction->amount, 2) }}</span>
										@endif
									</td>
									<td>{{ $transaction->description ?? '-' }}</td>
									<td>{{ $transaction->reference_number ?? '-' }}</td>
									<td>
										@if($transaction->status === 'completed')
											<span class="badge bg-success">✓ Completed</span>
										@elseif($transaction->status === 'pending')
											<span class="badge" style="background-color: #FFA500; color: white;">⧖ Pending</span>
										@else
											<span class="badge bg-danger">✕ Cancelled</span>
										@endif
									</td>
									<td>
										<a href="{{ route('transactions.show', $transaction) }}" class="btn btn-sm" style="background-color: #0d6efd; color: white; border: none;">👁️ View</a>
									</td>
								</tr>
							@endforeach
						</tbody>
					</table>
				</div>
			@endif
		</div>
	</div>
</div>
@endsection
