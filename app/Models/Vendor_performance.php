<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Vendor_performance extends Model
{

    protected $table='vendor_performance';
    protected $primaryKey='id';
    protected $fillable=['dome_pm','vendor_name','project','comment','rating','vendor_pm', 'company_id'];
}