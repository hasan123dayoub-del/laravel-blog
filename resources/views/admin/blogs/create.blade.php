@extends('layout')
@section('title','إضافة مقال')

@section('content')
<div class="card">
  <div class="card-body">
    <h4>إنشاء مقال جديد</h4>
    <form action="{{ route('admin.blogs.store') }}" method="POST" enctype="multipart/form-data">
      @csrf

      <div class="mb-3">
        <label class="form-label">العنوان</label>
        <input type="text" name="title" class="form-control" value="{{ old('title') }}" required>
      </div>

      <div class="mb-3">
        <label class="form-label">المحتوى</label>
        <textarea name="content" rows="6" class="form-control" required>{{ old('content') }}</textarea>
      </div>

      <div class="mb-3">
        <label class="form-label">الصورة (اختياري)</label>
        <input type="file" name="image" class="form-control">
      </div>

      <div class="mb-3">
        <label class="form-label">التصنيفات</label>
        <div>
          @foreach($categories as $c)
            <div class="form-check form-check-inline">
              <input class="form-check-input" type="checkbox" name="categories[]" id="cat{{ $c->id }}" value="{{ $c->id }}">
              <label class="form-check-label" for="cat{{ $c->id }}">{{ $c->name }}</label>
            </div>
          @endforeach
        </div>
      </div>

      <button class="btn btn-primary">حفظ</button>
      <a href="{{ route('admin.blogs.index') }}" class="btn btn-link">إلغاء</a>
    </form>
  </div>
</div>
@endsection
