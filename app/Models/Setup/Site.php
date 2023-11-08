<?php

namespace App\Models\Setup;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\casemanagement\enviro\master\TaskTypeTaskGroupMap;

class Site extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function offences()
    {
        return $this->hasMany(\App\Models\Setup\SiteOffence::class, 'site_id');
    }

    public function taskGroupMap()
    {
        return $this->hasMany(TaskTypeTaskGroupMap::class,'site_id');
    }
}
