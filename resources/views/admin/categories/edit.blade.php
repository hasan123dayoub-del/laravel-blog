@extends('layout')
@section('title','تعديل تصنيف')

@section('content')
<div class="card">
  <div class="card-body">
    <h4>تعديل التصنيف</h4>

    <form action="{{ route('admin.categories.update', $category->id) }}" method="POST">
      @csrf
      @method('PUT')

      <div class="mb-3">
        <label class="form-label">الاسم</label>
        <input type="text" 
               name="name" 
               class="form-control" 
               value="{{ old('name', $category->name) }}" 
               required>
      </div>

      <button class="btn btn-warning">تحديث</button>

      <a href="{{ route('admin.categories.index') }}" class="btn btn-link">
        إلغاء
      </a>
    </form>
  </div>
</div>
@endsection
