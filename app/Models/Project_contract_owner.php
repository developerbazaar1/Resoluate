<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Project_contract_owner extends Model
{

    protected $table='project_contract_owner';
    protected $primaryKey='id';
    protected $fillable=['project_name','project_umbea','client_name','document', 'owner_msa_id', 'status','client_email','client_contact','address','obligation','team', 'company_id', 'vendor_id', 'does_client_have_msa', 'does_msa_req','end_date', 'start_date', 'insert_user_id', 'document_original', 'documentId', 'sendUrl', 'signLink'];
}