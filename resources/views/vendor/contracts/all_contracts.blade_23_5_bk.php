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

      <div data-label="Example" class="mt-3">

         <div class="scroll-x">

         <ul class="nav nav-line tab-list min-w-m-c" id="myTab5" role="tablist">

            <li class="nav-item tab-item">

               <a class="nav-link {{ empty($tabName) || $tabName == 'owner-msa' ? 'active' : '' }} "  id="Owner-tab5" data-toggle="tab" href="#Owner5" role="tab" aria-controls="home" aria-selected="true">Owner MSA's</a>

            </li>

            <li class="nav-item">

               <a class="nav-link {{ $tabName == 'vendor-msa/psa' ? 'active' : '' }} " id="Vendor-tab5" data-toggle="tab" href="#Vendor5" role="tab" aria-controls="profile" aria-selected="false">Vendor MSA's / PSA's</a>

            </li>

            <li class="nav-item">

               <a class="nav-link {{ $tabName == 'project contract-owner' ? 'active' : '' }} " id="Project-owner-tab5" data-toggle="tab" href="#Project-owner5" role="tab" aria-controls="contact" aria-selected="false">Project Contract - Owner</a>

            </li>

            <li class="nav-item">

               <a class="nav-link {{ $tabName == 'project contract-vendor' ? 'active' : '' }}" id="Project-vendor-tab5" data-toggle="tab" href="#Project-vendor5" role="tab" aria-controls="contact" aria-selected="false">Project Contract - Vendor</a>

            </li>

            <li class="nav-item">

               <a class="nav-link {{ $tabName == 'nda' ? 'active' : '' }}" id="NDA-tab5" data-toggle="tab" href="#NDA5" role="tab" aria-controls="contact" aria-selected="false">NDA's</a>

            </li>

            <li class="nav-item">

               <a class="nav-link {{ $tabName == 'others' ? 'active' : '' }}" id="Other-tab5" data-toggle="tab" href="#Other5" role="tab" aria-controls="contact" aria-selected="false">Other's</a>

            </li>

         </ul>
      </div>

         <div class="tab-content mg-t-20" id="myTabContent5">

            <div class="tab-pane fade {{ empty($tabName) || $tabName == 'owner-msa' ? 'active show' : '' }}" id="Owner5" role="tabpanel" aria-labelledby="Owner-tab5">

              

               <div class="table-responsive">

               <table id="example11" class="table data-table">

                  <thead>

                     <tr class="table-heading">

                        <th>S.no. </th>

                        <th>Owner Name </th>

                        <th>Owner Email </th>

                        <th>Start Date </th>

                        <th>End date </th>

                        <th>View Doc </th>

                        <th>Go to Workflow </th>

                     </tr>

                  </thead>

                  <tbody>

                     @if(count($owner_msas) > 0)

                     @php

                         $sno = 1;

                      

                     @endphp

                     @foreach($owner_msas as $owner_msa)

                     <tr>

                        <td>{{$sno}}</td>

                        <td>{{$owner_msa->owner_name}}</td>

                        <td>{{$owner_msa->owner_email}}</td>

                        <td>{{$owner_msa->start_date  }}</td>

                        <td>{{$owner_msa->end_date}}</td>

                        <td><a class=" btn-sm btn-success"  href="{{ URL::asset('public/'.$owner_msa->document) }}" target="_blank">View Document</a></td>
                        @php 
                           $ownermsaid = Crypt::encrypt($owner_msa->id); 
                        @endphp
                        <td><a class=" btn-sm btn-success"  href="{{ route('vendor-owner-msa-start-workflow', $ownermsaid) }}" >{{$owner_msa->status}}</a></td>

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

            <div class="tab-pane fade {{ $tabName == 'vendor-msa/psa' ? 'active show' : '' }} " id="Vendor5" role="tabpanel" aria-labelledby="Vendor-tab5">

               

               <div class="table-responsive">

               <table id="example2" class="table data-table">

                  <thead>

                     <tr class="table-heading">

                        <th>S.no.</th>

                        <th>Vendor Name</th>

                        <th>Due Date</th>

                        <th>Executed Date</th>

                        <th>Expiry Date</th>

                        <th>Type</th>

                        <th>View Doc</th>

                        <th>Go to Workflow</th>

                     </tr>

                  </thead>

                  <tbody>

                     @if(count($vendor_msas) > 0)

                     @php

                         $sno = 1;

                      

                     @endphp

                     @foreach($vendor_msas as $vendor_msa)

                     <tr>

                        <td>{{$sno}}</td>

                        <td>{{$vendor_msa->vendor_name}}</td>

                        <td>{{$vendor_msa->due_date}}</td>

                        <td>{{$vendor_msa->exceuted_date}}</td>

                        <td>{{$vendor_msa->expired_date}}</td>

                        <td>{{$vendor_msa->type_msa_psa}}</td>

                        <td>

                           @if(!empty($vendor_msa->document))

                           <a class=" btn-sm btn-success"  href="{{ URL::asset('public/'.$vendor_msa->document) }}" target="_blank">View Document</a>

                           @else

                           <a class=" btn-sm btn-success" target="_blank" href="{{ URL::asset('public/'.$vendor_msa->template->document) }}" >View Document</a>

                           @endif

                        </td>

                        <td><a class=" btn-sm btn-success"  href="" >{{$vendor_msa->status}}</a></td>

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

            <div class="tab-pane fade  {{ $tabName == 'project contract-owner' ? 'active show' : '' }} " id="Project-owner5" role="tabpanel" aria-labelledby="Project-owner-tab5">

               

               <div class="table-responsive">

               <table id="example3" class="table data-table">

                  <thead>

                     <tr class="table-heading">

                        <th>S.no.</th>

                        <th>Project Name</th>

                        <th>Project Number</th>

                        <th>Client Name</th>

                        <th>Start Date</th>

                        <th>End Date</th>

                        <th>View Doc</th>

                        <th>Go to Workflow</th>

                     </tr>

                  </thead>

                  <tbody>

                     @if(count($project_contract_owners) > 0)

                     @php

                         $sno = 1;

                      

                     @endphp

                     @foreach($project_contract_owners as $pco)

                     <tr>

                        <td>{{$sno}}</td>

                        <td>{{$pco->project_name}}</td>

                        <td>{{$pco->project_umbea}}</td>

                        <td>{{$pco->client_name}}</td>

                        <td>{{$pco->start_date}}</td>

                        <td>{{$pco->end_date}}</td>

                        <td><a class=" btn-sm btn-success"  href="{{ URL::asset('public/'.$pco->document) }}" target="_blank">View Document</a></td>

                        <td><a class=" btn-sm btn-success"  href="" >{{$pco->status}}</a></td>

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

            <div class="tab-pane fade {{ $tabName == 'project contract-vendor' ? 'active show' : '' }} " id="Project-vendor5" role="tabpanel" aria-labelledby="Project-vendor-tab5">

               

               <div class="table-responsive">

               <table id="example4" class="table data-table">

                  <thead>

                     <tr class="table-heading">

                        <th>S.no.</th>

                        <th>Vendor Name</th>

                        <th>Project Name</th>

                        <th>Start Date</th>

                        <th>End Date</th>

                        <th>Amount</th>

                        <th>View Doc</th>

                        <th>Go to Workflow</th>

                     </tr>

                  </thead>

                  <tbody>

                     @if(count($project_contract_vendors) > 0)

                     @php

                         $sno = 1;

                      

                     @endphp

                     @foreach($project_contract_vendors as $vendor_msa)

                     <tr>

                        <td>{{$sno}}</td>

                        <td>{{$vendor_msa->vendor_name}}</td>

                        <td>{{$vendor_msa->project_name}}</td>

                        <td>{{$vendor_msa->start_date}}</td>

                        <td>{{$vendor_msa->end_date}}</td>

                        <td>${{$vendor_msa->amount}}</td>

                         <td>

                           @if(!empty($vendor_msa->document))

                           <a class=" btn-sm btn-success"  href="{{ URL::asset('public/'.$vendor_msa->document) }}" target="_blank">View Document</a>

                           @else

                           <a class=" btn-sm btn-success"  href="{{ URL::asset('public/'.$vendor_msa->template->document) }} " target="_blank">View Document</a>

                           @endif

                        </td>

                        

                        <td><a class=" btn-sm btn-success"  href="" >{{$vendor_msa->status}}</a></td>

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

            <div class="tab-pane fade" id="NDA5" role="tabpanel" aria-labelledby="NDA-tab5">

            </div>

            <div class="tab-pane fade" id="Other5" role="tabpanel" aria-labelledby="Other-tab5">

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

