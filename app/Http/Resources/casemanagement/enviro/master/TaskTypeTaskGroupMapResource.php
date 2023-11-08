<?php

namespace App\Http\Resources\casemanagement\enviro\master;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\setup\SiteResource;

class TaskTypeTaskGroupMapResource extends JsonResource
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
            "task_group_id" => $this->task_group_id,
            "site_id" => $this->site_id,
            "task_type_id" => $this->task_type_id,
            'sites' => new SiteResource($this->taskSite)
        ];
    }
}
