<?php

namespace App\Http\Resources\casemanagement\enviro\master;

use Illuminate\Http\Resources\Json\JsonResource;

class ServiceRequestTypeResource extends JsonResource
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
            "type_name" => $this->type_name,
            "minimum_images_required" => $this->minimum_images_required,
            "status" => $this->status,
        ];
    }
}
