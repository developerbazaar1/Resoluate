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
use File;
use App\Models\Notification;
use Illuminate\Support\Facades\Mail;

class ContractController extends Controller
{   
    
   

    public function external_contract()
    {

        $company_id = Auth::user()->company_id;
        $users = User::where('userType', 'user' )->where('company_role', 'team' )->where('company_id', $company_id )->orderBy('id','DESC')->get();
       
        $contracts = Contract_type::where('External_show', '1')->get();
        return view('user/contracts/external_contract', compact('users', 'contracts'));
    }

    public function store_external_contract(Request $request)
    {   
        $company_id = Auth::user()->company_id;
       
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
                $image_path = public_path('upload/'.$company_id.'/contract');
                $request->document->move($image_path, $fileName);
                $formInput['document'] = 'upload/'.$company_id.'/contract/'.$fileName;
            }
            unset($formInput['document_old']);
        }else{
            $formInput['document'] = $request->input('document_old');
        }

        $validated = $request->validate([
            'name' => 'required|max:255',
            'email' => 'required|email|max:255',
            // 'contact' => 'required',
            'contract_type' => 'required',
            // 'address' => 'required',
            // 'obligations' => 'required',
            // 'team' =>'required',
        ]); 
        
        $contract_type = $request->input('contract_type');

        $date = strtotime("+7 day");
        $due_date = date('Y-m-d', $date);
        $expired_date = date($due_date, strtotime('+2 years'));

        if($request->input('team')){
            $companyadmin_id = User::where('userType', 'user' )->where('company_role', 'company-admin' )->where('company_id', $company_id )->pluck('id')->toArray();

            $team_array = $request->input('team'); 

            foreach($companyadmin_id as $com){
                array_push($team_array, $com);
            } 
            $team_list = implode(',', $team_array);
        }else{
            $team_list = '';
        }
       

        if($contract_type = 1){
            // owner msa
            $data = array(
                "owner_name"=>$request->input('name'),
                "owner_email"=>$request->input('email'),
                "owner_contact"=>$request->input('contact'),
                "address"=>$request->input('address'),
                "obligation" => $request->input('obligations'),
                "team" => $team_list,
                "document" => $formInput['document'],
                "status" => "start",
                // "vendor_id" => $request->input('vendor'),
                "company_id" => $company_id,
                "insert_user_id" => Auth::user()->id,
            );

            $id = Owner_msa::create($data)->id; 

        }else if($contract_type = 2){
             // vendor msa/psa
             $data = array(
                "vendor_name"=>$request->input('name'),
                "vendor_email"=>$request->input('email'),
                "vendor_contact"=>$request->input('contact'),
                "address"=>$request->input('address'),
                "obligation" => $request->input('obligations'),
                "team" => $team_list,
                "document" => $formInput['document'],
                "status" => "start",
                "due_date" => $due_date,
                "expired_date" => $expired_date,
                // "vendor_id" => $request->input('vendor'),
                "company_id" => Auth::user()->company_id,
                "insert_user_id" => Auth::user()->id,
            );

            $id = Vendor_msa::create($data)->id; 

        }else if($contract_type = 3){
             // project contract owner 
            $data = array(
                "client_name"=>$request->input('name'),
                "client_email"=>$request->input('email'),
                "client_contact"=>$request->input('contact'),
                "address"=>$request->input('address'),
                "obligation" => $request->input('obligations'),
                "team" => $team_list,
                "document" => $formInput['document'],
                "status" => "start",
                "project_name"=>"external-".$request->input('name'),
                // "vendor_id" => $request->input('vendor'),
                "company_id" => Auth::user()->company_id,
                "insert_user_id" => Auth::user()->id,
            );

            $id = Project_contract_owner::create($data)->id; 

        }else if($contract_type = 4){
            // project contract vendor 
            $data = array(
                "vendor_name"=>$request->input('name'),
                "vendor_email"=>$request->input('email'),
                "vendor_contact"=>$request->input('contact'),
                "project_name"=>"external-".$request->input('name'),
                "address"=>$request->input('address'),
                "obligation" => $request->input('obligations'),
                "team" => $team_list,
                "document" => $formInput['document'],
                "status" => "start",
                // "vendor_id" => $request->input('vendor'),
                "company_id" => Auth::user()->company_id,
                "insert_user_id" => Auth::user()->id,
            );

            $id = Project_contract_vendor::create($data)->id; 

        }else if($contract_type = 5){
            // nda 
            $data = array(
                "name"=>$request->input('name'),
                "email"=>$request->input('email'),
                "contact"=>$request->input('contact'),
                "address"=>$request->input('address'),
                "obligation" => $request->input('obligations'),
                "team" => $team_list,
                "document" => $formInput['document'],
                "status" => "start",
                // "vendor_id" => $request->input('vendor'),
                "company_id" => Auth::user()->company_id,
                "insert_user_id" => Auth::user()->id,
            );

            $id = Nda::create($data)->id; 
        }else{
            // others
             $data = array(
                "name"=>$request->input('name'),
                "email"=>$request->input('email'),
                "contact"=>$request->input('contact'),
                "address"=>$request->input('address'),
                "obligation" => $request->input('obligations'),
                "team" => $team_list,
                "document" => $formInput['document'],
                "status" => "start",
                // "vendor_id" => $request->input('vendor'),
                "company_id" => Auth::user()->company_id,
                "insert_user_id" => Auth::user()->id,
            );

            $id = Other_contract::create($data)->id; 
        }


       
       
        if($id){
            return redirect()->back()->with('success',"External contract added successfully!");
        }else{
            return redirect()->back()->with('error',"External contract not added, please try again!");
        }
    
    }

    public function all_contracts()
    {
        if(!empty(request()->tabName)){
            $tabName = request()->tabName;
        }else{
            $tabName = '';
        }
        $company_id = Auth::user()->company_id;
        $loginuser_id = Auth::user()->id;
     
        $owner_msas = Owner_msa::where('company_id', $company_id )->whereRaw('FIND_IN_SET(?, team)', [$loginuser_id])->orderBy('id','DESC')->get();
     
       
        $vendor_msas = Vendor_msa::where('company_id', $company_id )->where('team_member', $loginuser_id )->orWhere('company_admin_id', $loginuser_id )->orderBy('id','DESC')->get();
        $project_contract_owners = Project_contract_owner::where('company_id', $company_id )->whereRaw('FIND_IN_SET(?, team)', [$loginuser_id])->orderBy('id','DESC')->get();
        $project_contract_vendors = Project_contract_vendor::where('company_id', $company_id )->whereRaw('FIND_IN_SET(?, team)', [$loginuser_id])->orderBy('id','DESC')->get();
        $ndas = Nda::where('company_id', $company_id )->orderBy('id','DESC')->get();
        $other_contracts = Other_contract::where('company_id', $company_id )->orderBy('id','DESC')->get();
        return view('user/contracts/all_contracts', compact('owner_msas', 'vendor_msas', 'project_contract_owners', 'project_contract_vendors', 'ndas', 'other_contracts', 'tabName'));
    }

    public function create_owner_msa()
    {
        $company_id = Auth::user()->company_id;
        $users = User::where('userType', 'user' )->where('company_role', 'team' )->where('company_id', $company_id )->orderBy('id','DESC')->get();
        $owner_msa_names = Owner_msa::where('company_id', $company_id )->pluck('owner_name')->toArray();
        return view('user/contracts/create_owner_msa', compact('owner_msa_names', 'users'));
    }

    public function store_owner_msa(Request $request)
    {  

        $company_id = Auth::user()->company_id;
        

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
                $image_path = public_path('upload/'.$company_id.'/contract');
                $request->document->move($image_path, $fileName);
                $formInput['document'] = 'upload/'.$company_id.'/contract/'.$fileName;
            }
            unset($formInput['document_old']);
        }else{
            $formInput['document'] = $request->input('document_old');
        }
        
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255',
            'team' => 'required',
            'start_date' => 'required',
            'end_date' => 'required',
        ]);
        
        if($image_path){
            $extension1 = "pdf";
            $fileName1 = rand(100,999999).time().'.'.$extension1;
            $image_path1 = 'upload/'.$company_id.'/original/'.$fileName1;
            File::copy(public_path($formInput['document']), public_path($image_path1));
        }
        
        if($request->input('team')){

            $companyadmin_id = User::where('userType', 'user' )->where('company_role', 'company-admin' )->where('company_id', $company_id )->pluck('id')->toArray();

            $team_array = $request->input('team'); 

            foreach($companyadmin_id as $com){
                array_push($team_array, $com);
            }

            $team_list = implode(',', $team_array);
        }else{
            $team_list = '';
        }
        
        $data = array(
            "owner_name"=>$request->input('name'),
            "owner_email"=>$request->input('email'),
            "team"=>$team_list,
            "document" => $formInput['document'],
            "document_original" => $image_path1,
            "status" => "start",
            "company_id" => Auth::user()->company_id,
            "start_date" => $request->input('start_date'),
            "end_date" => $request->input('end_date'),
            "insert_user_id" => Auth::user()->id,
        );

        $id = Owner_msa::create($data)->id;
       
        if($id){
            
            foreach($team_array as $ta){
                $datanot = array(
                    "user_id"=>$ta,
                    "sender_id"=>Auth::user()->id,
                    "message"=> 'New owner msa created and you are added in team of workflow',
                    "url"=>"user-all-contracts",
                    "status"=>'unseen',
                    
                );
                
                Notification::create($datanot)->id;
            }
            
            
                
            return redirect()->back()->with('success',"Owner Msa added successfully!");
        }else{
            return redirect()->back()->with('error',"Owner Msa not added, please try again!");
        }
    
    }

     public function create_vendor_msa()
    {
        $company_id = Auth::user()->company_id;
        $vendors = User::where('userType', 'vendor' )->where('company_id', $company_id )->orderBy('id','DESC')->get();
        $users = User::where('userType', 'user' )->where('company_role', 'team' )->where('company_id', $company_id )->orderBy('id','DESC')->get();
        $templates = Template::where('company_id', $company_id )->where('type', 'msa_psa' )->get();
        $msa_types = Msa_type::all();
        $vendor_msa_names = Vendor_msa::where('company_id', $company_id )->pluck('vendor_name')->toArray();
        return view('user/contracts/create_vendor_msa', compact('vendor_msa_names', 'vendors', 'msa_types', 'templates','users'));
    }

    public function store_vendor_msa(Request $request)
    {  
        $team_step1 = $request->input('team_step'); 
        $team_step = explode(",",$team_step1);

        $a =array();
        $team_member = '';
        $flow_teamno = '';
     
        foreach($team_step as $ts){ 
           
            $lastvar =  substr($ts,9); 
            $team = $request->input('team'.$lastvar);   
            $teamnumm = $team.'_'.$lastvar;  
            if($teamnumm == $team.'_1' ){
                $team_member = $team;
                $flow_teamno = 1;
              
            }
            array_push($a,$teamnumm);       
        }
        $arr = implode(" ", $a);

        $date = strtotime("+7 day");
        $due_date = date('Y-m-d', $date);
        $expired_date = date('Y-m-d', strtotime('+2 years', strtotime($due_date)));
        // date($due_date, strtotime('+2 years'));

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255',
            'contact' => 'required',
            'template_id' => 'required',
            'type_msa_psa' => 'required',
        ]);

     
        $template = Template::where('id', $request->input('template_id'))->first();
        $company_id = Auth::user()->company_id;
        $company_admin_user = User::where('company_role', 'company-admin' )->where('company_id', $company_id )->first();

        $company_admin_id = $company_admin_user->id; 

        $extension = "pdf";
        $fileName = rand(100,999999).time().'.'.$extension;
        $image_path = 'upload/'.$company_id.'/contract/vendor/'.$fileName;
        File::copy(public_path($template->document), public_path($image_path));
        
        if($image_path){
            $extension1 = "pdf";
            $fileName1 = rand(100,999999).time().'.'.$extension1;
            $image_path1 = 'upload/'.$company_id.'/original/'.$fileName1;
            File::copy(public_path($template->document), public_path($image_path1));
        }
        
        $data = array(
            "vendor_name"=>$request->input('name'),
            "vendor_email"=>$request->input('email'),
            "vendor_contact"=>$request->input('contact'),
            "address"=>$request->input('address'),
            // "vendor_id"=>$request->input('vendor'),
            "team"=>$arr,
            "type_msa_psa"=>$request->input('type_msa_psa'),
            "template_id"=>$request->input('template_id'),
            "status" => "start",
            "company_id" => Auth::user()->company_id,
            "due_date" => $due_date,
            "expired_date" => $expired_date,
            "insert_user_id" => Auth::user()->id,
            "document" => $image_path,
            "document_original" => $image_path1,
            "team_member" => $team_member,
            "flow_teamno" => $flow_teamno,
            "company_admin_id" => $company_admin_id,
            
        );

        $id = Vendor_msa::create($data)->id;
       
        if($id){
            
            
                $datanot = array(
                    "user_id"=>$team_member,
                    "sender_id"=>Auth::user()->id,
                    "message"=> 'New vendor msa created and you are added in team of workflow',
                    "url"=>"user-all-contracts-vendor-msa",
                    "status"=>'unseen',
                    
                );
                
                Notification::create($datanot)->id;
            
            
            return redirect()->back()->with('success',"Vendor Msa added successfully!");
        }else{
            return redirect()->back()->with('error',"Vendor Msa not added, please try again!");
        }
    
    }


       public function create_project_contract_owner()
    {
        $company_id = Auth::user()->company_id;
        $vendors = User::where('userType', 'vendor' )->where('company_id', $company_id )->orderBy('id','DESC')->get();
        $users = User::where('userType', 'user' )->where('company_role', 'team' )->where('company_id', $company_id )->orderBy('id','DESC')->get();
     
       
        $client_names = Owner_msa::where('company_id', $company_id )->pluck('owner_name')->toArray();
        return view('user/contracts/create_project_contract_owner', compact('client_names', 'vendors','users'));
    }

    public function store_project_contract_owner(Request $request)
    { 
        $company_id = Auth::user()->company_id;

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
                $image_path = public_path('upload/'.$company_id.'/contract');
                $request->document->move($image_path, $fileName);
                $formInput['document'] = 'upload/'.$company_id.'/contract/'.$fileName;
            }
            unset($formInput['document_old']);
        }else{
            $formInput['document'] = $request->input('document_old');
        }

        if($request->input('team')){
            $companyadmin_id = User::where('userType', 'user' )->where('company_role', 'company-admin' )->where('company_id', $company_id )->pluck('id')->toArray();

            $team_array = $request->input('team'); 

            foreach($companyadmin_id as $com){
                array_push($team_array, $com);
            }

            $team_list = implode(',', $team_array);
        }else{
            $team_list = '';
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'team' => 'required',
            'client_email' => 'required',
            'project_name' => 'required',
            'project_umbea' => 'required',
            'start_date' => 'required',
            'end_date' => 'required',
        ]);
        
        if($image_path){
            $extension1 = "pdf";
            $fileName1 = rand(100,999999).time().'.'.$extension1;
            $image_path1 = 'upload/'.$company_id.'/original/'.$fileName1;
            File::copy(public_path($formInput['document']), public_path($image_path1));
        }

        $data = array(
            "client_name"=>$request->input('name'),
            "client_email"=>$request->input('client_email'),
            "team" => $team_list,
            "document" => $formInput['document'],
            "document_original" => $image_path1,
            "status" => "start",
            "project_name"=>$request->input('project_name'),
            "project_umbea"=>$request->input('project_umbea'),
            "company_id" => $company_id,
            "does_client_have_msa"=>$request->input('does_client_have_msa'),
            "does_msa_req"=>$request->input('does_msa_req'),
            "start_date"=>$request->input('start_date'),
            "end_date"=>$request->input('end_date'),
            "insert_user_id" => Auth::user()->id,
        );

        $id = Project_contract_owner::create($data)->id; 

       
        if($id){
            
            foreach($team_array as $ta){
                $datanot = array(
                    "user_id"=>$ta,
                    "sender_id"=>Auth::user()->id,
                    "message"=> 'New Project contract owner created and you are added in team of workflow',
                    "url"=>"user-all-contracts-pco",
                    "status"=>'unseen',
                    
                );
                
                Notification::create($datanot)->id;
            }
            
            return redirect()->back()->with('success',"Project contract owner added successfully!");
        }else{
            return redirect()->back()->with('error',"Project contract owner not added, please try again!");
        }
    
    }

         public function create_project_contract_vendor()
    {
        $company_id = Auth::user()->company_id;
        $vendors = User::where('userType', 'vendor' )->where('company_id', $company_id )->orderBy('id','DESC')->get();
        $users = User::where('userType', 'user' )->where('company_role', 'team' )->where('company_id', $company_id )->orderBy('id','DESC')->get();
     
       $templates = Template::where('company_id', $company_id )->where('type', 'project' )->get();
        $vendor_msas = Vendor_msa::where('company_id', $company_id )->get();
         $project_names = Project_contract_owner::where('company_id', $company_id )->pluck('project_name')->toArray();
        return view('user/contracts/create_project_contract_vendor', compact('vendor_msas', 'vendors','users', 'project_names', 'templates'));
    }

    public function store_project_contract_vendor(Request $request)
    { 
        // if($request->file('document')){
        //     $image = $request->file('document');
        //     if($image->isValid()){
        //         if(!empty($request->input('document_old'))){
        //             if(file_exists(public_path('/').'/'.$request->input('document_old'))){
        //                 unlink(public_path('/').'/'.$request->input('document_old')); 
        //             }
        //         }
        //         $extension = $image->getClientOriginalExtension();
        //         $fileName = rand(100,999999).time().'.'.$extension;
        //         $image_path = public_path('upload/contract');
        //         $request->document->move($image_path, $fileName);
        //         $formInput['document'] = 'upload/contract/'.$fileName;
        //     }
        //     unset($formInput['document_old']);
        // }else{
        //     $formInput['document'] = $request->input('document_old');
        // }
        
        $company_id = Auth::user()->company_id;
        if($request->input('team')){
            $companyadmin_id = User::where('userType', 'user' )->where('company_role', 'company-admin' )->where('company_id', $company_id )->pluck('id')->toArray();

            $team_array = $request->input('team'); 

            foreach($companyadmin_id as $com){
                array_push($team_array, $com);
            } 
            $team_list = implode(',', $team_array);
        }else{
            $team_list = '';
        }
        
        $validated = $request->validate([
            'vendor_name' => 'required',
            'email' => 'required|string|email|max:255',
            'contact' => 'required',
            'project_name' => 'required',
            'amount' => 'required',
            'template_id' => 'required',
            'vendor' => 'required',
            'team' => 'required',
        ]);
        
        
         $template = Template::where('id', $request->input('template_id'))->first();
        

        $extension = "pdf";
        $fileName = rand(100,999999).time().'.'.$extension;
        $image_path = 'upload/'.$company_id.'/contract/vendor/'.$fileName;
        File::copy(public_path($template->document), public_path($image_path));
        
        if($image_path){
            $extension1 = "pdf";
            $fileName1 = rand(100,999999).time().'.'.$extension1;
            $image_path1 = 'upload/'.$company_id.'/original/'.$fileName1;
            File::copy(public_path($template->document), public_path($image_path1));
        }
        
        $data = array(
            "vendor_name"=>$request->input('name'),
            "vendor_msa_id"=>$request->input('vendor_name'),
            "vendor_email"=>$request->input('email'),
            "vendor_contact"=>$request->input('contact'),
            "template_id"=>$request->input('template_id'),
            "team" => $team_list,
            "status" => "start",
            "project_name"=>$request->input('project_name'),
            "start_date"=>$request->input('start_date'),
            "end_date"=>$request->input('end_date'),
            "amount"=>$request->input('amount'),
            "vendor_id" => $request->input('vendor'),
            "company_id" => $company_id,
            "insert_user_id" => Auth::user()->id,
            "document" => $image_path,
            "document_original" => $image_path1,
        );

        $id = Project_contract_vendor::create($data)->id; 

       
        if($id){
            
            foreach($team_array as $ta){
                $datanot = array(
                    "user_id"=>$ta,
                    "sender_id"=>Auth::user()->id,
                    "message"=> 'New Project contract Vendor created and you are added in team of workflow',
                    "url"=>"user-all-contracts-pcv",
                    "status"=>'unseen',
                    
                );
                
                Notification::create($datanot)->id;
            }
            
            return redirect()->back()->with('success',"Project contract vendor added successfully!");
        }else{
            return redirect()->back()->with('error',"Project contract vendor not added, please try again!");
        }
    
    }

    public function get_vendor_msa($id)
    {
        $vendor_msa = Vendor_msa::where('id', $id)->first();
        return response()->json($vendor_msa);
       
    }
    
     public function get_project_details($id)
    {
        $Project_contract_owner = Project_contract_owner::where('project_name', $id)->first();
        return response()->json($Project_contract_owner);
       
    }
    
    

    // work flow vendor

    public function vendor_msa_start_workflow($vendormsaid)
    {
        $id = Crypt::decrypt($vendormsaid);
        $company_id = Auth::user()->company_id;
        $vendor_msa = Vendor_msa::where('id', $id )->first();
        $teams = User::where('userType', 'user' )->where('company_role', 'team' )->where('company_id', $company_id )->orderBy('id','DESC')->get();
        
        return view('user/contracts/workflow/vendor_msa', compact('vendor_msa', 'teams'));
    }

    // request_signature
     public function vendor_msa_request_signature(Request $request)
    {   

        $vendormsaid = $request->input('vendormsaid'); 
        $vendor_msa = Vendor_msa::where('id', $vendormsaid )->first();
        $vendor_name = $vendor_msa->vendor_name;
        $vendor_email = $vendor_msa->vendor_email;
        $document  = $vendor_msa->document_original;
        $sendUrl  = $vendor_msa->sendUrl;

        if($sendUrl && ($vendor_msa->status != 'workflow')){ 
            
                $msg = "Request already sent please wait for response";
                return view('user/contracts/workflow/request_signature_vendor_msa', compact('sendUrl', 'msg')); 
            
        }else{


                // chcek vendor has an account
                $vendor = User::where('email', $vendor_email )->pluck('id')->toArray();
                
                if($vendor){
                        $id =  $vendor[0]; 
                }else{
                        $data = array(
                           'name'=>$vendor_name,
                           'email'=>$vendor_email,
                           'userType'=>'vendor',
                           'password'=> bcrypt('123'),
                        );
                 
                        $id = User::create($data)->id; 
                        

                }

                if($id){
                    $data1 = array(
                            "vendor_id" => $id,
                            "status" => "request-for-sign",
                    );

                    Vendor_msa::where('id',$vendormsaid)->update($data1);
                    
                    
                    $vendordetail = User::where('id', $id )->first();
                    
                    // email data
                        // $email_data = array(
                        //     'name' =>  $vendordetail->name,
                        //     'email' => $vendordetail->email,
                          
                        // );
                        
                        // Mail::send('mail.vendor_vmsa_request_sign', $email_data, function ($message) use ($email_data) {
                        // $message->to($email_data['email'], $email_data['name'])
                        // ->subject('Signature request send for vendor msa')
                        // ->from('resolutecontracts@gmail.com', 'Resolute');
                        // });
                    
                }


                $appurl = URL::to('/');
                $vendormsaidcrypt = Crypt::encrypt($vendormsaid); 
                
                $ch = curl_init();

                curl_setopt($ch, CURLOPT_URL, 'https://api.boldsign.com/v1/document/createEmbeddedRequestUrl');
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                curl_setopt($ch, CURLOPT_POST, 1);
                $post = array(
                    'Title' => 'vendor Msa document',
                    'ShowToolbar' => 'true',
                    'ShowNavigationButtons' => 'false',
                    'ShowPreviewButton' => 'true',
                    'ShowSendButton' => 'true',
                    'ShowSaveButton' => 'false',
                    'SendViewOption' => 'PreparePage',
                    'Locale' => 'EN',
                    // 'SendLinkValidTill' => '2023-10-21T06:37:57.424Z',
                    'RedirectUrl' => $appurl.'/user/update-and-check-document-status-vendormsa/'.$vendormsaidcrypt,
                    'Message' => 'This is vendor msa document sent to sign',
                    'EnableSigningOrder' => 'false',
                    'Signers[0][Name]' => $vendor_name,
                    'Signers[0][EmailAddress]' => $vendor_email,
                    'Signers[0][SignerOrder]' => '1',
                    // 'Signers[0][authenticationCode]' => '123',
                    // 'Signers[0][PrivateMessage]' => 'This is private message for signer',
                    'Signers[0][FormFields][0][FieldType]' => 'Signature',
                    'Signers[0][FormFields][0][Id]' => 'Sign',
                    'Signers[0][FormFields][0][PageNumber]' => '1',
                    'Signers[0][FormFields][0][IsRequired]' => 'True',
                    // 'Signers[0][FormFields][0][Bounds][X]' => '50',
                    // 'Signers[0][FormFields][0][Bounds][Y]' => '50',
                    'Signers[0][FormFields][0][Bounds][Width]' => '200',
                    'Signers[0][FormFields][0][Bounds][Height]' => '50',
                    'DisableEmails' => 'true',
                    'Files' => new \CURLFILE(public_path($document),'application/pdf','MyFile'),
                );
                curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
                
                $headers = array();
                $headers[] = 'Accept: application/json';
                $headers[] = 'X-Api-Key: Yzc2MmY0NzEtMjJiYi00MjJiLThiZmUtMDgwNGU1ZjJjYmE3';
                $headers[] = 'Content-Type: multipart/form-data';
                curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
                
                $result = curl_exec($ch); 
                if (curl_errno($ch)) {
                    echo 'Error:' . curl_error($ch);
                }
                curl_close($ch);
                $result = json_decode($result, true);   
           
                $documentId = $result['documentId'];
                $sendUrl = $result['sendUrl'];

                if($documentId){
                    $data2 = array(
                            "documentId" => $documentId,
                            "sendUrl" => $sendUrl,
                    );

                    Vendor_msa::where('id',$vendormsaid)->update($data2);
                }

               return view('user/contracts/workflow/request_signature_vendor_msa', compact('sendUrl')); 
        }
        
        
    }


     public function vendor_msa_sent_next_teammember(Request $request)
    {   
      
        $vendormsaid = $request->input('vendormsaid'); 
        $vendor_msa = Vendor_msa::where('id', $vendormsaid )->first();
        $vendor_team = $vendor_msa->team;
        $vendor_flow_teamno = $vendor_msa->flow_teamno;
        $flow_teamno= (int)$vendor_flow_teamno + 1;
        $ven_team = explode(" ", $vendor_team);
        $team_member = "";
        foreach ($ven_team as $vt) {

            $vv = substr($vt, -1);
            if($vv == $flow_teamno){
                $vv1 = $vv+ 1;
                $team_member = substr($vt,0,-$vv1);
            
            }
        }
        
      
        $data2 = array(
                "team_member" => $team_member,
                "flow_teamno" => $flow_teamno,
                "status" => 'workflow',
        );

        Vendor_msa::where('id',$vendormsaid)->update($data2);

        return view('user/contracts/workflow/request_sent_next_teammember');  
        
    }


    // workflow owner
    
    public function owner_msa_start_workflow($ownermsaid)
    {
        $id = Crypt::decrypt($ownermsaid);
        $company_id = Auth::user()->company_id;
        $owner_msa = Owner_msa::where('id', $id )->first();
        $teams = User::where('userType', 'user' )->where('company_role', 'team' )->where('company_id', $company_id )->orderBy('id','DESC')->get();
        
        return view('user/contracts/workflow/owner_msa', compact('owner_msa', 'teams'));
    }

   
    public function owner_msa_save_workflow(Request $request)
    {  $company_id = Auth::user()->company_id;
       
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
                        $image_path = public_path('upload/'.$company_id.'/contract');
                        $request->document->move($image_path, $fileName);
                        $formInput['document'] = 'upload/'.$company_id.'/contract/'.$fileName;
                    }
                    
                    if($formInput['document']){
                           $data1 = array(
                                "document" => $formInput['document'],
                                "status" => "workflow",
                            );
            
                        $ownermsaid = $request->input('ownermsaid');
                        Owner_msa::where('id',$ownermsaid)->update($data1);
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
    public function owner_msa_save_workflow__(Request $request)
    { dd($request->all()); die;
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
    
    // request_signature
     public function owner_msa_request_signature(Request $request)
    {   

        $ownermsaid = $request->input('ownermsaid'); 
        $owner_msa = Owner_msa::where('id', $ownermsaid )->first();
        $owner_name = $owner_msa->owner_name;
        $owner_email = $owner_msa->owner_email;
        $document  = $owner_msa->document_original;
        $sendUrl  = $owner_msa->sendUrl;

        if($sendUrl){ 
            $msg = "Request already sent please wait for response";
            return view('user/contracts/workflow/request_signature_owner_msa', compact('sendUrl', 'msg')); 

        }else{


                // chcek vendor has an account
                $vendor = User::where('email', $owner_email )->pluck('id')->toArray();
                
                if($vendor){
                        $id =  $vendor[0]; 
                }else{
                        $data = array(
                           'name'=>$owner_name,
                           'email'=>$owner_email,
                           'userType'=>'vendor',
                           'password'=> bcrypt('123'),
                        );
                 
                        $id = User::create($data)->id; 
                        

                }

                if($id){
                    $data1 = array(
                            "vendor_id" => $id,
                            "status" => "request-for-sign",
                    );

                    Owner_msa::where('id',$ownermsaid)->update($data1);
                }


                $appurl = URL::to('/');
                $ownermsaidcrypt = Crypt::encrypt($ownermsaid); 
                
                $ch = curl_init();

                curl_setopt($ch, CURLOPT_URL, 'https://api.boldsign.com/v1/document/createEmbeddedRequestUrl');
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                curl_setopt($ch, CURLOPT_POST, 1);
                $post = array(
                    'Title' => 'Owner Msa document',
                    'ShowToolbar' => 'true',
                    'ShowNavigationButtons' => 'false',
                    'ShowPreviewButton' => 'true',
                    'ShowSendButton' => 'true',
                    'ShowSaveButton' => 'false',
                    'SendViewOption' => 'PreparePage',
                    'Locale' => 'EN',
                    // 'SendLinkValidTill' => '2023-10-21T06:37:57.424Z',
                    'RedirectUrl' => $appurl.'/user/update-and-check-document-status/'.$ownermsaidcrypt,
                    'Message' => 'This is Owner msa document sent to sign',
                    'EnableSigningOrder' => 'false',
                    'Signers[0][Name]' => $owner_name,
                    'Signers[0][EmailAddress]' => $owner_email,
                    'Signers[0][SignerOrder]' => '1',
                    // 'Signers[0][authenticationCode]' => '123',
                    // 'Signers[0][PrivateMessage]' => 'This is private message for signer',
                    'Signers[0][FormFields][0][FieldType]' => 'Signature',
                    'Signers[0][FormFields][0][Id]' => 'Sign',
                    'Signers[0][FormFields][0][PageNumber]' => '1',
                    'Signers[0][FormFields][0][IsRequired]' => 'True',
                    // 'Signers[0][FormFields][0][Bounds][X]' => '50',
                    // 'Signers[0][FormFields][0][Bounds][Y]' => '50',
                    'Signers[0][FormFields][0][Bounds][Width]' => '200',
                    'Signers[0][FormFields][0][Bounds][Height]' => '50',
                    'DisableEmails' => 'true',
                    'Files' => new \CURLFILE(public_path($document),'application/pdf','MyFile'),
                );
                curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
                
                $headers = array();
                $headers[] = 'Accept: application/json';
                $headers[] = 'X-Api-Key: Yzc2MmY0NzEtMjJiYi00MjJiLThiZmUtMDgwNGU1ZjJjYmE3';
                $headers[] = 'Content-Type: multipart/form-data';
                curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
                
                $result = curl_exec($ch); 
                if (curl_errno($ch)) {
                    echo 'Error:' . curl_error($ch);
                }
                curl_close($ch);
                $result = json_decode($result, true);   
           
                $documentId = $result['documentId'];
                $sendUrl = $result['sendUrl'];

                if($documentId){
                    $data2 = array(
                            "documentId" => $documentId,
                            "sendUrl" => $sendUrl,
                    );

                    Owner_msa::where('id',$ownermsaid)->update($data2);
                }

               return view('user/contracts/workflow/request_signature_owner_msa', compact('sendUrl')); 
        }
        
        
    }


    
    public function update_and_check_document_status($ownermsaid)
    {
        $id = Crypt::decrypt($ownermsaid);
        $owner_msa = Owner_msa::where('id', $id )->first();
        $data1 = array(
                "status" => "sign-request-sent",
        );

        Owner_msa::where('id',$id)->update($data1); 
        
        $datanot = array(
            "user_id"=>$owner_msa->vendor_id, 
            "sender_id"=>$owner_msa->insert_user_id,
            "message"=> 'New sign request, please review the contract and sign it',
            "url"=>"sign-request-sent",
            "status"=>'unseen',
            
        );
        
        Notification::create($datanot)->id;
                
echo "Request sent please wait for response";
        die;
        return view('user/contracts/workflow/update_and_check_document_status');
    }

    public function update_and_check_document_status_vendormsa($vendormsaid)
    {
        $id = Crypt::decrypt($vendormsaid);
        $vendor_msa = Vendor_msa::where('id', $id )->first();
        $data1 = array(
                "status" => "sign-request-sent",
        );

        Vendor_msa::where('id',$id)->update($data1); 
        
        $datanot = array(
            "user_id"=>$vendor_msa->vendor_id,
            "sender_id"=>$vendor_msa->insert_user_id,
            "message"=> 'New sign request, please review the contract and sign it',
            "url"=>"sign-request-sent",
            "status"=>'unseen',
            
        );
        
        Notification::create($datanot)->id;
        
        echo "Request sent please wait for response";
        die;
        return view('user/contracts/workflow/update_and_check_document_status');
    }
    
    public function update_and_check_document_status_pco($pcoid)
    {
        $id = Crypt::decrypt($pcoid);
        $project_contract_owner = Project_contract_owner::where('id', $id )->first();
        $data1 = array(
                "status" => "sign-request-sent",
        );

        Project_contract_owner::where('id',$id)->update($data1); 
        $datanot = array(
            "user_id"=>$project_contract_owner->vendor_id,
            "sender_id"=>$project_contract_owner->insert_user_id,
            "message"=> 'New sign request, please review the contract and sign it',
            "url"=>"sign-request-sent",
            "status"=>'unseen',
            
        );
        
        Notification::create($datanot)->id;
echo "Request sent please wait for response";
        die;
        return view('user/contracts/workflow/update_and_check_document_status');
    }
    
    public function update_and_check_document_status_pcv($pcvid)
    {
        $id = Crypt::decrypt($pcvid);
        $project_contract_vendor = Project_contract_vendor::where('id', $id )->first();
        $data1 = array(
                "status" => "sign-request-sent",
        );

        Project_contract_vendor::where('id',$id)->update($data1); 
        
        $datanot = array(
            "user_id"=>$project_contract_vendor->vendor_id,
            "sender_id"=>$project_contract_vendor->insert_user_id,
            "message"=> 'New sign request, please review the contract and sign it',
            "url"=>"sign-request-sent",
            "status"=>'unseen',
            
        );
        
        Notification::create($datanot)->id;
        
echo "Request sent please wait for response";
        die;
        return view('user/contracts/workflow/update_and_check_document_status');
    }
    
     public function vendor_msa_save_workflow__(Request $request)
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
                          $location = 'public/upload/contract/vendor';
            
                          // Upload file
                          $image->move($location,$filename);
                     
                          // File path
                          $filepath = 'upload/contract/vendor/'.$filename;
                          if($filepath){
                               $data1 = array(
                                    "document" => $filepath,
                                    "status" => "workflow",
                                );
                
                            $vendormsaid = $request->input('vendormsaid');
                            Vendor_msa::where('id',$vendormsaid)->update($data1);
                          }
                    }
                    // unset($formInput['document_old']);
         
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
    
    public function vendor_msa_save_workflow(Request $request)
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
                                "status" => "workflow",
                            );
            
                        $vendormsaid = $request->input('vendormsaid');
                        Vendor_msa::where('id',$vendormsaid)->update($data1);
                    }
                                  
                    // unset($formInput['document_old']);
                    
                    
                    
                    // $image = $request->file('pdfFile');
                    // if($image->isValid()){
                    //     if(!empty($request->input('document_old'))){
                    //         if(file_exists(public_path('/').'/'.$request->input('document_old'))){
                    //             unlink(public_path('/').'/'.$request->input('document_old')); 
                    //         }
                    //     }
                     
                    //       $image = $request->file('pdfFile');
                    //       $filename = time().'_'.$image->getClientOriginalName();
            
                    //       // File extension
                    //       $extension = $image->getClientOriginalExtension();
            
                    //       // File upload location
                    //       $location = 'public/upload/contract/vendor';
            
                    //       // Upload file
                    //       $image->move($location,$filename);
                     
                    //       // File path
                    //       $filepath = 'upload/contract/vendor/'.$filename;
                    //       if($filepath){
                    //           $data1 = array(
                    //                 "document" => $filepath,
                    //                 "status" => "workflow",
                    //             );
                
                    //         $vendormsaid = $request->input('vendormsaid');
                    //         Vendor_msa::where('id',$vendormsaid)->update($data1);
                    //       }
                    // }
                    // unset($formInput['document_old']);
         
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
    
    
     // workflow owner
    
    public function project_contract_owner_start_workflow($pcoid)
    {
        $id = Crypt::decrypt($pcoid);
        $company_id = Auth::user()->company_id;
        $project_contract_owner = Project_contract_owner::where('id', $id )->first();
        $teams = User::where('userType', 'user' )->where('company_role', 'team' )->where('company_id', $company_id )->orderBy('id','DESC')->get();
        
        return view('user/contracts/workflow/project_contract_owner', compact('project_contract_owner', 'teams'));
    }

   
    public function project_contract_owner_save_workflow(Request $request)
    {  $company_id = Auth::user()->company_id;
       
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
                        $image_path = public_path('upload/'.$company_id.'/contract');
                        $request->document->move($image_path, $fileName);
                        $formInput['document'] = 'upload/'.$company_id.'/contract/'.$fileName;
                    }
                    
                    if($formInput['document']){
                           $data1 = array(
                                "document" => $formInput['document'],
                                "status" => "workflow",
                            );
            
                        $pcoid = $request->input('pcoid');
                        Project_contract_owner::where('id',$pcoid)->update($data1);
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
    
    
     // request_signature
     public function project_contract_owner_request_signature(Request $request)
    {   

        $pcoid = $request->input('pcoid'); 
        $project_contract_owner = Project_contract_owner::where('id', $pcoid )->first();
        $pco_name  = $project_contract_owner->client_name;
        $pco_email  = $project_contract_owner->client_email;
        $document  = $project_contract_owner->document_original;
        $sendUrl  = $project_contract_owner->sendUrl;

        if($sendUrl){ 
            $msg = "Request already sent please wait for response";
            return view('user/contracts/workflow/request_signature_project_contract_owner', compact('sendUrl', 'msg')); 

        }else{


                // chcek vendor has an account
                $vendor = User::where('email', $pco_email )->pluck('id')->toArray();
                
                if($vendor){
                        $id =  $vendor[0]; 
                }else{
                        $data = array(
                           'name'=>$pco_name,
                           'email'=>$pco_email,
                           'userType'=>'vendor',
                           'password'=> bcrypt('123'),
                        );
                 
                        $id = User::create($data)->id; 
                        

                }

                if($id){
                    $data1 = array(
                            "vendor_id" => $id,
                            "status" => "request-for-sign",
                    );

                    Project_contract_owner::where('id',$pcoid)->update($data1);
                }


                $appurl = URL::to('/');
                $pcoidcrypt = Crypt::encrypt($pcoid); 
                
                $ch = curl_init();

                curl_setopt($ch, CURLOPT_URL, 'https://api.boldsign.com/v1/document/createEmbeddedRequestUrl');
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                curl_setopt($ch, CURLOPT_POST, 1);
                $post = array(
                    'Title' => 'Project contract owner document',
                    'ShowToolbar' => 'true',
                    'ShowNavigationButtons' => 'false',
                    'ShowPreviewButton' => 'true',
                    'ShowSendButton' => 'true',
                    'ShowSaveButton' => 'false',
                    'SendViewOption' => 'PreparePage',
                    'Locale' => 'EN',
                    // 'SendLinkValidTill' => '2023-10-21T06:37:57.424Z',
                    'RedirectUrl' => $appurl.'/user/update-and-check-document-status-pco/'.$pcoidcrypt,
                    'Message' => 'This is Project contract owner document sent to sign',
                    'EnableSigningOrder' => 'false',
                    'Signers[0][Name]' => $pco_name,
                    'Signers[0][EmailAddress]' => $pco_email,
                    'Signers[0][SignerOrder]' => '1',
                    // 'Signers[0][authenticationCode]' => '123',
                    // 'Signers[0][PrivateMessage]' => 'This is private message for signer',
                    'Signers[0][FormFields][0][FieldType]' => 'Signature',
                    'Signers[0][FormFields][0][Id]' => 'Sign',
                    'Signers[0][FormFields][0][PageNumber]' => '1',
                    'Signers[0][FormFields][0][IsRequired]' => 'True',
                    // 'Signers[0][FormFields][0][Bounds][X]' => '50',
                    // 'Signers[0][FormFields][0][Bounds][Y]' => '50',
                    'Signers[0][FormFields][0][Bounds][Width]' => '200',
                    'Signers[0][FormFields][0][Bounds][Height]' => '50',
                    'DisableEmails' => 'true',
                    'Files' => new \CURLFILE(public_path($document),'application/pdf','MyFile'),
                );
                curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
                
                $headers = array();
                $headers[] = 'Accept: application/json';
                $headers[] = 'X-Api-Key: Yzc2MmY0NzEtMjJiYi00MjJiLThiZmUtMDgwNGU1ZjJjYmE3';
                $headers[] = 'Content-Type: multipart/form-data';
                curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
                
                $result = curl_exec($ch); 
                if (curl_errno($ch)) {
                    echo 'Error:' . curl_error($ch);
                }
                curl_close($ch);
                $result = json_decode($result, true);   
           
                $documentId = $result['documentId'];
                $sendUrl = $result['sendUrl'];

                if($documentId){
                    $data2 = array(
                            "documentId" => $documentId,
                            "sendUrl" => $sendUrl,
                    );

                    Project_contract_owner::where('id',$pcoid)->update($data2);
                }

               return view('user/contracts/workflow/request_signature_project_contract_owner', compact('sendUrl')); 
        }
        
        
    }
    
    
    // work flow vendor

    public function project_contract_vendor_start_workflow($pcvid)
    {
        $id = Crypt::decrypt($pcvid);
        $company_id = Auth::user()->company_id;
        $project_contract_vendor = Project_contract_vendor::where('id', $id )->first();
        $teams = User::where('userType', 'user' )->where('company_role', 'team' )->where('company_id', $company_id )->orderBy('id','DESC')->get();
        
        return view('user/contracts/workflow/project_contract_vendor', compact('project_contract_vendor', 'teams'));
    }
    
    
     // request_signature
     public function project_contract_vendor_request_signature(Request $request)
    {   

        $pcvid = $request->input('pcvid'); 
        $project_contract_vendor = Project_contract_vendor::where('id', $pcvid )->first();
        $vendor_name = $project_contract_vendor->vendor_name;
        $vendor_email = $project_contract_vendor->vendor_id;
        $document  = $project_contract_vendor->document_original;
        $sendUrl  = $project_contract_vendor->sendUrl;

        if($sendUrl && ($project_contract_vendor->status != 'workflow')){ 
            
                $msg = "Request already sent please wait for response";
                return view('user/contracts/workflow/request_signature_project_contract_vendor', compact('sendUrl', 'msg')); 
            
        }else{


                // chcek vendor has an account
                $vendor = User::where('email', $vendor_email )->pluck('id')->toArray();
                
                if($vendor){
                        $id =  $vendor[0]; 
                }else{
                    
                        $strArr = explode("@", $vendor_email);
                        if(count($strArr) == 2){
                            $nn = $strArr[0];
                        }else{
                            $nn = $vendor_email;
                        }

                        $data = array(
                           'name'=>$nn,
                           'email'=>$vendor_email,
                           'userType'=>'vendor',
                           'password'=> bcrypt('123'),
                        );
                 
                        $id = User::create($data)->id; 
                        

                }

                if($id){
                    $data1 = array(
                            "vendor_id" => $id,
                            "status" => "request-for-sign",
                    );

                    Project_contract_vendor::where('id',$pcvid)->update($data1);
                    
                    $vendordetail = User::where('id', $id )->first();
                    
                    // email data
                        // $email_data = array(
                        //     'name' =>  $vendordetail->name,
                        //     'email' => $vendordetail->email,
                          
                        // );
                        
                        // Mail::send('mail.vendor_pcv_request_sign', $email_data, function ($message) use ($email_data) {
                        // $message->to($email_data['email'], $email_data['name'])
                        // ->subject('Signature request send for project contract vendor')
                        // ->from('resolutecontracts@gmail.com', 'Resolute');
                        // });
                }


                $appurl = URL::to('/');
                $pcvidcrypt = Crypt::encrypt($pcvid); 
                
                $ch = curl_init();

                curl_setopt($ch, CURLOPT_URL, 'https://api.boldsign.com/v1/document/createEmbeddedRequestUrl');
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                curl_setopt($ch, CURLOPT_POST, 1);
                $post = array(
                    'Title' => 'Project Contract Vendor document',
                    'ShowToolbar' => 'true',
                    'ShowNavigationButtons' => 'false',
                    'ShowPreviewButton' => 'true',
                    'ShowSendButton' => 'true',
                    'ShowSaveButton' => 'false',
                    'SendViewOption' => 'PreparePage',
                    'Locale' => 'EN',
                    // 'SendLinkValidTill' => '2023-10-21T06:37:57.424Z',
                    'RedirectUrl' => $appurl.'/user/update-and-check-document-status-pcv/'.$pcvidcrypt,
                    'Message' => 'This is project contract vendor document sent to sign',
                    'EnableSigningOrder' => 'false',
                    'Signers[0][Name]' => $vendor_name,
                    'Signers[0][EmailAddress]' => $vendor_email,
                    'Signers[0][SignerOrder]' => '1',
                    // 'Signers[0][authenticationCode]' => '123',
                    // 'Signers[0][PrivateMessage]' => 'This is private message for signer',
                    'Signers[0][FormFields][0][FieldType]' => 'Signature',
                    'Signers[0][FormFields][0][Id]' => 'Sign',
                    'Signers[0][FormFields][0][PageNumber]' => '1',
                    'Signers[0][FormFields][0][IsRequired]' => 'True',
                    // 'Signers[0][FormFields][0][Bounds][X]' => '50',
                    // 'Signers[0][FormFields][0][Bounds][Y]' => '50',
                    'Signers[0][FormFields][0][Bounds][Width]' => '200',
                    'Signers[0][FormFields][0][Bounds][Height]' => '50',
                    'DisableEmails' => 'true',
                    'Files' => new \CURLFILE(public_path($document),'application/pdf','MyFile'),
                );
                curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
                
                $headers = array();
                $headers[] = 'Accept: application/json';
                $headers[] = 'X-Api-Key: Yzc2MmY0NzEtMjJiYi00MjJiLThiZmUtMDgwNGU1ZjJjYmE3';
                $headers[] = 'Content-Type: multipart/form-data';
                curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
                
                $result = curl_exec($ch); 
                if (curl_errno($ch)) {
                    echo 'Error:' . curl_error($ch);
                }
                curl_close($ch);
                $result = json_decode($result, true);   
           
                $documentId = $result['documentId'];
                $sendUrl = $result['sendUrl'];

                if($documentId){
                    $data2 = array(
                            "documentId" => $documentId,
                            "sendUrl" => $sendUrl,
                    );

                    Project_contract_vendor::where('id',$pcvid)->update($data2);
                }

               return view('user/contracts/workflow/request_signature_project_contract_vendor', compact('sendUrl')); 
        }
        
        
    }


}
