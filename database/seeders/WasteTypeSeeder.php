<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\casemanagement\enviro\master\WasteType;

class WasteTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
		//First make table empty.
		WasteType::truncate();
        WasteType::insert(array(
            0 => array('waste_type' => 'General', 'status' => '1'),
            1 => array('waste_type' => 'Recycling', 'status' => '1'),
            2 => array('waste_type' => 'Clinical', 'status' => '1'),
            3 => array('waste_type' => 'Tyres', 'status' => '1'),
            4 => array('waste_type' => 'Food', 'status' => '1'),
            5 => array('waste_type' => 'Battery', 'status' => '1'),
        ));
    }
}
