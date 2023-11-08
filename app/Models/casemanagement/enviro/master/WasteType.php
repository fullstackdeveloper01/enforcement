<?php

namespace App\Models\casemanagement\enviro\master;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WasteType extends Model
{
    use HasFactory;
    protected $table = 'tbl_master_env_waste_type';
    protected $fillable = [
        'waste_type','status'
    ];
}
