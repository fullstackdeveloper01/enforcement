<?php

namespace App\Models\casemanagement\enviro\master;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TypeOfDog extends Model
{
    use HasFactory;
    protected $table = 'tbl_master_env_type_of_dog';
    protected $fillable = [
        'name', 'status'
    ];
}
