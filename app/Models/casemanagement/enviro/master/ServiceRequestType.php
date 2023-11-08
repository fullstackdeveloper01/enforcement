<?php

namespace App\Models\casemanagement\enviro\master;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServiceRequestType extends Model
{
    use HasFactory;
    protected $table = 'tbl_master_env_service_request_type';
    protected $fillable = [
        'type_name','minimum_images_required','status'
    ];
}
