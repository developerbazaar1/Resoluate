@extends('user.layouts.header')
@section('styles') 

@endsection
@section('content')
<div class="content content-fixed ">
   <div class="container pd-x-0 pd-lg-x-10 pd-xl-x-0  ">
        
         <div class="position-relative">
            <nav aria-label="breadcrumb">
               <ol class="breadcrumb breadcrumb-style1 mg-b-10">
                  <li class="breadcrumb-item"><a href="{{ route('user-all-contracts', 'tabName=project contract-owner') }}">Project Contract Owner</a></li>
               </ol>
            </nav>
            <h4 class="mg-b-0 tx-spacing--1">Create Project Contract Owner</h4>
            <div class="back-btn back_pc">
              <a href="{{ route('user-all-contracts', 'tabName=project contract-owner') }}">
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

         

        <form method="POST" action="{{ route('user-store-project-contract-owner') }}" enctype="multipart/form-data">
         @csrf
          
          <div class="row external-border">
               <div class="col-md-6">
                    
                     <div class="party-one">
                       <label for="">Project Number:</label>
                       <input id="project_umbea" type="text" class="form-control @error('project_umbea') is-invalid @enderror" name="project_umbea" value="{{ old('project_umbea') }}"  autofocus>
                            @error('project_umbea')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                     </div>
                     <div class="party-one position-relative">
                        <label for="">Client Name:</label>
                        <input id="myInput" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}"  autocomplete="name" autofocus>
                          @error('name')
                              <span class="invalid-feedback" role="alert">
                                  <strong>{{ $message }}</strong>
                              </span>
                          @enderror
                     </div>
                 </div>
              <div class="col-md-6">
                  <div class="party-one">
                     <label for="">Project Name:</label>
                     <input id="project_name" type="text" class="form-control @error('project_name') is-invalid @enderror" name="project_name" value="{{ old('project_name') }}"  autofocus>
                          @error('project_name')
                              <span class="invalid-feedback" role="alert">
                                  <strong>{{ $message }}</strong>
                              </span>
                          @enderror
                  </div>
                 
                  
                 <div class="party-one position-relative">
                    <label for="">Client Email:</label>
                    <input id="client_email" type="text" class="form-control @error('client_email') is-invalid @enderror" name="client_email" value="{{ old('client_email') }}"  autofocus>
                      @error('client_email')
                          <span class="invalid-feedback" role="alert">
                              <strong>{{ $message }}</strong>
                          </span>
                      @enderror
                 </div>
              </div>
              <div class="col-md-12">
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
              <div class="col-md-6">
                     <div class="party-one position-relative">
                       <label for="">Start Date:</label>
                       <input type="date" class="form-control @error('start_date') is-invalid @enderror" placeholder="Choose date" id="start_date" name="start_date" value="{{ old('start_date') }}"  autocomplete="name" autofocus>
                        @error('start_date')
                              <span class="invalid-feedback" role="alert">
                                  <strong>{{ $message }}</strong>
                              </span>
                          @enderror
                     </div>
                     
                     <div class="party-one">
                       <label for="">Does the Client have an active MSA ?</label>
                       <div class="radio-btn d-flex">
                          <div class="custom-control custom-radio">
                            <input type="radio" id="does_client_have_msa" name="does_client_have_msa" class="custom-control-input" value="Yes">
                            <label class="custom-control-label" for="does_client_have_msa">Yes</label>
                          </div>
                          <div class="custom-control custom-radio">
                            <input type="radio" id="does_client_have_msa1" name="does_client_have_msa" class="custom-control-input" value="No">
                            <label class="custom-control-label" for="does_client_have_msa1">No</label>
                          </div>
                        </div>
                      </div>

                     
              </div>
              
              <div class="col-md-6">
                 <div class="party-one">
                        <label for="">End Date:</label>
                        <input id="end_date" type="date" class="form-control @error('end_date') is-invalid @enderror" name="end_date" value="{{ old('end_date') }}"  autofocus>
                          @error('end_date')
                              <span class="invalid-feedback" role="alert">
                                  <strong>{{ $message }}</strong>
                              </span>
                          @enderror
                  </div>

                 <div class="party-one d-none" id="does_msa_req_section">
                   <label for="">Is MSA an executed MSA required by the client ?</label>
                   <div class="radio-btn d-flex">
                      <div class="custom-control custom-radio">
                        <input type="radio" id="does_msa_req" name="does_msa_req" class="custom-control-input" value="Yes">
                        <label class="custom-control-label" for="does_msa_req">Yes</label>
                      </div>
                      <div class="custom-control custom-radio">
                        <input type="radio" id="does_msa_req1" name="does_msa_req" class="custom-control-input" value="No">
                        <label class="custom-control-label" for="does_msa_req1">No</label>
                      </div>
                    </div>
                  </div>

               </div>
               
               <div id="upload_section" class="col-md-12 d-none">
                
                 <div class="custom-file file-border">
                    <label class="file-upload" for="customFile">Upload Owner MSA <i class="fas fa-upload"></i></label>
                    <input type="file" name="document" class="custom-file-input" id="customFile">
                 </div>
                
                 
                 <div class="external-btn text-center">
                    <button type="submit" class="btn btn-primary">Submit</button>
                 </div>

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

<?php $myvalues = $client_names; ?>

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
  $("button").click(function(){
  $("p:first").addClass("intro");
});
  does_client_have_msa

  $(document).ready(function(){
    $('#does_client_have_msa').click(function(){
        $('#upload_section').removeClass('d-none'); 
        $('#does_msa_req_section').addClass('d-none');       
    });
    $('#does_client_have_msa1').click(function(){
        $('#does_msa_req_section').removeClass('d-none');  
        $('#upload_section').addClass('d-none');      
    });


    $('#does_msa_req').click(function(){
        $('#upload_section').addClass('d-none');       
    });
    $('#does_msa_req1').click(function(){
        $('#upload_section').removeClass('d-none');      
    });

  });

</script>
@endsection
