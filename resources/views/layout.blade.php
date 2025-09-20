<!DOCTYPE html>
<html>
<head>
    <title>@yield('title') - E-Commerce Prototype</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
</head>
<body class="p-4">
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
  <div class="container">
    <!-- Left-aligned brand/logo -->
    <a class="navbar-brand fw-bold text-primary" href="/">MyStore</a>

    <!-- Toggle for mobile -->
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNav">
      <span class="navbar-toggler-icon"></span>
    </button>

    <!-- Links -->
    <div class="collapse navbar-collapse" id="mainNav">
      <ul class="navbar-nav ms-auto">
        <li class="nav-item">
          <a class="nav-link btn btn-outline-primary me-2" href="/">Home</a>
        </li>
        <li class="nav-item">
          <a class="nav-link btn btn-outline-primary me-2" href="/products">Products</a>
        </li>
        <li class="nav-item">
          <a class="nav-link btn btn-outline-primary me-2" href="/cart">Cart</a>
        </li>
        <li class="nav-item">
          <a class="nav-link btn btn-outline-primary me-2" href="/checkout">Checkout</a>
        </li>
        <li class="nav-item">
          <a class="nav-link btn btn-outline-primary me-2" href="/admin">Admin</a>
        </li>
      </ul>
    </div>
  </div>
</nav>

    <div class="container">
        @yield('content')
    </div>
</body>
</html>
