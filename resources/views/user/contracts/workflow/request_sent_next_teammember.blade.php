@extends('user.layouts.header')
@section('styles') 

@endsection
@section('content')
<div class="content content-fixed ">
   <div class="container pd-x-0 pd-lg-x-10 pd-xl-x-0  ">
        <div class="position-relative">
            <nav aria-label="breadcrumb">
               <ol class="breadcrumb breadcrumb-style1 mg-b-10">
                  <li class="breadcrumb-item"><a href="#">Vendor MSA</a></li>
               </ol>
            </nav>
            <h4 class="mg-b-0 tx-spacing--1">Workflowflow: Vendor MSA</h4>
            <div class="back-btn back_pc">
              <a href="{{ route('user-all-contracts', 'tabName=vendor-msa/psa') }}">
              <i class="fa fa-arrow-left"></i>Back </a>
            </div>
        </div>

        <div>
            <h3 style="margin: 20% 32% 2% 32%">Request sent to next team member</h3>
            <a class="btn-sm btn-success"  href="{{ route('user-all-contracts') }}" style="margin: 20% 42% 2% 43%">GO TO Contracts</a>
        </div>
       

    </div>
</div>
@endsection
@section('scripts')    
   

@endsection