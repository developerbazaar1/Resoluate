@extends('vendor.layouts.header')
@section('styles') 

@endsection
@section('content')
<div class="content content-fixed ">
   <div class="container pd-x-0 pd-lg-x-10 pd-xl-x-0  ">

        
        
            <span id="doc_name" style="display:none">{{ URL::asset('public/'.$vendor_msa->document) }}</span>
            <span id="document_old" style="display:none" >{{ $vendor_msa->document }}</span>
            <span id="vendormsaid" style="display:none">{{ $vendor_msa->id }}</span>
            <span id="username" style="display:none">{{ Auth::user()->name; }}</span>
            <span id="useremail" style="display:none">{{ Auth::user()->email; }}</span>
            <div class="position-relative">
                <nav aria-label="breadcrumb">
                   <ol class="breadcrumb breadcrumb-style1 mg-b-10">
                      <li class="breadcrumb-item"><a href="#">Vendor MSA</a></li>
                   </ol>
                </nav>
                <h4 class="mg-b-0 tx-spacing--1">Comment: Vendor MSA</h4>
                <div class="create-new-btn custom-btn m-0" style="position:absolute;right: 0;top: -2px;">
                        @php 
                           $vendormsaid = Crypt::encrypt($vendor_msa->id); 
                        @endphp


                        <form method="POST" action="{{ route('vendor-vendormsa-sendback-to -team') }}">
                            @csrf
                                <input type="hidden" name="vendormsaid" value={{$vendor_msa->id}}> 
                                <button class="req_for_sign_btn" type="submit" >Send back to team</button>
                        </form>
                    </div>
                
            </div>
            <div id="embeddedView" style="height:90vh !important;"></div>

       
        
    </div>
</div>
@endsection
@section('scripts')    
    <script src="https://documentservices.adobe.com/view-sdk/viewer.js"></script>
    <script src="https://documentcloud.adobe.com/view-sdk/main.js"></script>
    
    <script type="text/javascript">
        const urlToPDF = $('#doc_name').html();
        const clientId = "3cf7a8bfd97c4c02a07d6c775ec06f92";
        const fileID = "3A5E36C8AA950DCDEBFBFE46FFCDE0A6";
        var viewerOptions = {
          embedMode: "FULL_WINDOW",
          defaultViewMode: "FIT_PAGE",
          showDownloadPDF: false,
          showPrintPDF: false,
          showLeftHandPanel: true,
          showAnnotationTools: true,
          enableAnnotationAPIs: true,
          includePDFAnnotations:true,
        };
        const saveOptions = {
            autoSaveFrequency: 0,
            enableFocusPolling: false,
            showSaveButton: true
        }
        const profile = {
          userProfile: {
            name: $("#username").html(),
            firstName: $("#username").html(),
            lastName: '',
            email: $("#useremail").html()
          }
        };
        
        var annotationManagerConfig = {
          showToolbar: true,
          showCommentsPanel: true,
          downloadWithAnnotations: false,
          printWithAnnotations: true
        };
        
        var eventOptions = {
          listenOn: [
            "ANNOTATION_ADDED",
            "ANNOTATION_UPDATED",
            "ANNOTATION_DELETED",
            "ANNOTATION_SELECTED",
            "ANNOTATION_CLICKED"
          ]
        };
        var activeViewer;
        
        document.addEventListener("adobe_dc_view_sdk.ready", function () {
            var adobeDCView = new AdobeDC.View({
                clientId: clientId,
                divId: "embeddedView"
            });
        
            adobeDCView.registerCallback(
              AdobeDC.View.Enum.CallbackType.GET_USER_PROFILE_API,
              function() {
                return new Promise((resolve, reject) => {
                  resolve({
                    code: AdobeDC.View.Enum.ApiResponseCode.SUCCESS,
                    data: profile
                });
              });
              }
            );
        
            adobeDCView.registerCallback(
                AdobeDC.View.Enum.CallbackType.SAVE_API, 
            
                function (metaData, content, options) {
                    var uint8Array = new Uint8Array(content);
                    var blob = new Blob([uint8Array], { type: 'application/pdf' });
               
                    formData = new FormData();
                    var pdfFilename = urlToPDF.split("/").slice(-1)[0];
                    var pdfFilename = pdfFilename.split(".")[0] + "-" + uuidv4() + ".pdf";
                    formData.append('document', blob, pdfFilename);
                    formData.append('vendormsaid', $("#vendormsaid").html());
                    formData.append('document_old', $('#document_old').html());
                    console.log(formData);
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });
                    $.ajax({
                        url:"{{url('/vendor/save-workflow/vendor-msa')}}",
                        contentType: false,
                        processData: false,
                        data: formData,
                        type: 'POST',
            
                        success: function(response)
                        {    
                            alert("done");
                        },
            
                    });
            
                    return new Promise((resolve, reject) => {
                        resolve({
                            code: AdobeDC.View.Enum.ApiResponseCode.SUCCESS,
                            data: {
                                metaData: { fileName: urlToPDF.split("/").slice(-1)[0], id:fileID }
                            }
                        });
                    });
                },
                saveOptions
            );
        
            previewPDF(adobeDCView, urlToPDF, fileID, "embeddedView");
          
        
        });
        
        // Helper Functions:
        
            function previewPDF(view, urlToPDF, fileID, side) {
              fetch(urlToPDF)
                .then((res) => res.blob())
                .then((blob) => {
                  view
                    .previewFile(
                      {
                        // The file content
                        content: { promise: Promise.resolve(blob.arrayBuffer()) },
                        metaData: {
                          fileName: urlToPDF.split("/").slice(-1)[0],
                          id: fileID
                        }
                      },
                      viewerOptions
                    )
                    .then((view) => {
                      view.getAnnotationManager().then((annotationManager) => {
                        annotationManager.setConfig(annotationManagerConfig);

                        if (side == "embeddedView") {
                          embeddedViewAnnotationManager = annotationManager;
                          embeddedViewAnnotationManager.registerEventListener(function (event) {
                            processEvent(event, "embeddedView");
                          }, eventOptions);
                        }
                        
                      });
                    });
                });
            }
            
            function processEvent(event, side) {
              var eventAnnotationManager;
              var activeUser;
              if (side == "embeddedView") {
                eventAnnotationManager = embeddedViewAnnotationManager;
                targetAnnotationManager = embeddedViewAnnotationManager;
                activeUserName = profile.userProfile.name;
              }
             
              if (event.data.creator.name != activeUserName) { 
                eventAnnotationManager.unselectAnnotation();
                // alert(event.type);
                if(event.type === "ANNOTATION_UPDATED"){
                    console.log(event);
                    alert("updated");
                }
                
                if(event.type === "ANNOTATION_DELETED"){
                    alert("deleted");
                }
                
              } else {
                if (activeViewer == side) {
                  if (event.type == "ANNOTATION_ADDED") {
                    console.log(event);
                  } else if (event.type == "ANNOTATION_DELETED") {
                   
                  } else if (event.type == "ANNOTATION_UPDATED") {
                   
                  }
                }
              }
            }
            
            document.getElementById("embeddedView").addEventListener("mouseover", function () {
                setActive(this);
            });
            document.getElementById("embeddedView").addEventListener("mouseout", function () {
                setPassive(this);
            });
      
            function setActive(div) {
              activeViewer = div.id;
              div.classList.add("active");
              div.classList.remove("passive");
            }
            
            function setPassive(div) {
              div.classList.add("passive");
              div.classList.remove("active");
            }
            
            function uuidv4() {
                return 'xxxxxxxx-xxxx-4xxx-yxxx-xxxxxxxxxxxx'.replace(/[xy]/g, function (c) {
                    var r = Math.random() * 16 | 0, v = c == 'x' ? r : (r & 0x3 | 0x8);
                    return v.toString(16);
                });
            }
            
            
            // Add arrayBuffer if necessary i.e. Safari
            (function () {
              if (Blob.arrayBuffer != "function") {
                Blob.prototype.arrayBuffer = myArrayBuffer;
              }
            
              function myArrayBuffer() {
                return new Promise((resolve) => {
                  let fileReader = new FileReader();
                  fileReader.onload = () => {
                    resolve(fileReader.result);
                  };
                  fileReader.readAsArrayBuffer(this);
                });
              }
            })();
            
            function fetchPDF(urlToPDF) { 
                return new Promise((resolve) => {
                    fetch(urlToPDF)
                        .then((resolve) => resolve.blob())
                        .then((blob) => {
                            resolve(blob.arrayBuffer());
                        })
                })
            }
        
    </script>


@endsection