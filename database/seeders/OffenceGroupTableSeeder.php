<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\casemanagement\enviro\master\OffenceGroup;

class OffenceGroupTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //First truncate table
		OffenceGroup::truncate();
        OffenceGroup::insert(array(
            0 => array('id' =>1, 'englishName' => 'Littering', 'welshName' => 'Sbwriel'),
            1 => array('id' =>2, 'englishName' => 'PSPO', 'welshName' => 'GDMC (Gorchmynion Diogelu Mannau Cyhoeddus)'),
            2 => array('id' =>3, 'englishName' => 'Graffiti', 'welshName' => 'Graffiti'),
            3 => array('id' =>4, 'englishName' => 'Fly Posting', 'welshName' => 'Postio anghyfreithlon'),
            4 => array('id' =>5, 'englishName' => 'Fly Tipping', 'welshName' => 'Tipio anghyfreithlon'),
            5 => array('id' =>6, 'englishName' => 'Duty Of Care', 'welshName' => 'Dyletswydd Gofal'),
            6 => array('id' =>7, 'englishName' => 'Litter from Vehicles', 'welshName' => 'Sbwriel o gerbyd'),
            7 => array('id' =>8, 'englishName' => 'Free Printed Matter', 'welshName' => 'Mater wedi argraffu'),
            8 => array('id' =>9, 'englishName' => 'Commercial Waste', 'welshName' => 'Gwastraff Masnachol'),
            9 => array('id' =>10, 'englishName' => 'Domestic Waste', 'welshName' => 'Gwastraff Domestig'),
            10 => array('id' =>11, 'englishName' => 'CPN', 'welshName' => 'RPN (Rhybudd Gwarchod Cymunedol)'),
            11 => array('id' =>12, 'englishName' => 'Abandoned Vehicle', 'welshName' => 'Cerbyd wedi ei adael'),
            12 => array('id' =>13, 'englishName' => 'Nuisance Vehicle', 'welshName' => 'Cerbyd niwsans'),
            13 => array('id' =>14, 'englishName' => 'Abandoned Trolleys', 'welshName' => 'Troli wedi ei adael'),
            14 => array('id' =>15, 'englishName' => 'Obstruction of Highways', 'welshName' => 'Rhwystr Priffyrdd'),
            15 => array('id' =>16, 'englishName' => 'London Local Authorities', 'welshName' => 'Awdurdodau Lleol Llundain'),
            16 => array('id' =>17, 'englishName' => 'Warnings', 'welshName' => 'Rhybudd'),
            17 => array('id' =>18, 'englishName' => 'Dog Fouling', 'welshName' => 'Baw Cwn'),
            18 => array('id' =>19, 'englishName' => 'DVLA', 'welshName' => 'Asiantaeth Trwyddedu Gyrwyr a Cherbydau'),
            19 => array('id' =>20, 'englishName' => 'Dog Control Orders', 'welshName' => 'Gorchymyn rheoli cwn'),
            20 => array('id' =>21, 'englishName' => 'Smoke Free (Premises)', 'welshName' => 'Adeilad di-fwg'),
            21 => array('id' =>22, 'englishName' => 'Skips', 'welshName' => 'Sgipiau'),
            22 => array('id' =>23, 'englishName' => 'Smoke Free (Place)', 'welshName' => 'Ardal di-fwg'),
            23 => array('id' =>24, 'englishName' => 'Smoke Free (Vehicle)', 'welshName' => 'Cerbyd di-fwg'),
            24 => array('id' =>25, 'englishName' => 'Littering (Waste)', 'welshName' => 'Sbwriel (Gwastraff)'),
            25 => array('id' =>26, 'englishName' => 'Presentation of Waste', 'welshName' => 'Arddangos Gwastraff'),
            26 => array('id' =>27, 'englishName' => 'Public Urination', 'welshName' => 'Troethi Cyhoeddus'),
            27 => array('id' =>28, 'englishName' => 'Anti-Idling', 'welshName' => 'Gwrth Segura'),
            28 => array('id' =>29, 'englishName' => 'PSPO Hopes Nose', 'welshName' => 'GDMC Hopes Nose'),
            29 => array('id' =>30, 'englishName' => 'Commercial Waste Receptacles', 'welshName' => 'Cynwysyddion Gwastraff Masnachol'),
            30 => array('id' =>31, 'englishName' => 'Transporting Waste', 'welshName' => 'Cludo Gwastraff'),
            31 => array('id' =>32, 'englishName' => 'Nuisance Parking', 'welshName' => 'Parcio Niwsans'),
            32 => array('id' =>33, 'englishName' => 'Test Payment Offence', 'welshName' => 'Tocyn Prawf'),
            33 => array('id' =>34, 'englishName' => 'Displaying Smoke Free Signs', 'welshName' => 'Arddanogs Arwyddion Di-Fwg'),
            34 => array('id' =>35, 'englishName' => 'Street Trading', 'welshName' => ''),
            35 => array('id' =>36, 'englishName' => 'Waste Carrier Licence', 'welshName' => ''),
        ));
    }
}
