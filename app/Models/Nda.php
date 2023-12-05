<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Nda extends Model
{

    protected $table='nda';
    protected $primaryKey='id';
    protected $fillable=['name','email','contact','document','status','address','obligation','team', 'company_id', 'vendor_id', 'insert_user_id'];
}