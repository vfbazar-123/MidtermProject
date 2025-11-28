@extends('layouts')
@section('title', 'Products | MyStore')
@section('content')
<div class="container-fluid px-3 px-md-5 mt-4">
	<div class="card mb-4">
		<div class="card-header d-flex justify-content-between align-items-center flex-wrap gap-2">
			<h3 class="mb-0">📦 Product Management</h3>
			<div class="d-flex gap-2 flex-wrap">
				<a href="{{ route('products.pdf', ['search' => $search ?? '']) }}" class="btn btn-danger btn-sm">
					📥 Download PDF
				</a>
				<a href="{{ route('product.create') }}" class="btn btn-primary btn-sm">
					➕ Add Product
				</a>
			</div>
		</div>
		<div class="card-body">
			@if(!empty($search))
				<p class="text-muted mb-3"><strong>🔍 Search Results:</strong> <span style="color: #EE4D2D; font-weight: 600;">{{ $search }}</span></p>
			@endif

			<!-- Search Form -->
			<form method="GET" action="{{ route('product.list') }}" class="mb-3 search-bar">
				<div class="input-group">
					<input
						type="text"
						name="search"
						class="form-control"
						placeholder="Search products by name or category..."
						value="{{ $search ?? '' }}"
					>
					<button type="submit" class="btn">🔍 Search</button>
				</div>
			</form>

			<!-- Products Table -->
			<div class="table-responsive">
				<table class="table table-hover align-middle">
					<thead>
						<tr>
							<th style="width: 12%;">Product ID</th>
							<th style="width: 18%;">Product Name</th>
							<th style="width: 15%;">Category</th>
							<th style="width: 10%;">Quantity</th>
							<th style="width: 12%;">Price</th>
							<th style="width: 10%;">Picture</th>
							<th style="width: 23%;">Action</th>
						</tr>
					</thead>
					<tbody>
						@forelse ($products as $product)
							<tr>
								<td>
									<span style="color: #EE4D2D; font-weight: 600;">{{ $product->product_id }}</span>
								</td>
								<td>
									<strong style="color: #333;">{{ $product->name }}</strong>
								</td>
								<td>
									<span class="badge" style="background-color: #FFE5E5; color: #EE4D2D;">{{ $product->cat }}</span>
								</td>
								<td>
									<span class="badge @if($product->qty > 10) bg-success @elseif($product->qty > 0) bg-warning @else bg-danger @endif">
										{{ $product->qty }}
									</span>
								</td>
								<td>
									<strong style="color: #EE4D2D; font-size: 1.1rem;">₱{{ number_format($product->price, 2) }}</strong>
								</td>
								<td>
									@if ($product->picture_id && file_exists(public_path('storage/' . $product->picture_id)))
										<img src="{{ asset('storage/' . $product->picture_id) }}" alt="{{ $product->name }}" width="50" style="border-radius: 4px; border: 1px solid #ddd;">
									@else
										<span class="badge bg-secondary">No Image</span>
									@endif
								</td>
								<td>
									<a href="{{ route('product.edit', $product->product_id) }}" class="btn btn-sm btn-warning">✏️ Edit</a>
									<form action="{{ route('product.destroy', $product->product_id) }}" method="POST" style="display:inline-block;">
										@csrf
										@method('DELETE')
										<button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Delete this product?')">🗑️ Delete</button>
									</form>
								</td>
							</tr>
						@empty
							<tr>
								<td colspan="7" class="text-center text-muted" style="padding: 40px;">
									<p style="font-size: 1.1rem;">No products found. <a href="{{ route('product.create') }}" style="color: #EE4D2D; text-decoration: none; font-weight: 600;">Create one now!</a></p>
								</td>
							</tr>
						@endforelse
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>
@endsection