<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\casemanagement\enviro\master\ApplicantType;

class ApplicantTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //First truncate table
		ApplicantType::truncate();
        ApplicantType::insert(array(
            0 => array('applicant_type' => 'Sole Trader', 'status' => '1'),
            1 => array('applicant_type' => 'Individual', 'status' => '1'),
            2 => array('applicant_type' => 'Limited Company', 'status' => '1'),
            3 => array('applicant_type' => 'Partnership', 'status' => '1'),
        ));
    }
}
