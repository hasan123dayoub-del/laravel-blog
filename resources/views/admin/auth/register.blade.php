@extends('layouts.app') {{-- تأكد عندك ملف layout أساسي --}}

@section('title', 'Register')

@section('content')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow">
                <div class="card-header text-center bg-success text-white">
                    <h4>تسجيل مستخدم جديد</h4>
                </div>
                <div class="card-body">
                    {{-- عرض الأخطاء --}}
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('register') }}">
                        @csrf

                        <div class="mb-3">
                            <label for="name" class="form-label">الاسم الكامل</label>
                            <input type="text" name="name" id="name" class="form-control" value="{{ old('name') }}" required autofocus>
                        </div>

                        <div class="mb-3">
                            <label for="email" class="form-label">البريد الإلكتروني</label>
                            <input type="email" name="email" id="email" class="form-control" value="{{ old('email') }}" required>
                        </div>

                        <div class="mb-3">
                            <label for="password" class="form-label">كلمة المرور</label>
                            <input type="password" name="password" id="password" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label for="password_confirmation" class="form-label">تأكيد كلمة المرور</label>
                            <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" required>
                        </div>

                        <div class="d-grid">
                            <button type="submit" class="btn btn-success">تسجيل</button>
                        </div>
                    </form>

                    <div class="mt-3 text-center">
                        <a href="{{ route('login') }}">هل لديك حساب؟ تسجيل الدخول</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
