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
