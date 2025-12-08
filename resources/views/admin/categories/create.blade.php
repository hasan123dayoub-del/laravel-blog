@extends('layouts.app')
@section('title', 'Create Category')

@section('content')
<h1>Create Category</h1>

<form action="{{ route('admin.categories.store') }}" method="POST">
    @csrf
    <div class="mb-3">
        <label for="name" class="form-label">Category Name</label>
        <input type="text" name="name" class="form-control" value="{{ old('name') }}" required>
    </div>
    <button type="submit" class="btn btn-primary">Create</button>
    <a href="{{ route('admin.categories.index') }}" class="btn btn-secondary">Back</a>
</form>
@endsection
