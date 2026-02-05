# PHP_Laravel12_SEO

<p align="center">
  <img src="https://img.shields.io/badge/Laravel-12.x-red" alt="Laravel Version">
  <img src="https://img.shields.io/badge/PHP-8.2+-blue" alt="PHP Version">
  <img src="https://img.shields.io/badge/SEO-Optimized-brightgreen" alt="SEO Ready">
  <img src="https://img.shields.io/badge/Package-archtechx%2Flaravel--seo-orange" alt="SEO Package">
  <img src="https://img.shields.io/badge/License-MIT-lightgrey" alt="License">
</p>


## Overview

This project demonstrates how to build an SEO-optimized product catalog using Laravel and the archtechx/laravel-seo package. It includes dynamic meta tags, OpenGraph data, Twitter Cards, canonical URLs, and structured data for individual product pages to improve search engine visibility and social media sharing.

## Features

* SEO-friendly product pages with dynamic meta titles and descriptions
* OpenGraph tags for rich link previews
* Twitter Card integration
* Canonical URLs to prevent duplicate content issues
* JSON-LD structured data for Google Rich Results
* Slug-based product URLs
* Image upload and storage for products
* Clean Blade layout with reusable SEO component
* Simple product management (Create, View, Delete)

## Folder Structure

```
app/
 ├── Models/
 │    └── Product.php
 ├── Http/
 │    └── Controllers/
 │         └── ProductController.php
 └── Providers/
      └── AppServiceProvider.php

resources/
 └── views/
      ├── layouts/
      │    └── app.blade.php
      └── product/
           ├── index.blade.php
           ├── create.blade.php
           └── show.blade.php

routes/
 └── web.php

database/
 └── migrations/
      └── create_products_table.php

public/
 └── products/   (uploaded product images)
```

---

## Step 1 — Create a New Laravel Project

```bash
composer create-project laravel/laravel seo-project
```

Start the server:

```bash
php artisan serve
```

Visit:

```
http://127.0.0.1:8000
```

### .env Configuration

```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=seo
DB_USERNAME=root
DB_PASSWORD=
```

---

## Step 2 — Install Laravel SEO Package

```bash
composer require archtechx/laravel-seo
```

---

## Step 3 — Add SEO Meta Component to Layout

Create layout file:

📁 `resources/views/layouts/app.blade.php`

```html
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    {{-- SEO meta tags (title, description, OG, Twitter, canonical, etc.) --}}
    <x-seo::meta />

    <style>
        /* Base page styling */
        body {
            font-family: Arial, Helvetica, sans-serif;
            margin: 0;
            background: #f4f6f9;
            color: #333;
        }

        /* Top navigation bar */
        header {
            background: #111;
            padding: 15px 30px;
        }

        /* Navigation links */
        header a {
            color: #fff;
            margin-right: 20px;
            text-decoration: none;
            font-weight: bold;
        }

        /* Main content container */
        .container {
            max-width: 1100px;
            margin: 30px auto;
            padding: 20px;
            background: #fff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0,0,0,0.05);
        }

        /* Page headings */
        h1 {
            margin-bottom: 20px;
        }

        /* Button styling */
        .btn {
            display: inline-block;
            padding: 8px 14px;
            background: #111;
            color: #fff;
            text-decoration: none;
            border-radius: 4px;
        }

        /* Button hover effect */
        .btn:hover {
            opacity: 0.9;
        }

        /* Form inputs and textareas */
        input, textarea {
            width: 100%;
            padding: 8px;
            margin-top: 5px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        /* Footer styling */
        footer {
            text-align: center;
            padding: 20px;
            margin-top: 40px;
            background: #eee;
            font-size: 14px;
        }
    </style>
</head>
<body>

{{-- Website header with navigation --}}
<header>
    <a href="/">Home</a>
    <a href="/product">Products</a>
    <a href="/product/create">Add Product</a>
</header>

{{-- Dynamic page content will be injected here --}}
<div class="container">
    @yield('content')
</div>

{{-- Footer section --}}
<footer>
    © {{ date('Y') }} {{ config('app.name') }}. All rights reserved.
</footer>

</body>
</html>
```

---

## Step 4 — Configure Default SEO Settings

📁 `app/Providers/AppServiceProvider.php`

```php
<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        seo()
            ->site('My Website Name') // Site name
            ->title(
                default: 'My Website Name',
                modify: fn (string $title) => $title . ' | My Website'
            )
            ->description(default: 'Welcome to my Laravel website.')
            ->image(default: asset('images/seo-cover.jpg')) // Default share image
            ->twitter() // ENABLE TWITTER CARDS
            ->twitterSite('@yourusername') // Twitter @site
            ->twitterCreator('@yourusername') // Twitter @creator
            ->withUrl(); // Adds canonical + og:url
    }
}
```

---

## Step 5 — Create Product Model & Migration

```bash
php artisan make:model Product -m
```

Edit migration:

📁 `database/migrations/...create_products_table.php`

```php
public function up(): void
{
    Schema::create('products', function (Blueprint $table) {
        $table->id();
        $table->string('name');
        $table->string('slug')->unique();
        $table->text('description');
        $table->decimal('price', 10, 2);
        $table->string('image');
        $table->timestamps();
    });
}
```

Run:

```bash
php artisan migrate
```

---

## Step 6 — Product Model

📁 `app/Models/Product.php`

```php
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = ['name', 'slug', 'description', 'price', 'image'];

    public function getRouteKeyName()
    {
        return 'slug';
    }
}
```

---

## Step 7 — Product Controller

```bash
php artisan make:controller ProductController
```

📁 `app/Http/Controllers/ProductController.php`

```php
<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    // Show all products with SEO meta
    public function index()
    {
        $products = Product::latest()->get();

        seo()
            ->title('All Products')
            ->description('Browse all available products in our store.')
            ->twitter();

        return view('product.index', compact('products'));
    }

    // Show product creation form
    public function create()
    {
        seo()->title('Add New Product')
            ->description('Create a new product');

        return view('product.create');
    }

    // Store new product in database with uploaded image
    public function store(Request $request)
    {
        // Validate product input fields
        $request->validate([
            'name' => 'required',
            'description' => 'required',
            'price' => 'required|numeric',
            'image' => 'required|image'
        ]);

        // Generate unique image name and move to public/products
        $imageName = time() . '.' . $request->image->extension();
        $request->image->move(public_path('products'), $imageName);

        // Create product record with slug and image path
        Product::create([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'description' => $request->description,
            'price' => $request->price,
            'image' => 'products/' . $imageName
        ]);

        return redirect()->route('product.index')->with('success', 'Product added!');
    }

    // Show single product with dynamic SEO tags
    public function show(Product $product)
    {
        seo()
            ->title($product->name)
            ->description($product->description)
            ->image(asset($product->image)) // Set OG/Twitter image
            ->twitter()
            ->type('product');

        return view('product.show', compact('product'));
    }

    // Delete product and its image file
    public function destroy(Product $product)
    {
        // Remove product image from public folder if exists
        if (file_exists(public_path($product->image))) {
            unlink(public_path($product->image));
        }

        // Delete product record from database
        $product->delete();

        return redirect()->route('product.index')->with('success', 'Product deleted successfully!');
    }
}
```

---

## Step 8 — Routes

📁 `routes/web.php`

```php
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
```

---

## Step 9 — Views

### 📄 resources/views/product/index.blade.php

```blade
@extends('layouts.app')

@section('content')
    <h1>All Products</h1>

    <a href="{{ route('product.create') }}" class="btn" style="margin-bottom:15px;">+ Add Product</a>

    <table style="width:100%; border-collapse: collapse; margin-top:20px;">
        <thead style="background:#111; color:#fff;">
            <tr>
                <th style="padding:10px; border:1px solid #ddd;">Image</th>
                <th style="padding:10px; border:1px solid #ddd;">Name</th>
                <th style="padding:10px; border:1px solid #ddd;">Slug</th>
                <th style="padding:10px; border:1px solid #ddd;">Price</th>
                <th style="padding:10px; border:1px solid #ddd;">Description</th>
                <th style="padding:10px; border:1px solid #ddd;">Action</th>
            </tr>
        </thead>

        <tbody>
            @forelse($products as $product)
                <tr>
                    <td style="padding:10px; border:1px solid #ddd; text-align:center;">
                        <img src="{{ asset($product->image) }}" width="60" style="border-radius:4px;">
                    </td>

                    <td style="padding:10px; border:1px solid #ddd;">
                        {{ $product->name }}
                    </td>

                    <td style="padding:10px; border:1px solid #ddd;">
                        {{ $product->slug }}
                    </td>

                    <td style="padding:10px; border:1px solid #ddd;">
                        ₹{{ $product->price }}
                    </td>

                    <td style="padding:10px; border:1px solid #ddd;">
                        {{ \Illuminate\Support\Str::limit($product->description, 50) }}
                    </td>

                    <td style="padding:10px; border:1px solid #ddd;">
                        <a href="{{ route('product.show', $product) }}" class="btn" style="padding:5px 10px;">View</a>

                        <form action="{{ route('product.destroy', $product) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                class="btn"
                                style="background:red;padding:5px 10px;"
                                onclick="return confirm('Are you sure you want to delete this product?')">
                                Delete
                            </button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" style="padding:15px; text-align:center;">
                        No products found.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
@endsection
```

---

### 📄 resources/views/product/create.blade.php

```blade
@extends('layouts.app')

@section('content')
    <h1>Add New Product</h1>

    @if ($errors->any())
        <div style="color:red;">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('product.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <label>Product Name</label>
        <input type="text" name="name" required>

        <label>Description</label>
        <textarea name="description" required></textarea>

        <label>Price</label>
        <input type="number" name="price" required>

        <label>Product Image</label>
        <input type="file" name="image" required>

        <button type="submit" class="btn">Save Product</button>
    </form>
@endsection
```

---

### 📄 resources/views/product/show.blade.php

```blade
@extends('layouts.app')

@section('content')

<h1>{{ $product->name }}</h1>

<img src="{{ asset($product->image) }}" width="350" style="border-radius:6px; margin-bottom:20px;">

<p>{{ $product->description }}</p>

<h2>Price: ₹{{ $product->price }}</h2>

<a href="{{ route('product.index') }}" class="btn">← Back to Products</a>

@php
$schema = [
    "@context" => "https://schema.org/",
    "@type" => "Product",
    "name" => $product->name,
    "image" => asset($product->image),
    "description" => $product->description,
    "offers" => [
        "@type" => "Offer",
        "priceCurrency" => "INR",
        "price" => $product->price,
        "availability" => "https://schema.org/InStock"
    ]
];
@endphp

<script type="application/ld+json">
{!! json_encode($schema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) !!}
</script>

@endsection
```

---

## Step 10 — Run Project

```bash
php artisan serve
```

Visit:

* Product List → [http://127.0.0.1:8000/product](http://127.0.0.1:8000/product)

  <img width="1592" height="926" alt="Screenshot 2026-02-05 115142" src="https://github.com/user-attachments/assets/893eb790-bddd-4de6-897f-f389afcdd316" />

* Add Product → [http://127.0.0.1:8000/product/create](http://127.0.0.1:8000/product/create)

  <img width="1499" height="929" alt="Screenshot 2026-02-05 115207" src="https://github.com/user-attachments/assets/3edda784-c1ad-44d0-87a9-83fd4d1543d7" />

* View Product → [http://127.0.0.1:8000/product/laptop](http://127.0.0.1:8000/product/laptop)

  <img width="1290" height="920" alt="Screenshot 2026-02-05 115105" src="https://github.com/user-attachments/assets/d97a4ed1-d52e-456f-b8d5-29eaf2ae387e" />

* View Product → [http://127.0.0.1:8000/product/tv](http://127.0.0.1:8000/product/tv)

  <img width="1286" height="923" alt="Screenshot 2026-02-05 115122" src="https://github.com/user-attachments/assets/a0b60a4b-f856-4f2e-a9c4-c2f0cec01648" />


---

## Final Result

Your Laravel app now includes:

✔ Dynamic Product Pages
✔ SEO Title & Description
✔ OpenGraph Tags
✔ Twitter Cards
✔ Canonical URLs
✔ Product Structured Data (Rich Results Ready)
