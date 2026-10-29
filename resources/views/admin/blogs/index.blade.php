@extends('layout')
@section('title','كل المقالات')

@section('content')
<div class="card">
  <div class="card-body">
    <h4>كل المقالات</h4>
    <a href="{{ route('admin.blogs.create') }}" class="btn btn-primary mb-3">إضافة مقال جديد</a>
    <a href="{{ route('admin.blogs.trash') }}" class="btn btn-secondary mb-3">المحذوفات</a>
    <a href="{{ route('frontend.favorites') }}" class="btn btn-success mb-3">مفضلاتي</a>

    @if($blogs->count() > 0)
    <table class="table table-bordered table-striped">
      <thead>
        <tr>
          <th>#</th>
          <th>العنوان</th>
          <th>المحتوى</th>
          <th>الصورة</th>
          <th>التصنيفات</th>
          <th>الإجراءات</th>
        </tr>
      </thead>
      <tbody>
        @foreach($blogs as $blog)
        <tr>
          <td>{{ $loop->iteration }}</td>
          <td>{{ $blog->title }}</td>
          <td>{{ Str::limit($blog->content,50) }}</td>
          <td>
            @if($blog->image)
              <img src="{{ asset('storage/blogs/'.$blog->image) }}" width="100">
            @else
              <span class="text-muted">لا توجد صورة</span>
            @endif
          </td>
          <td>
            @foreach($blog->categories as $cat)
              <span class="badge bg-secondary">{{ $cat->name }}</span>
            @endforeach
          </td>
          <td>
            <a href="{{ route('admin.blogs.edit', $blog) }}" class="btn btn-warning btn-sm">تعديل</a>
            <form action="{{ route('admin.blogs.destroy', $blog) }}" method="POST" style="display:inline-block;">
              @csrf @method('DELETE')
              <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('هل أنت متأكد؟')">حذف</button>
            </form>
          </td>
        </tr>
        @endforeach
      </tbody>
    </table>
    @else
      <div class="alert alert-info">لا توجد مقالات حالياً.</div>
    @endif
  </div>
</div>
@endsection
