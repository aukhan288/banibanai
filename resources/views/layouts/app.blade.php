<!DOCTYPE html>
<html lang="en">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>Majestic Admin</title>
  <link rel="stylesheet" href="{{ asset('css/materialdesignicons.min.css') }}" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/MaterialDesign-Webfont/7.4.47/css/materialdesignicons.min.css" integrity="sha512-/k658G6UsCvbkGRB3vPXpsPHgWeduJwiWGPCGS14IQw3xpr63AEMdA8nMYG2gmYkXitQxDTn6iiK/2fD4T87qA==" crossorigin="anonymous" referrerpolicy="no-referrer" />

  <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
  <link rel="stylesheet" href="{{ asset('css/datatable.css') }}">
  <link rel="stylesheet" href="{{ asset('css/sweetalert2.min.css') }}">
  <link rel="stylesheet" href="{{ asset('css/style.css') }}">

  <script src="{{ asset('js/jQuery3.7.1.min.js') }}"></script>
  <script src="{{ asset('js/popper.js') }}"></script>
  <script src="{{ asset('js/datatable.js') }}"></script>
  <script src="{{ asset('js/sweetalert2.all.min.js') }}"></script>
  <script src="{{ asset('js/bootstrap.min.js') }}"></script>
  <script src="{{ asset('js/template.js') }}"></script>
  <script src="{{ asset('js/off-canvas.js') }}"></script>
</head>
<body>
  <div class="container-scroller">
   
  <nav class="navbar col-lg-12 col-12 p-0 fixed-top d-flex flex-row">
  <div class="navbar-brand-wrapper d-flex justify-content-center">
    <div class="navbar-brand-inner-wrapper d-flex justify-content-between align-items-center w-100">
      <a class="navbar-brand brand-logo" href="index.html">
        <span >
          bani banai
        </span>
      </a>
    
      <a class="navbar-brand brand-logo-mini" href="index.html"><img src="../public/assets/images/logo-mini.svg"
          alt="logo" /></a>
      <button class="navbar-toggler navbar-toggler align-self-center" type="button" data-toggle="minimize">
        <span class="mdi mdi-sort-variant"></span>
      </button>
      <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button"
      data-toggle="offcanvas">
      <span class="mdi mdi-menu"></span>
    </button>
    </div>
  </div>
  <div class="navbar-menu-wrapper d-flex align-items-center justify-content-end">
    <ul class="navbar-nav navbar-nav-right">
      <li class="nav-item nav-profile dropdown">
        <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown" id="profileDropdown">
          <!-- <img src="../../../assets/images/faces/face5.jpg" alt="profile" /> -->
          <span class="nav-profile-name">{{ Auth::User()?->name }}</span>
        </a>
        <div class="dropdown-menu dropdown-menu-right navbar-dropdown" aria-labelledby="profileDropdown">
        <a class="dropdown-item">
        <i class="mdi mdi-user text-primary"></i>
          
            {{ Auth::User()?->role?->name }}
</a>  
        <a class="dropdown-item">
            <i class="mdi mdi-cog text-primary"></i>
            Settings
          </a>
    
          <a class="dropdown-item" href="{{ route('logout') }}"
          onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
            <i class="mdi mdi-logout text-primary"></i>
           <span>Logout</span> 
           <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
          </a>
        </div>
      </li>
    
  </div>
</nav>
    <!-- partial -->
    <div class="container-fluid page-body-wrapper">
      <!-- partial:partials/_sidebar.html -->
      <nav class="sidebar sidebar-offcanvas" id="sidebar">
        <ul class="nav">
          <li class="nav-item">
            <a class="nav-link" href="{{ url('/home') }}">
              <i class="mdi mdi-home menu-icon"></i>
              <span class="menu-title">Dashboard</span>
            </a>
          </li>
          @if(Auth::check() && Auth::user()->role->slug === 'admin')
  <li class="nav-item">
    <a class="nav-link" href="{{ url('/users') }}">
      <i class="mdi mdi-home menu-icon"></i>
      <span class="menu-title">Users</span>
    </a>
  </li>
@endif
@if(Auth::check() && (Auth::user()->role->slug === 'catering' || Auth::user()->role->slug === 'admin'))
  <li class="nav-item">
    <a class="nav-link" href="{{ url('/caterings') }}">
      <i class="mdi mdi-home menu-icon"></i>
      <span class="menu-title">Caterings</span>
    </a>
  </li>
@endif
@if(Auth::check() && (Auth::user()->role->slug === 'venu' || Auth::user()->role->slug === 'admin'))
  <li class="nav-item">
    <a class="nav-link" href="{{ url('/venus') }}">
      <i class="mdi mdi-home menu-icon"></i>
      <span class="menu-title">Venus</span>
    </a>
  </li>
@endif

        
        </ul>
      </nav>
      <!-- partial -->
      <div class="main-panel py-4">
       @yield('content')
        <!-- content-wrapper ends -->
        <!-- partial:partials/_footer.html -->
        <footer class="footer">
        <div class="d-sm-flex justify-content-center justify-content-sm-between">
          <span class="text-muted text-center text-sm-left d-block d-sm-inline-block">Copyright © <a href="https://www.bootstrapdash.com/" target="_blank">bootstrapdash.com </a>2021</span>
          <span class="float-none float-sm-right d-block mt-1 mt-sm-0 text-center">Only the best <a href="https://www.bootstrapdash.com/" target="_blank"> Bootstrap dashboard  </a> templates</span>
        </div>
        </footer>
        <!-- partial -->
      </div>
      <!-- main-panel ends -->
    </div>
    <!-- page-body-wrapper ends -->
  </div>
  <!-- container-scroller -->
</body>
</html>