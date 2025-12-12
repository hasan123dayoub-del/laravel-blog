@extends('layout')
@section('title','المقالات')

@section('content')
<h3 class="mb-4">المقالات</h3>

<div class="row">

    <div class="col-md-3 mb-3">
        <h5>التصنيفات</h5>
        @foreach($categories as $cat)
            <a href="{{ route('frontend.category', $cat->id) }}" class="btn btn-outline-secondary btn-sm mb-1 d-block">
                {{ $cat->name }}
            </a>
        @endforeach
    </div>

    <div class="col-md-9">
        <div class="row">
            @forelse($blogs as $blog)
                @include('frontend.partials.blog-card', ['blog' => $blog, 'type' => 'all'])
            @empty
                <div class="col-12 text-center">
                    <p>لا توجد مقالات حالياً.</p>
                </div>
            @endforelse
        </div>

        <div class="mt-3">
            {{ $blogs->links() }}
        </div>
    </div>
</div>
@endsection
