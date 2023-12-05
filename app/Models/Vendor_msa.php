<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Vendor_msa extends Model
{

    protected $table='vendor_msa';
    protected $primaryKey='id';
    protected $fillable=['vendor_name', 'vendor_contact', 'vendor_email', 'contract_type', 'template_type', 'due_date', 'executed_date', 'expired_date', 'type_msa_psa', 'document', 'status','address','obligation','team', 'company_id', 'vendor_id', 'template_id', 'insert_user_id', 'documentId', 'sendUrl', 'signLink', 'team_member', 'flow_teamno', 'company_admin_id', 'document_original'];


    public function template(){
        return $this->belongsTo(Template::class,'template_id');
    }
}