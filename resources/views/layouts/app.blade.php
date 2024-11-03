
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>Bani Banai</title>
  <meta content="" name="description">
  <meta content="" name="keywords">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <!-- Favicons -->
  <link href="{{ asset('images/logo.png') }}" rel="icon">
  <link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon">

 
  <!-- Vendor CSS Files -->
  <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
  <link href="{{ asset('bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">
  <link href="{{ asset('boxicons/css/boxicons.min.css') }}" rel="stylesheet">
  <!-- Template Main CSS File -->
  <link href="{{ asset('css/datatable.css') }}" rel="stylesheet">
  <link href="{{ asset('css/sweetalert2.min.css') }}" rel="stylesheet">
  <link href="{{ asset('css/style.css') }}" rel="stylesheet">

    <!-- Vendor JS Files -->
    <script src="{{ asset('js/jQuery3.7.1.min.js') }}"></script>
    <script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>

    <!-- Template Main JS File -->
    <script src="{{ asset('js/datatable.js') }}"></script>
    <script src="{{ asset('js/sweetalert2.all.min.js') }}"></script>
    <script src="{{ asset('js/main.js') }}"></script>
</head>

<body>

  <!-- ======= Header ======= -->
  <header id="header" class="header fixed-top d-flex align-items-center">

    <div class="d-flex align-items-center justify-content-between">
    <i class="bi bi-list toggle-sidebar-btn m-0"></i>
      <a href="index.html" class="logo d-flex align-items-center">
        <span style="color:#ff3db1; font-family: cursive; font-weight: 400;">bani</span> <span style="color:#31D2F2; font-family: cursive; font-weight: 400;"> banai</span>
        <!-- <img src="{{ asset('images/logo.png') }}" class="img-fluid" alt=""> -->
      </a>
      
    </div><!-- End Logo -->



    <nav class="header-nav ms-auto">
      <ul class="d-flex align-items-center">


        <li class="nav-item dropdown">

          <a class="nav-link nav-icon" href="#" data-bs-toggle="dropdown">
            <i class="bi bi-bell-fill"></i>
          </a><!-- End Notification Icon -->      
        </li><!-- End Notification Nav -->

        <li class="nav-item dropdown pe-3">

          <a class="nav-link nav-profile d-flex align-items-center pe-0" href="#" data-bs-toggle="dropdown">
            <span class="d-none d-md-block dropdown-toggle ps-2">{{ Auth::user()?->name }}</span>
          </a><!-- End Profile Iamge Icon -->

          <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow profile">
            <li class="dropdown-header">
              <h6>{{ Auth::user()?->role?->name }}</h6>
            </li>
            <li>
              <hr class="dropdown-divider">
            </li>

            <li>
              <a class="dropdown-item d-flex align-items-center" href="users-profile.html">
                <i class="bi bi-person"></i>
                <span>My Profile</span>
              </a>
            </li>
            <li>
              <hr class="dropdown-divider">
            </li>

       

       
            <li>
              <a class="dropdown-item d-flex align-items-center" href="{{ route('logout') }}"
              onclick="event.preventDefault();document.getElementById('logout-form').submit();">
                <i class="bi bi-box-arrow-right"></i>
                <span>Sign Out</span>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
              </a>
            </li>

          </ul><!-- End Profile Dropdown Items -->
        </li><!-- End Profile Nav -->

      </ul>
    </nav><!-- End Icons Navigation -->

  </header><!-- End Header -->

  <!-- ======= Sidebar ======= -->
  <aside id="sidebar" class="sidebar">

    <ul class="sidebar-nav" id="sidebar-nav">

      <li class="nav-item">
        <a class="nav-link collapsed" href="{{ url('/home') }}">
          <i class="bi bi-grid"></i>
          <span>Dashboard</span>
        </a>
      </li><!-- End Dashboard Nav -->
      @if(Auth::user()?->role?->slug=='admin')
      <li class="nav-item">
        <a class="nav-link collapsed" href="{{ url('/users') }}">
          <i class="bi bi-grid"></i>
          <span>Users</span>
        </a>
      </li><!-- End Dashboard Nav -->
      @endif
      <li class="nav-item">
        <a class="nav-link collapsed" href="{{ url('/stores') }}">
          <i class="bi bi-grid"></i>
          <span>Stores</span>
        </a>
      </li><!-- End Dashboard Nav -->
      @if( in_array(Auth::user()->role->slug, ['catering', 'chairity', 'venu']))
      <li class="nav-item">
        <a class="nav-link collapsed" href="{{ url('/categories') }}">
          <i class="bi bi-grid"></i>
          <span>Categories</span>
        </a>
      </li><!-- End Dashboard Nav -->
      <li class="nav-item">
        <a class="nav-link collapsed" href="{{ url('/products') }}">
          <i class="bi bi-grid"></i>
          <span>Products</span>
        </a>
      </li><!-- End Dashboard Nav -->
      @endif
      @if( in_array(Auth::user()->role->slug, ['catering', 'chairity', 'venu']))
      <li class="nav-item">
        <a class="nav-link collapsed" href="{{ url('/menu-mangement') }}">
          <i class="bi bi-grid"></i>
          <span>Menu management</span>
        </a>
      </li><!-- End Dashboard Nav -->
      @endif
      <li class="nav-item">
        <a class="nav-link collapsed" href="{{ url('/orders') }}">
          <i class="bi bi-grid"></i>
          <span>Orders</span>
        </a>
      </li><!-- End Dashboard Nav -->
      <li class="nav-item">
        <a class="nav-link collapsed" href="{{ url('/users') }}">
          <i class="bi bi-grid"></i>
          <span>Notifications</span>
        </a>
      </li><!-- End Dashboard Nav -->
      <li class="nav-item">
        <a class="nav-link collapsed" href="{{ url('/fees') }}">
          <i class="bi bi-grid"></i>
          <span>Fees</span>
        </a>
      </li><!-- End Dashboard Nav -->
    </ul>

  </aside><!-- End Sidebar-->

  <main id="main" class="main">
<!-- 
    <div class="pagetitle">
      <h1>Blank Page</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="index.html">Home</a></li>
          <li class="breadcrumb-item">Pages</li>
          <li class="breadcrumb-item active">Blank</li>
        </ol>
      </nav>
    </div> -->

    <section class="section">
     @yield('content')
    </section>

  </main><!-- End #main -->

  <!-- ======= Footer ======= -->
 

  <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>



</body>

</html>