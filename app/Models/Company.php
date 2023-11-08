<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'name',
        'email',
        'telephone',
        'address',
        'status',
        'deleted',
    ];

    public function role()
    {
        return $this->hasMany(Role::class);
    }
}
