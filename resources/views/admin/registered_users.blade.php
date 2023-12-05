@extends('admin.layouts.header')
@section('styles') 

@endsection
@section('content')

<div class="content content-fixed ">
   <div class="container pd-x-0 pd-lg-x-10 pd-xl-x-0  ">
      <div>
         <nav aria-label="breadcrumb">
            <ol class="breadcrumb breadcrumb-style1 mg-b-10">
               <li class="breadcrumb-item">
                  <a href="#">Registered Users</a>
               </li>
               <!-- <li class="breadcrumb-item active" aria-current="page">Website Analytics</li> -->
            </ol>
         </nav>
         <h4 class="mg-b-0 tx-spacing--1">Welcome to Registered Users</h4>
         <div class="custom-btn">
          <a href="{{ route('admin-create-user') }}"><i class="fas fa-plus"></i>Add New User</a>
         </div>
      </div>
      <!-- data table -->
      <div data-label="Example" class="template-content mt-5">
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
         <div class="tab-content mg-t-20" id="myTabContent5">
            <div class="tab-pane fade show active" id="msa-psa5" role="tabpanel" aria-labelledby="msa-psa-tab5">
               <table id="example1" class="table data-table">
                  <thead>
                     <tr class="table-heading">
                        <th>S.No.</th>
                        <th>Email</th>
                        <th>Name</th>
                        <th>Job Title</th>
                        <th>Company Name</th>
                        <th>Phone</th>
                        <th>Date</th>
                        <th>Action</th>
                     </tr>
                  </thead>
                  <tbody>
                     @if(count($users) > 0)
                     @php
                         $sno = 1;
                     @endphp
                     @foreach($users as $user)
                     <tr>
                        <td>{{ $sno }}</td>
                        <td>{{$user->email}}</td>
                        <td>{{$user->name}}</td>
                        <td>{{$user->job_title}}</td>
                        <td>{{$user->company_name}}</td>
                        <td>{{$user->phone}}</td>
                        <td>{{$user->created_at}}</td>
                        @php 
                           $userid = Crypt::encrypt($user->id); 
                        @endphp
                        <td><a href="{{ route('admin-edit-user', $userid) }}"><i class="fas fa-pen edit-icon"></i></a>

                         <!-- Button trigger modal -->
                         <button type="button" class="btn" data-toggle="modal" data-target="#exampleModalCenter"><i class="fa fa-trash"></i></button>
                         <!-- Modal -->
                         <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                           <div class="modal-dialog modal-dialog-centered" role="document">
                             <div class="modal-content">
                             <div class="modal-header modal-box-content">
                                <h5 class="modal-title" id="exampleModalLongTitle">Delete User</h5>
                                   <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                      <span aria-hidden="true">&times;</span>
                                         </button>
                                </div>
                               <div class="modal-body body-content">Are you sure, you want to delete ! 
                                 
                               </div>
                               <div class="modal-footer modal-btn">
                                 <a href="{{ route('admin-delete-user', $userid) }}" class="ajaxdelete btn btn-secondary">Yes</a>
                                 <button type="button" class="btn btn-primary" data-dismiss="modal">No</button>
                               </div>
                             </div>
                           </div>
                         </div>   
                        </td>

                     </tr>
                     @php
                        $sno++;
                     @endphp
                     @endforeach
                     @endif
                  </tbody>
               </table>
            </div>
         </div>
      </div>
      <!-- df-example -->
   </div>
</div>


@endsection
@section('scripts') 

<script>
  

     // $(".ajaxdelete").click(function(event){
     //    //  alert("Delete?");
     //     var href = $(this).attr("href")
     //     var btn = this;
    
     //      $.ajax({
     //        type: "GET",
     //        url: href,
     //        success: function(dataResult) {
    
     //        var dataResult = JSON.parse(dataResult);
     //        if(dataResult.statusCode==200){ 
     //            window.location.reload();
               
     //        }
     //        else if(dataResult.statusCode==201){
     //           alert("Error occured !");
     //        }
               
    
     //        }
     //      });
     //     event.preventDefault();
     //  })
  
</script>   
@endsection
