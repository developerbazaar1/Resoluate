@extends('user.layouts.header')
@section('styles') 

@endsection
@section('content')
<div class="content content-fixed ">
   <div class="container pd-x-0 pd-lg-x-10 pd-xl-x-0  ">
      <div>
         <nav aria-label="breadcrumb">
            <ol class="breadcrumb breadcrumb-style1 mg-b-10">
               <li class="breadcrumb-item"><a href="#">External Contract</a></li>
               <!-- <li class="breadcrumb-item active" aria-current="page">Website Analytics</li> -->
            </ol>
         </nav>
         <h4 class="mg-b-0 tx-spacing--1">Welcome to External Contract </h4>
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

         <form method="POST" action="{{ route('user-store-external-contract') }}" enctype="multipart/form-data">
         @csrf
            <div class="row external-border">
               <div class="col-md-6">
                  
                     <div class="party-one">
                        <label for="">Party Name:</label>
                        <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}"  autocomplete="name" autofocus>
                          @error('name')
                              <span class="invalid-feedback" role="alert">
                                  <strong>{{ $message }}</strong>
                              </span>
                          @enderror
                     </div>
                     <div class="party-one">
                        <label for="">Contact:</label>
                        <input id="contact" type="text" class="form-control @error('contact') is-invalid @enderror" name="contact" value="{{ old('contact') }}"  autofocus>
                          @error('contact')
                              <span class="invalid-feedback" role="alert">
                                  <strong>{{ $message }}</strong>
                              </span>
                          @enderror
                     </div>
                     <div class="party-one">
                       <label for="">Contract Type:</label>
                         <select name="contract_type" class="form-control contract_dropdown @error('contract_type') is-invalid @enderror">
                           <option label="Choose one"></option>
                            @if(count($contracts) > 0)
                               @foreach($contracts as $contract)
                                 @if ($contract->id ==  old('contract_type') )
                                     <option value="{{ $contract->id }}" selected>{{ $contract->name }}</option>
                                 @else
                                     <option value="{{ $contract->id }}" >{{$contract->name}}</option>
                                 @endif
                               @endforeach
                            @endif
                         </select>
                         @error('contract_type')
                              <span class="invalid-feedback" role="alert">
                                  <strong>{{ $message }}</strong>
                              </span>
                          @enderror
                     </div>
                     <div class="custom-file file-border mt-10">
                          <label for="">Upload</label>
                        <label class="file-upload" for="customFile">Upload An External Contract <i class="fas fa-upload"></i></label>
                        <input type="file" name="document" class="custom-file-input" id="customFile">
                     </div>
               </div>
               <div class="col-md-6">
                  <div class="party-one">
                        <label for="">Email:</label>
                        <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}"  autofocus>
                          @error('email')
                              <span class="invalid-feedback" role="alert">
                                  <strong>{{ $message }}</strong>
                              </span>
                          @enderror
                  </div>
                  <div class="party-one">
                     <label for="">Address:</label>
                     <input id="address" type="text" class="form-control @error('address') is-invalid @enderror" name="address" value="{{ old('address') }}"  autofocus>
                          @error('address')
                              <span class="invalid-feedback" role="alert">
                                  <strong>{{ $message }}</strong>
                              </span>
                          @enderror
                  </div>
                  <div class="party-one">
                     <label for="">Obligations:</label>
                     <textarea name="obligations" id="obligations" cols="20" rows="1"></textarea>

                          @error('obligations')
                              <span class="invalid-feedback" role="alert">
                                  <strong>{{ $message }}</strong>
                              </span>
                          @enderror
                  </div>
                  <div class="party-one"> 
                     <label for="">Add Team:</label>
                     <select name="team[]" class="team form-control select2" multiple="multiple">
                        <option label="Add Team On Workflow "></option>
                          @if(count($users) > 0)
                               @foreach($users as $user)
                                 @if($user->id ==  old('team'))
                                     <option value="{{ $user->id }}" selected>{{ $user->name }}</option>
                                 @else
                                     <option value="{{ $user->id }}" >{{$user->name}}</option>
                                 @endif
                               @endforeach
                          @endif
                     </select>
                  </div>
               </div>
             
               <div class="external-btn">
                  <button type="submit" class="btn btn-primary">Submit</button>
               </div>
            </div>
         </form>
   </div>
</div>


<!-- modal create vendor -->
    <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
          <div class="modal-content">
          <div class="modal-header modal-box-content">
             <h5 class="modal-title" id="exampleModalLongTitle">Create Vendor</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                   <span aria-hidden="true">&times;</span>
                      </button>
             </div>
             <center><div class="error" style="color: #8c001a;font-weight: 400">&nbsp;</div></center>
             <form id="vendorForm" >
               @csrf

                <div class="modal-body body-content p-5">
                
                    <div class="party-one">
                        <label for="">Vendor Name:</label>
                        <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}"  autofocus>
                          @error('name')
                              <span class="invalid-feedback" role="alert">
                                  <strong>{{ $message }}</strong>
                              </span>
                          @enderror
                    </div>
                    <div class="party-one">
                        <label for="">Email:</label>
                        <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" autofocus>
                          @error('email')
                              <span class="invalid-feedback" role="alert">
                                  <strong>{{ $message }}</strong>
                              </span>
                          @enderror
                    </div>
                 
                </div>
                <div class="modal-footer modal-btn">
                  <button type="submit" class="btn btn-secondary" >Create</button>
                </div>
             </form>

          </div>
        </div>
      </div>

@endsection
@section('scripts') 
<script>
    $("#vendorForm").submit(function(event) {
        event.preventDefault();
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        var name     = $('#name').val();
        var emails   = $('#emails').val();

        
        if(name === ''){
            $(".error").html('Please enter full name...');
            return false;
        }
        
        
        if(email === ''){
            $(".error").html('Please enter work email address...');
            return false;
        }
        
        formdata = new FormData($(this)[0]);

        $.ajax({
            url: "{{url('/user/create_vendor')}}/",

            contentType: false,
            processData: false,
            data: formdata,
            type: 'POST',

            success: function(response)
             {     $("#vendorForm")[0].reset();
                  
                 
                  $('#vendor').append(`<option value="${response.id}" selected>
                                       ${response.name}
                                  </option>`);
                    
                         $('#exampleModalCenter').modal('hide');
                

            },

        });
        return false;
    });
</script>


<script type="text/javascript">
    

 (function($) {

  'use strict';


  if ($(".team").length) {
   $(".team").select2({ maximumSelectionLength: 5, });
  }

})

(jQuery);



</script>
@endsection
