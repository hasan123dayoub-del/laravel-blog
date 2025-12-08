@extends('layouts.app')
@section('title', $blog->title)

@section('content')
<h1>{{ $blog->title }}</h1>

@if($blog->image)
    <img src="{{ asset('storage/' . $blog->image) }}" width="300" class="mb-3">
@endif

<p>{{ $blog->content }}</p>

<h5>Categories:</h5>
@foreach($blog->categories as $category)
    <span class="badge bg-info text-dark">{{ $category->name }}</span>
@endforeach

<div class="mt-3">
    <a href="{{ route('admin.blogs.index') }}" class="btn btn-secondary">Back</a>
    <a href="{{ route('admin.blogs.edit', $blog->id) }}" class="btn btn-warning">Edit</a>
</div>
@endsection
