<?php

namespace App\Models\casemanagement\enviro\master;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CancelCode extends Model
{
    use HasFactory;
    protected $table = 'tbl_master_env_cancel_code';
    protected $fillable = [
        'type', 'description', 'status'
    ];
}
