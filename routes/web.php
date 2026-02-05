<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;

// Homepage with basic SEO meta tags
Route::get('/', function () {
    seo()->title('Welcome to My Store');
    seo()->description('Shop the latest products at amazing prices.');
    return view('welcome');
});

// Display list of all products
Route::get('/product', [ProductController::class, 'index'])->name('product.index');

// Show form to create a new product
Route::get('/product/create', [ProductController::class, 'create'])->name('product.create');

// Store a newly created product in database
Route::post('/product', [ProductController::class, 'store'])->name('product.store');

// Show single product details using slug
Route::get('/product/{product}', [ProductController::class, 'show'])->name('product.show');

// Delete a product from database
Route::delete('/product/{product}', [ProductController::class, 'destroy'])->name('product.destroy');
