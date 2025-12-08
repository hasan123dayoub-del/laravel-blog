@extends('layouts.app')
@section('title', 'All Categories')

@section('content')
<h1>All Categories</h1>
<a href="{{ route('admin.categories.create') }}" class="btn btn-primary mb-3">Add New Category</a>

<table class="table table-bordered">
    <thead>
        <tr>
            <th>Name</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        @foreach($categories as $category)
        <tr>
            <td>{{ $category->name }}</td>
            <td>
                <a href="{{ route('admin.categories.edit', $category->id) }}" class="btn btn-warning btn-sm">Edit</a>
                <form action="{{ route('admin.categories.destroy', $category->id) }}" method="POST" class="d-inline">
                    @csrf
                    @method('DELETE')
                    <button class="btn btn-danger btn-sm" type="submit">Delete</button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
@endsection
