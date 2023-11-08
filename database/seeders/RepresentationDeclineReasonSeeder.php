<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\casemanagement\enviro\master\RepresentationDeclineReason;

class RepresentationDeclineReasonSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
		//First make table empty.
		RepresentationDeclineReason::truncate();
        RepresentationDeclineReason::insert([
            0 => array('reason' => 'Declined - Exemption - Underage', 'status' => '1'),
            1 => array('reason' => 'Declined - Exemption - Mental Health', 'status' => '1'),
            2 => array('reason' => 'Declined - Exemption - Vulnerable Person', 'status' => '1'),
            3 => array('reason' => 'Declined - Exemption - Accidental Littering', 'status' => '1'),
            4 => array('reason' => 'Declined - More time to pay the FPN (Financial Hardship)', 'status' => '1'),
            5 => array('reason' => 'Declined - I am exempt from the offence', 'status' => '1'),
            6 => array('reason' => 'Declined - False Identity', 'status' => '1'),
            7 => array('reason' => 'Declined - Alleged offender does not live at address', 'status' => '1'),
            8 => array('reason' => 'Declined - Details on Fixed Penalty Notice are incorrect', 'status' => '1'),
            9 => array('reason' => 'Declined - I refused to give the officer my details', 'status' => '1'),
            10 => array('reason' => 'Declined - I did not know it was an offence', 'status' => '1'),
            11 => array('reason' => 'Declined - I did not commit the alleged offence', 'status' => '1'),
            12 => array('reason' => 'Declined - Complaint against Enforcement Officer', 'status' => '1'),
            13 => array('reason' => 'Declined - Offence occurred on Private Land', 'status' => '1'),
            14 => array('reason' => 'Declined - Not enough bins', 'status' => '1'),
            15 => array('reason' => 'Declined - No Signage', 'status' => '1'),
            16 => array('reason' => 'Declined - Other Reason', 'status' => '1'),
            17 => array('reason' => 'Declined - Failed to Provide Waste Transfer Notes', 'status' => '1'),
            18 => array('reason' => 'FINAL RESPONSE', 'status' => '1'),
            19 => array('reason' => 'Awaiting permission to respond', 'status' => '1'),
            20 => array('reason' => 'Maximum Extension', 'status' => '1'),
            21 => array('reason' => 'FINAL RESPONSE & Maximum Extension', 'status' => '1'),
        ]);
    }
}
