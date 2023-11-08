<?php

namespace App\Models\casemanagement\enviro\master;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Visibility extends Model
{
    use HasFactory;
    protected $table = 'tbl_master_env_visibility';
    protected $fillable = [
        'visibility', 'status'
    ];
}
