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
use Auth;
class AdminController extends Controller
{
    public function index()
    {
         $date = today()->format('Y-m-d');

        $company_id = Auth::user()->company_id;
        $loginuser_id = Auth::user()->id;
        
        // active contract 
        
        $owner_msas = Owner_msa::where('end_date', '>=', $date)->orderBy('id','DESC')->get();
        $vendor_msas = Vendor_msa::where('expired_date', '>=', $date)->orderBy('id','DESC')->get();
        $project_contract_owners = Project_contract_owner::where('end_date', '>=', $date)->orderBy('id','DESC')->get();
         $project_contract_vendors = Project_contract_vendor::where('end_date', '>=', $date)->orderBy('id','DESC')->get();
          
        $active_owner_msa = count($owner_msas);
        $active_vendor_msa = count($vendor_msas);
        $active_project_contract_owners = count($project_contract_owners);
        $active_project_contract_vendors = count($project_contract_vendors);
        
        
        //  declined contract count
        $owner_msas_declined = Owner_msa::where('status', 'declined')->orderBy('id','DESC')->get();
        $vendor_msas_declined = Vendor_msa::where('status', 'declined')->orderBy('id','DESC')->get();
        $project_contract_owners_declined = Project_contract_owner::where('status', 'declined')->orderBy('id','DESC')->get();
        $project_contract_vendors_declined = Project_contract_vendor::where('status', 'declined')->orderBy('id','DESC')->get();
        
        $total_declined = count($owner_msas_declined) + count($vendor_msas_declined) + count($project_contract_owners_declined) + count($project_contract_vendors_declined);
      
       //  workflow contract count
        $owner_msas_workflow = Owner_msa::where('status', 'workflow')->orderBy('id','DESC')->get();
        $vendor_msas_workflow = Vendor_msa::where('status', 'workflow')->orderBy('id','DESC')->get();
        $project_contract_owners_workflow = Project_contract_owner::where('status', 'workflow')->orderBy('id','DESC')->get();
        $project_contract_vendors_workflow = Project_contract_vendor::where('status', 'workflow')->orderBy('id','DESC')->get();
        
        $total_workflow = count($owner_msas_workflow) + count($vendor_msas_workflow) + count($project_contract_owners_workflow) + count($project_contract_vendors_workflow);
      
      //  negotiation contract count
        $owner_msas_negotiation = Owner_msa::where('status', 'negotiation')->orderBy('id','DESC')->get();
        $vendor_msas_negotiation = Vendor_msa::where('status', 'negotiation')->orderBy('id','DESC')->get();
        $project_contract_owners_negotiation = Project_contract_owner::where('status', 'negotiation')->orderBy('id','DESC')->get();
        $project_contract_vendors_negotiation = Project_contract_vendor::where('status', 'negotiation')->orderBy('id','DESC')->get();
        
        $total_negotiation = count($owner_msas_negotiation) + count($vendor_msas_negotiation) + count($project_contract_owners_negotiation) + count($project_contract_vendors_negotiation);
      
    
      
      //  completed contract count
        $owner_msas_completed = Owner_msa::where('status', 'completed')->orderBy('id','DESC')->get();
        $vendor_msas_completed = Vendor_msa::where('status', 'completed')->orderBy('id','DESC')->get();
        $project_contract_owners_completed = Project_contract_owner::where('status', 'completed')->orderBy('id','DESC')->get();
        $project_contract_vendors_completed = Project_contract_vendor::where('status', 'completed')->orderBy('id','DESC')->get();
        
        $total_completed = count($owner_msas_completed) + count($vendor_msas_completed) + count($project_contract_owners_completed) + count($project_contract_vendors_completed);
      

      
        return view('admin/dashboard', compact('active_owner_msa', 'active_vendor_msa', 'active_project_contract_owners', 'active_project_contract_vendors', 'total_declined', 'total_workflow', 'total_negotiation', 'total_completed'));
    }
    
     public function edit_profile($id)
    {
        $userid = Crypt::decrypt($id);
        $user = User::where('id',$userid)->first();
        return view('admin/edit_profile', compact('user'));
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

    public function demo_request()
    {
        $users = DemoUser::all();
        return view('admin/demo_request',compact('users'));
    }

    public function registered_users()
    {
        $users = User::where('userType', 'user' )->where('company_role', 'company-admin' )->orderBy('id','DESC')->get();
        return view('admin/registered_users',compact('users'));
    }

    public function create_user()
    {
        return view('admin/create_user');
    }

    
    public function store_user(Request $request)
    {   
        
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:4|confirmed',
            'job_title' => 'required',
            'company_name' => 'required|unique:company',
            'phone' => 'required',
            'domain' => 'required',
        ]);
        
        $comdata = array(
            "company_name"=>$request->input('company_name'),
        );
        
       
        $company_id = Company::create($comdata)->id; 
        if($company_id){ 

            $data = array(
                "name"=>$request->input('name'),
                "email"=>$request->input('email'),
                "password"=>bcrypt($request->input('password')),
                "job_title"=>$request->input('job_title'),
                "company_name"=>$request->input('company_name'),
                "company_id"=>$company_id,
                "phone"=>$request->input('phone'),
                "domain"=>$request->input('domain'), 
                "userType" => "user",
                "company_role" => "company-admin",
            );
            $id = User::create($data)->id; 
            
            if($id){
                $userDetails = User::find($id);
                $userDetails->assignRole('Super Admin');

                return redirect()->back()->with('success',"User added successfully!");
            }else{
                return redirect()->back()->with('error',"User not added, please try again!");
            }

        }else{
            return redirect()->back()->with('error',"User not added, please try again!");
        }
        
       
    
    }

    public function edit_user($id)
    {
        $userid = Crypt::decrypt($id);
        $user = User::where('id',$userid)->first();
        return view('admin/edit_user', compact('user'));
    }

    public function update_user(Request $request)
    {
         $validated = $request->validate([
            'name' => 'required|string|max:255',
            'job_title' => 'required|max:255',
            'company_name' => 'required|max:255',
            'phone' => 'required|max:15',
            'domain' => 'required|max:255',
        ]);
        
        $data = array(
            "name"=>$request->input('name'),
            "job_title"=>$request->input('job_title'),
            "company_name"=>$request->input('company_name'),
            "phone"=>$request->input('phone'),
            "domain"=>$request->input('domain'), 
        );
        
       
            $userid = $request->input('userid');
            User::where('id',$userid)->update($data);
           
            return redirect()->back()->with('success',"User updated successfully!");
            
           
    }

    public function delete_user($id)
    {
        $userid = Crypt::decrypt($id);
        $delete = User::findOrFail($userid);
        if($delete->delete()){
            // echo json_encode(array(
            //     "statusCode"=>200
            // ));
            return redirect()->back()->with('success',"User deleted successfully!");
        }else{
            return redirect()->back()->with('error',"User not deleted, please try again!");
        }
    }

    
}
