<?php

namespace App\Models\casemanagement\enviro\master;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OffenceLocationSuffix extends Model
{
    use HasFactory;
    protected $table = 'tbl_master_env_offence_location_suffix';
    protected $fillable = [
        'textOnMachine', 'textOnLetter', 'status'
    ];
}
