<?php

namespace App\Http\Resources\setup;

use Illuminate\Http\Resources\Json\JsonResource;

class SiteResource extends JsonResource
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
            "slug" => $this->slug,
            "logo" => $this->logo,
            "geographical_area" => $this->geographical_area_id,
            "address_line1" => $this->address_line1,
            "address_line2" => $this->address_line2,
            "address_line3" => $this->address_line3,
            "address_line4" => $this->address_line4,
            "district" => $this->district,
            "town" => $this->town,
            "postal_code" => $this->postal_code,
            "county" => $this->county,
            "country" => $this->country,
            "geo_color" => $this->geo_color,
            "region_id" => $this->region_id,
            "notice_charge_amount_reduced" => $this->notice_charge_amount_reduced,
            "notice_charge_days_reduced" => $this->notice_charge_days_reduced,
            "notice_charge_amount_full" => $this->notice_charge_amount_full,
            "notice_charge_days_full" => $this->notice_charge_days_full,
            "default_extension_days" => $this->default_extension_days,
            "gdpr_url_expiry_hours" => $this->gdpr_url_expiry_hours,
            "status" => ($this->status == '1') ? true : false,
        ];
    }
}
