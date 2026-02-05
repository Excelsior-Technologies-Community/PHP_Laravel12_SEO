@extends('layouts.app')

@section('content')
    {{-- Page heading --}}
    <h1>All Products</h1>

    {{-- Button to go to product creation form --}}
    <a href="{{ route('product.create') }}" class="btn" style="margin-bottom:15px;">+ Add Product</a>

    {{-- Products table --}}
    <table style="width:100%; border-collapse: collapse; margin-top:20px;">
        <thead style="background:#111; color:#fff;">
            <tr>
                {{-- Product image column --}}
                <th style="padding:10px; border:1px solid #ddd;">Image</th>

                {{-- Product name column --}}
                <th style="padding:10px; border:1px solid #ddd;">Name</th>

                {{-- SEO-friendly slug column --}}
                <th style="padding:10px; border:1px solid #ddd;">Slug</th>

                {{-- Product price column --}}
                <th style="padding:10px; border:1px solid #ddd;">Price</th>

                {{-- Short product description column --}}
                <th style="padding:10px; border:1px solid #ddd;">Description</th>

                {{-- Action buttons column --}}
                <th style="padding:10px; border:1px solid #ddd;">Action</th>
            </tr>
        </thead>

        <tbody>
            {{-- Loop through products list --}}
            @forelse($products as $product)
                <tr>
                    {{-- Display product image --}}
                    <td style="padding:10px; border:1px solid #ddd; text-align:center;">
                        <img src="{{ asset($product->image) }}" width="60" style="border-radius:4px;">
                    </td>

                    {{-- Display product name --}}
                    <td style="padding:10px; border:1px solid #ddd;">
                        {{ $product->name }}
                    </td>

                    {{-- Display product slug --}}
                    <td style="padding:10px; border:1px solid #ddd;">
                        {{ $product->slug }}
                    </td>

                    {{-- Display product price --}}
                    <td style="padding:10px; border:1px solid #ddd;">
                        ₹{{ $product->price }}
                    </td>

                    {{-- Display shortened product description --}}
                    <td style="padding:10px; border:1px solid #ddd;">
                        {{ \Illuminate\Support\Str::limit($product->description, 50) }}
                    </td>

                    {{-- Action buttons: View + Delete --}}
                    <td style="padding:10px; border:1px solid #ddd;">
                        {{-- View product details --}}
                        <a href="{{ route('product.show', $product) }}" class="btn" style="padding:5px 10px;">View</a>

                        {{-- Delete product form --}}
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
                {{-- Show message if no products exist --}}
                <tr>
                    <td colspan="6" style="padding:15px; text-align:center;">
                        No products found.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
@endsection
