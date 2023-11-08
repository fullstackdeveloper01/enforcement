<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\casemanagement\enviro\master\ServiceRequestClosedCodes;

class ServiceRequestClosedCodesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ServiceRequestClosedCodes::insert(array(
            0 => array('closed_code_type' => 'CL01','closed_code_description'=>'Investigated and No Evidence Found','status' => '1'),
            1 => array('closed_code_type' => 'CL02','closed_code_description'=>'Complaint Withdrawn','status' => '1'),
            2 => array('closed_code_type' => 'CL03','closed_code_description'=>'Fixed Penalty Notice Issued','status' => '1'),
            3 => array('closed_code_type' => 'CL04','closed_code_description'=>'Case Referred for Prosecution','status' => '1'),
            4 => array('closed_code_type' => 'CL05','closed_code_description'=>'Simple Caution Issued','status' => '1'),
            5 => array('closed_code_type' => 'CL06','closed_code_description'=>'Review Permits or Licences','status' => '1'),
            6 => array('closed_code_type' => 'CL07','closed_code_description'=>'Civil Enforcement to be taken','status' => '1'),
            7 => array('closed_code_type' => 'CL08','closed_code_description'=>'Penalty Notice Issued','status' => '1'),
            8 => array('closed_code_type' => 'CL09','closed_code_description'=>'Informal Action Taken','status' => '1'),
            9 => array('closed_code_type' => 'CL10','closed_code_description'=>'Verbal Warning','status' => '1'),
            10 => array('closed_code_type' => 'CL11','closed_code_description'=>'Written Warning','status' => '1'),
            11 => array('closed_code_type' => 'CL12','closed_code_description'=>'Caution Issued with Costs','status' => '1'),
            12 => array('closed_code_type' => 'CL13','closed_code_description'=>'Anti-Social Behaviour Order (ASBO)','status' => '1'),
            13 => array('closed_code_type' => 'CL14','closed_code_description'=>'Legal Notice Issued','status' => '1'),
            14 => array('closed_code_type' => 'CL15','closed_code_description'=>'Repeated Door Knock - No Answer / No Evidence','status' => '1'),
            15 => array('closed_code_type' => 'CL16','closed_code_description'=>'No Waste Found','status' => '1'),
            16 => array('closed_code_type' => 'CL17','closed_code_description'=>'Unable to Trace Person','status' => '1'),
            17 => array('closed_code_type' => 'CL18','closed_code_description'=>'Did not attend PACE Interview','status' => '1'),
            18 => array('closed_code_type' => 'CL19','closed_code_description'=>'Refused to Give Account','status' => '1'),
            19 => array('closed_code_type' => 'CL20','closed_code_description'=>'Section 46 Notice Served','status' => '1'),
            20 => array('closed_code_type' => 'CL21','closed_code_description'=>'Section 47 Notice Served','status' => '1'),
            21 => array('closed_code_type' => 'CL22','closed_code_description'=>'Evidence Found and Enforcement Action to be taken','status' => '1'),
            22 => array('closed_code_type' => 'CL23','closed_code_description'=>'534 Duty of Care Notice Issued','status' => '1'),
            23 => array('closed_code_type' => 'CL24','closed_code_description'=>'Being Investigated On Earlier SR','status' => '1'),
            24 => array('closed_code_type' => 'CL33','closed_code_description'=>'Alleged Offender Mitigation Accepted','status' => '1'),
            25 => array('closed_code_type' => 'CL34','closed_code_description'=>'Time expired','status' => '1')
        ));
    }
}
