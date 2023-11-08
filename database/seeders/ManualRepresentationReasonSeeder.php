<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\casemanagement\enviro\master\ManualRepresentationReason;

class ManualRepresentationReasonSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //First truncate table
		ManualRepresentationReason::truncate();
        ManualRepresentationReason::insert([
            0 => [
              'reason' => 'Exemption - Underage',
              'isOnline' => '1',
            ],
            1 => [
              'reason' => 'Complaint - upheld',
              'isOnline' => '1',
            ],
            2 => [
              'reason' => 'Hardship evidence for Extension',
              'isOnline' => '1',
            ],
            3 => [
              'reason' => 'Medical evidence - unwell',
              'isOnline' => '1',
            ],
            4 => [
              'reason' => 'Viewing footage',
              'isOnline' => '1',
            ],
            5 => [
              'reason' => 'RTS',
              'isOnline' => '1',
            ],
            6 => [
              'reason' => 'Investigating',
              'isOnline' => '1',
            ],
            7 => [
              'reason' => 'Representation',
              'isOnline' => '1',
            ],
            8 => [
              'reason' => 'Letter received',
              'isOnline' => '1',
            ],
            9 => [
              'reason' => 'Letter to',
              'isOnline' => '1',
            ],
            10 => [
              'reason' => 'Email received',
              'isOnline' => '1',
            ],
            11 => [
              'reason' => 'Data/Subject Access Request',
              'isOnline' => '1',
            ],
            12 => [
              'reason' => 'Permission received to respond to original representation',
              'isOnline' => '1',
            ],
            13 => [
              'reason' => 'Request Court Hearing',
              'isOnline' => '1',
            ],
            14 => [
              'reason' => 'Exemption - Mental Health',
              'isOnline' => '1',
            ],
            15 => [
              'reason' => 'Exemption - Vulnerable Person',
              'isOnline' => '1',
            ],
            16 => [
              'reason' => 'Exemption - Accidental Littering',
              'isOnline' => '1',
            ],
            17 => [
              'reason' => 'Request - More time to pay the FPN (Financial Hardship)',
              'isOnline' => '1',
            ],
            18 => [
              'reason' => 'I am exempt from the offence',
              'isOnline' => '1',
            ],
            19 => [
              'reason' => 'False Identity',
              'isOnline' => '1',
            ],
            20 => [
              'reason' => 'Alleged offender does not live at address',
              'isOnline' => '1',
            ],
            21 => [
              'reason' => 'Details on Fixed Penalty Notice are incorrect',
              'isOnline' => '1',
            ],
            22 => [
              'reason' => 'I refused to give the officer my details',
              'isOnline' => '1',
            ],
            23 => [
              'reason' => 'I did not know it was an offence',
              'isOnline' => '1',
            ],
            24 => [
              'reason' => 'I did not commit the alleged offence',
              'isOnline' => '1',
            ],
            25 => [
              'reason' => 'Complaint against Enforcement Officer',
              'isOnline' => '1',
            ],
            26 => [
              'reason' => 'Offence Occurred on Private Land',
              'isOnline' => '1',
            ],
            27 => [
              'reason' => 'Not enough bins',
              'isOnline' => '1',
            ],
            28 => [
              'reason' => 'No Signage',
              'isOnline' => '1',
            ],
            29 => [
              'reason' => 'Waste Transfer Notes - Upload Documents',
              'isOnline' => '1',
            ],
            30 => [
              'reason' => 'Broken Social Distancing Rules',
              'isOnline' => '1',
            ],
        ]);
    }
}
