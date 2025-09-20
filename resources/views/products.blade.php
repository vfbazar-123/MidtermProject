@extends('layout')

@section('title', 'Products')

@section('content')
    <h1>Product List</h1>
    <p>This is a static product list page.</p>
    <ul>
        <li><a href="/products/1">Product 1</a></li>
        <li><a href="/products/2">Product 2</a></li>
        <li><a href="/products/3">Product 3</a></li>
    </ul>
@endsection
