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
