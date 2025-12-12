@extends('layout')
@section('title','التصنيفات')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
  <h3>التصنيفات</h3>
  <a href="{{ route('admin.categories.create') }}" class="btn btn-primary">إضافة تصنيف</a>
</div>

<div class="card bg-white">
  <div class="card-body p-0">
    <table class="table mb-0">
      <thead class="table-light">
        <tr>
          <th>الاسم</th>
          <th>عمليات</th>
        </tr>
      </thead>
      <tbody>
        @forelse($categories as $cat)
        <tr>
          <td>{{ $cat->name }}</td>
          <td>
            <a href="{{ route('admin.categories.edit', $cat->id) }}" class="btn btn-warning btn-sm">تعديل</a>

            <form action="{{ route('admin.categories.destroy', $cat->id) }}" method="POST" class="d-inline">
              @csrf 
              @method('DELETE')
              <button class="btn btn-danger btn-sm" onclick="return confirm('هل تريد حذف التصنيف؟')">
                حذف
              </button>
            </form>
          </td>
        </tr>
        @empty
        <tr>
          <td colspan="2" class="text-center">لا توجد تصنيفات</td>
        </tr>
        @endforelse
      </tbody>
    </table>
  </div>
</div>

{{ $categories->links() }}
@endsection
