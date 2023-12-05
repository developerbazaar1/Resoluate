@extends('user.layouts.header')
@section('styles') 

@endsection
@section('content')
<div class="content content-fixed">
   <div class="container pd-x-0 pd-lg-x-10 pd-xl-x-0">
   
      
         <div class="position-relative">
            <nav aria-label="breadcrumb">
               <ol class="breadcrumb breadcrumb-style1 mg-b-10">
                  <li class="breadcrumb-item"><a href="">{{ Auth::user()->name}}</a></li>
               </ol>
            </nav>
            <h4 class="mg-b-0 tx-spacing--1">Edit Profile</h4>
            <div class="back-btn back_pc">
              <a href="{{ route('user-dashboard') }}">
              <i class="fa fa-arrow-left"></i>Back </a>
            </div>
         </div>

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
      <form method="POST" action="{{ route('user-updateprofile') }}"  enctype="multipart/form-data">
      @csrf
         <div class="row external-border">
            <div class="col-md-6">
               <div class="party-one">
                  <label for="">Name:</label>
                  <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="@if(!empty($user->name)){{old('name', $user->name)}}@endif"  autocomplete="name" autofocus>

                    @error('name')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
               </div>
               <div class="party-one">
                  <label for="">Job Title:</label>
                  <input id="job_title" type="text" class="form-control @error('job_title') is-invalid @enderror" name="job_title" value="@if(!empty($user->job_title)){{old('job_title', $user->job_title)}}@endif"  autocomplete="name" autofocus>

                    @error('job_title')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
               </div>
               <div class="custom-file file-border">
                    <label class="file-upload" for="customFile">Upload Profile <i class="fas fa-upload"></i></label>
                    <input type="file" name="document" class="custom-file-input" id="customFile">
               </div>
            </div>

            <div class="col-md-6">   
               <div class="party-one">
                  <label for="">Email:</label>
                  

                   <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="@if(!empty($user->email)){{old('email', $user->email)}}@endif"  autocomplete="email" readonly>
                   
                    @error('email')
                     <span class="invalid-feedback" role="alert">
                         <strong>{{ $message }}</strong>
                     </span>
                    @enderror
               </div>
               <div class="party-one">
                  <label for="">Phone:</label>
                  <input id="phone" type="text" class="form-control @error('phone') is-invalid @enderror" name="phone" value="@if(!empty($user->phone)){{old('phone', $user->phone)}}@endif"  autocomplete="name" autofocus>

                    @error('phone')
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
            <input type="hidden" value="{{$user->id}}" name="userid">
            <input type="hidden" value="{{$user->password}}" name="password_old">
            <input type="hidden" value="{{$user->profile_image}}" name="document_old">
            <div class="external-btn">
               <button type="submit" class="btn btn-primary">Submit</button>
            </div>
         </div>
      </form>
      
      
   </div>
</div>
@endsection
@section('scripts') 


@endsection

