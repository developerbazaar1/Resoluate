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

class TemplateController extends Controller
{

    public function get_template($id)
    {
        $templates = Template::where('type_msa_psa', $id)->get();
        return response()->json($templates);
       
    }

    public function template_repository()
    {
        // $oldDetails = User::find(Auth::user()->id);
        // $oldDetails->assignRole('Super Admin');
        if(!empty(request()->tabName)){
            $tabName = request()->tabName;
        }else{
            $tabName = '';
        }
        
        $company_id = Auth::user()->company_id;
        $msas = Template::where('company_id', $company_id )->where('type', 'msa_psa' )->get();
        $pcs = Template::where('company_id', $company_id )->where('type', 'project')->get();
        return view('user/template/index', compact('msas', 'pcs', 'tabName'));
    }


    public function create_msa_template()
    {
        $msa_types = Msa_type::all();
        $company_id = Auth::user()->company_id;
        $msas = Template::where('company_id', $company_id )->where('type', 'msa_psa' )->get();
        return view('user/template/create_msa_template', compact('msas','msa_types'));
    }

    public function store_msa_template(Request $request)
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
                $image_path = public_path('upload/'.$company_id.'/template');
                $request->document->move($image_path, $fileName);
                $formInput['document'] = 'upload/'.$company_id.'/template/'.$fileName;
            }
            unset($formInput['document_old']);
        }else{
            $formInput['document'] = $request->input('document_old');
        }
        
        $validated = $request->validate([
            'name' => 'required|max:100',
            'trade' => 'required|max:100',
            'type_msa_psa' => 'required',

        ]);
        
        $data = array(
            "name"=>$request->input('name'),
            "trade"=>$request->input('trade'),
            "type_msa_psa"=>$request->input('type_msa_psa'),
            "document" => $formInput['document'],
            "type" => "msa_psa",
            "company_id" => Auth::user()->company_id,
        );

        $id = Template::create($data)->id;
       
        if($id){
            return redirect()->back()->with('success',"Template added successfully!");
        }else{
            return redirect()->back()->with('error',"Template not added, please try again!");
        }
    
    }

     public function edit_msa_template($id)
    {
        $tid = Crypt::decrypt($id); 
        $msa_types = Msa_type::all();
        $m = Template::where('id',$tid)->first();
        return view('user/template/edit_msa_template', compact('m', 'msa_types'));
    }

    public function update_msa_template(Request $request)
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
                $image_path = public_path('upload/'.$company_id.'/template');
                $request->document->move($image_path, $fileName);
                $formInput['document'] = 'upload/'.$company_id.'/template/'.$fileName;
            }
            unset($formInput['document_old']);
        }else{
            $formInput['document'] = $request->input('document_old');
        }
        
        $validated = $request->validate([
            'name' => 'required|max:100',
            'trade' => 'required|max:100',
            'type_msa_psa' => 'required',
         
        ]);
        
        $data = array(
            "name"=>$request->input('name'),
            "trade"=>$request->input('trade'),
            "type_msa_psa"=>$request->input('type_msa_psa'),
            "document" => $formInput['document'],
            "type" => "msa_psa",
            "company_id" => Auth::user()->company_id,
        );

            $tid = $request->input('tid');
            Template::where('id',$tid)->update($data);
           
            return redirect()->back()->with('success',"Msa template updated successfully!");
            
           
    }

    public function delete_msa_template($id)
    {
        $tid = Crypt::decrypt($id);
        $delete = Template::findOrFail($tid);
        $image = $delete->document;
        if($delete->delete()){
            if(!empty($image)){
                if(file_exists($image)){
                    unlink($image);
                }
            }
            return redirect()->back()->with('success',"Msa template deleted successfully!");
        }else{
            return redirect()->back()->with('error',"Msa template not deleted, please try again!");
        }
    }





    public function create_project_contract_template()
    {
        $company_id = Auth::user()->company_id;
        $pcs = Template::where('company_id', $company_id )->where('type', 'project')->get();
        return view('user/template/create_project_contract_template', compact('pcs'));
    }

    public function store_project_contract_template(Request $request)
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
                $image_path = public_path('upload/'.$company_id.'/template');
                $request->document->move($image_path, $fileName);
                $formInput['document'] = 'upload/'.$company_id.'/template/'.$fileName;
            }
            unset($formInput['document_old']);
        }else{
            $formInput['document'] = $request->input('document_old');
        }
        
        $validated = $request->validate([
            'name' => 'required',
            'trade' => 'required',
     
        ]);
        
        $data = array(
            "name"=>$request->input('name'),
            "trade"=>$request->input('trade'),
            "document" => $formInput['document'],
            "type" => "project",
            "company_id" => Auth::user()->company_id,
        );

        $id = Template::create($data)->id;
       
        if($id){
            return redirect()->back()->with('success',"Template added successfully!");
        }else{
            return redirect()->back()->with('error',"Template not added, please try again!");
        }
    
    }

    public function edit_project_contract_template($id)
    {
        $tid = Crypt::decrypt($id);
        $m = Template::where('id',$tid)->first();
        return view('user/template/edit_project_contract_template', compact('m'));
    }

    public function update_project_contract_template(Request $request)
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
                $image_path = public_path('upload/'.$company_id.'/template');
                $request->document->move($image_path, $fileName);
                $formInput['document'] = 'upload/'.$company_id.'/template/'.$fileName;
            }
            unset($formInput['document_old']);
        }else{
            $formInput['document'] = $request->input('document_old');
        }
        
        $validated = $request->validate([
            'name' => 'required',
            'trade' => 'required',
     
        ]);
        
        $data = array(
            "name"=>$request->input('name'),
            "trade"=>$request->input('trade'),
            "document" => $formInput['document'],
            "type" => "project",
            "company_id" => Auth::user()->company_id,
        );

        
       
            $tid = $request->input('tid');
            Template::where('id',$tid)->update($data);
           
            return redirect()->back()->with('success',"project contract template updated successfully!");
            
           
    }

    public function delete_project_contract_template($id)
    {
        $tid = Crypt::decrypt($id);
        $delete = Template::findOrFail($tid);
        $image = $delete->document;
        if($delete->delete()){
            if(!empty($image)){
                if(file_exists($image)){
                    unlink($image);
                }
            }
            return redirect()->back()->with('success1',"project contract template deleted successfully!");
        }else{
            return redirect()->back()->with('error1',"project contract template not deleted, please try again!");
        }
    }

   
}
