<?php

namespace App\Models\casemanagement\enviro\master;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OffenderHairColour extends Model
{
    use HasFactory;
    protected $table = 'tbl_master_env_offender_hair_colour';
    protected $fillable = [
        'textOnMachine', 'textOnLetter', 'status'
    ];
}
