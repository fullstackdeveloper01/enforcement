<?php

namespace App\Models\casemanagement\enviro;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EnviroImage extends Model
{
    use HasFactory;
    protected $table = 'tbl_enviro_images';
    protected $guarded = [];
}
