<?php

namespace App\Models\casemanagement\enviro;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Offender extends Model
{
    use HasFactory;
    protected $table = 'tbl_offenders';
    protected $guarded = [];
}
