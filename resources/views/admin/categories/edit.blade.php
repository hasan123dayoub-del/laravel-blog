@extends('layouts.app')
@section('title', 'Edit Category')

@section('content')
<h1>Edit Category</h1>

<form action="{{ route('admin.categories.update', $category->id) }}" method="POST">
    @csrf
    @method('PUT')
    <div class="mb-3">
        <label for="name" class="form-label">Category Name</label>
        <input type="text" name="name" class="form-control" value="{{ old('name', $category->name) }}" required>
    </div>
    <button type="submit" class="btn btn-primary">Update</button>
    <a href="{{ route('admin.categories.index') }}" class="btn btn-secondary">Back</a>
</form>
@endsection
