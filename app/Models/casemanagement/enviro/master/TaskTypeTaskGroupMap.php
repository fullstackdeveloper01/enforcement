<?php

namespace App\Models\casemanagement\enviro\master;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Setup\Site;

class TaskTypeTaskGroupMap extends Model
{
    use HasFactory;
    protected $table = 'tbl_master_env_task_type_task_group_map';
    protected $fillable = [
        'site_id','task_type_id','task_group_id','status'
    ];


    public function taskSite()
    {
        return $this->belongsTo(Site::class,'site_id');
    }
}
