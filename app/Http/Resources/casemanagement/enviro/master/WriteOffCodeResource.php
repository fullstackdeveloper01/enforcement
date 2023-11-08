<?php

namespace App\Http\Resources\casemanagement\enviro\master;

use Illuminate\Http\Resources\Json\JsonResource;

class WriteOffCodeResource extends JsonResource
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
            "type" => $this->type,
            "description" => $this->description,
            "status" => $this->status,
        ];
    }
}