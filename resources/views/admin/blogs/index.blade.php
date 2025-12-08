@extends('layouts.app')
@section('title', 'All Blogs')

@section('content')
<h1>All Blogs</h1>
<a href="{{ route('admin.blogs.create') }}" class="btn btn-primary mb-3">Add New Blog</a>

<table class="table table-bordered">
    <thead>
        <tr>
            <th>Title</th>
            <th>Image</th>
            <th>Categories</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        @foreach($blogs as $blog)
        <tr>
            <td>{{ $blog->title }}</td>
            <td>
                @if($blog->image)
                    <img src="{{ asset('storage/' . $blog->image) }}" width="100" height="70">
                @endif
            </td>
            <td>
                @foreach($blog->categories as $category)
                    <span class="badge bg-info text-dark">{{ $category->name }}</span>
                @endforeach
            </td>
            <td>
                <a href="{{ route('admin.blogs.show', $blog->id) }}" class="btn btn-info btn-sm">Show</a>
                <a href="{{ route('admin.blogs.edit', $blog->id) }}" class="btn btn-warning btn-sm">Edit</a>
                <form action="{{ route('admin.blogs.destroy', $blog->id) }}" method="POST" class="d-inline">
                    @csrf
                    @method('DELETE')
                    <button class="btn btn-danger btn-sm">Delete</button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

<a href="{{ route('admin.blogs.trash') }}" class="btn btn-secondary mt-3">View Trash</a>
@endsection
