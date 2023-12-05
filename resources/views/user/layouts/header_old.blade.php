<header class="navbar navbar-header navbar-header-fixed " id="header">
        <!-- mobile menu option -->
        <a href="" id="mainMenuOpen" class="burger-menu"><i data-feather="menu"></i></a>

        <!-- logo -->
        <div class="navbar-brand brand-logo">
            <a href="dashboard.php" class="df-logo">Resolute</a>
        </div>

        <!-- dashboard navigation -->
        <div id="navbarMenu" class="navbar-menu-wrapper">
            <ul class="nav navbar-menu">
                <li class="nav-label pd-l-20 pd-lg-l-25 d-lg-none">Main Navigation</li>
                
                <li class="nav-item">
                    <a href="{{ route('user-dashboard') }}" class="nav-link">Dashboard</a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('user-external-contract') }}" class="nav-link">External Contract</a>
                </li>
                <li class="nav-item ">
                    <a href="{{ route('user-all-contracts') }}" class="nav-link"><i data-feather="layers"></i>All Contracts</a>
                </li>
                <li class="nav-item"><a href="{{ route('user-template-repository') }}" class="nav-link"><i data-feather="box"></i> Template
                      Repository</a>
                </li>
                <li class="nav-item"><a href="{{ route('user-vendor-performance') }}" class="nav-link"><i data-feather="archive"></i>
                      Vendor Performance</a>
                </li>
                @if(auth()->user()->can('user-team'))
                <li class="nav-item"><a href="{{ route('user-team') }}" class="nav-link"><i data-feather="archive"></i>
                      Team</a>
                </li>
                @endif
            </ul>
        </div>

        <!-- Notification -->
        <div class="navbar-right">
            <div class="dropdown dropdown-notification bell-icon">
                <a href="" class="dropdown-link new-indicator" data-toggle="dropdown">
                <i class="far fa-bell"></i>
                    <span>2</span>
                </a>
                <div class="dropdown-menu dropdown-menu-right">
                    <div class="dropdown-header">Notifications</div>
                    <a href="" class="dropdown-item">
                        <div class="media">
                            <div class="avatar avatar-sm avatar-online"><img src="https://via.placeholder.com/350"
                                    class="rounded-circle" alt=""></div>
                            <div class="media-body mg-l-15">
                                <p>Congratulate <strong>Socrates Itumay</strong> for work anniversaries</p>
                                <span>Mar 15 12:32pm</span>
                            </div>
                        </div>
                    </a>
                    <div class="dropdown-footer"><a href="">View all Notifications</a></div>
                </div>
            </div>

            <!-- edit profile and logout options -->
            <div class="dropdown dropdown-profile">
                <a href="" class="dropdown-link" data-toggle="dropdown" data-display="static">
                    <div class="avatar avatar-sm user-icon"><i class="far fa-user"></i></div>
                </a><!-- dropdown-link -->
                <div class="dropdown-menu dropdown-menu-right tx-13">
                    <div class="avatar avatar-lg mg-b-15"><img src="https://via.placeholder.com/500"
                            class="rounded-circle" alt=""></div>
                    <h6 class="tx-semibold mg-b-5">Katherine Pechon</h6>
                    <p class="mg-b-25 tx-12 tx-color-03">Administrator</p>

                    <a href="" class="dropdown-item"><i data-feather="edit-3"></i> Edit Profile</a>
                    
                    <div class="dropdown-divider"></div>
                    
                    <a href="" class="dropdown-item"><i data-feather="settings"></i>Account Settings</a>
                    <a class="dropdown-item" href="{{ route('logout') }}"
                       onclick="event.preventDefault();
                                     document.getElementById('logout-form').submit();"><i data-feather="log-out"></i>Sign Out</a>

                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                        @csrf
                    </form>

                </div>
            </div>

        </div>

    </header>