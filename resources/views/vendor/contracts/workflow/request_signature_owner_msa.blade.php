@extends('user.layouts.header')
@section('styles') 

@endsection
@section('content')
<div class="content content-fixed ">
   <div class="container pd-x-0 pd-lg-x-10 pd-xl-x-0  ">
        <span id="doc_name" style="display:none">{{ URL::asset('public/'.$owner_msa->document) }}</span>
        <span id="document_old" style="display:none" >{{ $owner_msa->document }}</span>
        <span id="ownermsaid" style="display:none">{{ $owner_msa->id }}</span>
        <span id="username" style="display:none">{{ Auth::user()->name; }}</span>
        <span id="useremail" style="display:none">{{ Auth::user()->email; }}</span>
        <div class="position-relative">
            <nav aria-label="breadcrumb">
               <ol class="breadcrumb breadcrumb-style1 mg-b-10">
                  <li class="breadcrumb-item"><a href="#">Owner MSA</a></li>
               </ol>
            </nav>
            <h4 class="mg-b-0 tx-spacing--1">Workflow: Owner MSA</h4>
            
        </div>
        <iframe
            id = "prepare_page"
            src = {{$sendUrl}}
            width = "100%"
            class = "frame"
            style="height: 80vh;">
        </iframe>
    </div>
</div>
@endsection
@section('scripts')    
   


@endsection