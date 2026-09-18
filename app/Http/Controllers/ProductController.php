<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    /**
     * Display all products.
     */
    public function index()
    {
        $products = Product::latest()->get();

        seo()
            ->title('All Products')
            ->description('Browse all available products in our store.')
            ->twitter();

        return view('product.index', compact('products'));
    }

    /**
     * Show product creation form.
     */
    public function create()
    {
        seo()
            ->title('Add New Product')
            ->description('Create a new product with SEO metadata.');

        return view('product.create');
    }

    /**
     * Store new product.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'image' => 'required|image|mimes:jpg,jpeg,png,webp|max:2048',

            'meta_title' => 'nullable|string|max:60',
            'meta_description' => 'nullable|string|max:160',
            'focus_keyword' => 'nullable|string|max:100',
        ]);

        /*
         * Make sure the products directory exists.
         */
        if (!file_exists(public_path('products'))) {
            mkdir(public_path('products'), 0755, true);
        }

        /*
         * Generate unique image name.
         */
        $imageName = time() . '_' . Str::random(6) . '.' .
            $request->image->extension();

        /*
         * Move image into public/products.
         */
        $request->image->move(
            public_path('products'),
            $imageName
        );

        /*
         * Generate SEO-friendly slug.
         */
        $slug = Str::slug($request->name);

        /*
         * Prevent duplicate slug.
         */
        $originalSlug = $slug;
        $counter = 1;

        while (Product::where('slug', $slug)->exists()) {
            $slug = $originalSlug . '-' . $counter;
            $counter++;
        }

        /*
         * Create product.
         */
        Product::create([
            'name' => $request->name,
            'slug' => $slug,
            'description' => $request->description,
            'price' => $request->price,
            'image' => 'products/' . $imageName,

            'meta_title' => $request->meta_title,
            'meta_description' => $request->meta_description,
            'focus_keyword' => $request->focus_keyword,
        ]);

        return redirect()
            ->route('product.index')
            ->with('success', 'Product added successfully with SEO metadata!');
    }

    /**
     * Show individual product with SEO information.
     */
    public function show(Product $product)
    {
        $metaTitle = $product->meta_title ?: $product->name;

        $metaDescription = $product->meta_description
            ?: Str::limit($product->description, 160);

        seo()
            ->title($metaTitle)
            ->description($metaDescription)
            ->image(asset($product->image))
            ->twitter()
            ->type('product');

        return view('product.show', compact('product'));
    }

    /**
     * Delete product and image.
     */
    public function destroy(Product $product)
    {
        if (
            !empty($product->image) &&
            file_exists(public_path($product->image))
        ) {
            unlink(public_path($product->image));
        }

        $product->delete();

        return redirect()
            ->route('product.index')
            ->with('success', 'Product deleted successfully!');
    }

    /**
     * Generate dynamic XML sitemap.
     */
    public function sitemap()
    {
        $products = Product::latest()->get();

        return response()
            ->view('seo.sitemap', compact('products'))
            ->header('Content-Type', 'application/xml');
    }


/**
 * Generate dynamic robots.txt.
 */
public function robots()
{
    $content = "User-agent: *\n";
    $content .= "Allow: /\n";
    $content .= "Disallow: /product/create\n";
    $content .= "\n";
    $content .= "Sitemap: " . url('/sitemap.xml') . "\n";

    return response($content)
        ->header('Content-Type', 'text/plain');
}
}