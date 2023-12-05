@extends('user.layouts.header')
@section('styles') 

@endsection
@section('content')

<div class="content content-fixed ">
   <div class="container pd-x-0 pd-lg-x-10 pd-xl-x-0  ">
        <!-- <div class=" back-btn">
          <a href="{{ route('user-all-contracts') }}">
          <i class="fa fa-arrow-left"></i>Back </a>
        </div> -->
         <div class="position-relative">
            <nav aria-label="breadcrumb">
               <ol class="breadcrumb breadcrumb-style1 mg-b-10">
                  <li class="breadcrumb-item"><a href="{{ route('user-all-contracts', 'tabName=vendor-msa/psa') }}">Vendor MSA's / PSA's</a></li>
               </ol>
            </nav>
            <h4 class="mg-b-0 tx-spacing--1">Create Vendor MSA's / PSA's</h4>
            <div class="back-btn back_pc">
              <a href="{{ route('user-all-contracts', 'tabName=vendor-msa/psa') }}">
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

         

        <form method="POST" action="{{ route('user-store-vendor-msa') }}" >
         @csrf
          
          <div class="row external-border">
               <div class="col-md-6">
                  
                     <div class="party-one">
                        <label for="">Vendor Name:</label>
                        <input id="myInput" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}"  autocomplete="name" autofocus>
                          @error('name')
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
                       <label for="">Select Type:</label>
                         <select name="type_msa_psa" id="type_msa_psa" class="form-control contract_dropdown">
                           <option label="Choose one"></option>
                            @if(count($msa_types) > 0)
                               @foreach($msa_types as $msa_type)
                                 @if ($msa_type->id ==  old('type_msa_psa') )
                                     <option value="{{ $msa_type->name }}" selected>{{ $msa_type->name }}</option>
                                 @else
                                     <option value="{{ $msa_type->name }}" >{{$msa_type->name}}</option>
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
                      <label for="">Contact:</label>
                      <input id="contact" type="text" class="form-control @error('contact') is-invalid @enderror" name="contact" value="{{ old('contact') }}"  autofocus>
                        @error('contact')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                   </div>
                   <div class="party-one">
                       <label for="">Select Template:</label>
                         <select name="template_id" id="template_id" class="form-control contract_dropdown">
                            @if(count($templates) > 0)
                             @foreach($templates as $template)
                                @if (old('template') == $template->id)
                                   <option value="{{ $template->id }}" selected>{{ $template->name }}</option>
                                @else
                                   
                                @endif
                             @endforeach
                            @endif
                           <!-- <option label="Choose one"></option>
                            @if(count($templates) > 0)
                               @foreach($templates as $template)
                                 @if ($template->id ==  old('template') )
                                     <option value="{{ $template->id }}" selected>{{ $template->name }}</option>
                                 @else
                                     <option value="{{ $template->id }}" >{{$template->name}}</option>
                                 @endif
                               @endforeach
                            @endif -->
                         </select>
                     </div>
                   
               </div>
               
               <!-- <div class="col-md-6">
                     <div class="party-one">
                       <label for="">Add Vendor to Resolute:</label>
                         <select name="vendor" id="vendor" class="form-control contract_dropdown">
                           <option label="Choose one"></option>
                            @if(count($vendors) > 0)
                               @foreach($vendors as $vendor)
                                 @if ($vendor->id ==  old('vendor') )
                                     <option value="{{ $vendor->id }}" selected>{{ $vendor->name }}</option>
                                 @else
                                     <option value="{{ $vendor->id }}" >{{$vendor->name}}</option>
                                 @endif
                               @endforeach
                            @endif
                         </select>
                         <a href="" data-toggle="modal" data-target="#exampleModalCenter" class="tx-13 text-right">
                             
                             <span class="badge text-bg-success">If the vendor is not on Resolute, Click here to add</span></a>   
                     </div>
               </div> -->
               <div class="col-md-6">
                <div class="party-one">
                   <input name="team_step" id="team_step" type="hidden" value="" >
                  
                    <label for="">Create Workflow:</label>
                        <div class="customer_records">
                          <input name="team_step1" type="text" class="teaminputjs" value="1" readonly>
                         
                          <select name="team1" id="team" class="teamjs team_hir form-control contract_dropdown"  onchange="myFunction()">
                             <option label="Choose Team"></option>
                              @if(count($users) > 0)
                                 @foreach($users as $user)
                                   @if ($user->id ==  old('team') )
                                       <option value="{{ $user->id }}" selected>{{ $user->name }}</option>
                                   @else
                                       <option value="{{ $user->id }}" >{{$user->name}}</option>
                                   @endif
                                 @endforeach
                              @endif
                           </select>
                          <a class="extra-fields-customer" href="#">+</a>
                        </div>
                        <div class="customer_records_dynamic"></div>
                    </div> 
               </div>

               
               <div class="external-btn col-12 d-flex justify-content-center">
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
      </div>

<style>
    .badge {
    font-size: 10px;
    font-weight: 500;
    font-family: -apple-system, BlinkMacSystemFont, "Inter UI", Roboto, sans-serif;
    padding: 3px 5px 4px;
    border-radius: 3px;
}

.text-bg-success {
    color: #fff !important;
    background-color: #0C8842 !important;
}
    
</style>

<?php $myvalues = $vendor_msa_names; ?>

@endsection
@section('scripts') 
<script>
function autocomplete(inp, arr) {
  /*the autocomplete function takes two arguments,
  the text field element and an array of possible autocompleted values:*/
  var currentFocus;
  /*execute a function when someone writes in the text field:*/
  inp.addEventListener("input", function(e) {
      var a, b, i, val = this.value;
      /*close any already open lists of autocompleted values*/
      closeAllLists();
      if (!val) { return false;}
      currentFocus = -1;
      /*create a DIV element that will contain the items (values):*/
      a = document.createElement("DIV");
      a.setAttribute("id", this.id + "autocomplete-list");
      a.setAttribute("class", "autocomplete-items");
      /*append the DIV element as a child of the autocomplete container:*/
      this.parentNode.appendChild(a);
      /*for each item in the array...*/
      for (i = 0; i < arr.length; i++) {
        /*check if the item starts with the same letters as the text field value:*/
        if (arr[i].substr(0, val.length).toUpperCase() == val.toUpperCase()) {
          /*create a DIV element for each matching element:*/
          b = document.createElement("DIV");
          /*make the matching letters bold:*/
          b.innerHTML = "<strong>" + arr[i].substr(0, val.length) + "</strong>";
          b.innerHTML += arr[i].substr(val.length);
          /*insert a input field that will hold the current array item's value:*/
          b.innerHTML += "<input type='hidden' value='" + arr[i] + "'>";
          /*execute a function when someone clicks on the item value (DIV element):*/
          b.addEventListener("click", function(e) {
              /*insert the value for the autocomplete text field:*/
              inp.value = this.getElementsByTagName("input")[0].value;
              /*close the list of autocompleted values,
              (or any other open lists of autocompleted values:*/
              closeAllLists();
          });
          a.appendChild(b);
        }
      }
  });
  /*execute a function presses a key on the keyboard:*/
  inp.addEventListener("keydown", function(e) {
      var x = document.getElementById(this.id + "autocomplete-list");
      if (x) x = x.getElementsByTagName("div");
      if (e.keyCode == 40) {
        /*If the arrow DOWN key is pressed,
        increase the currentFocus variable:*/
        currentFocus++;
        /*and and make the current item more visible:*/
        addActive(x);
      } else if (e.keyCode == 38) { //up
        /*If the arrow UP key is pressed,
        decrease the currentFocus variable:*/
        currentFocus--;
        /*and and make the current item more visible:*/
        addActive(x);
      } else if (e.keyCode == 13) {
        /*If the ENTER key is pressed, prevent the form from being submitted,*/
        e.preventDefault();
        if (currentFocus > -1) {
          /*and simulate a click on the "active" item:*/
          if (x) x[currentFocus].click();
        }
      }
  });
  function addActive(x) {
    /*a function to classify an item as "active":*/
    if (!x) return false;
    /*start by removing the "active" class on all items:*/
    removeActive(x);
    if (currentFocus >= x.length) currentFocus = 0;
    if (currentFocus < 0) currentFocus = (x.length - 1);
    /*add class "autocomplete-active":*/
    x[currentFocus].classList.add("autocomplete-active");
  }
  function removeActive(x) {
    /*a function to remove the "active" class from all autocomplete items:*/
    for (var i = 0; i < x.length; i++) {
      x[i].classList.remove("autocomplete-active");
    }
  }
  function closeAllLists(elmnt) {
    /*close all autocomplete lists in the document,
    except the one passed as an argument:*/
    var x = document.getElementsByClassName("autocomplete-items");
    for (var i = 0; i < x.length; i++) {
      if (elmnt != x[i] && elmnt != inp) {
        x[i].parentNode.removeChild(x[i]);
      }
    }
  }
  /*execute a function when someone clicks in the document:*/
  document.addEventListener("click", function (e) {
      closeAllLists(e.target);
  });
}
var countries = <?php echo json_encode($myvalues); ?>;
/*An array containing all the country names in the world:*/
var countries_ = ["Afghanistan","Albania","Algeria","Andorra","Angola","Anguilla","Antigua & Barbuda","Argentina","Armenia","Aruba","Australia","Austria","Azerbaijan","Bahamas","Bahrain","Bangladesh","Barbados","Belarus","Belgium","Belize","Benin","Bermuda","Bhutan","Bolivia","Bosnia & Herzegovina","Botswana","Brazil","British Virgin Islands","Brunei","Bulgaria","Burkina Faso","Burundi","Cambodia","Cameroon","Canada","Cape Verde","Cayman Islands","Central Arfrican Republic","Chad","Chile","China","Colombia","Congo","Cook Islands","Costa Rica","Cote D Ivoire","Croatia","Cuba","Curacao","Cyprus","Czech Republic","Denmark","Djibouti","Dominica","Dominican Republic","Ecuador","Egypt","El Salvador","Equatorial Guinea","Eritrea","Estonia","Ethiopia","Falkland Islands","Faroe Islands","Fiji","Finland","France","French Polynesia","French West Indies","Gabon","Gambia","Georgia","Germany","Ghana","Gibraltar","Greece","Greenland","Grenada","Guam","Guatemala","Guernsey","Guinea","Guinea Bissau","Guyana","Haiti","Honduras","Hong Kong","Hungary","Iceland","India","Indonesia","Iran","Iraq","Ireland","Isle of Man","Israel","Italy","Jamaica","Japan","Jersey","Jordan","Kazakhstan","Kenya","Kiribati","Kosovo","Kuwait","Kyrgyzstan","Laos","Latvia","Lebanon","Lesotho","Liberia","Libya","Liechtenstein","Lithuania","Luxembourg","Macau","Macedonia","Madagascar","Malawi","Malaysia","Maldives","Mali","Malta","Marshall Islands","Mauritania","Mauritius","Mexico","Micronesia","Moldova","Monaco","Mongolia","Montenegro","Montserrat","Morocco","Mozambique","Myanmar","Namibia","Nauro","Nepal","Netherlands","Netherlands Antilles","New Caledonia","New Zealand","Nicaragua","Niger","Nigeria","North Korea","Norway","Oman","Pakistan","Palau","Palestine","Panama","Papua New Guinea","Paraguay","Peru","Philippines","Poland","Portugal","Puerto Rico","Qatar","Reunion","Romania","Russia","Rwanda","Saint Pierre & Miquelon","Samoa","San Marino","Sao Tome and Principe","Saudi Arabia","Senegal","Serbia","Seychelles","Sierra Leone","Singapore","Slovakia","Slovenia","Solomon Islands","Somalia","South Africa","South Korea","South Sudan","Spain","Sri Lanka","St Kitts & Nevis","St Lucia","St Vincent","Sudan","Suriname","Swaziland","Sweden","Switzerland","Syria","Taiwan","Tajikistan","Tanzania","Thailand","Timor L'Este","Togo","Tonga","Trinidad & Tobago","Tunisia","Turkey","Turkmenistan","Turks & Caicos","Tuvalu","Uganda","Ukraine","United Arab Emirates","United Kingdom","United States of America","Uruguay","Uzbekistan","Vanuatu","Vatican City","Venezuela","Vietnam","Virgin Islands (US)","Yemen","Zambia","Zimbabwe"];

/*initiate the autocomplete function on the "myInput" element, and pass along the countries array as possible autocomplete values:*/
autocomplete(document.getElementById("myInput"), countries);
</script>



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
<script>
  $(document).ready(function(){
  
      var option = '';
      option += "<option value=''>Select Template</option>";
      $('#type_msa_psa').change(function(){
      var id = $(this).val();
      
          $.ajax({
              url: "{{url('user/get-template')}}/"+id,  
              type: 'get',
              
              success: function(response){ 
              var len = response.length;
              var option = '';
                  if(len > 0){
                      for(var i=0; i<len; i++){
                          var id = response[i].id;
                          var name = response[i].name;
                          option += "<option value='"+id+"'>"+name+"</option>"; 
                      }
                      $("#template_id").html(option); 
                    
                  }
              }
          });
      });
  });
</script>

<script>



  function myFunction() {
    var myarray = [];
        $('.teaminputjs').each(function() {
          myarray.push($(this).attr("name"));
         
        });
          $("#team_step").val(myarray);
  }

 

  $('.extra-fields-customer').click(function() { 
    
     var myarray = [];
        $('.teaminputjs').each(function() {
          myarray.push($(this).attr("name"));
         
        });
          $("#team_step").val(myarray);
  });
      
      
  $(document).on('click', '.remove-field', function(e) { 
    // var len = $(".customer_records_dynamic input").length;
    var myarray = [];
        $('.teaminputjs').each(function() {
          myarray.push($(this).attr("name"));
         
        });

          $("#team_step").val(myarray);
    e.preventDefault();
  });


</script>
<script>
     $('.extra-fields-customer').click(function() {
        $('.customer_records').clone().appendTo('.customer_records_dynamic');
        $('.customer_records_dynamic .customer_records').addClass('single remove');
        $('.single .extra-fields-customer').remove();
        $('.single').append('<a href="#" class="remove-field btn-remove-customer">-</a>');
        $('.customer_records_dynamic > .single').attr("class", "remove");
      
        $('.customer_records_dynamic select').each(function() {
          var count = 1;
          var fieldname = $(this).attr("name");
          var lst =  fieldname[fieldname.length -1];
          var val_input = parseInt(lst) + parseInt(count);
          $(this).attr('name', fieldname + val_input);
          count++;
        });

        $('.customer_records_dynamic input').each(function() {
          var count = 1;
          var fieldval= $(this).val();
          var val_input = parseInt(fieldval) + parseInt(count);
          $(this).val(val_input);

          var fieldname = $(this).attr("name");
          var lst =  fieldname[fieldname.length -1];
          var val_input_name = parseInt(lst) + parseInt(count);
          $(this).attr('name', fieldname + val_input_name);
          count++;
        });

        
      
      });
      
      $(document).on('click', '.remove-field', function(e) {
        $(this).parent('.remove').remove();
        e.preventDefault();
      });


</script>
@endsection
