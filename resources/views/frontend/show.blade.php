@extends('layout')
@section('title',$blog->title)

@section('content')
<div class="card mb-3">
  @if($blog->image)
    <img src="{{ asset('storage/blogs/'.$blog->image) }}" class="card-img-top" style="height:300px;object-fit:cover;">
  @endif
  <div class="card-body">
    <h3>{{ $blog->title }}</h3>
    <p>{{ $blog->content }}</p>
    <p>
      @foreach($blog->categories as $cat)
        <span class="badge bg-secondary">{{ $cat->name }}</span>
      @endforeach
    </p>
    <a href="{{ route('frontend.index') }}" class="btn btn-link">العودة للمقالات</a>
  </div>
</div>
@endsection
