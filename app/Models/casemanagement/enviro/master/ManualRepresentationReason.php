<?php

namespace App\Models\casemanagement\enviro\master;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ManualRepresentationReason extends Model
{
    use HasFactory;
    protected $table = 'tbl_master_env_manual_representation_reason';
    protected $fillable = [
        'reason','isOnline'
    ];
}
