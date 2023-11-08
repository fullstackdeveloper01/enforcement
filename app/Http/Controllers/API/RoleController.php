<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Role;
use App\Models\RoleHasPermission;
use App\Http\Resources\RoleResource;
use App\Http\Resources\SingleRoleResource;
use App\Models\Permission;

class RoleController extends Controller
{
    public function index(Request $request)
    {
        $this->authorize('viewAny', Role::class);
        $user = auth()->user();
        if($request->q){
            $role = Role::where('company_id',$user->company_id)->where('deleted',0)->where('name', 'like', $request->q.'%')->get();
        }else{
            $role = Role::where('company_id',$user->company_id)->where('deleted',0)->get();
        }

        return response()->json([
            'message' => 'Role lists.',
            'data' => RoleResource::collection($role),
        ],200);
    }

    
    public function show($id)
    {
        $this->authorize('viewAny', Role::class);
        $user = auth()->user();
        $role = Role::where('company_id',$user->company_id)->where('deleted',0)->find($id);
        if(!$role){
            return response()->json([
                'message' => "No data available.",
            ],400);
        }
        return response()->json([
            'message' => 'Role Detail.',
            'data' => new RoleResource($role),
        ],200);
    }

    public function create(Request $request)
    {
        $this->authorize('create', Role::class);
        $user = auth()->user();
        $validation = Validator::make($request->all(),[
            'name' => 'required',
        ]);

        if($validation->fails()){
            return response()->json([
                'errors' => $validation->errors(),
            ],400);
        }
        $name = strtolower($request->name);

        $role = new Role;
        $role['name'] = $name;
        $role['company_id'] = $user->company_id;
        $role->save();
        $role = Role::where('id',$role->id)->first();
        return response()->json([
            'message' => 'Role created successfully.',
            'data' => new RoleResource($role),
        ],200);
    }

    public function edit(Request $request, $id)
    {
        $this->authorize('update', Role::class);
        $user = auth()->user();
        $validation = Validator::make($request->all(),[
            'name' => 'required',
        ]);

        if($validation->fails()){
            return response()->json([
                'errors' => $validation->errors(),
            ],400);
        }

        $role = Role::where('company_id',$user->company_id)->where('id',$id)->first();

        if(!$role)
        {
            return response()->json([
                'message' => 'Role not exists.',
            ],400);
        }

        $name = strtolower($request->name);

        $role->name = $name;
        $role->save();
        return response()->json([
            'message' => 'Role updated successfully.',
            'data' => new RoleResource($role),
        ],200);
    }

    public function status(Request $request, $id)
    {
        $this->authorize('update', Role::class);
        $user = auth()->user();
        $role = Role::where('company_id',$user->company_id)->where('id',$id)->first();

        if(!$role)
        {
            return response()->json([
                'message' => 'Role not exists.',
            ],400);
        }
        $role->status = $request->status;
        $role->save();
        return response()->json([
            'message' => 'Role status updated successfully.',
            'data' => new RoleResource($role),
        ],200);
        
    }

    public function delete(Request $request, $id)
    {
        $this->authorize('delete', Role::class);
        $user = auth()->user();
        $role = Role::where('company_id',$user->company_id)->where('id',$id)->first();

        if(!$role)
        {
            return response()->json([
                'message' => 'Role not exists.',
            ],400);
        }

        $role->deleted = true;
        $role->save();

        $getRoleHasPermission = RoleHasPermission::where('role_id',$id)->get();
        if($getRoleHasPermission){
            foreach ($getRoleHasPermission as $getPermission){
                $getPermission->delete();
            }
        }
        return response()->json([
            'message' => 'Role deleted successfully.',
        ],200);
    }

    public function rolePermission($id)
    {
        $this->authorize('viewAny', Role::class);
        $user = auth()->user();
        $role = Role::where('deleted',0)->find($id);
        if(!$role){
            return response()->json([
                'message' => "No data available.",
            ],400);
        }
        // return $role;
        return response()->json([
            'message' => 'Role Detail.',
            'data' => new SingleRoleResource($role),
        ],200);
    }

    public function updatePermission($role, $permission, $status)
    {
        
        $this->authorize('update', Role::class);
        $checkStatus = RoleHasPermission::where('role_id',$role)->where('permission_id',$permission)->first();
        if($checkStatus){
            $checkStatus->delete();
            return response()->json([
                'message' => "Permission updated successfully",
            ],200);
        }
        $checkStatus = new RoleHasPermission;
        $checkStatus['role_id'] = $role;
        $checkStatus['permission_id'] = $permission;
        $checkStatus->save();
        return response()->json([
            'message' => "Permission updated successfully",
        ],200);
    }
}
