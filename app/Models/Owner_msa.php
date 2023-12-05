<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Owner_msa extends Model
{

    protected $table='owner_msa';
    protected $primaryKey='id';
    protected $fillable=['owner_name','owner_email','owner_contact','document','status','address','obligation','team', 'company_id', 'vendor_id', 'start_date', 'end_date', 'insert_user_id', 'document_original'];
}