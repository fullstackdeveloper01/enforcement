<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Permission;
use App\Http\Resources\PermissionResource;

class PermissionController extends Controller
{
    public function index()
    {
        $permission = Permission::where('deleted',0)->get();

        return PermissionResource::collection($permission);
    }
}
