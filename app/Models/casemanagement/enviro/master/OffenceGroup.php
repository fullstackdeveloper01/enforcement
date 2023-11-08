<?php

namespace App\Models\casemanagement\enviro\master;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OffenceGroup extends Model
{
    use HasFactory;
    protected $table = 'tbl_master_env_offence_group';
    protected $fillable = [
        'englishName', 'welshName', 'type', 'status'
    ];
}
