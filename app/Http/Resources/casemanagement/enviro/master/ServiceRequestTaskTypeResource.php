<?php

namespace App\Http\Resources\casemanagement\enviro\master;

use Illuminate\Http\Resources\Json\JsonResource;

class ServiceRequestTaskTypeResource extends JsonResource
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
            "id"=>$this->id,
            "site_id" => $this->site_id,
            "task_type_name" => $this->task_type_name,
            "status" => $this->status,
        ];
    }
}
