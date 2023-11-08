<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\casemanagement\enviro\master\RepresentationAcceptReason;

class RepresentationAcceptReasonSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
		//First make table empty.
		RepresentationAcceptReason::truncate();
        RepresentationAcceptReason::insert([
            ['reason' => 'Exemption - Underage', 'status' => '1'],
            ['reason' => 'Exemption - Medical Reasons', 'status' => '1'],
            ['reason' => 'Exemption - Vulnerable', 'status' => '1'],
            ['reason' => 'Council Request', 'status' => '1'],
            ['reason' => 'Not in public interest to Pursue', 'status' => '1'],
            ['reason' => 'District Request', 'status' => '1'],
            ['reason' => 'Evidential Shortfall', 'status' => '1'],
            ['reason' => 'Officer Misconduct', 'status' => '1'],
            ['reason' => 'Valid Waste Transfer Notes Supplied', 'status' => '1'],
            ['reason' => 'COVID 19', 'status' => '1'],
            ['reason' => 'Transfer of Liability', 'status' => '1'],
            ['reason' => 'Re-issued', 'status' => '1'],
            ['reason' => 'Evidence Supplied', 'status' => '1'],
            ['reason' => 'False Identity', 'status' => '1']
        ]);
    }
}
