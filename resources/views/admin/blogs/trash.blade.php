@extends('layout')
@section('title','سلة المحذوفات')

@section('content')
<div class="card">
  <div class="card-body">
    <h4>سلة المحذوفات</h4>
    <a href="{{ route('admin.blogs.index') }}" class="btn btn-primary mb-3">الرجوع لكل المقالات</a>

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
          <td>{{ Str::limit($blog->content, 50) }}</td>
          <td>
            @if($blog->image)
              <img src="{{ asset('storage/blogs/'.$blog->image) }}" width="100" alt="">
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
            {{-- استعادة المقال --}}
            <form action="{{ route('admin.blogs.restore', $blog->id) }}" method="POST" style="display:inline-block;">
              @csrf
              <button type="submit" class="btn btn-success btn-sm">استعادة</button>
            </form>

            {{-- حذف نهائي --}}
            <form action="{{ route('admin.blogs.forceDelete', $blog->id) }}" method="POST" style="display:inline-block;">
              @csrf
              @method('DELETE')
              <button type="submit" class="btn btn-danger btn-sm"
                onclick="return confirm('هل أنت متأكد من الحذف النهائي؟')">حذف نهائي</button>
            </form>
          </td>
        </tr>
        @endforeach
      </tbody>
    </table>

    {{-- Pagination --}}
    {{ $blogs->links() }}

    @else
      <div class="alert alert-info">لا توجد مقالات محذوفة حالياً.</div>
    @endif
  </div>
</div>
@endsection
