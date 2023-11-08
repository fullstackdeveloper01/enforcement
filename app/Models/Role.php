<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;

    protected $fillable = [
        'company_id',
        'name',
        'status',
        'deleted',
    ];

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function roleHasPermissions()
    {
        return $this->belongsToMany(Permission::class, RoleHasPermission::class);
    }


}
