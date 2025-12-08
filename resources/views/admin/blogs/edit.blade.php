@extends('layouts.app')
@section('title', 'Edit Blog')

@section('content')
<h1>Edit Blog</h1>

<form action="{{ route('admin.blogs.update', $blog->id) }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')

    <div class="mb-3">
        <label for="title" class="form-label">Title</label>
        <input type="text" name="title" class="form-control" value="{{ old('title', $blog->title) }}" required>
    </div>

    <div class="mb-3">
        <label for="content" class="form-label">Content</label>
        <textarea name="content" class="form-control" rows="5" required>{{ old('content', $blog->content) }}</textarea>
    </div>

    <div class="mb-3">
        <label for="image" class="form-label">Image</label>
        <input type="file" name="image" class="form-control">
        @if($blog->image)
            <img src="{{ asset('storage/' . $blog->image) }}" width="120" class="mt-2">
        @endif
    </div>

    <div class="mb-3">
        <label class="form-label">Categories</label>
        <div class="form-check">
            @foreach($categories as $category)
            <input class="form-check-input" type="checkbox" name="categories[]" value="{{ $category->id }}"
                id="cat{{ $category->id }}"
                {{ $blog->categories->contains($category->id) ? 'checked' : '' }}>
            <label class="form-check-label" for="cat{{ $category->id }}">{{ $category->name }}</label><br>
            @endforeach
        </div>
    </div>

    <button type="submit" class="btn btn-primary">Update</button>
    <a href="{{ route('admin.blogs.index') }}" class="btn btn-secondary">Back</a>
</form>
@endsection
