<?php

namespace App\Models\casemanagement\enviro\master;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServiceRequestReportedVia extends Model
{
    use HasFactory;
    protected $table = 'tbl_master_env_service_request_reported_via';
    protected $fillable = [
        'reported_via','is_back_office','is_online','status'
    ];
}
