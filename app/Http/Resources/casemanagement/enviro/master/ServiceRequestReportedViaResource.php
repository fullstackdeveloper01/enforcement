<?php

namespace App\Http\Resources\casemanagement\enviro\master;

use Illuminate\Http\Resources\Json\JsonResource;

class ServiceRequestReportedViaResource extends JsonResource
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
            "reported_via" => $this->reported_via,
            "is_back_office" => $this->is_back_office,
            "is_online" => $this->is_online,
            "status" => $this->status,
        ];
    }
}
