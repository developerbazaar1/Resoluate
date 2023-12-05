@extends('vendor.layouts.header')

@section('styles') 



@endsection

@section('content')

<div class="content content-fixed ">

   <div class="container pd-x-0 pd-lg-x-10 pd-xl-x-0  ">

      <div>

         <nav aria-label="breadcrumb">

            <ol class="breadcrumb breadcrumb-style1 mg-b-10">

               <li class="breadcrumb-item"><a href="#">All Contracts</a></li>

               <!-- <li class="breadcrumb-item active" aria-current="page">Website Analytics</li> -->

            </ol>

         </nav>

         <h4 class="mg-b-0 tx-spacing--1">Welcome to All Contracts</h4>

      </div>

  

   
              

               <div class="table-responsive">

               <table id="example11" class="table data-table">

                  <thead>

                     <tr class="table-heading">

                    

                        <th>Contract Type</th>

                        <th>Start Date/Executed Date </th>

                        <th>End date </th>

                        <th>View Doc </th>

                        <th>Status </th>

                     </tr>

                  </thead>

                  <tbody>


                     @foreach($owner_msas as $owner_msa)

                     <tr>

                        <td>Owner Msa</td>

                        <td>{{$owner_msa->start_date  }}</td>

                        <td>{{$owner_msa->end_date}}</td>

                        <td><a class=" btn-sm btn-success"  href="{{ URL::asset('public/'.$owner_msa->document) }}" target="_blank">View Document</a></td>
                        @php 
                           $ownermsaid = Crypt::encrypt($owner_msa->id); 
                        @endphp
                        <td><a class=" btn-sm btn-success"  href="{{ route('vendor-owner-msa-start-workflow', $ownermsaid) }}" >@php if($owner_msa->status == 'negotiation'){ echo "Comment"; }else{ echo $owner_msa->status; } @endphp</a></td>

                     </tr>

                     @endforeach
                     @foreach($vendor_msas as $vendor_msa)

                     <tr>

                        <td>Vendor Msa</td>

                        <td>{{$vendor_msa->executed_date}}</td>

                        <td>{{$vendor_msa->expired_date}}</td>

                        <td>

                           @if(!empty($vendor_msa->document))

                           <a class=" btn-sm btn-success"  href="{{ URL::asset('public/'.$vendor_msa->document) }}" target="_blank">View Document</a>

                           @else

                           <a class=" btn-sm btn-success" target="_blank" href="{{ URL::asset('public/'.$vendor_msa->template->document) }}" >View Document</a>

                           @endif

                        </td>

                        @php 
                           $vendormsaid = Crypt::encrypt($vendor_msa->id); 
                        @endphp
                        <td><a class=" btn-sm btn-success"  href="{{ route('vendor-vendormsa-start-workflow', $vendormsaid) }}" >@php if($vendor_msa->status == 'negotiation'){ echo "Comment"; }else{ echo $vendor_msa->status; } @endphp</a></td>
                        
                     </tr>

                     @endforeach

                      @foreach($project_contract_owners as $pco)

                     <tr>


                        <td>Project Contract Owner</td>

                        <td>{{$pco->start_date}}</td>

                        <td>{{$pco->end_date}}</td>

                        <td><a class=" btn-sm btn-success"  href="{{ URL::asset('public/'.$pco->document) }}" target="_blank">View Document</a></td>

                         @php 
                           $pcoid = Crypt::encrypt($pco->id); 
                        @endphp
                        <td><a class=" btn-sm btn-success"  href="{{ route('vendor-project-contract-owner-start-workflow', $pcoid) }}" >@php if($pco->status == 'negotiation'){ echo "Comment"; }else{ echo $pco->status; } @endphp</a></td>

                     </tr>

                     @endforeach

                     @foreach($project_contract_vendors as $vendor_msa)

                     <tr>

                        <td>Project Contract Vendor</td>

                        <td>{{$vendor_msa->start_date}}</td>

                        <td>{{$vendor_msa->end_date}}</td>

                         <td>

                           @if(!empty($vendor_msa->document))

                           <a class=" btn-sm btn-success"  href="{{ URL::asset('public/'.$vendor_msa->document) }}" target="_blank">View Document</a>

                           @else

                           <a class=" btn-sm btn-success"  href="{{ URL::asset('public/'.$vendor_msa->template->document) }} " target="_blank">View Document</a>

                           @endif

                        </td>

                        

                        @php 
                           $pcvid = Crypt::encrypt($vendor_msa->id); 
                        @endphp
                        <td><a class=" btn-sm btn-success"  href="{{ route('vendor-project-contract-vendor-start-workflow', $pcvid) }}" >@php if($vendor_msa->status == 'negotiation'){ echo "Comment"; }else{ echo $vendor_msa->status; } @endphp</a></td>

                     </tr>

                     @endforeach

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

      $(function() {

        'use strict'

        $('#example11').DataTable({

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



      $(function() {

        'use strict'

        $('#example3').DataTable({

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

        $('#example4').DataTable({

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

        $('#example5').DataTable({

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

        $('#example6').DataTable({

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

