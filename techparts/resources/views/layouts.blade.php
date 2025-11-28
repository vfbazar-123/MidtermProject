<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>@yield('title', 'MyStore')</title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
	<style>
		:root {
			--shopee-red: #EE4D2D;
			--shopee-orange: #FFA500;
			--shopee-white: #FFFFFF;
			--shopee-light-gray: #F5F5F5;
			--shopee-dark-gray: #666666;
		}

		* {
			margin: 0;
			padding: 0;
			box-sizing: border-box;
		}

		body {
			background-color: var(--shopee-light-gray);
			font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
			color: #333;
		}

		/* ===== NAVBAR ===== */
		.navbar {
			background: linear-gradient(135deg, var(--shopee-red) 0%, #E64C3C 100%);
			box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
			padding: 12px 0;
		}

		.navbar-brand {
			font-size: 1.8rem;
			font-weight: 800;
			color: var(--shopee-white) !important;
			letter-spacing: 1px;
			display: flex;
			align-items: center;
			gap: 8px;
		}

		.navbar-brand::before {
			content: "🛍️";
			font-size: 1.5rem;
		}

		.navbar .nav-link {
			color: var(--shopee-white) !important;
			font-weight: 500;
			margin: 0 12px;
			padding: 8px 0 !important;
			border-bottom: 3px solid transparent;
			transition: all 0.3s ease;
			font-size: 0.95rem;
		}

		.navbar .nav-link:hover {
			border-bottom-color: var(--shopee-orange);
			color: var(--shopee-orange) !important;
		}

		/* ===== MAIN CONTENT ===== */
		main {
			background-color: var(--shopee-light-gray);
			padding: 20px 0;
			min-height: calc(100vh - 200px);
		}

		/* ===== HERO SECTION ===== */
		.hero-section {
			background: linear-gradient(135deg, var(--shopee-red) 0%, #E64C3C 100%);
			color: var(--shopee-white);
			padding: 40px 0;
			margin-bottom: 30px;
			box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
		}

		.hero-section h1 {
			font-weight: 800;
			margin-bottom: 15px;
			font-size: 2.2rem;
			text-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
		}

		.hero-section p {
			font-size: 1rem;
			opacity: 0.95;
			font-weight: 500;
		}

		/* ===== SEARCH BAR ===== */
		.search-bar {
			margin-top: 20px;
		}

		.search-bar .input-group {
			box-shadow: 0 2px 8px rgba(0, 0, 0, 0.15);
			border-radius: 4px;
			overflow: hidden;
		}

		.search-bar input {
			border: none;
			padding: 12px 16px;
			font-size: 1rem;
			border-radius: 0;
		}

		.search-bar input:focus {
			border: none;
			box-shadow: none;
			outline: none;
		}

		.search-bar button {
			background-color: var(--shopee-orange);
			color: var(--shopee-white);
			font-weight: 600;
			border: none;
			padding: 12px 24px;
			cursor: pointer;
			transition: background-color 0.3s ease;
		}

		.search-bar button:hover {
			background-color: #FF8C00;
		}

		/* ===== PRODUCT GRID ===== */
		.product-grid {
			display: grid;
			grid-template-columns: repeat(auto-fill, minmax(220px, 1fr));
			gap: 16px;
			padding: 0;
		}

		.product-card {
			background: var(--shopee-white);
			border-radius: 4px;
			overflow: hidden;
			transition: all 0.3s ease;
			box-shadow: 0 1px 2px rgba(0, 0, 0, 0.08);
			border: 1px solid #e0e0e0;
			display: flex;
			flex-direction: column;
		}

		.product-card:hover {
			box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
			transform: translateY(-4px);
		}

		.product-card img {
			width: 100%;
			height: 180px;
			object-fit: contain;
			background-color: var(--shopee-light-gray);
			padding: 12px;
			border-bottom: 1px solid #e0e0e0;
		}

		.product-card-body {
			padding: 12px;
			flex-grow: 1;
			display: flex;
			flex-direction: column;
		}

		.product-card-title {
			font-size: 0.95rem;
			font-weight: 500;
			color: #333;
			margin-bottom: 8px;
			line-height: 1.4;
			display: -webkit-box;
			-webkit-line-clamp: 2;
			-webkit-box-orient: vertical;
			overflow: hidden;
		}

		.product-card-category {
			color: var(--shopee-dark-gray);
			font-size: 0.8rem;
			margin-bottom: 8px;
		}

		.product-price-section {
			display: flex;
			align-items: baseline;
			gap: 8px;
			margin-bottom: 8px;
		}

		.product-price {
			color: var(--shopee-red);
			font-weight: 700;
			font-size: 1.3rem;
		}

		.product-original-price {
			color: var(--shopee-dark-gray);
			font-size: 0.85rem;
			text-decoration: line-through;
		}

		.product-discount {
			color: var(--shopee-red);
			font-size: 0.75rem;
			font-weight: 600;
		}

		.product-stock {
			color: #888;
			font-size: 0.8rem;
			margin-bottom: 8px;
		}

		/* ===== CARDS & CONTAINERS ===== */
		.card {
			border: none;
			border-radius: 4px;
			box-shadow: 0 1px 2px rgba(0, 0, 0, 0.08);
			overflow: hidden;
		}

		.card-header {
			background: linear-gradient(135deg, var(--shopee-red) 0%, #E64C3C 100%);
			color: var(--shopee-white);
			font-weight: 600;
			border: none;
			padding: 16px;
		}

		.card-body {
			padding: 16px;
		}

		/* ===== TABLE STYLING ===== */
		.table {
			background-color: var(--shopee-white);
			border-radius: 4px;
			overflow: hidden;
			margin-bottom: 0;
		}

		.table thead {
			background: linear-gradient(135deg, var(--shopee-red) 0%, #E64C3C 100%);
			color: var(--shopee-white);
		}

		.table thead th {
			font-weight: 600;
			border: none;
			padding: 14px;
		}

		.table tbody td {
			padding: 14px;
			vertical-align: middle;
			border-color: #e0e0e0;
		}

		.table-hover tbody tr:hover {
			background-color: rgba(238, 77, 45, 0.04);
		}

		/* ===== BUTTONS ===== */
		.btn-primary {
			background-color: var(--shopee-red);
			border: none;
			font-weight: 600;
			padding: 10px 20px;
			border-radius: 4px;
			transition: all 0.3s ease;
		}

		.btn-primary:hover {
			background-color: #D64423;
			color: var(--shopee-white);
		}

		.btn-secondary {
			background-color: #e0e0e0;
			border: 1px solid #ccc;
			color: #333;
			font-weight: 600;
			padding: 10px 20px;
			border-radius: 4px;
			transition: all 0.3s ease;
		}

		.btn-secondary:hover {
			background-color: #d0d0d0;
			color: #333;
		}

		.btn-warning {
			background-color: var(--shopee-orange);
			border: none;
			color: var(--shopee-white);
			font-weight: 600;
		}

		.btn-warning:hover {
			background-color: #FF8C00;
			color: var(--shopee-white);
		}

		.btn-danger {
			background-color: #ff6b6b;
			border: none;
			color: var(--shopee-white);
			font-weight: 600;
		}

		.btn-danger:hover {
			background-color: #ff5252;
			color: var(--shopee-white);
		}

		/* ===== BADGES ===== */
		.badge {
			padding: 4px 8px;
			border-radius: 3px;
			font-size: 0.75rem;
			font-weight: 600;
		}

		.badge.bg-success {
			background-color: #27ae60 !important;
		}

		.badge.bg-warning {
			background-color: var(--shopee-orange) !important;
		}

		.badge.bg-danger {
			background-color: #e74c3c !important;
		}

		.badge-new {
			background-color: var(--shopee-red);
			color: var(--shopee-white);
		}

		/* ===== ALERT STYLING ===== */
		.alert-success {
			background-color: #d4edda;
			border: 1px solid #c3e6cb;
			color: #155724;
			border-radius: 4px;
		}

		.alert-danger {
			background-color: #f8d7da;
			border: 1px solid #f5c6cb;
			color: #721c24;
			border-radius: 4px;
		}

		/* ===== FORM ELEMENTS ===== */
		.form-control,
		.form-select {
			border: 1px solid #ddd;
			border-radius: 4px;
			padding: 10px 12px;
			transition: all 0.3s ease;
		}

		.form-control:focus,
		.form-select:focus {
			border-color: var(--shopee-red);
			box-shadow: 0 0 0 0.2rem rgba(238, 77, 45, 0.25);
		}

		.form-label {
			font-weight: 500;
			color: #333;
			margin-bottom: 8px;
		}

		/* ===== FOOTER ===== */
		footer {
			background: linear-gradient(135deg, var(--shopee-red) 0%, #E64C3C 100%);
			color: var(--shopee-white);
			margin-top: auto;
			padding: 20px 0;
			border-top: 3px solid var(--shopee-orange);
		}

		footer p {
			margin: 0;
			font-weight: 500;
		}

		footer .small {
			opacity: 0.9;
		}

		/* ===== SECTION TITLES ===== */
		.section-title {
			color: var(--shopee-red);
			font-weight: 700;
			font-size: 1.5rem;
			margin-bottom: 24px;
			padding-bottom: 12px;
			border-bottom: 3px solid var(--shopee-red);
			display: inline-block;
		}

		/* ===== RESPONSIVE ===== */
		@media (max-width: 768px) {
			.hero-section h1 {
				font-size: 1.5rem;
			}

			.product-grid {
				grid-template-columns: repeat(auto-fill, minmax(160px, 1fr));
				gap: 12px;
			}

			.navbar-brand {
				font-size: 1.3rem;
			}

			.navbar .nav-link {
				margin: 0 6px;
				font-size: 0.85rem;
			}
		}

		@media (max-width: 576px) {
			.product-grid {
				grid-template-columns: repeat(2, 1fr);
			}

			.container {
				padding: 0 10px;
			}

			.btn-sm {
				padding: 6px 12px;
				font-size: 0.75rem;
			}
		}

		/* ===== ANIMATIONS ===== */
		@keyframes fadeIn {
			from {
				opacity: 0;
				transform: translateY(10px);
			}
			to {
				opacity: 1;
				transform: translateY(0);
			}
		}

		.product-card {
			animation: fadeIn 0.3s ease;
		}
	</style>
</head>
<body class="d-flex flex-column min-vh-100">
	<!-- Navbar -->
	<nav class="navbar navbar-expand-lg navbar-dark sticky-top">
		<div class="container-fluid px-3 px-md-5">
			<a class="navbar-brand" href="{{ route('product.view') }}">MyStore</a>
			<button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
				<span class="navbar-toggler-icon"></span>
			</button>
			<div class="collapse navbar-collapse" id="navbarNav">
				<ul class="navbar-nav ms-auto">
					<li class="nav-item"><a class="nav-link" href="{{ route('product.view') }}">🏠 Home</a></li>
					<li class="nav-item"><a class="nav-link" href="{{ route('product.list') }}">📦 Products</a></li>
					<li class="nav-item"><a class="nav-link" href="{{ route('transactions.index') }}">💳 Transactions</a></li>
					<li class="nav-item"><a class="nav-link" href="{{ route('accounts.index') }}">💰 Accounts</a></li>
				</ul>
			</div>
		</div>
	</nav>

	<!-- Page Content -->
	<main class="flex-grow-1">
		@yield('content')
	</main>

	<!-- Footer -->
	<footer class="text-white text-center py-4 mt-5">
		<div class="container">
			<p class="mb-2"><strong>© <span id="year"></span> MyStore. All rights reserved.</strong></p>
			<p class="small">🎯 Your Premier Tech Parts Store | Fast Shipping | Authentic Products | Customer Support</p>
		</div>
	</footer>

	<!-- Script -->
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
	<script>
		document.getElementById('year').textContent = new Date().getFullYear();
	</script>
</body>
</html>