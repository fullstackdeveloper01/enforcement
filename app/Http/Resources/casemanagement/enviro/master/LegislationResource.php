<?php

namespace App\Http\Resources\casemanagement\enviro\master;

use Illuminate\Http\Resources\Json\JsonResource;

class LegislationResource extends JsonResource
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
            "title" => $this->title,
            "legislation" => $this->legislation,
            "language" => $this->language,
            "offenceSpecificText" => $this->offenceSpecificText,
            "status" => $this->status,
        ];
    }
}
