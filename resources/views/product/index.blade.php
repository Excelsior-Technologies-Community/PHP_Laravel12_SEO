@extends('layouts.app')

@section('content')

<style>
    * {
        box-sizing: border-box;
    }

    .dashboard {
        max-width: 1200px;
        margin: 0 auto;
    }

    /* Header */
    .dashboard-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 20px;
        margin-bottom: 25px;
        flex-wrap: wrap;
    }

    .dashboard-title h1 {
        margin: 0 0 6px;
        font-size: 30px;
        color: #111827;
    }

    .dashboard-title p {
        margin: 0;
        color: #6b7280;
        font-size: 15px;
    }

    .add-product-btn {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        background: #111827;
        color: #fff;
        text-decoration: none;
        padding: 11px 18px;
        border-radius: 8px;
        font-weight: 600;
        transition: 0.2s;
    }

    .add-product-btn:hover {
        background: #000;
        transform: translateY(-1px);
    }

    /* Success Message */
    .success-message {
        display: flex;
        align-items: center;
        gap: 10px;
        background: #ecfdf3;
        color: #166534;
        border: 1px solid #bbf7d0;
        padding: 13px 16px;
        border-radius: 8px;
        margin-bottom: 22px;
        font-size: 14px;
        font-weight: 500;
    }

    /* Statistics */
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 18px;
        margin-bottom: 25px;
    }

    .stat-card {
        background: #fff;
        border: 1px solid #e5e7eb;
        border-radius: 12px;
        padding: 20px;
        box-shadow: 0 3px 12px rgba(0, 0, 0, 0.04);
    }

    .stat-top {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 12px;
    }

    .stat-label {
        color: #6b7280;
        font-size: 14px;
        font-weight: 500;
    }

    .stat-icon {
        width: 38px;
        height: 38px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: #f3f4f6;
        border-radius: 9px;
        font-size: 18px;
    }

    .stat-value {
        font-size: 27px;
        font-weight: 700;
        color: #111827;
    }

    /* SEO Tools */
    .seo-tools {
        background: #111827;
        border-radius: 12px;
        padding: 20px;
        margin-bottom: 25px;
        color: #fff;
    }

    .seo-tools-header {
        margin-bottom: 15px;
    }

    .seo-tools-header h2 {
        margin: 0 0 5px;
        font-size: 19px;
    }

    .seo-tools-header p {
        margin: 0;
        color: #d1d5db;
        font-size: 13px;
    }

    .seo-tool-buttons {
        display: flex;
        gap: 10px;
        flex-wrap: wrap;
    }

    .seo-tool-btn {
        display: inline-flex;
        align-items: center;
        gap: 7px;
        background: #fff;
        color: #111827;
        text-decoration: none;
        padding: 9px 14px;
        border-radius: 7px;
        font-size: 13px;
        font-weight: 600;
        transition: 0.2s;
    }

    .seo-tool-btn:hover {
        background: #f3f4f6;
    }

    /* Product Section */
    .product-card {
        background: #fff;
        border: 1px solid #e5e7eb;
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 3px 12px rgba(0, 0, 0, 0.04);
    }

    .product-card-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 18px 20px;
        border-bottom: 1px solid #e5e7eb;
        gap: 15px;
        flex-wrap: wrap;
    }

    .product-card-header h2 {
        margin: 0;
        font-size: 19px;
        color: #111827;
    }

    .product-count {
        color: #6b7280;
        font-size: 13px;
    }

    /* Table */
    .table-wrapper {
        width: 100%;
        overflow-x: auto;
    }

    .product-table {
        width: 100%;
        border-collapse: collapse;
        min-width: 900px;
    }

    .product-table th {
        background: #f9fafb;
        color: #4b5563;
        text-align: left;
        padding: 13px 15px;
        border-bottom: 1px solid #e5e7eb;
        font-size: 12px;
        text-transform: uppercase;
        letter-spacing: 0.4px;
        white-space: nowrap;
    }

    .product-table td {
        padding: 14px 15px;
        border-bottom: 1px solid #f1f5f9;
        color: #374151;
        font-size: 14px;
        vertical-align: middle;
    }

    .product-table tbody tr {
        transition: 0.15s;
    }

    .product-table tbody tr:hover {
        background: #f9fafb;
    }

    .product-table tbody tr:last-child td {
        border-bottom: none;
    }

    /* Product Image */
    .product-image-wrapper {
        width: 58px;
        height: 58px;
        border-radius: 9px;
        overflow: hidden;
        background: #f3f4f6;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .product-image-wrapper img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .no-image {
        color: #9ca3af;
        font-size: 11px;
    }

    /* Product Name */
    .product-name {
        font-weight: 600;
        color: #111827;
        margin-bottom: 3px;
    }

    .product-slug {
        color: #6b7280;
        font-size: 12px;
    }

    /* Price */
    .product-price {
        font-weight: 700;
        color: #111827;
        white-space: nowrap;
    }

    /* SEO Score */
    .seo-score-wrapper {
        min-width: 100px;
    }

    .seo-score {
        display: inline-flex;
        align-items: center;
        padding: 5px 9px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 700;
        white-space: nowrap;
    }

    .score-excellent {
        background: #dcfce7;
        color: #166534;
    }

    .score-good {
        background: #fef3c7;
        color: #92400e;
    }

    .score-needs {
        background: #ffedd5;
        color: #9a3412;
    }

    .score-poor {
        background: #fee2e2;
        color: #991b1b;
    }

    .seo-label {
        display: block;
        margin-top: 4px;
        color: #6b7280;
        font-size: 11px;
    }

    /* Description */
    .description {
        max-width: 220px;
        color: #6b7280;
        line-height: 1.5;
    }

    /* Actions */
    .action-buttons {
        display: flex;
        gap: 7px;
        align-items: center;
    }

    .view-btn {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        background: #111827;
        color: #fff;
        text-decoration: none;
        padding: 7px 11px;
        border-radius: 6px;
        font-size: 12px;
        font-weight: 600;
    }

    .view-btn:hover {
        background: #000;
    }

    .delete-btn {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        background: #fff;
        color: #dc2626;
        border: 1px solid #fecaca;
        padding: 6px 10px;
        border-radius: 6px;
        font-size: 12px;
        font-weight: 600;
        cursor: pointer;
    }

    .delete-btn:hover {
        background: #fef2f2;
    }

    /* Empty State */
    .empty-state {
        text-align: center;
        padding: 60px 20px;
    }

    .empty-icon {
        width: 60px;
        height: 60px;
        background: #f3f4f6;
        border-radius: 50%;
        margin: 0 auto 15px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 25px;
    }

    .empty-state h3 {
        margin: 0 0 7px;
        color: #111827;
    }

    .empty-state p {
        margin: 0 0 20px;
        color: #6b7280;
        font-size: 14px;
    }

    /* Responsive */
    @media (max-width: 850px) {

        .stats-grid {
            grid-template-columns: 1fr;
        }

        .dashboard-title h1 {
            font-size: 25px;
        }

        .dashboard-header {
            align-items: flex-start;
        }

        .add-product-btn {
            width: 100%;
            justify-content: center;
        }
    }

    @media (max-width: 600px) {

        .dashboard {
            padding: 0 5px;
        }

        .seo-tools {
            padding: 16px;
        }

        .seo-tool-buttons {
            flex-direction: column;
        }

        .seo-tool-btn {
            justify-content: center;
        }

        .product-card-header {
            align-items: flex-start;
        }
    }
</style>

<div class="dashboard">


{{-- PAGE HEADER --}}
<div class="dashboard-header">

    <div class="dashboard-title">

        <h1>Product SEO Dashboard</h1>

        <p>
            Manage products and monitor their search engine optimization.
        </p>

    </div>

    <a
        href="{{ route('product.create') }}"
        class="add-product-btn"
    >
        <span>＋</span>
        Add New Product
    </a>

</div>


{{-- SUCCESS MESSAGE --}}
@if(session('success'))

    <div class="success-message">

        <span>✓</span>

        <span>{{ session('success') }}</span>

    </div>

@endif


{{-- STATISTICS --}}
@php
    $totalProducts = $products->count();

    $excellentProducts = $products
        ->filter(fn($product) => $product->seo_score >= 80)
        ->count();

    $averageSeoScore = $totalProducts > 0
        ? round($products->avg('seo_score'))
        : 0;
@endphp


<div class="stats-grid">

    {{-- TOTAL PRODUCTS --}}
    <div class="stat-card">

        <div class="stat-top">

            <span class="stat-label">
                Total Products
            </span>

            <span class="stat-icon">
                📦
            </span>

        </div>

        <div class="stat-value">
            {{ $totalProducts }}
        </div>

    </div>


    {{-- SEO SCORE --}}
    <div class="stat-card">

        <div class="stat-top">

            <span class="stat-label">
                Average SEO Score
            </span>

            <span class="stat-icon">
                🔍
            </span>

        </div>

        <div class="stat-value">
            {{ $averageSeoScore }}/100
        </div>

    </div>


    {{-- OPTIMIZED PRODUCTS --}}
    <div class="stat-card">

        <div class="stat-top">

            <span class="stat-label">
                Well Optimized
            </span>

            <span class="stat-icon">
                ✓
            </span>

        </div>

        <div class="stat-value">
            {{ $excellentProducts }}
        </div>

    </div>

</div>


{{-- SEO TOOLS --}}
<div class="seo-tools">

    <div class="seo-tools-header">

        <h2>
            SEO Tools
        </h2>

        <p>
            Manage technical SEO resources for your product website.
        </p>

    </div>


    <div class="seo-tool-buttons">

        <a
            href="{{ route('seo.sitemap') }}"
            target="_blank"
            class="seo-tool-btn"
        >
            🗺️ XML Sitemap
        </a>

        <a
            href="{{ route('seo.robots') }}"
            target="_blank"
            class="seo-tool-btn"
        >
            🤖 Robots.txt
        </a>

    </div>

</div>


{{-- PRODUCT TABLE --}}
<div class="product-card">

    <div class="product-card-header">

        <h2>
            All Products
        </h2>

        <span class="product-count">
            {{ $totalProducts }}
            {{ $totalProducts == 1 ? 'product' : 'products' }}
        </span>

    </div>


    <div class="table-wrapper">

        <table class="product-table">

            <thead>

                <tr>

                    <th>
                        Image
                    </th>

                    <th>
                        Product
                    </th>

                    <th>
                        Price
                    </th>

                    <th>
                        SEO Score
                    </th>

                    <th>
                        Description
                    </th>

                    <th>
                        Actions
                    </th>

                </tr>

            </thead>


            <tbody>

                @forelse($products as $product)

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


                    <tr>

                        {{-- IMAGE --}}
                        <td>

                            <div class="product-image-wrapper">

                                @if($product->image)

                                    <img
                                        src="{{ asset($product->image) }}"
                                        alt="{{ $product->name }}"
                                    >

                                @else

                                    <span class="no-image">
                                        No Image
                                    </span>

                                @endif

                            </div>

                        </td>


                        {{-- PRODUCT --}}
                        <td>

                            <div class="product-name">
                                {{ $product->name }}
                            </div>

                            <div class="product-slug">
                                /product/{{ $product->slug }}
                            </div>

                        </td>


                        {{-- PRICE --}}
                        <td>

                            <span class="product-price">
                                ₹{{ number_format($product->price, 2) }}
                            </span>

                        </td>


                        {{-- SEO SCORE --}}
                        <td>

                            <div class="seo-score-wrapper">

                                <span
                                    class="seo-score {{ $scoreClass }}"
                                >
                                    {{ $product->seo_score }}/100
                                </span>

                                <span class="seo-label">
                                    {{ $product->seo_score_label }}
                                </span>

                            </div>

                        </td>


                        {{-- DESCRIPTION --}}
                        <td>

                            <div class="description">

                                {{ \Illuminate\Support\Str::limit(
                                    $product->description,
                                    80
                                ) }}

                            </div>

                        </td>


                        {{-- ACTIONS --}}
                        <td>

                            <div class="action-buttons">

                                <a
                                    href="{{ route(
                                        'product.show',
                                        $product
                                    ) }}"
                                    class="view-btn"
                                >
                                    👁 View
                                </a>


                                <form
                                    action="{{ route(
                                        'product.destroy',
                                        $product
                                    ) }}"
                                    method="POST"
                                    style="display:inline;"
                                >

                                    @csrf

                                    @method('DELETE')

                                    <button
                                        type="submit"
                                        class="delete-btn"
                                        onclick="
                                            return confirm(
                                                'Are you sure you want to delete this product?'
                                            )
                                        "
                                    >
                                        🗑 Delete
                                    </button>

                                </form>

                            </div>

                        </td>

                    </tr>

                @empty

                    <tr>

                        <td
                            colspan="6"
                            style="border:none;"
                        >

                            <div class="empty-state">

                                <div class="empty-icon">
                                    📦
                                </div>

                                <h3>
                                    No Products Found
                                </h3>

                                <p>
                                    Start by adding your first product
                                    and optimize it for SEO.
                                </p>

                                <a
                                    href="{{ route('product.create') }}"
                                    class="add-product-btn"
                                >
                                    ＋ Add Your First Product
                                </a>

                            </div>

                        </td>

                    </tr>

                @endforelse

            </tbody>

        </table>

    </div>

</div>

</div>

@endsection
