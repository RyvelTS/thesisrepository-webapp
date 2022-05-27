<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Laravel') }}</title>
    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    @yield('css')
</head>
<body>
  <div class="container-fluid">
    <div class="row flex-nowrap">
      <div id="dashboard" class="col-auto col-md-3 col-xl-2 bg-light">
        <div class="d-flex flex-column align-items-center align-items-sm-start px-3 py-3 text-dark min-vh-100">
          <a href="/" class="d-flex align-items-center pb-3 mb-md-0 me-md-auto text-decoration-none">
            <span class="fs-4 d-none d-sm-inline fw-bold text-dark">Thesis Repository</span>
          </a>
          <hr>
          <ul class="nav nav-pills flex-column mb-sm-auto mb-0 align-items-center align-items-sm-start" id="menu">
            <li class="nav-item py-1">
              <a id="homeLink" href="{{route('home')}}" class="nav-link align-middle px-0 link-secondary"><i class="bi bi-house-door"></i> <span class="ms-1 d-none d-sm-inline">Home</span>
              </a>
            </li>
            <li class="nav-item py-1">
              <a id="discoverLink" href="{{ route('thesis_search') }}" class="nav-link align-middle px-0 link-secondary"><i class="bi bi-search"></i> <span class="ms-1 d-none d-sm-inline">Discover</span></a>
            </li>
            @cannot('admin')
            <li class="py-1">
              <a href="#submenu1" data-bs-toggle="collapse" class="nav-link px-0 align-middle link-secondary fw-bold"><i class="bi bi-files"></i> <span class="ms-1 d-none d-sm-inline">My Thesis</span></a>
              <ul class="collapse show nav flex-column ms-2" id="submenu1" data-bs-parent="#menu">
                <li class="w-100">
                  <a id="createLink" href="{{route('thesis_create')}}" class="nav-link px-0 link-secondary"><i class="bi bi-file-earmark-plus"></i> <span class="d-none d-sm-inline ms-2">Create Thesis</span></a>
                </li>
                
                <li>
                  <a id="manageLink" href="{{ route('user_thesis_index') }}" class="nav-link px-0 link-secondary"><i class="bi bi-pencil-square"></i> <span class="d-none d-sm-inline ms-2">Manage Thesis</span></a>
                </li>
              </ul>
            </li>
            @endcannot
            @can('admin')
            <li class="py-1">
              <a href="#submenu2" data-bs-toggle="collapse" class="nav-link px-0 align-middle link-danger fw-bold"><i class="bi bi-key-fill"></i> <span class="ms-1 d-none d-sm-inline">Administrator</span></a>
              <ul class="collapse show nav flex-column ms-2" id="submenu2" data-bs-parent="#menu">
                <li class="w-100">
                  <a id="manageSchool" href="{{ route('school.index') }}" class="nav-link px-0 link-secondary"><i class="bi bi-building"></i> <span class="d-none d-sm-inline ms-2">Manage School</span></a>
                </li>
                <li>
                  <a id="manageUser" href="{{ route('user.index') }}" class="nav-link px-0 link-secondary"><i class="bi bi-people-fill"></i> <span class="d-none d-sm-inline ms-2">Manage User</span></a>
                </li>
              </ul>
            </li>
            @endcan
          </ul>
          <hr>
          <div class="dropdown pb-4">
            <a href="#" class="d-flex align-items-center text-dark text-decoration-none dropdown-toggle" id="dropdownUser1" data-bs-toggle="dropdown" aria-expanded="false">
              @isset(Auth::user()->picture)
              <img src="{{asset('/storage/pictures/'.Auth::user()->picture)}}" width="30" height="30" class="rounded-circle">
              @else
              <img src="{{asset('/storage/pictures/anonymous-user.jpg')}}"alt="hugenerd" width="30" height="30" class="rounded-circle">
              @endisset
              
              <span class="d-none d-sm-inline ms-2">{{ Auth::user()->name }}</span>
            </a>
            <ul class="dropdown-menu dropdown-menu-dark text-small shadow">
              <li><a class="dropdown-item" href="{{route('profile')}}">Profile</a></li>
              <li>
                <hr class="dropdown-divider">
              </li>
              <li>
                <a class="dropdown-item" href="{{ route('logout') }}"
                onclick="event.preventDefault();
                              document.getElementById('logout-form').submit();">
                 {{ __('Logout') }}
                </a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                  @csrf
                </form>
              </li>
            </ul>
          </div>
        </div>
      </div>
      <div style="overflow-y: scroll ; max-height:100vh;" class="col py-3">
        @yield('content')
      </div>
    </div>
  </div>
  @yield('script')
</body>
</html>
