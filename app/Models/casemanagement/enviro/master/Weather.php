<?php

namespace App\Models\casemanagement\enviro\master;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Weather extends Model
{
    use HasFactory;
    protected $table = 'tbl_master_env_weather';
    protected $fillable = [
        'textOnMachine', 'textOnLetter', 'status'
    ];
}
