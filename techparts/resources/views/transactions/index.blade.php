@extends('layouts')

@section('title', 'Transactions - MyStore')

@section('content')
<div class="container-fluid px-3 px-md-5 mt-4">
	<div class="card mb-4">
		<div class="card-header d-flex justify-content-between align-items-center flex-wrap gap-2">
			<h3 class="mb-0">💰 Transaction Management</h3>
			<a href="{{ route('transactions.create') }}" class="btn btn-primary" style="background: linear-gradient(135deg, #EE4D2D 0%, #E64C3C 100%); border: none; font-weight: 600;">
				➕ New Transaction
			</a>
		</div>
		<div class="card-body">
			@if($message = Session::get('success'))
				<div class="alert alert-success alert-dismissible fade show" role="alert" style="border-left: 4px solid #28a745;">
					{{ $message }}
					<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
				</div>
			@endif

			@if($message = Session::get('error'))
				<div class="alert alert-danger alert-dismissible fade show" role="alert" style="border-left: 4px solid #EE4D2D;">
					{{ $message }}
					<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
				</div>
			@endif

			<div class="table-responsive">
				<table class="table table-hover">
					<thead style="background: linear-gradient(135deg, #EE4D2D 0%, #E64C3C 100%); color: white;">
						<tr>
							<th>Date</th>
							<th>Account</th>
							<th>Type</th>
							<th>Amount</th>
							<th>Description</th>
							<th>Reference</th>
							<th>Status</th>
							<th>Actions</th>
						</tr>
					</thead>
					<tbody>
						@forelse($transactions as $transaction)
							<tr>
								<td>{{ $transaction->transaction_date->format('M d, Y') }}</td>
								<td>
									<a href="{{ route('accounts.show', $transaction->account) }}" style="color: #EE4D2D; text-decoration: none; font-weight: 600;">
										{{ $transaction->account->account_name }}
									</a>
								</td>
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
								<td>{{ Str::limit($transaction->description, 30) ?? '-' }}</td>
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
									<a href="{{ route('transactions.edit', $transaction) }}" class="btn btn-sm" style="background-color: #FFA500; color: white; border: none;">✏️ Edit</a>
									<form action="{{ route('transactions.destroy', $transaction) }}" method="POST" style="display:inline;">
										@csrf
										@method('DELETE')
										<button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">🗑️ Delete</button>
									</form>
								</td>
							</tr>
						@empty
							<tr>
								<td colspan="8" class="text-center text-muted" style="padding: 30px;">No transactions found.</td>
							</tr>
						@endforelse
					</tbody>
				</table>
			</div>

			<div class="d-flex justify-content-center mt-4">
				{{ $transactions->links() }}
			</div>
		</div>
	</div>
</div>
@endsection
