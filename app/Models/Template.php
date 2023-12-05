<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Template extends Model
{

    protected $table='template';
    protected $primaryKey='id';
    protected $fillable=['trade','name','type','document','type_msa_psa', 'company_id'];
}