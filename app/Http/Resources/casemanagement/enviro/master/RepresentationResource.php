<?php

namespace App\Http\Resources\casemanagement\enviro\master;

use Illuminate\Http\Resources\Json\JsonResource;

class RepresentationResource extends JsonResource
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
            "ticket_id"=>$this->ticket_id,
            "fpn_number" => $this->fpn_number,
            "site" => $this->siteData,
            "offence" => $this->enviroData->offence,
            "first_name" => $this->first_name,
            "last_name" => $this->last_name,
            "email" => $this->email,
            "address_line1" => $this->address_line1,
            "city" => $this->city,
            "country" => $this->country,
            "post_code" => $this->post_code,
            "phone" => $this->phone,
            "amount" => $this->amount,
            "reason" => $this->reasonData,
            "appeal_note" => $this->appeal_note,
            "upload" => $this->upload,
            'lodged_status' => $this->lodged_status,
            "accept_statement" => $this->accept_statement,
            "privacy_statement" => $this->privacy_statement,
            "created_at" => $this->created_at
        ];
    }
    
}
