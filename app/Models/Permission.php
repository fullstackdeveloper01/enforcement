<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'category',
        'status',
        'deleted',
    ];


    // public function permissions()
    // {
    //     return $this->belongsToMany(Role::class);
    // }

    public function category()
    {
        return $this->belongsToMany(Category::class);
    }
}
