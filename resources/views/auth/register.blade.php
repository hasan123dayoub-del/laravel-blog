@extends('layout')
@section('title','تسجيل جديد')

@section('content')
<div class="row justify-content-center">
  <div class="col-md-6">
    <div class="card shadow-sm">
      <div class="card-body">
        <h4 class="card-title mb-3">إنشاء حساب</h4>

        <form method="POST" action="{{ route('register') }}">
          @csrf

          <div class="mb-3">
            <label class="form-label">الاسم</label>
            <input type="text" name="name" class="form-control" value="{{ old('name') }}" required>
          </div>

          <div class="mb-3">
            <label class="form-label">البريد الإلكتروني</label>
            <input type="email" name="email" class="form-control" value="{{ old('email') }}" required>
          </div>

          <div class="mb-3">
            <label class="form-label">كلمة المرور</label>
            <input type="password" name="password" class="form-control" required>
          </div>

          <div class="mb-3">
            <label class="form-label">تأكيد كلمة المرور</label>
            <input type="password" name="password_confirmation" class="form-control" required>
          </div>

          <button class="btn btn-primary">تسجيل</button>
          <a href="{{ route('login.form') }}" class="btn btn-link">لديك حساب؟ تسجيل الدخول</a>
        </form>

      </div>
    </div>
  </div>
</div>
@endsection
