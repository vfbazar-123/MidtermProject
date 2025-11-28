@extends('layouts')
@section('title', 'Edit Product | MyStore')
@section('content')
<div class="container-fluid px-3 px-md-5 mt-5">
	<div class="card mb-4" style="max-width: 600px; margin: 0 auto;">
		<div class="card-header" style="background: linear-gradient(135deg, #FFA500 0%, #FF8C00 100%); color: white;">
			<h3 class="mb-0">✏️ Edit Product</h3>
		</div>
		<div class="card-body">
			<form action="{{ route('product.update', $product->product_id) }}" method="POST" enctype="multipart/form-data">
				@csrf
				@method('PUT')
				<div class="mb-3">
				<label class="form-label fw-bold">Product ID</label>
				<input type="text" class="form-control bg-light" name="product_id" value="{{ $product->product_id }}" readonly>
				</div>

				<div class="mb-3">
				<label class="form-label fw-bold">Product Name</label>
				<input type="text" class="form-control" name="name" value="{{ $product->name }}" required style="border: 1px solid #ddd;">
				</div>
				<div class="mb-3">
				<label class="form-label fw-bold">Product Category</label>
				<select class="form-select" name="cat" required style="border: 1px solid #ddd;">
				<option value="">Select a Category</option>
				@foreach (['Electronics & Gadgets', 'Home & Living', 'Automotive & Tools', 'Sports & Outdoors'] as $category)
				<option value="{{ $category }}" {{ $product->cat === $category ? 'selected' : '' }}>
				{{ $category }}
				</option>
				@endforeach
				</select>
				</div>
				<div class="mb-3">
				<label class="form-label fw-bold">Quantity</label>
				<input type="number" class="form-control" name="qty" value="{{ $product->qty }}" required style="border: 1px solid #ddd;">
				</div>
				<div class="mb-3">
				<label class="form-label fw-bold">Price (₱)</label>
				<input type="number" step="0.01" class="form-control" name="price" value="{{ $product->price }}" required style="border: 1px solid #ddd;">
				</div>
				<div class="mb-3">
				<label class="form-label fw-bold">Current Picture</label><br>
				@if ($product->picture_id && file_exists(public_path('storage/' . $product->picture_id)))
				<img src="{{ asset('storage/' . $product->picture_id) }}" alt="{{ $product->name }}" width="100" class="img-thumbnail mb-2" style="border: 2px solid #EE4D2D; border-radius: 4px;">
				@else
				<img src="https://via.placeholder.com/100?text=No+Image" class="img-thumbnail mb-2" alt="No Image">
				@endif
				<input type="file" class="form-control" name="picture_id" accept="image/*" style="border: 1px solid #ddd;">
				</div>
				<div class="d-flex justify-content-between gap-2">
				<a href="{{ route('product.list') }}" class="btn btn-secondary" style="background-color: #6c757d; border: none;">
				← Cancel
				</a>
				<button type="submit" class="btn btn-primary" style="background: linear-gradient(135deg, #FFA500 0%, #FF8C00 100%); border: none; font-weight: 600;">
				💾 Update Product
				</button>
				</div>
			</form>
		</div>
	</div>
</div>
@endsection