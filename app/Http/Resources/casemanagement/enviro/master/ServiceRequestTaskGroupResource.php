<?php

namespace App\Http\Resources\casemanagement\enviro\master;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\casemanagement\enviro\master\TaskTypeTaskGroupMapResource;

class ServiceRequestTaskGroupResource extends JsonResource
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
            "task_group_name" => $this->task_group_name,
            "status" => $this->status,
            "task_type_task_group" => TaskTypeTaskGroupMapResource::collection($this->taskType)
        ];
    }
}
