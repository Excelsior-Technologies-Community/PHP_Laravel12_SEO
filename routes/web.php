<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;


/*
|--------------------------------------------------------------------------
| Homepage
|--------------------------------------------------------------------------
*/

Route::get('/', function () {

    seo()
        ->title('Welcome to My Store')
        ->description(
            'Shop the latest products at amazing prices.'
        );

    return view('welcome');

})->name('home');


/*
|--------------------------------------------------------------------------
| SEO Routes
|--------------------------------------------------------------------------
*/

/*
 * Dynamic XML Sitemap
 */
Route::get('/sitemap.xml', [
    ProductController::class,
    'sitemap'
])->name('seo.sitemap');


/*
 * Dynamic Robots.txt
 */
Route::get('/robots.txt', [
    ProductController::class,
    'robots'
])->name('seo.robots');


/*
|--------------------------------------------------------------------------
| Product Routes
|--------------------------------------------------------------------------
*/

/*
 * Display all products
 */
Route::get('/product', [
    ProductController::class,
    'index'
])->name('product.index');


/*
 * Show create product form
 */
Route::get('/product/create', [
    ProductController::class,
    'create'
])->name('product.create');


/*
 * Store product
 */
Route::post('/product', [
    ProductController::class,
    'store'
])->name('product.store');


/*
 * Show product using SEO-friendly slug
 */
Route::get('/product/{product}', [
    ProductController::class,
    'show'
])->name('product.show');


/*
 * Delete product
 */
Route::delete('/product/{product}', [
    ProductController::class,
    'destroy'
])->name('product.destroy');