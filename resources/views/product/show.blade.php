@extends('layouts.app')

@section('content')

<h1>{{ $product->name }}</h1>

<img src="{{ asset($product->image) }}" width="350" style="border-radius:6px; margin-bottom:20px;">

<p>{{ $product->description }}</p>

<h2>Price: ₹{{ $product->price }}</h2>

<a href="{{ route('product.index') }}" class="btn">← Back to Products</a>

{{-- SEO Schema JSON-LD SAFE VERSION --}}
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
