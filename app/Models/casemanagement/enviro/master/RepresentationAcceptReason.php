<?php

namespace App\Models\casemanagement\enviro\master;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RepresentationAcceptReason extends Model
{
    use HasFactory;
    protected $table = 'tbl_master_env_representation_accept_reason';
    protected $fillable = [
        'reason','status'
    ];
}
