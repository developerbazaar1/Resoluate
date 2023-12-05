@extends('vendor.layouts.header')
@section('styles') 

@endsection
@section('content')
<div class="content content-fixed">
   <div class="container pd-x-0 pd-lg-x-10 pd-xl-x-0">
      <div class="d-sm-flex align-items-center justify-content-between mg-b-20 mg-lg-b-25 mg-xl-b-30">
         <div>
            <nav aria-label="breadcrumb">
               <ol class="breadcrumb breadcrumb-style1 mg-b-10">
                  <li class="breadcrumb-item"><a href="{{ route('user-dashboard') }}">Dashboard</a></li>
               </ol>
            </nav>
            <h4 class="mg-b-0 tx-spacing--1">Welcome to Dashboard</h4>
            
            
         
         </div>
         <!--<div class="d-none d-md-block">-->
         <!--   <div class="dropdown">-->
         <!--      <button class="btn dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">-->
         <!--      Sort By Status-->
         <!--      </button>-->
         <!--      <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">-->
         <!--         <a class="dropdown-item" href="#">last 10 days</a>-->
         <!--         <a class="dropdown-item" href="#">last 30 days</a>-->
         <!--         <a class="dropdown-item" href="#">last 45 days</a>-->
         <!--      </div>-->
         <!--   </div>-->
         <!--</div>-->
      </div>
      
      <span class="d-none" id="active_owner_msa_count">{{$active_owner_msa}}</span>
      <span class="d-none" id="active_vendor_msa_count">{{$active_vendor_msa}}</span>
      <span  class="d-none" id="active_project_contract_owners_count">{{$active_project_contract_owners}}</span>
      <span class="d-none" id="active_project_contract_vendors_count">{{$active_project_contract_vendors}}</span>
      
      
      <span class="d-none" id="total_declined_count">{{$total_declined}}</span>
      <span class="d-none" id="total_workflow_count">{{$total_workflow}}</span>
      <span class="d-none" id="total_negotiation_count">{{$total_negotiation}}</span>
      <span class="d-none" id="total_completed_count">{{$total_completed}}</span>
      
      
      
      <div class="row">
         <div class="col-md-6">
            <div class="row row-xs">
               <div class="col col-xl-9 d-none">
                  <div class="card">
                     <canvas id="chartBar2" width="529" height="300" style="display: block; width: 529px; height: 300px;" class="chartjs-render-monitor"></canvas>
                  </div>
               </div>
            </div>
            <div class="card">
               <div class="card-header">
                  <h6 class="mg-b-0">Current Active Contract</h6>
               </div>
               <div class="card-body pd-lg-25">
                  <div class="chart-seven">
                     <div class="chartjs-size-monitor" style="position: absolute; inset: 0px; overflow: hidden; pointer-events: none; visibility: hidden; z-index: -1;">
                        <div class="chartjs-size-monitor-expand" style="position:absolute;left:0;top:0;right:0;bottom:0;overflow:hidden;pointer-events:none;visibility:hidden;z-index:-1;">
                           <div style="position:absolute;width:1000000px;height:1000000px;left:0;top:0"></div>
                        </div>
                        <div class="chartjs-size-monitor-shrink" style="position:absolute;left:0;top:0;right:0;bottom:0;overflow:hidden;pointer-events:none;visibility:hidden;z-index:-1;">
                           <div style="position:absolute;width:200%;height:200%;left:0; top:0"></div>
                        </div>
                     </div>
                     <canvas id="chartDonut_cur" width="226" height="188" style="display: block; width: 226px; height: 188px;" class="chartjs-render-monitor1"></canvas>
                  </div>
               </div>
            
            </div>
         </div>
         <div class="col-md-6">
            <div class="card">
               <div class="card-header">
                  <h6 class="mg-b-0">By Status</h6>
               </div>
               <div class="card-body pd-lg-25">
                  <div class="chart-seven" style="height: 410px !important;">
                     <div class="chartjs-size-monitor" style="position: absolute; inset: 0px; overflow: hidden; pointer-events: none; visibility: hidden; z-index: -1;">
                        <div class="chartjs-size-monitor-expand" style="position:absolute;left:0;top:0;right:0;bottom:0;overflow:hidden;pointer-events:none;visibility:hidden;z-index:-1;">
                           <div style="position:absolute;width:1000000px;height:1000000px;left:0;top:0"></div>
                        </div>
                        <div class="chartjs-size-monitor-shrink" style="position:absolute;left:0;top:0;right:0;bottom:0;overflow:hidden;pointer-events:none;visibility:hidden;z-index:-1;">
                           <div style="position:absolute;width:200%;height:200%;left:0; top:0"></div>
                        </div>
                     </div>
                     <canvas id="chartDonut_status" width="226" height="188" style="display: block; width: 226px!important; height: 188px !important;" class="chartjs-render-monitor"></canvas>
                  </div>
               </div>
              
            </div>
         </div>
      </div>
      <div class="row row-xs">
         <div class="col col-xl-9 d-none">
            <div class="card">
               <canvas id="chartBar1" width="529" height="300" style="display: block; width: 529px; height: 300px;" class="chartjs-render-monitor"></canvas>
            </div>
         </div>
      </div>
      
       <div>
        <canvas id="chart"></canvas>
    </div>
   </div>
</div>
@endsection
@section('scripts') 
<script src="{{ URL::asset('assets/js/Chart.bundle.min.js') }}"></script>
<script src="{{ URL::asset('assets/js/chart.morris.js') }}"></script>
<script src="{{ URL::asset('assets/js/chart.chartjs.js') }}"></script>
<script src="{{ URL::asset('assets/js/chart.flot.js') }}"></script>
<script src="{{ URL::asset('assets/jquery.flot/jquery.flot.js') }}"></script>

  
  <script>
  
     
  var aomc =  $('#active_owner_msa_count').html();
  var avmc =  $('#active_vendor_msa_count').html();
  var apcoc =  $('#active_project_contract_owners_count').html();
  var apcvc =  $('#active_project_contract_vendors_count').html();
  
  
  var datapie = {
        labels: ['Owners MSA', 'Vendor MSA', 'Project Contract - Owner', 'Project Contract - Vendor'],
        datasets: [{
          data: [aomc,avmc,apcoc,apcvc],
          backgroundColor: ['#f77eb9', '#7ebcff','#00cccc','#fdbd88']
        }]
      };
   
  var ctx9 = document.getElementById('chartDonut_cur');
  var myDonutChart = new Chart(ctx9, {
    type: 'doughnut',
    data: datapie,
    options: optionpie
  });
  
  
  var tdc =  $('#total_declined_count').html();
  var twc =  $('#total_workflow_count').html();
  var tnc =  $('#total_negotiation_count').html();
  var tcc =  $('#total_completed_count').html();
  
  
      var datapie1 = {
        labels: ['Executed', 'In Workflow', 'Under Negotiation', 'Declined'],
        datasets: [{
          data: [tcc,twc,tnc,tdc],
          backgroundColor: ['#f77eb9', '#7ebcff','#00cccc','#fdbd88']
        }]
      };
      

  var ctx91 = document.getElementById('chartDonut_status');
  var myDonutChart1 = new Chart(ctx91, {
    type: 'doughnut',
    data: datapie1,
    options: optionpie
  });
  
   var optionpie = {
    maintainAspectRatio: false,
    responsive: true,
    legend: {
      display: false,
    },
    animation: {
      animateScale: true,
      animateRotate: true
    }
  };
  </script>
 
    
@endsection
