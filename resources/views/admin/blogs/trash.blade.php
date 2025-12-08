@extends('layouts.app')
@section('title', 'Trash Blogs')

@section('content')
<h1>Deleted Blogs (Trash)</h1>

<table class="table table-bordered">
    <thead>
        <tr>
            <th>Title</th>
            <th>Deleted At</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        @foreach($blogs as $blog)
        <tr>
            <td>{{ $blog->title }}</td>
            <td>{{ $blog->deleted_at }}</td>
            <td>
                <form action="{{ route('admin.blogs.restore', $blog->id) }}" method="POST" class="d-inline">
                    @csrf
                    @method('PUT')
                    <button class="btn btn-success btn-sm">Restore</button>
                </form>
                <form action="{{ route('admin.blogs.forceDelete', $blog->id) }}" method="POST" class="d-inline">
                    @csrf
                    @method('DELETE')
                    <button class="btn btn-danger btn-sm">Delete Permanently</button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

<a href="{{ route('admin.blogs.index') }}" class="btn btn-secondary mt-3">Back to Blogs</a>
@endsection
