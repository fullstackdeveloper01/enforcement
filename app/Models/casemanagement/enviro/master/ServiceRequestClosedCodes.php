<?php

namespace App\Models\casemanagement\enviro\master;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServiceRequestClosedCodes extends Model
{
    use HasFactory;
    protected $table = 'tbl_master_env_service_request_closed_codes';
    protected $fillable = [
        'closed_code_type','closed_code_description','status'
    ];
}
