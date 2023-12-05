<!DOCTYPE html>
<html lang="en">
 <head>

    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="shortcut icon" type="image/x-icon" href="{{ URL::asset('assets/img/favicon.png') }}">
    <title>Resolute</title>
    <link href="{{ URL::asset('assets/fontawesome-free/css/all.min.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/fontawesome-free/css/all.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ URL::asset('assets/css/dashforge.css') }}">
    <link rel="stylesheet" href="{{ URL::asset('assets/css/dashforge.auth.css') }}">
    <link rel="stylesheet" href="{{ URL::asset('assets/css/style.css') }}">
  </head>
<body>

    <header class="navbar navbar-header navbar-header-fixed">
        <a href="#" id="mainMenuOpen" class="burger-menu"><i data-feather="menu"></i></a>
        <div class="navbar-brand brand-logo">
            <a href="#" class="df-logo">Resolute</a>
        </div>

    </header>


    <div class="content content-fixed content-auth">
        <div class="container">
            <div class="login-heading">
                <h1>Reset Password</h1>
                
            </div>
            <div class="media align-items-stretch justify-content-center ht-100p pos-relative mg-t-50">

                <div class="media-body align-items-center d-none d-lg-flex">
                   <div class="mx-wd-600 login-side-image">
                        <img src="{{ URL::asset('assets/img/loginimg.jpg') }}" class="img-fluid" alt="">
                    </div>
                </div>
                <div class="sign-wrapper mg-lg-l-50 mg-xl-l-60">
                    <div class="wd-100p form-border">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif
                        <form method="POST" action="{{ route('password.email') }}">
                        @csrf
                           
                               
                                <div class="form-group password-filed">
                                    <div class="d-flex justify-content-between form-label mg-b-5">
                                        <label class="mg-b-0-f">Email Address:</label>  
                                    </div>
                                    <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                                    @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                    
                                </div>

                                
                                <button  type="submit" class="btn btn-brand-02 btn-block">Send Password Reset Link</button>
                            
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <footer class="footer mg-t-auto resolute-footer " id="footer">
      <div>
        <span> Copyright &copy; Resolute Contract Solution 2023  </span>
        
      </div>
      <div>
        <nav class="nav">
         
          <a href="" class="nav-link">Terms & Conditions</a>
          <a href="" class="nav-link">Privacy Policy</a>
        </nav>
      </div>
    </footer>

    <script src="{{ URL::asset('assets/jquery/jquery.min.js') }}"></script>
    <script src="{{ URL::asset('assets/bootstrap/js/bootstrap.bundle.min.js') }}"></script>

</body>

</html>


