@extends('user.layouts.header')
@section('styles') 

@endsection
@section('content')

<div class="content content-fixed ">
   <div class="container pd-x-0 pd-lg-x-10 pd-xl-x-0  ">
      <div>
         <nav aria-label="breadcrumb">
            <ol class="breadcrumb breadcrumb-style1 mg-b-10">
               <li class="breadcrumb-item">
                  <a href="{{ route('user-vendor-performance') }}">Vendor Performance</a>
               </li>
              
            </ol>
         </nav>
         <h4 class="mg-b-0 tx-spacing--1">Welcome to Vendor Performance</h4>
         
      </div>
      <!-- data table -->
      <div data-label="Example" class="template-content mt-5">
       
        <!--<div class="vendor-sort-btn mb-5">-->
        <!--    <div class="dropdown">-->
        <!--        <button class="btn dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">-->
        <!--        Sort By-->
        <!--        </button>-->
        <!--        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">-->
        <!--          <a class="dropdown-item" href="#">Trading</a>-->
        <!--          <a class="dropdown-item" href="#">Rating</a>-->
        <!--          <a class="dropdown-item" href="#">Location</a>-->
        <!--          <a class="dropdown-item" href="#">Projects</a>-->
        <!--        </div>-->
        <!--    </div>-->
        <!--</div>-->
       
         <div class="tab-content mg-t-20" id="myTabContent5">
            <div class="table-responsive">

               <table id="example1" class="table data-table">
                  <thead>
                     <tr class="table-heading">
                        <th>S.No.</th>
                        <th>Dome PM</th>
                        <th>Vendor Name</th>
                        <th>Project</th>
                        <th>Comments</th>
                        <th>Rating</th>
                        <th>Vendor PM </th>
                     </tr>
                  </thead>
                  <tbody>
                     @if(count($vendor_performances) > 0)
                     @php
                         $sno = 1;
                     @endphp
                     @foreach($vendor_performances as $vendor_performance)
                     <tr>
                        <td>{{ $sno }}</td>
                        <td>{{$vendor_performance->dome_pm}}</td>
                        <td>{{$vendor_performance->vendor_name}}</td>
                        <td>{{$vendor_performance->project}}</td>
                        <td>{{$vendor_performance->comment}}</td>
                        <td>{{$vendor_performance->rating}}</td>
                        <td>{{$vendor_performance->vendor_pm}}</td>
                       
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
</script>
@endsection
