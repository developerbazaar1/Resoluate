<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Other_contract extends Model
{

    protected $table='other_contract';
    protected $primaryKey='id';
    protected $fillable=['name','email','contact','document','status','address','obligation','team', 'company_id', 'vendor_id', 'insert_user_id'];
}