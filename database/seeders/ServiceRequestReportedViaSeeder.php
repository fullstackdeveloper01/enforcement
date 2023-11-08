<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\casemanagement\enviro\master\ServiceRequestReportedVia;

class ServiceRequestReportedViaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ServiceRequestReportedVia::insert(array(
            0 => array('reported_via' => 'Online','is_back_office' => '0','is_online' => '1','status' => '1'),
            1 => array('reported_via' => 'Telephone','is_back_office' => '1','is_online' => '0','status' => '1'),
            2 => array('reported_via' => 'Email','is_back_office' => '1','is_online' => '0','status' => '1'),
            3 => array('reported_via' => 'At Office','is_back_office' => '1','is_online' => '0','status' => '1'),
            4 => array('reported_via' => 'Letter of complaint','is_back_office' => '1','is_online' => '0','status' => '1'),
            5 => array('reported_via' => 'Corporate Complaint','is_back_office' => '1','is_online' => '0','status' => '1'),
            6 => array('reported_via' => 'Elected Member','is_back_office' => '1','is_online' => '0','status' => '1'),
            7 => array('reported_via' => 'Enforcement Officer','is_back_office' => '0','is_online' => '0','status' => '1'),
            8 => array('reported_via' => 'Officer','is_back_office' => '1','is_online' => '0','status' => '1')
        ));
    }
}
