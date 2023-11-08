<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\casemanagement\enviro\master\ServiceRequestType;

class ServiceRequestTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ServiceRequestType::insert(array(
            0 => array('type_name' => 'Fly Tipping','minimum_images_required' => 6,'status' => '1'),
            1 => array('type_name' => 'Household Duty of Care','minimum_images_required' => 1,'status' => '1'),
            2 => array('type_name' => 'Littering','minimum_images_required' => 1,'status' => '1'),
            3 => array('type_name' => 'Commercial Waste','minimum_images_required' => 6,'status' => '1'),
            4 => array('type_name' => 'Domestic Waste','minimum_images_required' => 6,'status' => '1'),
            5 => array('type_name' => 'Vehicle Littering','minimum_images_required' => 0,'status' => '1'),
            6 => array('type_name' => 'Fly Posting','minimum_images_required' => 1,'status' => '1'),
            7 => array('type_name' => 'Abandoned Vehicle','minimum_images_required' => 1,'status' => '1'),
            8 => array('type_name' => 'Duty of Care Visit','minimum_images_required' => 0,'status' => '0'),
            9 => array('type_name' => 'Abandoned Trollies','minimum_images_required' => 2,'status' => '1'),
            10 => array('type_name' => 'Homeless Encampments','minimum_images_required' => 6,'status' => '1'),
            11 => array('type_name' => 'DOC Visit Report','minimum_images_required' => 3,'status' => '1'),
            12 => array('type_name' => 'PSPO Signage','minimum_images_required' => 1,'status' => '1')
        ));
    }
}
