<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{

    protected $table='notification';
    protected $primaryKey='id';
    protected $fillable=['user_id','sender_id','message','status','url','did'];
}