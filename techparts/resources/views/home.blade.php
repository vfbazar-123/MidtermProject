@extends('layouts')
@section('title', 'Home | MyStore')
@section('content')
<!-- Hero Section -->
<section class="hero-section">
	<div class="container-fluid px-3 px-md-5">
		<h1>Welcome to MyStore</h1>
		<p class="lead">Your one-stop shop for Electronics & Gadgets, Home & Living, Automotive & Tools, and Sports & Outdoors!</p>

		<form action="{{ route('product.view') }}" method="GET" class="search-bar">
			<div class="input-group" style="max-width: 600px; margin: 20px auto 0;">
				<input
					type="search"
					name="search"
					class="form-control"
					placeholder="Search products..."
					value="{{ request('search') }}"
				>
				<button class="btn" type="submit">🔍 Search</button>
			</div>
		</form>
	</div>
</section>

<!-- Featured Products -->
<section class="py-5">
	<div class="container-fluid px-3 px-md-5">
		<h2 class="section-title">
			@if(!empty($query))
				Search Results: "{{ $query }}"
			@else
				🔥 Featured Products
			@endif
		</h2>
		<div class="product-grid">
			@forelse($products as $product)
				<div class="product-card">
					<img
						src="{{ asset('storage/' . $product->picture_id) }}"
						alt="{{ $product->name }}"
						onerror="this.src='https://via.placeholder.com/150x150?text=No+Image';"
					/>
					<div class="product-card-body">
						<h5 class="product-card-title">{{ $product->name }}</h5>
						<p class="product-card-category">📦 {{ $product->cat }}</p>
						<div class="product-price-section">
							<span class="product-price">₱{{ number_format($product->price, 2) }}</span>
						</div>
						<p class="product-stock">✓ {{ $product->qty }} in stock</p>
					</div>
				</div>
			@empty
				<div style="grid-column: 1/-1; text-align: center; padding: 60px 20px;">
					<h4 style="color: #EE4D2D; margin-bottom: 10px;">😕 No Products Found</h4>
					<p style="color: #666;">Try adjusting your search or browse our full catalog</p>
				</div>
			@endforelse
		</div>
	</div>
</section>
@endsection