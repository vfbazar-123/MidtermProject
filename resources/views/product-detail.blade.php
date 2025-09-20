@extends('layout')

@section('title', 'Product Detail')

@section('content')
    <h1>Item Details</h1>
    <p>Showing details for product ID: {{ $id }}</p>
@endsection
