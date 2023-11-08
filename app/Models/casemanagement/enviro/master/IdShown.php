<?php

namespace App\Models\casemanagement\enviro\master;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IdShown extends Model
{
    use HasFactory;
    protected $table = 'tbl_master_env_id_shown';
    protected $fillable = [
        'textOnMachine', 'textOnLetter', 'status'
    ];
}
