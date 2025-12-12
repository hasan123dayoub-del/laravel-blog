@extends('layout')
@section('title','تعديل مقال')

@section('content')
<div class="card">
  <div class="card-body">
    <h4>تعديل المقال</h4>

    <form action="{{ route('admin.blogs.update', $blog) }}" method="POST" enctype="multipart/form-data">
      @csrf @method('PUT')

      <div class="mb-3">
        <label class="form-label">العنوان</label>
        <input type="text" name="title" class="form-control" value="{{ old('title',$blog->title) }}" required>
      </div>

      <div class="mb-3">
        <label class="form-label">المحتوى</label>
        <textarea name="content" rows="6" class="form-control" required>{{ old('content',$blog->content) }}</textarea>
      </div>

      <div class="mb-3">
        <label class="form-label">الصورة الحالية</label><br>
        @if($blog->image)
          <img src="{{ asset('storage/'.$blog->image) }}" width="180" class="mb-2">
        @else
          <div class="text-muted mb-2">لا توجد صورة</div>
        @endif
        <input type="file" name="image" class="form-control">
      </div>

      <div class="mb-3">
        <label class="form-label">التصنيفات</label>
        <div>
          @foreach($categories as $c)
            <div class="form-check form-check-inline">
              <input class="form-check-input" type="checkbox" name="categories[]" id="cat{{ $c->id }}"
                     value="{{ $c->id }}" {{ in_array($c->id, $blog->categories->pluck('id')->toArray()) ? 'checked' : '' }}>
              <label class="form-check-label" for="cat{{ $c->id }}">{{ $c->name }}</label>
            </div>
          @endforeach
        </div>
      </div>

      <button class="btn btn-warning">تحديث</button>
      <a href="{{ route('admin.blogs.index') }}" class="btn btn-link">إلغاء</a>
    </form>
  </div>
</div>
@endsection
