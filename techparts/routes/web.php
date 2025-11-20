<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\productcontroller;

// Root route - redirect to the product view to avoid 404 on '/'
Route::get('/', function () {
	return redirect()->route('product.view');
});

Route::get('/viewproduct', [productcontroller::class, 'index'])->name('product.view');
Route::get('/productview', [productcontroller::class, 'product_manage'])->name('product.list');
Route::get('/products/add', [productcontroller::class, 'product_create'])->name('product.create');
Route::post('/product/add', [productcontroller::class, 'product_save'])->name('product.save');

// Edit / Update / Delete
Route::get('/products/{product_id}/edit', [productcontroller::class, 'edit'])->name('product.edit');
Route::put('/products/{product_id}', [productcontroller::class, 'update'])->name('product.update');
Route::delete('/products/{product_id}', [productcontroller::class, 'destroy'])->name('product.destroy');
Route::get('/products/pdf', [productcontroller::class, 'downloadPDF'])->name('products.pdf');

// Debug: return product count (remove in production)
Route::get('/_debug/products/count', function () {
	return response()->json(['count' => \App\Models\Product::count()]);
});