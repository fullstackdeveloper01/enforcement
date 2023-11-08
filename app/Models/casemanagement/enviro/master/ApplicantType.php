<?php

namespace App\Models\casemanagement\enviro\master;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ApplicantType extends Model
{
    use HasFactory;
    protected $table = 'tbl_master_env_applicant_type';
    protected $fillable = [
        'applicant_type','status'
    ];
}
