<?php

namespace App\Models\casemanagement\enviro\master;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Legislation extends Model
{
    use HasFactory;
    protected $table = 'tbl_master_env_legislation';
    protected $fillable = [
        'title', 'legislation','language','offenceSpecificText','status'
    ];
}
