<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\casemanagement\enviro\master\ProducedWasteTransfer;

class ProducedWasteTransferSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
		//First make table empty.
		ProducedWasteTransfer::truncate();
        ProducedWasteTransfer::insert(array(
            0 => array('waste_transfer' => 'Failed to Produce Waste Transfer Notes', 'status' => '1'),
            1 => array('waste_transfer' => '1 – 3 months', 'status' => '1'),
            2 => array('waste_transfer' => '3-6 months', 'status' => '1'),
            3 => array('waste_transfer' => '6-9 months', 'status' => '1'),
            4 => array('waste_transfer' => '9 -12 months', 'status' => '1'),
            5 => array('waste_transfer' => '12 months to 18 months', 'status' => '1'),
            6 => array('waste_transfer' => '2 years', 'status' => '1'),
        ));
    }
}
