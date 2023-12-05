<!DOCTYPE html>
<html lang="en">
  <head>

    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="shortcut icon" type="image/x-icon" href="{{ URL::asset('assets/img/favicon.png') }}">
    <title>Resolute-Admin</title>
    <link href="{{ URL::asset('assets/ionicons/css/ionicons.min.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/fontawesome-free/css/all.min.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/fontawesome-free/css/all.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/datatables.net-dt/css/jquery.dataTables.min.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/datatables.net-responsive-dt/css/responsive.dataTables.min.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link href="{{ URL::asset('assets/select2/css/select2.min.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ URL::asset('assets/css/dashforge.demo.css') }}">
        <link rel="stylesheet" href="{{ URL::asset('assets/css/dashforge.css') }}">
    <link rel="stylesheet" href="{{ URL::asset('assets/css/dashforge.dashboard.css') }}">
    <link rel="stylesheet" href="{{ URL::asset('assets/css/custom css/dashboard.css') }}">
    <link rel="stylesheet" href="{{ URL::asset('assets/css/style.css') }}">
    <link rel="stylesheet" href="{{ URL::asset('assets/css/pra_style.css') }}">
  </head>
  <body>

     <aside class="aside aside-fixed sidebar-height ">


      <div class="aside-header sidebar-logo">
        <a href="" class="aside-logo">Resolute</a>
        <a href="" class="aside-menu-link">
          <i data-feather="menu"></i>
          <i data-feather="x"></i>
        </a>
      </div>
      <div class="aside-body bg-gray-900">
        <div class="aside-loggedin">
          <div class="d-flex align-items-center justify-content-start">
            @if(!empty(Auth::user()->profile_image))
                <a href="" class="avatar"><img src="{{ URL::asset('/public/'.Auth::user()->profile_image) }}" class="rounded-circle" alt=""></a>
            @else  
            <a href="" class="avatar"><img src="{{ URL::asset('assets/img/profilepicture.jpg') }}" class="rounded-circle" alt=""></a>
            @endif
            <div class="aside-alert-link">
            
              <a data-toggle="tooltip" title="Sign out" href="{{ route('logout') }}"
                   onclick="event.preventDefault();
                                 document.getElementById('logout-form').submit();"><i data-feather="log-out"></i></a>

                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                    @csrf
                </form>
            </div>
          </div>
          <div class="aside-loggedin-user">
            <a href="#loggedinMenu" class="d-flex align-items-center justify-content-between mg-b-2" data-toggle="collapse">
              <h6 class="tx-semibold mg-b-0">{{Auth::user()->name}}</h6>
              <i data-feather="chevron-down"></i>
            </a>
            <p class="tx-color-03 tx-12 mg-b-0">{{Auth::user()->company_role}}</p>
          </div>
          <div class="collapse" id="loggedinMenu">
            <ul class="nav nav-aside mg-b-0">
              @php 
                    $userid = Crypt::encrypt(Auth::user()->id); 
                @endphp
              <li class="nav-item"><a href="{{ route('admin-editprofile', $userid) }}" class="nav-link"><i data-feather="edit"></i> <span>Edit Profile</span></a></li>
              <li class="nav-item">
                <a class="nav-link" href="{{ route('logout') }}"
                   onclick="event.preventDefault();
                                 document.getElementById('logout-form').submit();"><i data-feather="log-out"></i><span>Sign Out</span></a>

                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                    @csrf
                </form>
              </li>
            </ul>
          </div>
        </div><!-- aside-loggedin -->
        <ul class="nav nav-aside sidebar-icons">
          <li class="nav-label"><a class="custom-clr" href="{{ route('admin-dashboard') }}">Dashboard</a></li>
          
          
          <li class="nav-item icon-list icon-1"><a href="{{ route('admin-registered-users') }}" class="nav-link"><i class="fas fa-users"></i> <span> Registered Users</span></a></li>
          
          
        </ul>
      </div>
 </aside>

    <!--begin::Content-->
    @yield('content')
    <!--end::Content-->

    <!--begin::Footer-->
    @include('admin.layouts.footer')

  </body>
</html>

