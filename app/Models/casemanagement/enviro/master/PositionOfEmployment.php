<?php

namespace App\Models\casemanagement\enviro\master;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PositionOfEmployment extends Model
{
    use HasFactory;
    protected $table = 'tbl_master_env_postition_of_employement';
    protected $fillable = [
        'position_of_employment','status'
    ];
}
