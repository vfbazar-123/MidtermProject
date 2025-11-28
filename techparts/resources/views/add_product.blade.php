@extends('layouts')
@section('title', 'Add Product | MyStore')
@section('content')
<div class="container-fluid px-3 px-md-5 mt-5">
	<div class="card mb-4" style="max-width: 600px; margin: 0 auto;">
		<div class="card-header" style="background: linear-gradient(135deg, #EE4D2D 0%, #E64C3C 100%); color: white;">
			<h3 class="mb-0">➕ Add New Product</h3>
		</div>
		<div class="card-body">
			{{-- Success Message --}}
			@if (session('success'))
			<div class="alert alert-success" style="border-left: 4px solid #28a745;">{{ session('success') }}</div>
			@endif
			{{-- Validation Errors --}}
			@if ($errors->any())
			<div class="alert alert-danger" style="border-left: 4px solid #EE4D2D;">
			<ul class="mb-0">
			@foreach ($errors->all() as $error)
			<li>{{ $error }}</li>
			@endforeach
			</ul>
			</div>
			@endif
			{{-- Product Form --}}
			<form action="{{ route('product.save') }}" method="POST" enctype="multipart/form-data">
			@csrf
			{{-- Product ID --}}
			<div class="mb-3">
			<label class="form-label fw-bold">Product ID</label>
			<input
			type="text"
			class="form-control bg-light"
			name="product_id"
			value="{{ $newProductId }}"
			readyonly
			>
			</div>
			{{-- Product Name --}}
			<div class="mb-3">
			<label class="form-label fw-bold">Product Name</label>
			<input
			type="text"
			class="form-control"
			name="name"
			value="{{ old('name') }}"
			placeholder="Enter product name"
			required
			style="border: 1px solid #ddd;"
			>
			</div>
			{{-- Product Category --}}
			<div class="mb-3">
			<label class="form-label fw-bold">Product Category</label>
			<select class="form-select" name="cat" required style="border: 1px solid #ddd;">
			<option value="">Select a Category</option>
			@foreach (['Electronics & Gadgets','Home & Living','Automotive & Tools','Sports & Outdoors'] as $category)
			<option value="{{ $category }}" {{ old('cat') == $category ? 'selected' : '' }}>
			{{ $category }}
			</option>
			@endforeach
			</select>
			</div>
			{{-- Quantity --}}
			<div class="mb-3">
			<label class="form-label fw-bold">Quantity</label>
			<input
			type="number"
			class="form-control"
			name="qty"
			min="0"
			value="{{ old('qty') }}"
			placeholder="Enter quantity"
			required
			style="border: 1px solid #ddd;"
			>
			</div>
			{{-- Price --}}
			<div class="mb-3">
			<label class="form-label fw-bold">Price (₱)</label>
			<input
			type="number"
			step="0.01"
			class="form-control"
			name="price"
			value="{{ old('price') }}"
			placeholder="Enter price"
			required
			style="border: 1px solid #ddd;"
			>
			</div>
			{{-- Product Picture --}}
			<div class="mb-3">
			<label class="form-label fw-bold">Product Picture</label>
			<input
			type="file"
			class="form-control"
			name="picture_id"
			accept="image/*"
			required
			style="border: 1px solid #ddd;"
			>
			<small class="text-muted">Accepted formats: JPG, PNG (max: 2MB)</small>
			</div>
			{{-- Buttons --}}
			<div class="d-flex justify-content-between gap-2">
			<a href="{{ route('product.list') }}" class="btn btn-secondary" style="background-color: #6c757d; border: none;">
			← Cancel
			</a>
			<button type="submit" class="btn btn-primary" style="background: linear-gradient(135deg, #EE4D2D 0%, #E64C3C 100%); border: none; font-weight: 600;">
			💾 Save Product
			</button>
			</div>
			</form>
		</div>
	</div>
</div>
@endsection