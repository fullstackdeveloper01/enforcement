<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\casemanagement\enviro\master\ServiceRequestTaskGroup;
use App\Models\casemanagement\enviro\master\TaskTypeTaskGroupMap;


class ServiceRequestTaskGroupSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $serviceRequestTaskGroup = ServiceRequestTaskGroup::create([
            'task_group_name'=>'Test Data 1',
            'status' => '1'
        ]); 
        TaskTypeTaskGroupMap::insert(array(
            0 => array('task_group_id'=> $serviceRequestTaskGroup->id ,'site_id' => '1','task_type_id' => '1'),
            1 => array('task_group_id'=> $serviceRequestTaskGroup->id ,'site_id' => '1','task_type_id' => '2'),
        ));

    }
}
