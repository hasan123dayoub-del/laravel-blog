@extends('layouts.app')
@section('title', $category->name)

@section('content')
<h1>Category Details</h1>

<p><strong>Name:</strong> {{ $category->name }}</p>

<a href="{{ route('admin.categories.index') }}" class="btn btn-secondary">Back</a>
<a href="{{ route('admin.categories.edit', $category->id) }}" class="btn btn-warning">Edit</a>
@endsection
