@extends('user.layouts.header')
@section('styles') 

@endsection
@section('content')
<div class="content content-fixed ">
   <div class="container pd-x-0 pd-lg-x-10 pd-xl-x-0  ">
        <div class="position-relative">
            <nav aria-label="breadcrumb">
               <ol class="breadcrumb breadcrumb-style1 mg-b-10">
                  <li class="breadcrumb-item"><a href="{{ route('user-all-contracts', 'tabName=project contract-vendor') }}">Project Contract Vendor</a></li>
               </ol>
            </nav>
            <h4 class="mg-b-0 tx-spacing--1">Create Project Contract Vendor</h4>
            <div class="back-btn back_pc">
              <a href="{{ route('user-all-contracts', 'tabName=project contract-vendor') }}">
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

     

        <form method="POST" action="{{ route('user-store-project-contract-vendor') }}" enctype="multipart/form-data">
         @csrf
          
          <div class="row external-border">
                <div class="col-md-12">
                   <div class="party-one">
                     <label for="">Vendor name:</label>
                       <select name="vendor_name" id="vendor_name" class="form-control contract_dropdown">
                         <option label="Choose one"></option>
                          @if(count($vendor_msas) > 0)
                             @foreach($vendor_msas as $vendor_msa)
                               @if ($vendor_msa->id ==  old('vendor_name') )
                                   <option value="{{ $vendor_msa->id }}" selected>{{ $vendor_msa->vendor_name }}</option>
                               @else
                                   <option value="{{ $vendor_msa->id }}" >{{$vendor_msa->vendor_name}}</option>
                               @endif
                             @endforeach
                          @endif
                       </select>
                   </div>
                </div>
                <input type="hidden" name="name" id="name" value="">
                <div class="col-md-6">
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
                       <label for="">Project Name:</label>
                         <select name="project_name" id="project_name" class="form-control contract_dropdown">
                           <option label="Choose one"></option>
                            @if(count($project_names) > 0)
                               @foreach($project_names as $project)
                                 @if ($project ==  old('project_name') )
                                     <option value="{{ $project }}" selected>{{ $project }}</option>
                                 @else
                                     <option value="{{ $project }}" >{{$project}}</option>
                                 @endif
                               @endforeach
                            @endif
                         </select>
                         @error('project_name')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                         @enderror
                     </div>

                     <div class="party-one">
                       <label for="">Select Template:</label>
                         <select name="template_id" id="template_id" class="form-control contract_dropdown">
                            <option label="Choose one"></option>
                            @if(count($templates) > 0)
                             @foreach($templates as $template)
                                 @if ($template->id ==  old('template') )
                                     <option value="{{ $template->id }}" selected>{{ $template->name }}</option>
                                 @else
                                     <option value="{{ $template->id }}" >{{$template->name}}</option>
                                 @endif
                               @endforeach
                            @endif
                         
                         </select>
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
                     <label for="">Amount:</label>
                     <input id="amount" type="text" class="form-control @error('amount') is-invalid @enderror" name="amount" value="{{ old('amount') }}"  autofocus>
                          @error('amount')
                              <span class="invalid-feedback" role="alert">
                                  <strong>{{ $message }}</strong>
                              </span>
                          @enderror
                  </div>
                  
                  
                    <div class="party-one">
                       <label for="">Add Team:</label>
                       <select name="team[]" class="@error('team') is-invalid @enderror team form-control select2" multiple="multiple">
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
                       @error('team')
                              <span class="invalid-feedback" role="alert">
                                  <strong>{{ $message }}</strong>
                              </span>
                          @enderror
                       
                    </div>

                    
                   
               </div>

               <div class="col-md-12">
                   <div class="party-one">
                    <label for="">Add vendor:</label>
                    <input type="text" class="form-control @error('vendor') is-invalid @enderror" placeholder="pragya@gmail.com" id="vendor" name="vendor" value="{{ old('vendor') }}"  autocomplete="name" autofocus>
                    @error('vendor')
                          <span class="invalid-feedback" role="alert">
                              <strong>{{ $message }}</strong>
                          </span>
                      @enderror
                   
                  </div> 
                </div>
                <input type="hidden" name="start_date" id="start_date" value="">
                <input type="hidden" name="end_date" id="end_date" value="">
               <div class="external-btn">
                  <button type="submit" class="btn btn-primary">Submit</button>
               </div>
            </div>
  
        </form>

   </div>
</div>



<!-- modal create vendor -->
    <!-- <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
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
                        <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}"  autofocus>
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
      </div> -->



@endsection
@section('scripts') 

<script>
   $(document).ready(function(){
        $('#vendor_name').change(function(){ 
          var id = $(this).val();
           
              $.ajax({
                  url: "{{url('user/get-vendor-msa')}}/"+id,  
                  type: 'get',
                  
                  success: function(response){ 
                    $('#contact').val(response.vendor_contact);
                    $('#email').val(response.vendor_email);
                    $('#name').val(response.vendor_name);
                  }
              });
        });
   });

   $(document).ready(function(){
        $('#project_name').change(function(){ 
          var id = $(this).val();
           
              $.ajax({
                  url: "{{url('user/get-project-details')}}/"+id,  
                  type: 'get',
                  
                  success: function(response){ 
                    $('#start_date').val(response.start_date);
                    $('#end_date').val(response.end_date);
                  }
              });
        });
   });

    // $("#vendorForm").submit(function(event) {
    //     event.preventDefault();
    //     $.ajaxSetup({
    //         headers: {
    //             'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    //         }
    //     });

    //     var name     = $('#name').val();
    //     var emails   = $('#emails').val();

        
    //     if(name === ''){
    //         $(".error").html('Please enter full name...');
    //         return false;
    //     }
        
        
    //     if(email === ''){
    //         $(".error").html('Please enter work email address...');
    //         return false;
    //     }
        
    //     formdata = new FormData($(this)[0]);

    //     $.ajax({
    //         url: "{{url('/user/create_vendor')}}/",

    //         contentType: false,
    //         processData: false,
    //         data: formdata,
    //         type: 'POST',

    //         success: function(response)
    //          {     $("#vendorForm")[0].reset();
                  
                 
    //               $('#vendor').append(`<option value="${response.id}" selected>
    //                                    ${response.name}
    //                               </option>`);
                    
    //                      $('#exampleModalCenter').modal('hide');
                

    //         },

    //     });
    //     return false;
    // });
</script>

@endsection
