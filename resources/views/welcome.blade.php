@extends('layout')

@section('title', 'Home')

@section('content')
    <!-- Logo + Search bar -->
    <div class="py-3 border-bottom">
        <div class="container d-flex align-items-center">
            
            <form class="flex-grow-1 d-flex">
                <input type="text" class="form-control" placeholder="Search for anything">
                <button class="btn btn-primary ms-2">Search</button>
            </form>
        </div>
    </div>

    <!-- (removed horizontal nav categories) -->

    <!-- Hero banner -->
    <div class="bg-warning text-dark py-5">
        <div class="container d-flex flex-column flex-md-row align-items-center">
            <div class="flex-fill">
                <h1 class="fw-bold">Everything You Need in One Place</h1>
                <p>Find your next great deal or favorite item.</p>
                <a href="#" class="btn btn-dark rounded-pill">Shop Now</a>
            </div>
            <div class="flex-fill d-flex justify-content-center mt-4 mt-md-0">
                <img src="{{ asset('images/hero.png') }}" alt="Logo" class="img-fluid" style="max-width: 150px;">

        </div>
    </div>
@endsection
