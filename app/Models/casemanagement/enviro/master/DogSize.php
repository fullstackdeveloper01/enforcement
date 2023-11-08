<?php

namespace App\Models\casemanagement\enviro\master;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DogSize extends Model
{
    use HasFactory;
    protected $table = 'tbl_master_env_dog_size';
    protected $fillable = [
        'name', 'status'
    ];
}
