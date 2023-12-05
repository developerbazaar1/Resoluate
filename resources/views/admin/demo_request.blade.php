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
                  <a href="#">Demo Request</a>
               </li>
               <!-- <li class="breadcrumb-item active" aria-current="page">Website Analytics</li> -->
            </ol>
         </nav>
         <h4 class="mg-b-0 tx-spacing--1">Welcome to Demo Request</h4>
      </div>
      <!-- data table -->
      <div data-label="Example" class="template-content mt-3">
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
@endsection
