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
use App\Models\Notification;
use Auth;
use App\Models\Vendor_performance;
use Illuminate\Support\Facades\Mail;

class UserController extends Controller
{
    public function index()
    {
        $date = today()->format('Y-m-d');

        $company_id = Auth::user()->company_id;
        $loginuser_id = Auth::user()->id;
        
        // active contract 
        
        $owner_msas = Owner_msa::where('company_id', $company_id )->where('end_date', '>=', $date)->orderBy('id','DESC')->get();
        $vendor_msas = Vendor_msa::where('company_id', $company_id )->where('expired_date', '>=', $date)->orderBy('id','DESC')->get();
        $project_contract_owners = Project_contract_owner::where('company_id', $company_id )->where('end_date', '>=', $date)->orderBy('id','DESC')->get();
         $project_contract_vendors = Project_contract_vendor::where('company_id', $company_id )->where('end_date', '>=', $date)->orderBy('id','DESC')->get();
          
        $active_owner_msa = count($owner_msas);
        $active_vendor_msa = count($vendor_msas);
        $active_project_contract_owners = count($project_contract_owners);
        $active_project_contract_vendors = count($project_contract_vendors);
        
        
        //  declined contract count
        $owner_msas_declined = Owner_msa::where('company_id', $company_id )->where('status', 'declined')->orderBy('id','DESC')->get();
        $vendor_msas_declined = Vendor_msa::where('company_id', $company_id )->where('status', 'declined')->orderBy('id','DESC')->get();
        $project_contract_owners_declined = Project_contract_owner::where('company_id', $company_id )->where('status', 'declined')->orderBy('id','DESC')->get();
        $project_contract_vendors_declined = Project_contract_vendor::where('company_id', $company_id )->where('status', 'declined')->orderBy('id','DESC')->get();
        
        $total_declined = count($owner_msas_declined) + count($vendor_msas_declined) + count($project_contract_owners_declined) + count($project_contract_vendors_declined);
      
       //  workflow contract count
        $owner_msas_workflow = Owner_msa::where('company_id', $company_id )->where('status', 'workflow')->orderBy('id','DESC')->get();
        $vendor_msas_workflow = Vendor_msa::where('company_id', $company_id )->where('status', 'workflow')->orderBy('id','DESC')->get();
        $project_contract_owners_workflow = Project_contract_owner::where('company_id', $company_id )->where('status', 'workflow')->orderBy('id','DESC')->get();
        $project_contract_vendors_workflow = Project_contract_vendor::where('company_id', $company_id )->where('status', 'workflow')->orderBy('id','DESC')->get();
        
        $total_workflow = count($owner_msas_workflow) + count($vendor_msas_workflow) + count($project_contract_owners_workflow) + count($project_contract_vendors_workflow);
      
      //  negotiation contract count
        $owner_msas_negotiation = Owner_msa::where('company_id', $company_id )->where('status', 'negotiation')->orderBy('id','DESC')->get();
        $vendor_msas_negotiation = Vendor_msa::where('company_id', $company_id )->where('status', 'negotiation')->orderBy('id','DESC')->get();
        $project_contract_owners_negotiation = Project_contract_owner::where('company_id', $company_id )->where('status', 'negotiation')->orderBy('id','DESC')->get();
        $project_contract_vendors_negotiation = Project_contract_vendor::where('company_id', $company_id )->where('status', 'negotiation')->orderBy('id','DESC')->get();
        
        $total_negotiation = count($owner_msas_negotiation) + count($vendor_msas_negotiation) + count($project_contract_owners_negotiation) + count($project_contract_vendors_negotiation);
      
    
      
      //  completed contract count
        $owner_msas_completed = Owner_msa::where('company_id', $company_id )->where('status', 'completed')->orderBy('id','DESC')->get();
        $vendor_msas_completed = Vendor_msa::where('company_id', $company_id )->where('status', 'completed')->orderBy('id','DESC')->get();
        $project_contract_owners_completed = Project_contract_owner::where('company_id', $company_id )->where('status', 'completed')->orderBy('id','DESC')->get();
        $project_contract_vendors_completed = Project_contract_vendor::where('company_id', $company_id )->where('status', 'completed')->orderBy('id','DESC')->get();
        
        $total_completed = count($owner_msas_completed) + count($vendor_msas_completed) + count($project_contract_owners_completed) + count($project_contract_vendors_completed);
      

      
        return view('user/dashboard', compact('active_owner_msa', 'active_vendor_msa', 'active_project_contract_owners', 'active_project_contract_vendors', 'total_declined', 'total_workflow', 'total_negotiation', 'total_completed'));
    }

   
    public function edit_profile($id)
    {
        $userid = Crypt::decrypt($id);
        $user = User::where('id',$userid)->first();
        return view('user/edit_profile', compact('user'));
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

    

    

    public function vendor_performance()
    
    {
        $company_id = Auth::user()->company_id;
        $vendor_performances = Vendor_performance::where('company_id', $company_id )->orderBy('id','DESC')->get();
        
        return view('user/vendor_performance', compact('vendor_performances'));
    }

     public function team()
    {
        $company_id = Auth::user()->company_id;
        $users = User::where('userType', 'user' )->where('company_role', 'team' )->where('company_id', $company_id )->orderBy('id','DESC')->get();
        return view('user/team',compact('users'));
    }

    public function create_member()
    {
        return view('user/create_member');
    }

    
    public function store_member(Request $request)
    {  
        
        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:4|confirmed',
            'job_title' => 'required',
            'phone' => 'required',
        ]);
        
       

        $data = array(
            "name"=>$request->input('name'),
            "email"=>$request->input('email'),
            "password"=>bcrypt($request->input('password')),
            "job_title"=>$request->input('job_title'),
            "phone"=>$request->input('phone'),
            "userType" => "user",
            "company_role" => "team",
            "company_id" => Auth::user()->company_id,
            "company_name" => Auth::user()->company_name,
            "domain" => Auth::user()->domain,
        );
        $id = User::create($data)->id; 
       
        if($id){
            return redirect()->back()->with('success',"Member added successfully!");
        }else{
            return redirect()->back()->with('error',"Member not added, please try again!");
        }
    
    }

    public function edit_member($id)
    {
        $userid = Crypt::decrypt($id);
        $user = User::where('id',$userid)->first();
        return view('user/edit_member', compact('user'));
    }

    public function update_member(Request $request)
    {
         $validated = $request->validate([
            'name' => 'required|string|max:255',
            'job_title' => 'required|max:255',
            'phone' => 'required|max:15',
        ]);
        
        $data = array(
            "name"=>$request->input('name'),
            "job_title"=>$request->input('job_title'),
            "phone"=>$request->input('phone'),

        );
        
       
            $userid = $request->input('userid');
            User::where('id',$userid)->update($data);
           
            return redirect()->back()->with('success',"Member updated successfully!");
            
           
    }

    public function delete_member($id)
    {
        $userid = Crypt::decrypt($id);
        $delete = User::findOrFail($userid);
        if($delete->delete()){
            // echo json_encode(array(
            //     "statusCode"=>200
            // ));
            return redirect()->back()->with('success',"Member deleted successfully!");
        }else{
            return redirect()->back()->with('error',"Member not deleted, please try again!");
        }
    }



     public function create_vendor(Request $request)
    {  
        
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
          
        ]);
        
       

        $data = array(
            "name"=>$request->input('name'),
            "email"=>$request->input('email'),
            "password"=>bcrypt("$request->input('name').'123'"),
            "userType" => "vendor",
            "company_id" => Auth::user()->company_id,

        );
        $id = User::create($data)->id; 
        
        if($id){

           $company_id = Auth::user()->company_id;
           $vendors = User::where('userType', 'vendor' )->where('company_id', $company_id )->orderBy('id','DESC')->get();
           $vendor = array(
                'id' => $id,
                "name"=>$request->input('name'),
                "email"=>$request->input('email'),
           );
            return response()->json($vendor);

        }else{
            return redirect()->back()->with('error',"Vendor not added, please try again!");
        }
    
    }
    
    
    public function comment($id)
    {
        $pcvid = Crypt::decrypt($id);
        $project_contract_vendors = Project_contract_vendor::where('id', $pcvid )->first();
        return view('user/comment', compact('pcvid', 'project_contract_vendors'));
    }

    
    public function store_comment(Request $request)
    {  
        
        $validated = $request->validate([
            'rating' => 'required',
            'comment' => 'required',
        ]);
        
        $id = $request->input('pcvid'); 
        
        $project_contract_vendors = Project_contract_vendor::where('id', $id )->first();
        
       
        $ii = $project_contract_vendors->insert_user_id;
        $domepm_details = User::where('id', $ii )->first();
        
        $vv = $project_contract_vendors->vendor_id;
        $vendor_details = User::where('id', $vv )->first();
        
        $data = array(
            "dome_pm"=>$domepm_details->name,
            "vendor_name"=>$vendor_details->name,
            "project"=>$project_contract_vendors->project_name,
            "comment"=>$request->input('comment'),
            "rating"=>$request->input('rating'),
            "vendor_pm" =>$project_contract_vendors->vendor_name,
            "company_id" =>$project_contract_vendors->company_id,
        );
        $id = Vendor_performance ::create($data)->id; 
       
        if($id){
            return redirect('/');
        }else{
            return redirect()->back()->with('error',"Performance rating not added, please try again!");
        }
    
    }
    
    public function get_pcv_email_data()
    {
        $date = date("Y-m-d");
        $project_contract_vendors = Project_contract_vendor::where('comment_email_send', 'no')->where('end_date', '<' , $date)->get();
    
        foreach($project_contract_vendors as $pcv){
            $userid = $pcv->insert_user_id;
            $user_details = User::where('id', $userid)->first();
            $email = $user_details->email;
            $name = $user_details->name;
            $project_name = $pcv->project_name;
            $pcvid = Crypt::encrypt($pcv->id); 
       
            // mail send
            
             // email data
            //     $email_data = array(
            //         'name' =>  $name,
            //         'email' => $email,
            //         'project_name' => $project_name,
            //         'pcvid' => $pcvid
            //     );
                
            // Mail::send('mail.send_comment_email', $email_data, function ($message) use ($email_data) {
            //     $message->to($email_data['email'], $email_data['name'])
            //     ->subject('Review the vendor')
            //     ->from('resolutecontracts@gmail.com', 'Resolute');
            //     });
            
            
            $data1 = array(
                    "comment_email_send" => "yes",
            );
    
            Project_contract_vendor::where('id',$pcv->id)->update($data1); 
        
                
        }
        
        $data['success'] = 1;
        $data['message'] = 'success'; 
        
        return response()->json($data);
    }
    
    
    public function change_notification_status($id){

    
    $not_status = Notification::where('id', $id)->pluck('status')->first();
        if($not_status == "unseen"){
            
            $data = array(
                "status"=>'seen',
            );
            
            $notifications = Notification::where('id', $id)->update($data);
            $urld = Notification::where('id', $id)->pluck('url')->first();
            
            if($urld == 'user-all-contracts'){
                return redirect(route('user-all-contracts'));
            }else if($urld == 'user-all-contracts-vendor-msa'){
                return redirect(route('user-all-contracts', 'tabName=vendor-msa/psa'));
            }else if($urld == 'user-all-contracts-pco'){
                return redirect(route('user-all-contracts', 'tabName=project contract-owner'));
            }else if($urld == 'user-all-contracts-pcv'){
                return redirect(route('user-all-contracts', 'tabName=project contract-vendor'));
            }else if($urld == 'sign-request-sent'){
                return redirect(route('vendor-all-contracts'));
            }else{
                return redirect(route('home'));
            }
            
        }else{
       
            $urld = Notification::where('id', $id)->pluck('url')->first();
            
            if($urld == 'user-all-contracts'){
                return redirect(route('user-all-contracts'));
            }else if($urld == 'user-all-contracts-vendor-msa'){
                return redirect(route('user-all-contracts', 'tabName=vendor-msa/psa'));
            }else if($urld == 'user-all-contracts-pco'){
                return redirect(route('user-all-contracts', 'tabName=project contract-owner'));
            }else if($urld == 'user-all-contracts-pcv'){
                return redirect(route('user-all-contracts', 'tabName=project contract-vendor'));
            }else if($urld == 'sign-request-sent'){
                return redirect(route('vendor-all-contracts'));
            }else{
                return redirect(route('home'));
            }
            
        }
    }
    

}
