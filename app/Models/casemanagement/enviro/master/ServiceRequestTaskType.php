<?php

namespace App\Models\casemanagement\enviro\master;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\casemanagement\enviro\master\ServiceRequestTaskGroup;
use App\Models\Setup\Site;

class ServiceRequestTaskType extends Model
{
    use HasFactory;
    protected $table = 'tbl_master_env_service_request_task_type';
    protected $fillable = [
        'site_id','task_type_name','status'
    ];

    

    public function taskGroup()
    {
        return $this->belongsToMany(ServiceRequestTaskGroup::class, 'tbl_master_env_task_type_task_group_map','task_type_id', 'task_group_id');
    }
}
