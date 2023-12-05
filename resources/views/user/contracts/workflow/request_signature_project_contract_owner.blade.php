@extends('user.layouts.header')
@section('styles') 

@endsection
@section('content')
<div class="content content-fixed ">
   <div class="container pd-x-0 pd-lg-x-10 pd-xl-x-0  ">
        <div class="position-relative">
            <nav aria-label="breadcrumb">
               <ol class="breadcrumb breadcrumb-style1 mg-b-10">
                  <li class="breadcrumb-item"><a href="#">Project Contract Owner</a></li>
               </ol>
            </nav>
            <h4 class="mg-b-0 tx-spacing--1">Signatureflow: Project Contract Owner</h4>
            <div class="back-btn back_pc">
              <a href="{{ route('user-all-contracts') }}">
              <i class="fa fa-arrow-left"></i>Back </a>
            </div>
        </div>

        @if(isset($msg))
         <h3 style="margin:20%">{{$msg}}</h3>
        @else

        <iframe
            id = "prepare_page"
            src = "{{$sendUrl}}"
            width = "100%"
            class = "frame"
            style="height: 80vh;">
        </iframe>
        @endif
       

    </div>
</div>
@endsection
@section('scripts')    
   

@endsection