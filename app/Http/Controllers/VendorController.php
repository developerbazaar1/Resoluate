<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Crypt;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Company;
use App\Models\Vendor_msa;
use App\Models\Owner_msa;
use App\Models\Project_contract_vendor;
use App\Models\Project_contract_owner;
use App\Models\Template;
use App\Models\Contract_type;
use App\Models\Nda;
use App\Models\Msa_type;
use App\Models\Other_contract;
use Auth;
use URL; 
use Illuminate\Support\Facades\Mail;

class VendorController extends Controller
{
    public function index()
    {
        $date = today()->format('Y-m-d');

       
        $loginuser_id = Auth::user()->id;
        $loginuser_email = Auth::user()->email;
        
        // active contract 
        
        $owner_msas = Owner_msa::where('vendor_id', $loginuser_id )->where('end_date', '>=', $date)->orderBy('id','DESC')->get();
        $vendor_msas = Vendor_msa::where('vendor_id', $loginuser_id )->where('expired_date', '>=', $date)->orderBy('id','DESC')->get();
        $project_contract_owners = Project_contract_owner::where('vendor_id', $loginuser_id )->where('end_date', '>=', $date)->orderBy('id','DESC')->get();
        $project_contract_vendors = Project_contract_vendor::whereRaw('FIND_IN_SET(?, vendor_id)', [$loginuser_email])->where('end_date', '>=', $date)->orderBy('id','DESC')->get();
          
         $active_owner_msa = count($owner_msas);
         $active_vendor_msa = count($vendor_msas);
         $active_project_contract_owners = count($project_contract_owners);
         $active_project_contract_vendors = count($project_contract_vendors);
        
        
        //  declined contract count
        $owner_msas_declined = Owner_msa::where('vendor_id', $loginuser_id )->where('status', 'declined')->orderBy('id','DESC')->get();
        $vendor_msas_declined = Vendor_msa::where('vendor_id', $loginuser_id )->where('status', 'declined')->orderBy('id','DESC')->get();
        $project_contract_owners_declined = Project_contract_owner::where('vendor_id', $loginuser_id )->where('status', 'declined')->orderBy('id','DESC')->get();
        $project_contract_vendors_declined = Project_contract_vendor::whereRaw('FIND_IN_SET(?, vendor_id)', [$loginuser_email])->where('status', 'declined')->orderBy('id','DESC')->get();
        
         $total_declined = count($owner_msas_declined) + count($vendor_msas_declined) + count($project_contract_owners_declined) + count($project_contract_vendors_declined);
      
       //  workflow contract count
        $owner_msas_workflow = Owner_msa::where('vendor_id', $loginuser_id )->where('status', 'workflow')->orderBy('id','DESC')->get();
        $vendor_msas_workflow = Vendor_msa::where('vendor_id', $loginuser_id )->where('status', 'workflow')->orderBy('id','DESC')->get();
        $project_contract_owners_workflow = Project_contract_owner::where('vendor_id', $loginuser_id )->where('status', 'workflow')->orderBy('id','DESC')->get();
        $project_contract_vendors_workflow = Project_contract_vendor::whereRaw('FIND_IN_SET(?, vendor_id)', [$loginuser_email])->where('vendor_id', $loginuser_id )->where('status', 'workflow')->orderBy('id','DESC')->get();
        
         $total_workflow = count($owner_msas_workflow) + count($vendor_msas_workflow) + count($project_contract_owners_workflow) + count($project_contract_vendors_workflow);
      
      //  negotiation contract count
        $owner_msas_negotiation = Owner_msa::where('vendor_id', $loginuser_id )->where('status', 'negotiation')->orderBy('id','DESC')->get();
        $vendor_msas_negotiation = Vendor_msa::where('vendor_id', $loginuser_id )->where('status', 'negotiation')->orderBy('id','DESC')->get();
        $project_contract_owners_negotiation = Project_contract_owner::where('vendor_id', $loginuser_id )->where('status', 'negotiation')->orderBy('id','DESC')->get();
        $project_contract_vendors_negotiation = Project_contract_vendor::whereRaw('FIND_IN_SET(?, vendor_id)', [$loginuser_email])->where('status', 'negotiation')->orderBy('id','DESC')->get();
        
         $total_negotiation = count($owner_msas_negotiation) + count($vendor_msas_negotiation) + count($project_contract_owners_negotiation) + count($project_contract_vendors_negotiation);
      
    
      
      //  completed contract count
        $owner_msas_completed = Owner_msa::where('vendor_id', $loginuser_id )->where('status', 'completed')->orderBy('id','DESC')->get();
        $vendor_msas_completed = Vendor_msa::where('vendor_id', $loginuser_id )->where('status', 'completed')->orderBy('id','DESC')->get();
        $project_contract_owners_completed = Project_contract_owner::where('vendor_id', $loginuser_id )->where('status', 'completed')->orderBy('id','DESC')->get();
        $project_contract_vendors_completed = Project_contract_vendor::whereRaw('FIND_IN_SET(?, vendor_id)', [$loginuser_email])->where('status', 'completed')->orderBy('id','DESC')->get();
        
         $total_completed = count($owner_msas_completed) + count($vendor_msas_completed) + count($project_contract_owners_completed) + count($project_contract_vendors_completed);
      

  
        return view('vendor/dashboard', compact('active_owner_msa', 'active_vendor_msa', 'active_project_contract_owners', 'active_project_contract_vendors', 'total_declined', 'total_workflow', 'total_negotiation', 'total_completed'));
       
    }
    
     public function edit_profile($id)
    {
        $userid = Crypt::decrypt($id);
        $user = User::where('id',$userid)->first();
        return view('vendor/edit_profile', compact('user'));
    }

    public function update_profile(Request $request)
    {

        if($request->file('document')){
             $image = $request->file('document'); 
            if($image->isValid()){
                if(!empty($request->input('document_old'))){
                    if(file_exists(public_path('/').'/'.$request->input('document_old'))){
                        unlink(public_path('/').'/'.$request->input('document_old')); 
                    }
                }
                $extension = $image->getClientOriginalExtension();
                $fileName = rand(100,999999).time().'.'.$extension;
                $image_path = public_path('upload/user_profile');
                $request->document->move($image_path, $fileName);
                $formInput['document'] = 'upload/user_profile/'.$fileName;
            }
            unset($formInput['document_old']);
        }else{
            $formInput['document'] = $request->input('document_old');
        }
        
       
        
         $validated = $request->validate([
            'name' => 'required|string|max:255',
            'job_title' => 'required|max:255',
            'phone' => 'required|max:15',
        ]);
        
        
        if(!empty($request->input('password'))){
            $password = bcrypt($request->input('password'));
        }else{
            $password = $request->input('password_old');
        }
        
        $data = array(
            "name"=>$request->input('name'),
            "job_title"=>$request->input('job_title'),
            "phone"=>$request->input('phone'),
            "profile_image"=>$formInput['document'],
            "password"=>$password,
        );
        
       
            $userid = $request->input('userid');
            User::where('id',$userid)->update($data);
           
            return redirect()->back()->with('success',"Profile updated successfully!");
            
           
    }
    
    public function all_contracts()
    {
        if(!empty(request()->tabName)){
            $tabName = request()->tabName;
        }else{
            $tabName = '';
        }
        $vendor_id = Auth::user()->id;
        // $company_id = Auth::user()->company_id;
        $owner_msas = Owner_msa::where('vendor_id', $vendor_id )->orderBy('id','DESC')->get();
        $vendor_msas = Vendor_msa::where('vendor_id', $vendor_id )->where('status', '!=' ,'workflow')->orderBy('id','DESC')->get();
        $project_contract_owners = Project_contract_owner::where('vendor_id', $vendor_id )->orderBy('id','DESC')->get();
        $project_contract_vendors = Project_contract_vendor::where('vendor_id', $vendor_id )->orderBy('id','DESC')->get();
        $ndas = Nda::where('vendor_id', $vendor_id )->orderBy('id','DESC')->get();
        $other_contracts = Other_contract::where('vendor_id', $vendor_id )->orderBy('id','DESC')->get();
        return view('vendor/contracts/all_contracts', compact('owner_msas', 'vendor_msas', 'project_contract_owners', 'project_contract_vendors', 'ndas', 'other_contracts', 'tabName'));
    }

      // workflow
    
    public function owner_msa_start_workflow($ownermsaid)
    {
        $id = Crypt::decrypt($ownermsaid);
        $owner_msa = Owner_msa::where('id', $id )->first();

        if(!empty($owner_msa->documentId)){
            if($owner_msa->status == 'sign-request-sent'){
              
                if(!empty($owner_msa->signLink)){
                    $signLink = $owner_msa->signLink; 
                }else{
                   // get sign url from bold sign

                    $documentId = $owner_msa->documentId;
                    $sendUrl = $owner_msa->sendUrl;
                    $owner_email = $owner_msa->owner_email;

                    $curl = curl_init();

                    $appurl = URL::to('/');
                    $red_url = $appurl.'/vendor/update-and-check-document-status/'.$ownermsaid;

                    curl_setopt_array($curl, array(
                      CURLOPT_URL => 'https://api.boldsign.com/v1/document/getEmbeddedSignLink?documentId='.$documentId.'&signerEmail='.$owner_email.'&redirectUrl='.$red_url,
                      CURLOPT_RETURNTRANSFER => true,
                      CURLOPT_ENCODING => '',
                      CURLOPT_MAXREDIRS => 10,
                      CURLOPT_TIMEOUT => 0,
                      CURLOPT_FOLLOWLOCATION => true,
                      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                      CURLOPT_CUSTOMREQUEST => 'GET',
                      CURLOPT_HTTPHEADER => array(
                        'X-API-KEY: Yzc2MmY0NzEtMjJiYi00MjJiLThiZmUtMDgwNGU1ZjJjYmE3'
                      ),
                    ));

                    $response = curl_exec($curl);

                    curl_close($curl);
                    // echo $response;
                    $result = json_decode($response, true);   
                       
                    $signLink = $result['signLink']; 
                }

                


            }else if($owner_msa->status == 'completed'){

                $signLink = $owner_msa->signLink;
            }else{
                $signLink = "";
            } 
           
        }else{
            $signLink = "";
        }

        $data1 = array(
                "signLink" => $signLink,
        );

        Owner_msa::where('id',$id)->update($data1);
        
        return view('vendor/contracts/workflow/owner_msa', compact('owner_msa', 'signLink'));
    }
    
    public function owner_msa_save_workflow(Request $request)
    {
        $data = array();
          
          if($request->file('pdfFile')) { 
              
                    $image = $request->file('pdfFile');
                    if($image->isValid()){
                        if(!empty($request->input('document_old'))){
                            if(file_exists(public_path('/').'/'.$request->input('document_old'))){
                                unlink(public_path('/').'/'.$request->input('document_old')); 
                            }
                        }
                     
                          $image = $request->file('pdfFile');
                          $filename = time().'_'.$image->getClientOriginalName();
            
                          // File extension
                          $extension = $image->getClientOriginalExtension();
            
                          // File upload location
                          $location = 'public/upload/contract';
            
                          // Upload file
                          $image->move($location,$filename);
                     
                          // File path
                          $filepath = 'upload/contract/'.$filename;
                          if($filepath){
                               $data1 = array(
                                    "document" => $filepath,
                                    "status" => "workflow",
                                );
                
                            $ownermsaid = $request->input('ownermsaid');
                            Owner_msa::where('id',$ownermsaid)->update($data1);
                          }
                    }
                    unset($formInput['document_old']);
         
               // Response
               $data['success'] = 1;
               $data['message'] = 'Uploaded Successfully!';

          }else{
               // Response
               $data['success'] = 2;
               $data['message'] = 'File not uploaded.'; 
          }
         

        return response()->json($data);
    
   
    }

    public function update_and_check_document_status($ownermsaid)
    {
        $id = Crypt::decrypt($ownermsaid);
        $owner_msa = Owner_msa::where('id', $id )->first();
        $data1 = array(
                "status" => "completed",
        );

        Owner_msa::where('id',$id)->update($data1);
        $vendordetail = User::where('id', $owner_msa->vendor_id )->first();
                    
            // email data
                // $email_data = array(
                //     'name' =>  $vendordetail->name,
                //     'email' => $vendordetail->email,
                  
                // );
                
                // Mail::send('mail.vendor_congo_contract_sign', $email_data, function ($message) use ($email_data) {
                // $message->to($email_data['email'], $email_data['name'])
                // ->subject('Contract signed successfuly')
                // ->from('resolutecontracts@gmail.com', 'Resolute');
                // });
                
        return view('vendor/contracts/workflow/update_and_check_document_status', compact('owner_msa'));
    }




    // vendor msa workflow
     // workflow
    
    public function vendor_msa_start_workflow($vendormsaid)
    {
        $id = Crypt::decrypt($vendormsaid);
        $vendor_msa = Vendor_msa::where('id', $id )->first();

        if(!empty($vendor_msa->documentId)){
            if($vendor_msa->status == 'sign-request-sent'){
              
                if(!empty($vendor_msa->signLink)){
                    $signLink = $vendor_msa->signLink; 
                }else{
                   // get sign url from bold sign

                    $documentId = $vendor_msa->documentId;
                    $sendUrl = $vendor_msa->sendUrl;
                    $vendor_email = $vendor_msa->vendor_email;

                    $curl = curl_init();

                    $appurl = URL::to('/');
                    $red_url = $appurl.'/vendor/update-and-check-document-status-vendormsa/'.$vendormsaid;

                    curl_setopt_array($curl, array(
                      CURLOPT_URL => 'https://api.boldsign.com/v1/document/getEmbeddedSignLink?documentId='.$documentId.'&signerEmail='.$vendor_email.'&redirectUrl='.$red_url,
                      CURLOPT_RETURNTRANSFER => true,
                      CURLOPT_ENCODING => '',
                      CURLOPT_MAXREDIRS => 10,
                      CURLOPT_TIMEOUT => 0,
                      CURLOPT_FOLLOWLOCATION => true,
                      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                      CURLOPT_CUSTOMREQUEST => 'GET',
                      CURLOPT_HTTPHEADER => array(
                        'X-API-KEY: Yzc2MmY0NzEtMjJiYi00MjJiLThiZmUtMDgwNGU1ZjJjYmE3'
                      ),
                    ));

                    $response = curl_exec($curl);

                    curl_close($curl);
                    // echo $response;
                    $result = json_decode($response, true);   
                       
                    $signLink = $result['signLink']; 
                }

                


            }else if($vendor_msa->status == 'completed'){

                $signLink = $vendor_msa->signLink;
            }else{
                $signLink = "";
            } 
           
        }else{
            $signLink = "";
        }

        $data1 = array(
                "signLink" => $signLink,
        );

        Vendor_msa::where('id',$id)->update($data1);
        
        return view('vendor/contracts/workflow/vendor_msa', compact('vendor_msa', 'signLink'));
    }
    
    public function vendor_vendormsa_save_workflow(Request $request)
    {
        $data = array();
          $company_id = Auth::user()->company_id;
          if($request->file('document')) { 
              
                     $image = $request->file('document');
                    if($image->isValid()){
                        if(!empty($request->input('document_old'))){
                            if(file_exists(public_path('/').'/'.$request->input('document_old'))){
                                unlink(public_path('/').'/'.$request->input('document_old')); 
                            }
                        }
                        $extension = $image->getClientOriginalExtension();
                        $fileName = rand(100,999999).time().'.'.$extension;
                        $image_path = public_path('upload/'.$company_id.'/contract/vendor');
                        $request->document->move($image_path, $fileName);
                        $formInput['document'] = 'upload/'.$company_id.'/contract/vendor/'.$fileName;
                    }
                    
                    if($formInput['document']){
                           $data1 = array(
                                "document" => $formInput['document'],
                                "status" => "negotiation",
                            );
            
                        $vendormsaid = $request->input('vendormsaid');
                        Vendor_msa::where('id',$vendormsaid)->update($data1);
                    }
       
         
               // Response
               $data['success'] = 1;
               $data['message'] = 'Uploaded Successfully!';

          }else{
               // Response
               $data['success'] = 2;
               $data['message'] = 'File not uploaded.'; 
          }
         

        return response()->json($data);
    
   
    }

    public function update_and_check_document_status_vendormsa($vendormsaid)
    {
        $id = Crypt::decrypt($vendormsaid);
        $vendor_msa = Vendor_msa::where('id', $id )->first();
        $data1 = array(
                "status" => "completed",
                "executed_date" => date("Y/m/d"),
        );

        Vendor_msa::where('id',$id)->update($data1);

        $vendordetail = User::where('id', $vendor_msa->vendor_id )->first();
                    
            // email data
                // $email_data = array(
                //     'name' =>  $vendordetail->name,
                //     'email' => $vendordetail->email,
                  
                // );
                
                // Mail::send('mail.vendor_congo_contract_sign', $email_data, function ($message) use ($email_data) {
                // $message->to($email_data['email'], $email_data['name'])
                // ->subject('Contract signed successfuly')
                // ->from('resolutecontracts@gmail.com', 'Resolute');
                // });
        return view('vendor/contracts/workflow/update_and_check_document_status', compact('vendor_msa'));
    }
    
    
     // request_signature
     public function vendor_msa_request_negotiation(Request $request)
    {   

        $vendormsaid = $request->input('vendormsaid'); 
        $vendor_msa = Vendor_msa::where('id', $vendormsaid )->first();

        $data1 = array(
                "status" => "negotiation",
        );

        Vendor_msa::where('id',$vendormsaid)->update($data1);
        return view('vendor/contracts/workflow/request_negotiation_vendor_msa', compact('vendor_msa')); 

        
        
        
    }
    
      // sendback to team
     public function vendor_msa_sendback_to_team(Request $request)
    {   

        $vendormsaid = $request->input('vendormsaid'); 
        $vendor_msa = Vendor_msa::where('id', $vendormsaid )->first();

        $data1 = array(
                "status" => "workflow",
        );

        Vendor_msa::where('id',$vendormsaid)->update($data1);
        
        // return view('vendor/contracts/workflow/request_negotiation_vendor_msa', compact('vendor_msa'));
        
        if(!empty(request()->tabName)){
            $tabName = request()->tabName;
        }else{
            $tabName = '';
        }
        $vendor_id = Auth::user()->id;
        // $company_id = Auth::user()->company_id;
        $owner_msas = Owner_msa::where('vendor_id', $vendor_id )->orderBy('id','DESC')->get();
        $vendor_msas = Vendor_msa::where('vendor_id', $vendor_id )->where('status', '!=' ,'workflow')->orderBy('id','DESC')->get();
        $project_contract_owners = Project_contract_owner::where('vendor_id', $vendor_id )->orderBy('id','DESC')->get();
        $project_contract_vendors = Project_contract_vendor::where('vendor_id', $vendor_id )->orderBy('id','DESC')->get();
        $ndas = Nda::where('vendor_id', $vendor_id )->orderBy('id','DESC')->get();
        $other_contracts = Other_contract::where('vendor_id', $vendor_id )->orderBy('id','DESC')->get();
        return view('vendor/contracts/all_contracts', compact('owner_msas', 'vendor_msas', 'project_contract_owners', 'project_contract_vendors', 'ndas', 'other_contracts', 'tabName'));
        
        
        
    }
    
    // project contract owner
         // workflow
    
    public function Project_contract_owner_start_workflow($pcoid)
    {
        $id = Crypt::decrypt($pcoid);
        $project_contract_owner = Project_contract_owner::where('id', $id )->first();

        if(!empty($project_contract_owner->documentId)){
            if($project_contract_owner->status == 'sign-request-sent'){
              
                if(!empty($project_contract_owner->signLink)){
                    $signLink = $project_contract_owner->signLink; 
                }else{
                   // get sign url from bold sign

                    $documentId = $project_contract_owner->documentId;
                    $sendUrl = $project_contract_owner->sendUrl;
                    $client_email = $project_contract_owner->client_email;

                    $curl = curl_init();

                    $appurl = URL::to('/');
                    $red_url = $appurl.'/vendor/update-and-check-document-status-pco/'.$pcoid;

                    curl_setopt_array($curl, array(
                      CURLOPT_URL => 'https://api.boldsign.com/v1/document/getEmbeddedSignLink?documentId='.$documentId.'&signerEmail='.$client_email.'&redirectUrl='.$red_url,
                      CURLOPT_RETURNTRANSFER => true,
                      CURLOPT_ENCODING => '',
                      CURLOPT_MAXREDIRS => 10,
                      CURLOPT_TIMEOUT => 0,
                      CURLOPT_FOLLOWLOCATION => true,
                      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                      CURLOPT_CUSTOMREQUEST => 'GET',
                      CURLOPT_HTTPHEADER => array(
                        'X-API-KEY: Yzc2MmY0NzEtMjJiYi00MjJiLThiZmUtMDgwNGU1ZjJjYmE3'
                      ),
                    ));

                    $response = curl_exec($curl);

                    curl_close($curl);
                    // echo $response;
                    $result = json_decode($response, true);   
                       
                    $signLink = $result['signLink']; 
                }

                


            }else if($project_contract_owner->status == 'completed'){

                $signLink = $project_contract_owner->signLink;
            }else{
                $signLink = "";
            } 
           
        }else{
            $signLink = "";
        }

        $data1 = array(
                "signLink" => $signLink,
        );

        Project_contract_owner::where('id',$id)->update($data1);
        
        return view('vendor/contracts/workflow/project_contract_owner', compact('project_contract_owner', 'signLink'));
    }
    
    public function Project_contract_owner_save_workflow(Request $request)
    {
        $data = array();
          
          if($request->file('pdfFile')) { 
              
                    $image = $request->file('pdfFile');
                    if($image->isValid()){
                        if(!empty($request->input('document_old'))){
                            if(file_exists(public_path('/').'/'.$request->input('document_old'))){
                                unlink(public_path('/').'/'.$request->input('document_old')); 
                            }
                        }
                     
                          $image = $request->file('pdfFile');
                          $filename = time().'_'.$image->getClientOriginalName();
            
                          // File extension
                          $extension = $image->getClientOriginalExtension();
            
                          // File upload location
                          $location = 'public/upload/contract';
            
                          // Upload file
                          $image->move($location,$filename);
                     
                          // File path
                          $filepath = 'upload/contract/'.$filename;
                          if($filepath){
                               $data1 = array(
                                    "document" => $filepath,
                                    "status" => "workflow",
                                );
                
                            $pcoid = $request->input('$pcoid');
                            Project_contract_owner::where('id',$pcoid)->update($data1);
                          }
                    }
                    unset($formInput['document_old']);
         
               // Response
               $data['success'] = 1;
               $data['message'] = 'Uploaded Successfully!';

          }else{
               // Response
               $data['success'] = 2;
               $data['message'] = 'File not uploaded.'; 
          }
         

        return response()->json($data);
    
   
    }

    public function update_and_check_document_status_pco($pcoid)
    {
        $id = Crypt::decrypt($pcoid);
        $project_contract_owner = Project_contract_owner::where('id', $id )->first();
        $data1 = array(
                "status" => "completed",
        );
        
        Project_contract_owner::where('id',$id)->update($data1);
        
        $vendordetail = User::where('id', $project_contract_owner->vendor_id )->first();
                    
            // email data
                // $email_data = array(
                //     'name' =>  $vendordetail->name,
                //     'email' => $vendordetail->email,
                  
                // );
                
                // Mail::send('mail.vendor_congo_contract_sign', $email_data, function ($message) use ($email_data) {
                // $message->to($email_data['email'], $email_data['name'])
                // ->subject('Contract signed successfuly')
                // ->from('resolutecontracts@gmail.com', 'Resolute');
                // });
        
        return view('vendor/contracts/workflow/update_and_check_document_status', compact('project_contract_owner'));
    }
    
    
    
    
     // project contract vendor
         // workflow
    
    public function Project_contract_vendor_start_workflow($pcvid)
    {
        $id = Crypt::decrypt($pcvid);
        $project_contract_vendor = Project_contract_vendor::where('id', $id )->first();

        if(!empty($project_contract_vendor->documentId)){
            if($project_contract_vendor->status == 'sign-request-sent'){
                
                 if(!empty($project_contract_vendor->signLink)){
                    $signLink = $project_contract_vendor->signLink; 
                }else{
                   // get sign url from bold sign

                     $documentId = $project_contract_vendor->documentId;
                     $sendUrl = $project_contract_vendor->sendUrl;
                     $userdetail = User::where('id', $project_contract_vendor->vendor_id )->first(); 
                     $owner_email = $userdetail->email;

                    $curl = curl_init();

                    $appurl = URL::to('/');
                  
                    $red_url = $appurl.'/vendor/update-and-check-document-status-pcv/'.$pcvid;
                    
                    curl_setopt_array($curl, array(
                      CURLOPT_URL => 'https://api.boldsign.com/v1/document/getEmbeddedSignLink?documentId='.$documentId.'&signerEmail='.$owner_email.'&redirectUrl='.$red_url,
                      CURLOPT_RETURNTRANSFER => true,
                      CURLOPT_ENCODING => '',
                      CURLOPT_MAXREDIRS => 10,
                      CURLOPT_TIMEOUT => 0,
                      CURLOPT_FOLLOWLOCATION => true,
                      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                      CURLOPT_CUSTOMREQUEST => 'GET',
                      CURLOPT_HTTPHEADER => array(
                        'X-API-KEY: Yzc2MmY0NzEtMjJiYi00MjJiLThiZmUtMDgwNGU1ZjJjYmE3'
                      ),
                    ));

                    $response = curl_exec($curl);

                    curl_close($curl);
                    // echo $response;
                    $result = json_decode($response, true);   
                      
                    $signLink = $result['signLink']; 
                }
                
                

                


            }else if($project_contract_vendor->status == 'completed'){

                $signLink = $project_contract_vendor->signLink;
            }else{
                $signLink = "";
            } 
           
        }else{
            $signLink = "";
        }

        $data1 = array(
                "signLink" => $signLink,
        );

        Project_contract_vendor::where('id',$id)->update($data1);
        
        return view('vendor/contracts/workflow/project_contract_vendor', compact('project_contract_vendor', 'signLink'));
    }
    
    public function Project_contract_vendor_save_workflow(Request $request)
    {
        $data = array();
          
          if($request->file('pdfFile')) { 
              
                    $image = $request->file('pdfFile');
                    if($image->isValid()){
                        if(!empty($request->input('document_old'))){
                            if(file_exists(public_path('/').'/'.$request->input('document_old'))){
                                unlink(public_path('/').'/'.$request->input('document_old')); 
                            }
                        }
                     
                          $image = $request->file('pdfFile');
                          $filename = time().'_'.$image->getClientOriginalName();
            
                          // File extension
                          $extension = $image->getClientOriginalExtension();
            
                          // File upload location
                          $location = 'public/upload/contract';
            
                          // Upload file
                          $image->move($location,$filename);
                     
                          // File path
                          $filepath = 'upload/contract/'.$filename;
                          if($filepath){
                               $data1 = array(
                                    "document" => $filepath,
                                    "status" => "workflow",
                                );
                
                            $pcvid = $request->input('$pcvid');
                            Project_contract_vendor::where('id',$pcvid)->update($data1);
                          }
                    }
                    unset($formInput['document_old']);
         
               // Response
               $data['success'] = 1;
               $data['message'] = 'Uploaded Successfully!';

          }else{
               // Response
               $data['success'] = 2;
               $data['message'] = 'File not uploaded.'; 
          }
         

        return response()->json($data);
    
   
    }

    public function update_and_check_document_status_pcv($pcvid)
    {
        $id = Crypt::decrypt($pcvid);
        $project_contract_vendor = Project_contract_vendor::where('id', $id )->first();
        $data1 = array(
                "status" => "completed",
        );

        Project_contract_vendor::where('id',$id)->update($data1);
        
        $vendordetail = User::where('id', $project_contract_vendor->vendor_id )->first();
                    
            // email data
                // $email_data = array(
                //     'name' =>  $vendordetail->name,
                //     'email' => $vendordetail->email,
                  
                // );
                
                // Mail::send('mail.vendor_congo_contract_sign', $email_data, function ($message) use ($email_data) {
                // $message->to($email_data['email'], $email_data['name'])
                // ->subject('Contract signed successfuly')
                // ->from('resolutecontracts@gmail.com', 'Resolute');
                // });
                
        return view('vendor/contracts/workflow/update_and_check_document_status', compact('project_contract_vendor'));
    }
    
    
}
