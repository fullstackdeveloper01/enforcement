<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CompanyResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        
        return [
            "id" => $this->id,
            "name" => $this->name,
            "email" => $this->email,
            "telephone" => $this->telephone,
            "address" => $this->address,
            "role" => UserRolePermissionResource::collection($this->role),
            "status" => $this->status,
        ];
    }
}
