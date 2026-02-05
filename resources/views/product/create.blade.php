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
