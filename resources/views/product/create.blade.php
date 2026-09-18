@extends('layouts.app')

@section('content')

<style>
    .form-card {
        max-width: 800px;
        margin: auto;
    }

    .section-title {
        background: #111;
        color: #fff;
        padding: 12px 15px;
        border-radius: 5px;
        margin-top: 25px;
        margin-bottom: 20px;
    }

    .field-label {
        font-weight: bold;
        display: block;
        margin-bottom: 5px;
    }

    .help-text {
        color: #777;
        font-size: 13px;
        margin-top: -8px;
        margin-bottom: 15px;
    }

    .seo-box {
        background: #f4f8ff;
        border: 1px solid #cdddf5;
        padding: 20px;
        border-radius: 8px;
        margin-top: 20px;
    }

    .btn-save {
        margin-top: 20px;
        border: none;
        cursor: pointer;
    }
</style>

<div class="form-card">

    <h1>Add New Product</h1>

    @if ($errors->any())
        <div style="
            background:#ffe6e6;
            color:#b30000;
            padding:15px;
            border-radius:6px;
            margin-bottom:20px;
        ">
            <strong>Please fix the following errors:</strong>

            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form
        action="{{ route('product.store') }}"
        method="POST"
        enctype="multipart/form-data"
    >

        @csrf

        {{-- PRODUCT INFORMATION --}}
        <div class="section-title">
            📦 Product Information
        </div>

        <label class="field-label">
            Product Name
        </label>

        <input
            type="text"
            name="name"
            value="{{ old('name') }}"
            placeholder="Example: Premium Laptop"
            required
        >

        <label class="field-label">
            Description
        </label>

        <textarea
            name="description"
            rows="6"
            placeholder="Enter detailed product description..."
            required
        >{{ old('description') }}</textarea>

        <label class="field-label">
            Price
        </label>

        <input
            type="number"
            name="price"
            value="{{ old('price') }}"
            min="0"
            step="0.01"
            placeholder="Example: 59999"
            required
        >

        <label class="field-label">
            Product Image
        </label>

        <input
            type="file"
            name="image"
            accept=".jpg,.jpeg,.png,.webp"
            required
        >

        <div class="help-text">
            Allowed formats: JPG, JPEG, PNG and WEBP. Maximum size: 2 MB.
        </div>


        {{-- SEO INFORMATION --}}
        <div class="section-title">
            🔍 SEO Optimization
        </div>

        <div class="seo-box">

            <label class="field-label">
                Meta Title
            </label>

            <input
                type="text"
                name="meta_title"
                value="{{ old('meta_title') }}"
                maxlength="60"
                placeholder="Example: Premium Laptop - Best Price"
            >

            <div class="help-text">
                Recommended length: 30–60 characters.
            </div>


            <label class="field-label">
                Meta Description
            </label>

            <textarea
                name="meta_description"
                rows="4"
                maxlength="160"
                placeholder="Write a search-engine friendly description..."
            >{{ old('meta_description') }}</textarea>

            <div class="help-text">
                Recommended length: 120–160 characters.
            </div>


            <label class="field-label">
                Focus Keyword
            </label>

            <input
                type="text"
                name="focus_keyword"
                value="{{ old('focus_keyword') }}"
                maxlength="100"
                placeholder="Example: premium laptop"
            >

            <div class="help-text">
                Use the main keyword you want this product page to target.
            </div>

        </div>


        <button
            type="submit"
            class="btn btn-save"
        >
            💾 Save Product
        </button>

        <a
            href="{{ route('product.index') }}"
            class="btn"
            style="margin-left:10px;"
        >
            ← Back
        </a>

    </form>

</div>

@endsection