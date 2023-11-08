<?php

namespace App\Http\Resources\casemanagement\enviro\master;

use Illuminate\Http\Resources\Json\JsonResource;

class OffenceResource extends JsonResource
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            "id"=>$this->id,
            "name" => $this->name,
            "welshName" => $this->welshName,
            "description" => $this->description,
            "welshDescription" => $this->welshDescription,
            "englishLegislation" => $this->engLegislation,
            "welshLegislation" => $this->welLegislation,
            "group" => $this->offenceGroup,
            "minImageRequired" => $this->minImageRequired,
            "maxFine" => $this->maxFine,
            "issueType" => $this->issueType,
            "status" => $this->status,
        ];
    }
    
}
