<?php

namespace App\Models\casemanagement\enviro\master;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CompanyRegisteredType extends Model
{
    use HasFactory;
    protected $table = 'tbl_master_env_company_registered_type';
    protected $fillable = [
        'registered_type','status'
    ];
}
