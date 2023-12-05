<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Contract_type extends Model
{

    protected $table='contract_type';
    protected $primaryKey='id';
    protected $fillable=['name', 'External_show'];
}
