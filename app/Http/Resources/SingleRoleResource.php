<?php

namespace App\Http\Resources;

use App\Models\Permission;
use Illuminate\Http\Resources\Json\JsonResource;

class SingleRoleResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        // return [
        //     "id" => $this->id,
        //     "permission" => RolePermissionResource::collection($this->roleHasPermissions),
        //     "status" => $this->status,
        // ];

        return [
            "id" => $this->id,
            "permission" => RolePermissionResource::collection($this->getPermission(Permission::all(),$this->roleHasPermissions)),
            "status" => $this->status,
        ];
    }

    public function getPermission($allPermissions, $availablePermissions)
    {
        $permissions = [];
        $permission = [];
        $ap = [];
        if($availablePermissions->count() > 0){
            foreach($availablePermissions as $availablePermission){
                $ap[] = $availablePermission->id;
            }
        }
        $i = 0;
        foreach($allPermissions as $allPermission)
        {
            if (in_array($allPermission->id, $ap,true)) {
                $permission['id'] = $allPermission->id;
                $permission['category'] = $allPermission->category;
                $permission['activeStatus'] = 1;
                $permission['status'] = $allPermission->status;
                $permissions[$i] = $permission;
            } else {
                $permission['id'] = $allPermission->id;
                $permission['category'] = $allPermission->category;
                $permission['activeStatus'] = 0;
                $permission['status'] = $allPermission->status;
                $permissions[$i] = $permission;
            }
            $i++;
        }
        return $permissions;
    }
}
