<?php

namespace App\Models\casemanagement\enviro\master;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RepresentationDeclineReason extends Model
{
    use HasFactory;
    protected $table = 'tbl_master_env_representation_decline_reason';
    protected $fillable = [
        'reason','status'
    ];
}
