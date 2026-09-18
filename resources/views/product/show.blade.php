@extends('layouts.app')

@section('content')

<style>
    .product-container {
        max-width: 900px;
        margin: auto;
    }

    .product-image {
        width: 350px;
        max-width: 100%;
        border-radius: 8px;
        margin-bottom: 20px;
    }

    .seo-panel {
        background: #f7f9fc;
        border: 1px solid #ddd;
        border-radius: 8px;
        padding: 20px;
        margin-top: 30px;
    }

    .seo-panel h2 {
        margin-top: 0;
    }

    .seo-item {
        padding: 10px 0;
        border-bottom: 1px solid #ddd;
    }

    .seo-item:last-child {
        border-bottom: none;
    }

    .score {
        font-size: 24px;
        font-weight: bold;
    }

    .score-excellent {
        color: #198754;
    }

    .score-good {
        color: #997404;
    }

    .score-needs {
        color: #d97706;
    }

    .score-poor {
        color: #dc3545;
    }

    .preview {
        background: #fff;
        border: 1px solid #ddd;
        padding: 15px;
        border-radius: 6px;
        margin-top: 20px;
    }

    .preview-title {
        color: #1a0dab;
        font-size: 20px;
    }

    .preview-url {
        color: #188038;
        font-size: 14px;
    }

    .preview-description {
        color: #555;
        font-size: 14px;
        margin-top: 5px;
    }
</style>


<div class="product-container">

    <h1>{{ $product->name }}</h1>


    @if($product->image)

        <img
            src="{{ asset($product->image) }}"
            alt="{{ $product->name }}"
            class="product-image"
        >

    @endif


    <p>
        {{ $product->description }}
    </p>


    <h2>
        Price: ₹{{ number_format($product->price, 2) }}
    </h2>


    <a
        href="{{ route('product.index') }}"
        class="btn"
    >
        ← Back to Products
    </a>


    {{-- SEO INFORMATION --}}
    <div class="seo-panel">

        <h2>
            🔍 SEO Analysis
        </h2>


        @php

            $scoreClass = match(true) {

                $product->seo_score >= 80
                    => 'score-excellent',

                $product->seo_score >= 60
                    => 'score-good',

                $product->seo_score >= 40
                    => 'score-needs',

                default
                    => 'score-poor',

            };

        @endphp


        <div class="seo-item">

            <strong>SEO Score:</strong>

            <span class="score {{ $scoreClass }}">

                {{ $product->seo_score }}/100

            </span>

        </div>


        <div class="seo-item">

            <strong>SEO Status:</strong>

            {{ $product->seo_score_label }}

        </div>


        <div class="seo-item">

            <strong>Meta Title:</strong>

            {{ $product->meta_title ?: 'Not configured' }}

        </div>


        <div class="seo-item">

            <strong>Meta Description:</strong>

            {{ $product->meta_description ?: 'Not configured' }}

        </div>


        <div class="seo-item">

            <strong>Focus Keyword:</strong>

            {{ $product->focus_keyword ?: 'Not configured' }}

        </div>


        <div class="seo-item">

            <strong>SEO Slug:</strong>

            {{ $product->slug }}

        </div>


        <div class="seo-item">

            <strong>Canonical URL:</strong>

            {{ url('/product/' . $product->slug) }}

        </div>


        {{-- SEARCH ENGINE PREVIEW --}}
        <h3 style="margin-top:25px;">
            🔎 Search Engine Preview
        </h3>


        <div class="preview">

            <div class="preview-title">

                {{ $product->meta_title ?: $product->name }}

            </div>


            <div class="preview-url">

                {{ url('/product/' . $product->slug) }}

            </div>


            <div class="preview-description">

                {{
                    $product->meta_description
                    ?: \Illuminate\Support\Str::limit(
                        $product->description,
                        160
                    )
                }}

            </div>

        </div>

    </div>


    {{-- JSON-LD STRUCTURED DATA --}}
    @php

        $schema = [

            "@context" => "https://schema.org/",

            "@type" => "Product",

            "name" => $product->name,

            "image" => asset($product->image),

            "description" => $product->description,

            "url" => url('/product/' . $product->slug),

            "offers" => [

                "@type" => "Offer",

                "priceCurrency" => "INR",

                "price" => $product->price,

                "availability" =>
                    "https://schema.org/InStock",

                "url" =>
                    url('/product/' . $product->slug),

            ],

        ];

    @endphp


    <script type="application/ld+json">

        {!! json_encode(
            $schema,
            JSON_UNESCAPED_SLASHES |
            JSON_UNESCAPED_UNICODE
        ) !!}

    </script>

</div>

@endsection