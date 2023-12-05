@extends('user.layouts.header')
@section('styles') 

@endsection
@section('content')
<div class="content content-fixed">
   <div class="container pd-x-0 pd-lg-x-10 pd-xl-x-0">
      <!-- <div class="d-sm-flex align-items-center justify-content-between mg-b-20 mg-lg-b-25 mg-xl-b-30"> -->
         <div class="position-relative">
            <nav aria-label="breadcrumb">
               <ol class="breadcrumb breadcrumb-style1 mg-b-10">
                  <li class="breadcrumb-item"><a href="{{ route('user-team') }}">Team</a></li>
               </ol>
            </nav>
            <h4 class="mg-b-0 tx-spacing--1">Create New Member</h4>
            <div class="back-btn back_pc">
              <a href="{{ route('user-team') }}">
              <i class="fa fa-arrow-left"></i>Back </a>
            </div>
         </div>
      <!-- </div> -->
        
        @if($message = Session::get('success'))
            <div class="alert alert-success alert-dismissible alert-btn">
                <strong>
                  <i class="fa fa-check"></i> {{ $message }}</strong>
                <button type="button" class="btn" data-dismiss="alert">
                  <i class="fa fa-close"></i>
                </button>
            </div>
        @endif

        @if($message = Session::get('error'))
            <div class="alert alert-danger alert-dismissible alert-btn">
             <strong>
               <i class="fas fa-exclamation-triangle"></i> {{ $message }} </strong>
             <button type="button" class="btn" data-dismiss="alert">
               <i class="fa fa-close"></i>
             </button>
           </div>
        @endif  
      <form method="POST" action="{{ route('user-store-member') }}">
      @csrf
         <div class="row external-border">
            <div class="col-md-6">
               <div class="party-one">
                  <label for="">Name:</label>
                  <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}"  autocomplete="name" autofocus>

                    @error('name')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
               </div>
               <div class="party-one">
                  <label for="">Job Title:</label>
                  <input id="job_title" type="text" class="form-control @error('job_title') is-invalid @enderror" name="job_title" value="{{ old('job_title') }}"  autocomplete="name" autofocus>

                    @error('job_title')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
               </div>
               
               <div class="party-one">
                  <label for="">Password:</label>
                  <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password"  autocomplete="new-password">

                  @error('password')
                     <span class="invalid-feedback" role="alert">
                         <strong>{{ $message }}</strong>
                     </span>
                  @enderror
               </div>
            </div>

            <div class="col-md-6">   
               <div class="party-one">
                  <label for="">Email:</label>
                  <!-- <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}"  autocomplete="email"> -->

                   <div class="input-group">
                       <input type="text" class="form-control email_temp"  placeholder="Recipient's username" aria-label="Recipient's username" aria-describedby="basic-addon2">
                       <span class="input-group-text" id="basic-addon2">@php echo"@".Auth::user()->domain @endphp</span>
                   </div>
                   <input type="hidden" value="" class="@error('email') is-invalid @enderror" id="email" name="email">
                    @error('email')
                     <span class="invalid-feedback" role="alert">
                         <strong>{{ $message }}</strong>
                     </span>
                    @enderror
               </div>
               <div class="party-one">
                  <label for="">Phone:</label>
                  <input id="phone" type="text" class="form-control @error('phone') is-invalid @enderror" name="phone" value="{{ old('phone') }}"  autocomplete="name" autofocus>

                    @error('phone')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
               </div>
               <div class="party-one">
                  <label for="">Confirm Password:</label>
                  <input id="password-confirm" type="password" class="form-control" name="password_confirmation"  autocomplete="new-password">
               </div>
            </div>

            <div class="external-btn">
               <button type="submit" class="btn btn-primary">Submit</button>
            </div>
         </div>
      </form>
   </div>
</div>
@endsection
@section('scripts') 
<script type="text/javascript">

    $('.email_temp').keyup(function() {  
        var endd = $('#basic-addon2').text(); 
        var dInput = this.value; 
        $('#email').val(dInput + endd); 
    });
</script>

@endsection

