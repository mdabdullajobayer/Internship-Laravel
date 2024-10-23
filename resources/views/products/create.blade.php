@extends('layouts.admin', ['title' => 'Create Product'])

@section('mainContent')

<div class="container mt-5">
    <h2>Create Product</h2>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="form-group">
            <label for="name">Product Name</label>
            <input type="text" class="form-control" id="name" name="name" required>
        </div>

        <div class="form-group">
            <label for="image">Product Image</label>
            <input type="file" class="form-control" id="image" name="image" required>
        </div>

        <div class="form-group">
            <label for="features">Features</label>
            <input type="text" class="form-control" id="features" name="features[]" placeholder="Feature 1" required>
            <input type="text" class="form-control mt-2" name="features[]" placeholder="Feature 2">
            <input type="text" class="form-control mt-2" name="features[]" placeholder="Feature 3">
            <button type="button" class="btn btn-link" id="add-feature">Add Another Feature</button>
        </div>

        <button type="submit" class="btn btn-primary">Create Product</button>
    </form>
</div>

<script>
    document.getElementById('add-feature').addEventListener('click', function() {
        const input = document.createElement('input');
        input.type = 'text';
        input.className = 'form-control mt-2';
        input.name = 'features[]';
        input.placeholder = 'Feature ' + (document.querySelectorAll('input[name="features[]"]').length + 1);
        document.querySelector('form .form-group').appendChild(input);
    });
</script>
@endsection