@extends('layouts')

@section('title', 'Edit Account - MyStore')

@section('content')
<div class="container-fluid px-3 px-md-5 mt-4">
	<div class="row mb-4">
		<div class="col">
			<h1 style="color: #EE4D2D; font-weight: 700;">✏️ Edit Account</h1>
		</div>
		<div class="col text-end">
			<a href="{{ route('accounts.show', $account) }}" class="btn btn-secondary" style="background-color: #6c757d; border: none;">
				← Back to Account
			</a>
		</div>
	</div>

	<div class="row">
		<div class="col-md-8">
			<div class="card">
				<div class="card-header" style="background: linear-gradient(135deg, #FFA500 0%, #FF8C00 100%); color: white;">
					<h5 class="mb-0">Account Information</h5>
				</div>
				<div class="card-body">
					<form action="{{ route('accounts.update', $account) }}" method="POST">
						@csrf
						@method('PUT')

						<div class="mb-3">
							<label for="account_number" class="form-label fw-bold">Account Number *</label>
							<input type="text" class="form-control @error('account_number') is-invalid @enderror" 
								   id="account_number" name="account_number" value="{{ old('account_number', $account->account_number) }}" required 
								   style="border: 1px solid #ddd;">
							@error('account_number')
								<div class="invalid-feedback">{{ $message }}</div>
							@enderror
						</div>

						<div class="mb-3">
							<label for="account_name" class="form-label fw-bold">Account Name *</label>
							<input type="text" class="form-control @error('account_name') is-invalid @enderror" 
								   id="account_name" name="account_name" value="{{ old('account_name', $account->account_name) }}" required 
								   style="border: 1px solid #ddd;">
							@error('account_name')
								<div class="invalid-feedback">{{ $message }}</div>
							@enderror
						</div>

						<div class="mb-3">
							<label for="account_type" class="form-label fw-bold">Account Type *</label>
							<select class="form-select @error('account_type') is-invalid @enderror" 
									id="account_type" name="account_type" required style="border: 1px solid #ddd;">
								<option value="">Select Type</option>
								<option value="Cash" {{ old('account_type', $account->account_type) === 'Cash' ? 'selected' : '' }}>💵 Cash</option>
								<option value="Bank" {{ old('account_type', $account->account_type) === 'Bank' ? 'selected' : '' }}>🏦 Bank</option>
								<option value="Credit Card" {{ old('account_type', $account->account_type) === 'Credit Card' ? 'selected' : '' }}>💳 Credit Card</option>
							</select>
							@error('account_type')
								<div class="invalid-feedback">{{ $message }}</div>
							@enderror
						</div>

						<div class="mb-3">
							<label for="balance" class="form-label fw-bold">Balance *</label>
							<input type="number" step="0.01" class="form-control @error('balance') is-invalid @enderror" 
								   id="balance" name="balance" value="{{ old('balance', $account->balance) }}" required 
								   style="border: 1px solid #ddd;">
							@error('balance')
								<div class="invalid-feedback">{{ $message }}</div>
							@enderror
						</div>

						<div class="mb-3">
							<label for="status" class="form-label fw-bold">Status *</label>
							<select class="form-select @error('status') is-invalid @enderror" 
									id="status" name="status" required style="border: 1px solid #ddd;">
								<option value="active" {{ old('status', $account->status) === 'active' ? 'selected' : '' }}>✓ Active</option>
								<option value="inactive" {{ old('status', $account->status) === 'inactive' ? 'selected' : '' }}>⊘ Inactive</option>
								<option value="closed" {{ old('status', $account->status) === 'closed' ? 'selected' : '' }}>✕ Closed</option>
							</select>
							@error('status')
								<div class="invalid-feedback">{{ $message }}</div>
							@enderror
						</div>

						<div class="mb-3">
							<label for="description" class="form-label fw-bold">Description</label>
							<textarea class="form-control @error('description') is-invalid @enderror" 
									  id="description" name="description" rows="3" style="border: 1px solid #ddd;">{{ old('description', $account->description) }}</textarea>
							@error('description')
								<div class="invalid-feedback">{{ $message }}</div>
							@enderror
						</div>

						<div class="d-grid gap-2 d-sm-flex justify-content-sm-end">
							<button type="submit" class="btn btn-primary" style="background: linear-gradient(135deg, #FFA500 0%, #FF8C00 100%); border: none; font-weight: 600;">
								💾 Update Account
							</button>
							<a href="{{ route('accounts.show', $account) }}" class="btn btn-secondary" style="background-color: #6c757d; border: none;">
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
