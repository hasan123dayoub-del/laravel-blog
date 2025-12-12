<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title','TaskBlog')</title>

    <!-- Bootstrap CDN (no Vite) -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        html,body { direction: rtl; }
        .card-img-top{ height:190px; object-fit:cover; }
        .truncate-line { display: -webkit-box; -webkit-line-clamp: 3; -webkit-box-orient: vertical; overflow: hidden; }
    </style>
    @stack('head')
</head>
<body class="bg-light">

<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <div class="container">
    <a class="navbar-brand" href="{{ route('frontend.index') }}">TaskBlog</a>

    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navMain">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navMain">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item"><a class="nav-link" href="{{ route('frontend.index') }}">الرئيسية</a></li>
        <li class="nav-item"><a class="nav-link" href="{{ route('admin.blogs.index') }}">لوحة الإدارة</a></li>
      </ul>

      <ul class="navbar-nav ms-auto">
        @auth
          <li class="nav-item">
            <form action="{{ route('logout') }}" method="POST" class="d-inline">
              @csrf
              <button class="btn btn-sm btn-outline-light">تسجيل خروج</button>
            </form>
          </li>
        @else
          <li class="nav-item"><a class="nav-link" href="{{ route('login.form') }}">دخول</a></li>
          <li class="nav-item"><a class="nav-link" href="{{ route('register.form') }}">تسجيل</a></li>
        @endauth
      </ul>
    </div>
  </div>
</nav>

<div class="container py-4">
    @if($errors->any())
      <div class="alert alert-danger">
        <ul class="mb-0">
          @foreach($errors->all() as $err) <li>{{ $err }}</li> @endforeach
        </ul>
      </div>
    @endif

    @if(session('success'))
      <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @yield('content')
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"></script>
@stack('scripts')
</body>
</html>
