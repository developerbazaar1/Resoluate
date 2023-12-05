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
<body class="loginpage">

    <header class="navbar navbar-header navbar-header-fixed">
        <a href="#" id="mainMenuOpen" class="burger-menu"><i data-feather="menu"></i></a>
        <div class="navbar-brand brand-logo">
            <a href="#" class="df-logo">Resolute</a>
        </div>

    </header>


    <div class="content content-fixed content-auth">
        <div class="container">
            <div class="login-heading">
                <h1>Welcome Back To Resolute Dashboard!</h1>
                <p>Please Login To Continue</p>
            </div>
            <div class="media align-items-stretch justify-content-center ht-100p pos-relative mg-t-50">

                <div class="media-body align-items-center d-none d-lg-flex">
                   <div class="mx-wd-600 login-side-image">
                        <img src="{{ URL::asset('assets/img/loginimg-2.jpg') }}" class="img-fluid" alt="">
                    </div>
                </div>
                <div class="sign-wrapper mg-lg-l-50 mg-xl-l-60">
                    <div class="wd-100p form-border">
                        <form method="POST" action="{{ route('login') }}">
                            @csrf
                        
                            <div id="email-section">
                                <div class="form-group form-label mg-t-20" >

                                    <label>Email: </label>
                                   
                                    <input id="email" type="email" class="mb-0 form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" placeholder="yourname@yourmail.com" required autocomplete="email" autofocus>
                                      
                                    <span class="invalid-feedback d-none" id="email-error" role="alert">
                                        <strong></strong>
                                    </span>  
                                    @error('email')
                                        <span class="invalid-feedback"  role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror

                                </div>

                                <a id="next-pass"> <button class="btn btn-brand-02 btn-block">Next</button></a>

                                <div class="divider-text">or</div>
                                <div class="support-link">
                                    <a href="" class="tx-13">Resend Invite</a>
                                    <a href="" class="tx-13">Contact Support Email</a>
                                </div>
                            </div>

                            <div id="password-section" class="d-none">
                                <div class="form-group password-filed">
                                    <div class="d-flex justify-content-between form-label mg-b-5">
                                      <label class="mg-b-0-f">Password:</label>  
                                    </div>
                                    <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password" placeholder="Enter your password" >

                                    @error('password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                    <a  href="{{ route('password.request') }}"class="tx-13">Forgot password?</a>
                                </div>
                                
                                <button  type="submit" class="btn btn-brand-02 btn-block">Submit</button>
                            </div>
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
 

    <script>
        $("#next-pass").click(function(){
          var email = $("#email").val(); 
          if(email == ""){
            
            $("#email").addClass("is-invalid");
            $("#email-error").removeClass("d-none");
            $("#email-error strong").text("Please enter email address");
            return false;
          }else{

            var regex =
/^([a-zA-Z0-9_\.\-\+])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;

            if (!regex.test(email)) {
                $("#email").addClass("is-invalid");
                $("#email-error").removeClass("d-none");
                $("#email-error strong").text("Please enter valid email address");
                return false;
            }
            else {
                $("#email-section").addClass("d-none");
                $("#password-section").removeClass("d-none");
            }

            
          }
          
        });
    </script>

</body>

</html>

