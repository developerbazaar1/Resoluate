<!DOCTYPE html>
<html lang="en">
  <head>

    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="shortcut icon" type="image/x-icon" href="{{ URL::asset('assets/img/favicon.png') }}">
    <title>Resolute</title>
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
    <style>
        .box::-webkit-scrollbar-track
          {
              -webkit-box-shadow: inset 0 0 6px rgba(0,0,0,0.3);
              background-color: #F5F5F5;
            border-radius: 2px
          }
          .box::-webkit-scrollbar
          {
              width: 5px;
              background-color: #F5F5F5;
            border-radius: 5px
          }
          .box::-webkit-scrollbar-thumb
          {
              background-color: black;
              border: 2px solid black;
            border-radius: 5px
          }
          .notification{
           margin-right: 10px;
            position: relative;
            display: inline-block;
          }
          .number{
            font-size: 10px;
            height: 14px;
            width: 14px;
            background-color: #D63031;
            border-radius: 20px;
            color: white;
            text-align: center;
            position: absolute;
            top: -6px;
            padding: 1px;
            border-style: solid;
            border-width: 0px;
            right: -3px;
          }
          .number:empty {
             display: none;
          }
          .notBtn{
            transition: 0.5s;
            cursor: pointer;
            border: none;
            background-color: transparent;
          }
          .notBtn:focus{
            outline: 0px !important;
          }
        /* .number .fas{
            font-size: 15pt;
            padding-bottom: 10px;
            color: black;
            margin-right: 40px;
            margin-left: 40px;
          } */
          .box{
            width: 230px;
            height: 0px;
            border-radius: 10px;
            transition: 0.5s;
            position: absolute;
            overflow-y: scroll;
            padding: 0px;
            left: -155px;
            margin-top: 15px;
            background-color: #F4F4F4;
            -webkit-box-shadow: 10px 10px 23px 0px rgba(0,0,0,0.2);
            -moz-box-shadow: 10px 10px 23px 0px rgba(0,0,0,0.1);
            box-shadow: 10px 10px 23px 0px rgba(0,0,0,0.1);
            cursor: context-menu;
            z-index: 2;
          }
          .fas:hover {
            color: #D63031;
          }
          .notBtn > .box{
            height: 30vh;
            display: none;
          }
          .content{
            padding: 20px;
            color: black;
            vertical-align: middle;
            text-align: left;
          }
          .gry{
            background-color: #F4F4F4;
          }
          /* .top{
            color: black;
            padding: 10px
          }
          .display{
            position: relative;
          } */
          .cont{
            position: absolute;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: #F4F4F4;
          }
          .cont:empty{
            display: none;
          }
          .stick{
            text-align: center;
            display: block;
            font-size: 50pt;
            padding-top: 70px;
            padding-left: 80px
          }
          .stick:hover{
            color: black;
          }
          .cent{
            text-align: center;
            display: block;
          }
          .sec{
            padding: 8px 0px;
            background-color: #F4F4F4;
            transition: 0.5s;
          }
          .profCont{
            padding-left:6px;
          }
          .profile{
            -webkit-clip-path: circle(50% at 50% 50%);
            clip-path: circle(50% at 50% 50%);
            width: 35px;
            float: left;
          }
          .txt{
            vertical-align: top;
            font-size:14px;
            padding: 1px 10px 0px 10px;
            text-align: left;
            color:#000;
          }
          .sub{
            font-size:12px;
            color:#000;
          }
          .new{
            border: 1px solid #001737;
            border-style: none none solid none;
          }
          .sec:hover{
            background-color: #BFBFBF;
          }
          .aside-alert-link a + a {
            margin-left: 0px;
        }
        .active-notification{
            background-color:#0017375e;
        }
        
        #open-box{
            color: white !important;
        }
    </style>
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
                <!-- notification start -->
                
                
                @php 
                    $user = DB::table('users')->where('id', Auth::user()->id )->first();
        			$notification = DB::table('notification')->where('user_id', Auth::user()->id )->orderBy('id','DESC')->limit(50)->get();
        			$notification_new = DB::table('notification')->where('user_id', Auth::user()->id )->where('status', 'unseen' )->orderBy('id','DESC')->get();
        			$notification_old = DB::table('notification')->where('user_id', Auth::user()->id )->where('status', 'seen' )->orderBy('id','DESC')->get();
        		@endphp
                  <div class="icons">
                    <div class="notification">
                      <button class="notBtn">
                        <!--Number supports double digits and automatically hides itself when there is nothing between divs -->
                        @if(count($notification_new) > 0)
                          <div class="number">{{ count($notification_new) }}</div>
                        @endif
                        
                        <i id="open-box" class="fas fa-bell"></i>
                        <div class="box">
                          <div class="display">
                            <div class="cont"><!-- Fold this div and try deleting everything in between -->
                            @if(count($notification) < 1)
                                  <p class="mt-5">No Notification Available</p>
                            @else
                                
                              @foreach($notification as $note)
                              @php $id = $note->id; @endphp
                              @if($note->status == 'seen')
                              <div class="sec new">
                                <a href="{{ route('change-notification-status', $id) }}">
                                  <!--<div class="profCont">-->
                                  <!--  <img class="profile" src="https://obamawhitehouse.archives.gov/sites/obamawhitehouse.archives.gov/files/styles/person_medium_photo/public/person-photo/amanda_lucidon22.jpg?itok=JFPi8OFJ">-->
                                  <!--</div>-->
                                  <div class="txt">{{ $note->message }}</div>
                                  <div class="txt sub">{{ $note->created_at }}</div>
                                </a>
                              </div>
                              @else
                              <div class="sec new active-notification">
                                <a href="{{ route('change-notification-status', $id) }}">
                                  <!--<div class="profCont">-->
                                  <!--  <img class="profile" src="https://obamawhitehouse.archives.gov/sites/obamawhitehouse.archives.gov/files/styles/person_medium_photo/public/person-photo/amanda_lucidon22.jpg?itok=JFPi8OFJ">-->
                                  <!--</div>-->
                                  <div class="txt">{{ $note->message }}</div>
                                  <div class="txt sub">{{ $note->created_at }}</div>
                                </a>
                              </div>
                              @endif
                              @endforeach
                            
                            @endif  
                              
                              
                            </div>
                          </div>
                        </div>
                      </button>
                    </div>
                  </div>
                  <!-- notification end -->
                              
              
              
              
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
              <li class="nav-item"><a href="{{ route('user-editprofile', $userid) }}" class="nav-link"><i data-feather="edit"></i> <span>Edit Profile</span></a></li>
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
          <li class="nav-label"><a class="custom-clr" href="{{ route('user-dashboard') }}">Dashboard</a></li>
          
          <li class="nav-item icon-list"><a href="{{ route('user-external-contract') }}" class="nav-link"><i class="fas fa-file-contract"></i><span>External Contract</span></a></li>
          <li class="nav-item icon-list"><a href="{{ route('user-all-contracts') }}" class="nav-link"><i class="fa-sharp fas fa-file-signature"></i> <span> All Contracts </span></a></li>
          <li class="nav-item icon-list"><a href="{{ route('user-template-repository') }}" class="nav-link"><i class="fa fa-database"></i> <span>Template
           Repository</span></a></li>
          <li class="nav-item icon-list icon-1"><a href="{{ route('user-vendor-performance') }}" class="nav-link"><!--<i class="fas fa-star"></i>--><i class="fas fa-id-card"></i> <span> Vendor Performance</span></a></li>
          @if(auth()->user()->can('user-team'))
          <li class="nav-item icon-list icon-1"><a href="{{ route('user-team') }}" class="nav-link"><i class="fas fa-users"></i> <span> Team</span></a></li>
          @endif
          
        </ul>
      </div>
 </aside>

    <!--begin::Content-->
    @yield('content')
    <!--end::Content-->

    <!--begin::Footer-->
    @include('user.layouts.footer')
    <script>
        $(document).ready(function(){
            $("#open-box").click(function(){
                $(".box").toggle();
            });
        });
    </script>
  </body>
</html>
