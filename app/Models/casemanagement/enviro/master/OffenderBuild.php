<?php

namespace App\Models\casemanagement\enviro\master;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OffenderBuild extends Model
{
    use HasFactory;
    protected $table = 'tbl_master_env_offender_build';
    protected $fillable = [
        'textOnMachine', 'textOnLetter', 'status'
    ];
}
