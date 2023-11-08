<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\casemanagement\enviro\master\PositionOfEmployment;

class PostitonOfEmploymentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        PositionOfEmployment::insert(array(
            0 => array('position_of_employment' => 'Environmental Enforcement Officer','status' => '1'),
            1 => array('position_of_employment' => 'Administrator','status' => '1'),
        ));
    }
}
