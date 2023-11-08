<?php

namespace App\Models\casemanagement\enviro\master;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\casemanagement\enviro\master\ServiceRequestTaskType;

class ServiceRequestTaskGroup extends Model
{
    use HasFactory;
    protected $table = 'tbl_master_env_service_request_task_group';
    protected $fillable = [
        'task_group_name','status'
    ];

    public function taskType()
    {
        return $this->hasMany(TaskTypeTaskGroupMap::class,'task_group_id');
    }
}
