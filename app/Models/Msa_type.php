<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Msa_type extends Model
{

    protected $table='msa_type';
    protected $primaryKey='id';
    protected $fillable=['id','name'];
}