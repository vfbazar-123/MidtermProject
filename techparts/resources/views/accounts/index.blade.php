@extends('layouts')

@section('title', 'Accounts - MyStore')

@section('content')
<div class="container-fluid px-3 px-md-5 mt-4">
	<div class="card mb-4">
		<div class="card-header d-flex justify-content-between align-items-center flex-wrap gap-2">
			<h3 class="mb-0">💳 Account Management</h3>
			<a href="{{ route('accounts.create') }}" class="btn btn-primary" style="background: linear-gradient(135deg, #EE4D2D 0%, #E64C3C 100%); border: none; font-weight: 600;">
				➕ New Account
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
							<th>Account Number</th>
							<th>Account Name</th>
							<th>Type</th>
							<th>Balance</th>
							<th>Status</th>
							<th>Actions</th>
						</tr>
					</thead>
					<tbody>
						@forelse($accounts as $account)
							<tr>
								<td><strong style="color: #EE4D2D;">{{ $account->account_number }}</strong></td>
								<td>{{ $account->account_name }}</td>
								<td><span class="badge" style="background-color: #FFA500; color: white;">{{ $account->account_type }}</span></td>
								<td>
									<strong style="color: #EE4D2D; font-size: 1.05rem;">₱{{ number_format($account->balance, 2) }}</strong>
								</td>
								<td>
									@if($account->status === 'active')
										<span class="badge bg-success">✓ Active</span>
									@elseif($account->status === 'inactive')
										<span class="badge" style="background-color: #FFA500; color: white;">⊘ Inactive</span>
									@else
										<span class="badge bg-danger">✕ Closed</span>
									@endif
								</td>
								<td>
									<a href="{{ route('accounts.show', $account) }}" class="btn btn-sm" style="background-color: #0d6efd; color: white; border: none;">👁️ View</a>
									<a href="{{ route('accounts.edit', $account) }}" class="btn btn-sm" style="background-color: #FFA500; color: white; border: none;">✏️ Edit</a>
									<form action="{{ route('accounts.destroy', $account) }}" method="POST" style="display:inline;">
										@csrf
										@method('DELETE')
										<button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">🗑️ Delete</button>
									</form>
								</td>
							</tr>
						@empty
							<tr>
								<td colspan="6" class="text-center text-muted" style="padding: 30px;">No accounts found.</td>
							</tr>
						@endforelse
					</tbody>
				</table>
			</div>

			<div class="d-flex justify-content-center mt-4">
				{{ $accounts->links() }}
			</div>
		</div>
	</div>
</div>
@endsection
