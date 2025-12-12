@extends('layout')
@section('title','إضافة تصنيف')

@section('content')
<div class="card">
  <div class="card-body">
    <h4>إنشاء تصنيف جديد</h4>

    <form action="{{ route('admin.categories.store') }}" method="POST">
      @csrf

      <div class="mb-3">
        <label class="form-label">الاسم</label>
        <input type="text" 
               name="name" 
               class="form-control" 
               value="{{ old('name') }}" 
               required>
      </div>

      <button class="btn btn-primary">حفظ</button>

      <a href="{{ route('admin.categories.index') }}" class="btn btn-link">
        إلغاء
      </a>
    </form>
  </div>
</div>
@endsection
