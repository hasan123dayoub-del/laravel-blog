<nav class="navbar navbar-expand-lg navbar-light bg-light">
  <div class="container-fluid">
    <a class="navbar-brand" href="{{ route('frontend.home') }}">Blog</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" >
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav ms-auto">
        <li class="nav-item"><a class="nav-link" href="{{ route('frontend.blogs.index') }}">All Blogs</a></li>
        @guest
            <li class="nav-item"><a class="nav-link" href="{{ route('frontend.login') }}">Login</a></li>
            <li class="nav-item"><a class="nav-link" href="{{ route('frontend.register') }}">Register</a></li>
        @else
            <li class="nav-item">
              <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="btn btn-danger btn-sm">Logout</button>
              </form>
            </li>
        @endguest
      </ul>
    </div>
  </div>
</nav>
