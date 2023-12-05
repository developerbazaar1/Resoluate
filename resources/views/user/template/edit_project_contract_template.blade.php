@extends('user.layouts.header')
@section('styles') 

@endsection
@section('content')
<div class="content content-fixed ">
   <div class="container pd-x-0 pd-lg-x-10 pd-xl-x-0  ">
        <!-- <div class=" back-btn">
          <a href="{{ route('user-template-repository', 'tabName=project-contract') }}">
          <i class="fa fa-arrow-left"></i>Back </a>
        </div> -->

         <div class="position-relative">
            <nav aria-label="breadcrumb">
               <ol class="breadcrumb breadcrumb-style1 mg-b-10">
                  <li class="breadcrumb-item"><a href="#">Template Repository</a></li>
               </ol>
            </nav>
            <h4 class="mg-b-0 tx-spacing--1">Edit Project Contract Template</h4>
            <div class="back-btn back_pc">
              <a href="{{ route('user-template-repository', 'tabName=project-contract') }}">
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

         

        <form method="POST" action="{{ route('user-update-project-contract-template') }}" enctype="multipart/form-data">
         @csrf
          
          <div class="row external-border">
               <div class="col-md-6">
                  
                     <div class="party-one">
                        <label for="">Trade:</label>
                        <input id="trade" type="text" class="form-control @error('trade') is-invalid @enderror" name="trade" value="@if(!empty($m->trade)){{old('trade', $m->trade)}}@endif"  autocomplete="trade" autofocus>
                          @error('trade')
                              <span class="invalid-feedback" role="alert">
                                  <strong>{{ $message }}</strong>
                              </span>
                          @enderror
                     </div>
                     
                     
               </div>
               <div class="col-md-6">
                  <div class="party-one">
                        <label for="">Name:</label>
                        <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="@if(!empty($m->name)){{old('name', $m->name)}}@endif"  autocomplete="name" autofocus>
                          @error('name')
                              <span class="invalid-feedback" role="alert">
                                  <strong>{{ $message }}</strong>
                              </span>
                          @enderror
                     </div>
                     
                </div>
                <div class="col-md-12">
                     <div class="custom-file file-border">
                        <label class="file-upload" for="customFile">Upload MSA Template<i class="fas fa-upload"></i></label>
                        <input type="hidden" name="document_old"  value="@if(!empty($m->document)){{old('document', $m->document)}}@endif">
                        <input type="file" name="document" class="custom-file-input" id="customFile">
                     </div>
                </div>
                <input type="hidden" name="tid" value="{{$m->id}}">
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
