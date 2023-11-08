<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        // return parent::toArray($request);

        return [
            "id" => $this->id,
            "name" => $this->name,
            "email" => $this->email,
            "first_name" => $this->first_name,
            "last_name" => $this->last_name,
            "ni_number" => $this->ni_number,
            "operator_number" => $this->operator_number,
            "pin_number" => $this->pin_number,
            "start_date" => $this->start_date,
            "end_date" => $this->end_date,
            "email_verified_at" => $this->email_verified_at,
            "company" => new CompanyResource($this->company),
            "role" => new UserRolePermissionResource($this->role),
            "is_officer" => ($this->is_officer == 1) ? true: false,
            "status" => $this->status,
        ];
    }
}
