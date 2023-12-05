<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Crypt;
use Illuminate\Http\Request;
use App\Models\Vendor_msa;
use App\Models\Owner_msa;
use App\Models\Project_contract_vendor;
use App\Models\Project_contract_owner;

class PdfController extends Controller
{
    public function show($type, $id)
    {
        $idd = Crypt::decrypt($id);
        
        if($type == 'vendor-msa'){
            $vendor_msa = Vendor_msa::where('id', $idd )->first();
            $pdfFilePath = public_path($vendor_msa->document_original);
            
            
        }else if($type == 'owner-msa'){
            $owner_msa = Owner_msa::where('id', $idd )->first();
            $pdfFilePath = public_path($owner_msa->document_original);
            
        }else if($type == 'project-contract-owner'){
            $project_contract_owner = Project_contract_owner::where('id', $idd )->first();
            $pdfFilePath = public_path($project_contract_owner->document_original);
            
        }else if($type == 'project-contract-vendor'){
            $project_contract_vendor = Project_contract_vendor::where('id', $idd )->first();
            $pdfFilePath = public_path($project_contract_vendor->document_original);
            
        }else{
            $project_contract_vendor = '';
        }

       return response(file_get_contents($pdfFilePath), 200)
        ->header('Content-Type', 'application/pdf')
        ->header('Content-Disposition', 'attachment; filename="pdfdocument"');
        
        // return response()->file($pdfFilePath);
         
    }
}

