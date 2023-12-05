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

class ContractEditController extends Controller
{
    public function edit_contract(Request $request, $type, $id)
    {  
      // echo $request->input('name');
        $data = array();
            
            
            
              if($request->file('document')) {
                  $idd = Crypt::decrypt($id);
                   
                        
                        if($type == 'vendor-msa'){
                            
                                $vendor_msa = Vendor_msa::where('id', $idd )->first();
                                $document_old = $vendor_msa->document_original;
                                $company_id = $vendor_msa->company_id;
                                $image = $request->file('document');
                                if($image->isValid()){
                                    if(!empty($document_old)){
                                        if(file_exists(public_path('/').'/'.$document_old)){
                                            unlink(public_path('/').'/'.$document_old); 
                                        }
                                    }
                                    $extension = 'pdf';
                                    $fileName = rand(100,999999).time().'.'.$extension;
                                    $image_path = public_path('upload/'.$company_id.'/original');
                                    $request->document->move($image_path, $fileName);
                                    $formInput['document'] = 'upload/'.$company_id.'/original/'.$fileName;
                                }
                                
                                if($formInput['document']){
                                
                                
                                    $data1 = array(
                                        "document_original" => $formInput['document'],
                                    );
                    
                                    Vendor_msa::where('id',$idd)->update($data1);
                                }
                                          
                                unset($formInput['document_old']);
                            
                        }else if($type == 'owner-msa'){
                                
                                $owner_msa = Owner_msa::where('id', $idd )->first();
                                $document_old = $owner_msa->document_original;
                                $company_id = $owner_msa->company_id;
                                $image = $request->file('document');
                                if($image->isValid()){
                                    if(!empty($document_old)){
                                        if(file_exists(public_path('/').'/'.$document_old)){
                                            unlink(public_path('/').'/'.$document_old); 
                                        }
                                    }
                                    $extension = 'pdf';
                                    $fileName = rand(100,999999).time().'.'.$extension;
                                    $image_path = public_path('upload/'.$company_id.'/original');
                                    $request->document->move($image_path, $fileName);
                                    $formInput['document'] = 'upload/'.$company_id.'/original/'.$fileName;
                                }
                                
                                if($formInput['document']){
                                
                                
                                    $data1 = array(
                                        "document_original" => $formInput['document'],
                                    );
                    
                                    Owner_msa::where('id',$idd)->update($data1);
                                }
                                          
                                unset($formInput['document_old']);
                                
                                
                            
                        }else if($type == 'project-contract-owner'){
                            
                                $project_contract_owner = Project_contract_owner::where('id', $idd )->first();
                                $document_old = $project_contract_owner->document_original;
                                $company_id = $project_contract_owner->company_id;
                                $image = $request->file('document');
                                if($image->isValid()){
                                    if(!empty($document_old)){
                                        if(file_exists(public_path('/').'/'.$document_old)){
                                            unlink(public_path('/').'/'.$document_old); 
                                        }
                                    }
                                    $extension = 'pdf';
                                    $fileName = rand(100,999999).time().'.'.$extension;
                                    $image_path = public_path('upload/'.$company_id.'/original');
                                    $request->document->move($image_path, $fileName);
                                    $formInput['document'] = 'upload/'.$company_id.'/original/'.$fileName;
                                }
                                
                                if($formInput['document']){
                                
                                
                                    $data1 = array(
                                        "document_original" => $formInput['document'],
                                    );
                    
                                    Project_contract_owner::where('id',$idd)->update($data1);
                                }
                                          
                                unset($formInput['document_old']);
                                
                                
                            
                        }else if($type == 'project-contract-vendor'){
                                $project_contract_vendor = Project_contract_vendor::where('id', $idd )->first();
                                $document_old = $project_contract_vendor->document_original;
                                $company_id = $project_contract_vendor->company_id;
                                $image = $request->file('document');
                                if($image->isValid()){
                                    if(!empty($document_old)){
                                        if(file_exists(public_path('/').'/'.$document_old)){
                                            unlink(public_path('/').'/'.$document_old); 
                                        }
                                    }
                                    $extension = 'pdf';
                                    $fileName = rand(100,999999).time().'.'.$extension;
                                    $image_path = public_path('upload/'.$company_id.'/original');
                                    $request->document->move($image_path, $fileName);
                                    $formInput['document'] = 'upload/'.$company_id.'/original/'.$fileName;
                                }
                                
                                if($formInput['document']){
                                
                                
                                    $data1 = array(
                                        "document_original" => $formInput['document'],
                                    );
                    
                                    Project_contract_vendor::where('id',$idd)->update($data1);
                                }
                                          
                                unset($formInput['document_old']);
                            
                        }else{
                            
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
    
    
}
 