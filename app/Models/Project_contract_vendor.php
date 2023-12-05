<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Project_contract_vendor extends Model
{

    protected $table='project_contract_vendor';
    protected $primaryKey='id';
    protected $fillable=['vendor_name','vendor_contact','vendor_email','project_name', 'amount', 'vendor_msa_id','document', 'status','address','obligation','team', 'company_id', 'vendor_id', 'start_date', 'end_date', 'template_id', 'insert_user_id', 'document_original', 'documentId', 'sendUrl', 'signLink', 'comment_email_send'];

    
    public function template(){
        return $this->belongsTo(Template::class,'template_id');
    }
    
   
}