@extends('layout')
@section('title','تسجيل الدخول')

@section('content')
<div class="row justify-content-center">
  <div class="col-md-5">
    <div class="card shadow-sm">
      <div class="card-body">
        <h4 class="card-title mb-3">تسجيل الدخول</h4>

        <form method="POST" action="{{ route('login') }}">
          @csrf

          <div class="mb-3">
            <label class="form-label">البريد الإلكتروني</label>
            <input type="email" name="email" class="form-control" value="{{ old('email') }}" required>
          </div>

          <div class="mb-3">
            <label class="form-label">كلمة المرور</label>
            <input type="password" name="password" class="form-control" required>
          </div>

          <button class="btn btn-success">دخول</button>
          <a href="{{ route('register.form') }}" class="btn btn-link">إنشاء حساب</a>
        </form>

      </div>
    </div>
  </div>
</div>
@endsection
