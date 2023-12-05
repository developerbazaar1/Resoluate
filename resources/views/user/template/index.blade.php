@extends('user.layouts.header')

@section('styles') 



@endsection

@section('content')

<div class="content content-fixed ">

   <div class="container pd-x-0 pd-lg-x-10 pd-xl-x-0  ">

      <div>

         <nav aria-label="breadcrumb">

            <ol class="breadcrumb breadcrumb-style1 mg-b-10">

               <li class="breadcrumb-item"><a href="{{ route('user-template-repository') }}">Template Repository</a></li>{{ Request::segment(3) }}

               <!-- <li class="breadcrumb-item active" aria-current="page">Website Analytics</li> -->

            </ol>

         </nav>

         <h4 class="mg-b-0 tx-spacing--1">Welcome to Template Repository</h4>

      </div>

      <div data-label="Example" class="mt-3">

         <ul class="nav nav-line tab-list" id="myTab5" role="tablist">

            <li class="nav-item tab-item">

               <a class="nav-link {{ empty($tabName) || $tabName == 'msa' ? 'active' : '' }} " id="Owner-tab5" data-toggle="tab" href="#Owner5" role="tab" aria-controls="home" aria-selected="true">MSA's / PSA's</a>

            </li>

            <li class="nav-item">

               <a class="nav-link {{ $tabName == 'project-contract' ? 'active' : '' }} " id="Vendor-tab5" data-toggle="tab" href="#Vendor5" role="tab" aria-controls="profile" aria-selected="false">Project Contracts</a>

            </li>

            

         </ul>

         <div class="tab-content mg-t-20" id="myTabContent5">

            <div class="tab-pane fade {{ empty($tabName) || $tabName == 'msa' ? 'active show' : '' }}" id="Owner5" role="tabpanel" aria-labelledby="Owner-tab5">

               

               <div class="create-new-btn custom-btn">

                  @if(auth()->user()->can('user-create-owner-msa'))

                  <a href="{{ route('user-create-msa-template') }}">Create New <i class="fas fa-plus"></i></a>

                  @endif

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

                <div class="table-responsive">

               <table id="example1" class="table data-table">

                  <thead>

                     <tr class="table-heading">

                        <th>S.no.</th>

                        <th>Name</th>

                        <th>Type (MSA's/PSA's)</th>

                        <th>Last Update</th>

                        <th>View Template</th>

                        @if(auth()->user()->can('user-edit-msa-template'))

                        <th>Action</th>

                        @endif

                     </tr>

                  </thead>

                  <tbody>

                     @if(count($msas) > 0)

                     @php

                         $sno = 1;

                      

                     @endphp

                     @foreach($msas as $msa)

                     <tr>

                        <td>{{$sno}}</td>

                        <td>{{$msa->name}}</td>

                        <td>{{$msa->type_msa_psa}}</td>

                        <td>{{$msa->updated_at}}</td>

                        <td>

                           @if(!empty($msa->document))

                           <a class=" btn-sm btn-success" target="_blank" href="{{ URL::asset('/public/'.$msa->document) }}" target="_blank">View Document</a>

                           @else

                           <b>Not Available</b>

                           @endif

                        </td>

                        @php 

                           $mid = Crypt::encrypt($msa->id); 

                        @endphp

                        @if(auth()->user()->can('user-edit-msa-template'))

                        <td>

                         <a href="{{ route('user-edit-msa-template', $mid) }}"><i class="fas fa-pen edit-icon"></i></a>



                        <!-- Button trigger modal -->

                         <button type="button" class="btn" data-toggle="modal" data-target="#exampleModalCenter1"><i class="fa fa-trash text-danger"></i></button>

                         <!-- Modal -->

                         <div class="modal fade" id="exampleModalCenter1" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">

                           <div class="modal-dialog modal-dialog-centered" role="document">

                             <div class="modal-content">

                             <div class="modal-header modal-box-content">

                                <h5 class="modal-title" id="exampleModalLongTitle">Delete Template</h5>

                                   <button type="button" class="close" data-dismiss="modal" aria-label="Close">

                                      <span aria-hidden="true">&times;</span>

                                         </button>

                                </div>

                               <div class="modal-body body-content">Are you sure, you want to delete ! 

                                 

                               </div>

                               <div class="modal-footer modal-btn">

                                 <a href="{{ route('user-delete-msa-template', $mid) }}" class="ajaxdelete btn btn-secondary">Yes</a>

                                 <button type="button" class="btn btn-primary" data-dismiss="modal">No</button>

                               </div>

                             </div>

                           </div>

                         </div>   



                        </td>

                        @endif

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

            <div class="tab-pane fade {{ $tabName == 'project-contract' ? 'active show' : '' }} " id="Vendor5" role="tabpanel" aria-labelledby="Vendor-tab5">

               

               <div class="create-new-btn custom-btn">

                  @if(auth()->user()->can('user-create-project-contract-template'))

                  <a href="{{ route('user-create-project-contract-template') }}">Create New <i class="fas fa-plus"></i></a>

                  @endif

               </div>

               

               @if($message = Session::get('success1'))

                  <div class="alert alert-success alert-dismissible alert-btn">

                      <strong>

                        <i class="fa fa-check"></i> {{ $message }}</strong>

                      <button type="button" class="btn" data-dismiss="alert">

                        <i class="fa fa-close"></i>

                      </button>

                  </div>

               @endif



               @if($message = Session::get('error1'))

                  <div class="alert alert-danger alert-dismissible alert-btn">

                   <strong>

                     <i class="fas fa-exclamation-triangle"></i> {{ $message }} </strong>

                   <button type="button" class="btn" data-dismiss="alert">

                     <i class="fa fa-close"></i>

                   </button>

                 </div>

               @endif 

               <div class="table-responsive">
               <table id="example2" class="table data-table">

                  <thead>

                     <tr class="table-heading">

                        <th>S.no.</th>

                        <th>Name</th>

                        <th>Last Update</th>

                        <th>View Template</th>

                        @if(auth()->user()->can('user-edit-project-contract-template'))

                        <th>Action</th>

                        @endif

                     </tr>

                  </thead>

                  <tbody>

                     @if(count($pcs) > 0)

                     @php

                         $sno = 1;

                      

                     @endphp

                     @foreach($pcs as $pc)

                     <tr>

                        <td>{{$sno}}</td>

                        <td>{{$pc->name}}</td>

                        <td>{{$pc->updated_at}}</td>

                        <td>

                           @if(!empty($msa->document))

                           <a class=" btn-sm btn-success" target="_blank" href="{{ URL::asset('/public/'.$pc->document) }}" target="_blank">View Document</a>

                           @else

                           <b>Not Available</b>

                           @endif

                        </td>

                        @php 

                           $pcid = Crypt::encrypt($pc->id); 

                        @endphp



                        @if(auth()->user()->can('user-edit-project-contract-template'))

                        <td>

                         <a href="{{ route('user-edit-project-contract-template', $pcid) }}"><i class="fas fa-pen edit-icon"></i></a>



                        <!-- Button trigger modal -->

                         <button type="button" class="btn" data-toggle="modal" data-target="#exampleModalCenter"><i class="fa fa-trash text-danger"></i></button>

                         <!-- Modal -->

                         <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">

                           <div class="modal-dialog modal-dialog-centered" role="document">

                             <div class="modal-content">

                             <div class="modal-header modal-box-content">

                                <h5 class="modal-title" id="exampleModalLongTitle">Delete Template</h5>

                                   <button type="button" class="close" data-dismiss="modal" aria-label="Close">

                                      <span aria-hidden="true">&times;</span>

                                         </button>

                                </div>

                               <div class="modal-body body-content">Are you sure, you want to delete ! 

                                 

                               </div>

                               <div class="modal-footer modal-btn">

                                 <a href="{{ route('user-delete-project-contract-template', $pcid) }}" class="ajaxdelete btn btn-secondary">Yes</a>

                                 <button type="button" class="btn btn-primary" data-dismiss="modal">No</button>

                               </div>

                             </div>

                           </div>

                         </div>   



                        </td>

                        @endif

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

      </div>

      <!-- df-example -->

   </div>

</div>

@endsection

@section('scripts') 

<script>

      $(function() {

        'use strict'

        $('#example1').DataTable({

          language: {

            searchPlaceholder: 'Search...',

            sSearch: '',

            lengthMenu: '_MENU_ ',

          }

        });

        // Select2

        $('.dataTables_length select').select2({

          minimumResultsForSearch: Infinity

        });

      });



      $(function() {

        'use strict'

        $('#example2').DataTable({

          language: {

            searchPlaceholder: 'Search...',

            sSearch: '',

            lengthMenu: '_MENU_ ',

          }

        });

        // Select2

        $('.dataTables_length select').select2({

          minimumResultsForSearch: Infinity

        });

      });



</script>

@endsection

