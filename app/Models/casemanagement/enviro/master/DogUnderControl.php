<?php

namespace App\Models\casemanagement\enviro\master;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DogUnderControl extends Model
{
    use HasFactory;
    protected $table = 'tbl_master_env_dog_under_control';
    protected $fillable = [
        'name', 'status'
    ];
}
