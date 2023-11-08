<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\casemanagement\enviro\master\ServiceRequestTaskType;

class ServiceRequestTaskTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ServiceRequestTaskType::insert(array(
            0 => array('site_id' => '1','task_type_name'=>'Photographs','status' => '1'),
            1 => array('site_id' => '1','task_type_name'=>'Door to Door Enquiries','status' => '1'),
            2 => array('site_id' => '1','task_type_name'=>'Examine Waste','status' => '1'),
            3 => array('site_id' => '1','task_type_name'=>'Door Step Interview','status' => '1'),
            4 => array('site_id' => '1','task_type_name'=>'Recorded Interview','status' => '1'),
            5 => array('site_id' => '1','task_type_name'=>'Public Data - Waste Carriers','status' => '1'),
            6 => array('site_id' => '1','task_type_name'=>'Google Search','status' => '1'),
            7 => array('site_id' => '1','task_type_name'=>'Social Media Search','status' => '1'),
            8 => array('site_id' => '1','task_type_name'=>'Business Rates','status' => '1'),
            9 => array('site_id' => '1','task_type_name'=>'Sketch Plan','status' => '1'),
            10 => array('site_id' => '1','task_type_name'=>'Examine Waste Receptacle','status' => '1'),
            11 => array('site_id' => '1','task_type_name'=>'Check Waste Management Agreement','status' => '1'),
            12 => array('site_id' => '1','task_type_name'=>'Check Waste Transfer Notes','status' => '1'),
            13 => array('site_id' => '1','task_type_name'=>'Letter under Caution','status' => '1'),
            14 => array('site_id' => '1','task_type_name'=>'Google Search','status' => '1'),
            15 => array('site_id' => '1','task_type_name'=>'Companies House Search','status' => '1'),
            16 => array('site_id' => '1','task_type_name'=>'DVLA','status' => '1'),
            17 => array('site_id' => '1','task_type_name'=>'Homeless Encampments','status' => '1'),
            18 => array('site_id' => '1','task_type_name'=>'Fly Tipping','status' => '1'),
            19 => array('site_id' => '1','task_type_name'=>'Domestic Waste','status' => '1'),
            20 => array('site_id' => '1','task_type_name'=>'Duty of Care','status' => '1')
        ));
    }
}
