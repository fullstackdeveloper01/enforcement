<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\casemanagement\enviro\master\Offence;
use App\Models\casemanagement\enviro\master\OffenceLocationPrefix;
use App\Models\casemanagement\enviro\master\OffenceLocationSuffix;
use App\Models\casemanagement\enviro\master\OffenceHow;
use App\Models\casemanagement\enviro\master\AddressVerifiedBy;
use App\Models\casemanagement\enviro\master\Ethnicity;
use App\Models\casemanagement\enviro\master\Weather;
use App\Models\casemanagement\enviro\master\OffenderHairColour;
use App\Models\casemanagement\enviro\master\OffenderBuild;
use App\Models\casemanagement\enviro\master\IdShown;
use App\Models\casemanagement\enviro\master\Visibility;
use App\Models\casemanagement\enviro\master\WriteOffCode;
use App\Models\casemanagement\enviro\master\CancelCode;
use App\Models\casemanagement\enviro\master\PaymentMethod;
use App\Models\casemanagement\enviro\master\Legislation;
use App\Models\casemanagement\enviro\master\TypeOfLand;
use App\Models\casemanagement\enviro\master\TypeOfDog;
use App\Models\casemanagement\enviro\master\DogSize;
use App\Models\casemanagement\enviro\master\DogUnderControl;
use App\Models\casemanagement\enviro\Enviro;
use App\Models\casemanagement\enviro\Offender;

class LovSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
		//First make table empty.
		Offence::truncate();
		OffenceLocationPrefix::truncate();
		OffenceHow::truncate();
		AddressVerifiedBy::truncate();
		Ethnicity::truncate();
		OffenceLocationSuffix::truncate();
		Weather::truncate();
		OffenderHairColour::truncate();
		OffenderBuild::truncate();
		IdShown::truncate();
		Visibility::truncate();
		WriteOffCode::truncate();
		CancelCode::truncate();
		PaymentMethod::truncate();
		Legislation::truncate();
		TypeOfLand::truncate();
		TypeOfDog::truncate();
		DogSize::truncate();
		DogUnderControl::truncate();
		Enviro::truncate();
		Offender::truncate();

		// OFFENCE Type
        Offence::insert(array(
			array('name' => 'Cigarette Butt', 'group' => '1', 'englishLegislation' => '1', 'welshLegislation' => '2', 'issueType' => '1', 'minImageRequired' => '1', 'maxFine' => '2500'),
			array('name' => 'Rolled up cigarette', 'group' => '1', 'englishLegislation' => '1', 'welshLegislation' => '2', 'issueType' => '1', 'minImageRequired' => '1', 'maxFine' => '2500'),
			array('name' => 'Dog Fouling', 'group' => '17', 'englishLegislation' => '3', 'welshLegislation' => '8', 'issueType' => '1', 'minImageRequired' => '1', 'maxFine' => '2500'),
			array('name' => 'Graffiti', 'group' => '3', 'englishLegislation' => '5', 'welshLegislation' => '6', 'issueType' => '1', 'minImageRequired' => '1', 'maxFine' => '2500'),
			array('name' => 'Fly Posting', 'group' => '4', 'englishLegislation' => '4', 'welshLegislation' => '7', 'issueType' => '1', 'minImageRequired' => '1', 'maxFine' => '2500'),
			array('name' => 'Business DOC FPN', 'group' => '6', 'englishLegislation' => '47', 'welshLegislation' => '10', 'issueType' => '1', 'minImageRequired' => '1', 'maxFine' => '2500'),
			array('name' => 'Cigarette', 'group' => '1', 'englishLegislation' => '1', 'welshLegislation' => '2', 'issueType' => '1', 'minImageRequired' => '1', 'maxFine' => '2500'),
			array('name' => 'Spitting', 'group' => '1', 'englishLegislation' => '1', 'welshLegislation' => '2', 'issueType' => '1', 'minImageRequired' => '1', 'maxFine' => '2500'),
			array('name' => 'Confectionary Packs', 'group' => '1', 'englishLegislation' => '1', 'welshLegislation' => '2', 'issueType' => '1', 'minImageRequired' => '1', 'maxFine' => '2500'),
			array('name' => 'Packaging', 'group' => '1', 'englishLegislation' => '1', 'welshLegislation' => '2', 'issueType' => '1', 'minImageRequired' => '1', 'maxFine' => '2500'),
			array('name' => 'Snack Packs', 'group' => '1', 'englishLegislation' => '1', 'welshLegislation' => '2', 'issueType' => '1', 'minImageRequired' => '1', 'maxFine' => '2000'),
			array('name' => 'Non-Alcoholic Drinks Related', 'group' => '1', 'englishLegislation' => '1', 'welshLegislation' => '2', 'issueType' => '1', 'minImageRequired' => '1', 'maxFine' => '2000'),
			array('name' => 'Fast Food Related', 'group' => '1', 'englishLegislation' => '1', 'welshLegislation' => '2', 'issueType' => '1', 'minImageRequired' => '1', 'maxFine' => '2000'),
			array('name' => 'Discarded Food', 'group' => '1', 'englishLegislation' => '1', 'welshLegislation' => '2', 'issueType' => '1', 'minImageRequired' => '1', 'maxFine' => '2000'),
			array('name' => 'Alcoholic Drinks', 'group' => '1', 'englishLegislation' => '1', 'welshLegislation' => '2', 'issueType' => '1', 'minImageRequired' => '1', 'maxFine' => '2000'),
			array('name' => 'Printed Literature', 'group' => '1', 'englishLegislation' => '1', 'welshLegislation' => '2', 'issueType' => '1', 'minImageRequired' => '1', 'maxFine' => '2000'),
			array('name' => 'Bag containing Dog Faeces', 'group' => '1', 'englishLegislation' => '1', 'welshLegislation' => '2', 'issueType' => '1', 'minImageRequired' => '1', 'maxFine' => '2000'),
			array('name' => 'Other Litter', 'group' => '1', 'englishLegislation' => '1', 'welshLegislation' => '2', 'issueType' => '1', 'minImageRequired' => '1', 'maxFine' => '2000'),
			array('name' => 'Soft Drink Can', 'group' => '1', 'englishLegislation' => '1', 'welshLegislation' => '2', 'issueType' => '1', 'minImageRequired' => '1', 'maxFine' => '2000'),
			array('name' => 'Soft Drink Bottle', 'group' => '1', 'englishLegislation' => '1', 'welshLegislation' => '2', 'issueType' => '1', 'minImageRequired' => '1', 'maxFine' => '2000'),
			array('name' => 'Scratch Card', 'group' => '1', 'englishLegislation' => '1', 'welshLegislation' => '2', 'issueType' => '1', 'minImageRequired' => '1', 'maxFine' => '2000'),
			array('name' => 'Chewing Gum', 'group' => '1', 'englishLegislation' => '1', 'welshLegislation' => '2', 'issueType' => '1', 'minImageRequired' => '1', 'maxFine' => '1000'),
			array('name' => 'Other Offence', 'group' => '1', 'englishLegislation' => '1', 'welshLegislation' => '2', 'issueType' => '1', 'minImageRequired' => '1', 'maxFine' => '1000'),
			array('name' => 'Littering (W)', 'group' => '17', 'englishLegislation' => '37', 'welshLegislation' => '10000', 'issueType' => '2', 'minImageRequired' => '1', 'maxFine' => '1000'),
			array('name' => 'Cigar', 'group' => '1', 'englishLegislation' => '1', 'welshLegislation' => '2', 'issueType' => '1', 'minImageRequired' => '1', 'maxFine' => '1000'),
			array('name' => 'Dogs on Lead by Direction', 'group' => '2', 'englishLegislation' => '25', 'welshLegislation' => '26', 'issueType' => '1', 'minImageRequired' => '1', 'maxFine' => '1000'),
			array('name' => 'Dogs on Leads', 'group' => '2', 'englishLegislation' => '25', 'welshLegislation' => '26', 'issueType' => '1', 'minImageRequired' => '1', 'maxFine' => '1000'),
			array('name' => 'Dogs Exclusion Zones', 'group' => '2', 'englishLegislation' => '25', 'welshLegislation' => '26', 'issueType' => '1', 'minImageRequired' => '1', 'maxFine' => '1000'),
			array('name' => 'Maximum Number of Dogs', 'group' => '2', 'englishLegislation' => '25', 'welshLegislation' => '26', 'issueType' => '1', 'minImageRequired' => '1', 'maxFine' => '1000'),
			array('name' => 'Dog Bags', 'group' => '2', 'englishLegislation' => '25', 'welshLegislation' => '26', 'issueType' => '1', 'minImageRequired' => '1', 'maxFine' => '1000'),
			array('name' => 'Sweet Wrapper', 'group' => '1', 'englishLegislation' => '1', 'welshLegislation' => '2', 'issueType' => '1', 'minImageRequired' => '1', 'maxFine' => '1000'),
			array('name' => 'na', 'group' => '1', 'englishLegislation' => '1', 'welshLegislation' => '2', 'issueType' => '1', 'minImageRequired' => '1', 'maxFine' => '1000'),
			array('name' => 'Bottle', 'group' => '1', 'englishLegislation' => '1', 'welshLegislation' => '2', 'issueType' => '1', 'minImageRequired' => '1', 'maxFine' => '1000'),
			array('name' => 'Dog Fouling (W)', 'group' => '17', 'englishLegislation' => '38', 'welshLegislation' => '10000', 'issueType' => '2', 'minImageRequired' => '1', 'maxFine' => '1000'),
			array('name' => 'Dogs on Lead by Direction (W)', 'group' => '17', 'englishLegislation' => '42', 'welshLegislation' => '10000', 'issueType' => '2', 'minImageRequired' => '1', 'maxFine' => '1000'),
			array('name' => 'Dogs On Leads (W)', 'group' => '17', 'englishLegislation' => '41', 'welshLegislation' => '10000', 'issueType' => '2', 'minImageRequired' => '1', 'maxFine' => '1000'),
			array('name' => 'Dogs Exclusion Zones (W)', 'group' => '17', 'englishLegislation' => '40', 'welshLegislation' => '10000', 'issueType' => '2', 'minImageRequired' => '1', 'maxFine' => '1000'),
			array('name' => 'Maximum Number of Dogs (W)', 'group' => '17', 'englishLegislation' => '43', 'welshLegislation' => '10000', 'issueType' => '2', 'minImageRequired' => '1', 'maxFine' => '1000'),
			array('name' => 'Bottle Top', 'group' => '1', 'englishLegislation' => '1', 'welshLegislation' => '2', 'issueType' => '1', 'minImageRequired' => '1', 'maxFine' => '1000'),
			array('name' => 'Cigarette (V) - Company Vehicle', 'group' => '24', 'englishLegislation' => '44', 'welshLegislation' => '10000', 'issueType' => '1', 'minImageRequired' => '1', 'maxFine' => '1000'),
			array('name' => 'Dog Fouling (PSPO)', 'group' => '2', 'englishLegislation' => '25', 'welshLegislation' => '10000', 'issueType' => '1', 'minImageRequired' => '1', 'maxFine' => '1000'),
			array('name' => 'Dog Fouling (DCO)', 'group' => '20', 'englishLegislation' => '46', 'welshLegislation' => '10000', 'issueType' => '1', 'minImageRequired' => '1', 'maxFine' => '1000'),
			array('name' => 'Dogs on Leads (DCO)', 'group' => '20', 'englishLegislation' => '46', 'welshLegislation' => '10000', 'issueType' => '1', 'minImageRequired' => '1', 'maxFine' => '1000'),
			array('name' => 'Dogs on Leads by Direction (DCO)', 'group' => '20', 'englishLegislation' => '46', 'welshLegislation' => '10000', 'issueType' => '1', 'minImageRequired' => '1', 'maxFine' => '1000'),
			array('name' => 'Rolled Up Cigarette (V) - Heavy Goods Vehicle', 'group' => '24', 'englishLegislation' => '44', 'welshLegislation' => '10000', 'issueType' => '1', 'minImageRequired' => '1', 'maxFine' => '1000'),
			array('name' => 'Cigar (V) - Private Hire Taxi', 'group' => '24', 'englishLegislation' => '44', 'welshLegislation' => '10000', 'issueType' => '1', 'minImageRequired' => '1', 'maxFine' => '500'),
			array('name' => 'Cigarette (P)', 'group' => '23', 'englishLegislation' => '44', 'welshLegislation' => '10000', 'issueType' => '1', 'minImageRequired' => '1', 'maxFine' => '500'),
			array('name' => 'Rolled Up Cigarette (P)', 'group' => '23', 'englishLegislation' => '44', 'welshLegislation' => '10000', 'issueType' => '1', 'minImageRequired' => '1', 'maxFine' => '500'),
			array('name' => 'Cigar (P)', 'group' => '23', 'englishLegislation' => '44', 'welshLegislation' => '10000', 'issueType' => '1', 'minImageRequired' => '1', 'maxFine' => '500'),
			array('name' => 'Cigarette (PR)', 'group' => '21', 'englishLegislation' => '44', 'welshLegislation' => '10000', 'issueType' => '1', 'minImageRequired' => '1', 'maxFine' => '500'),
			array('name' => 'Rolled Up Cigarette (PR)', 'group' => '21', 'englishLegislation' => '44', 'welshLegislation' => '10000', 'issueType' => '1', 'minImageRequired' => '1', 'maxFine' => '500'),
			array('name' => 'Cigar (PR)', 'group' => '21', 'englishLegislation' => '44', 'welshLegislation' => '10000', 'issueType' => '1', 'minImageRequired' => '1', 'maxFine' => '500'),
			array('name' => 'Cigarette (V) - Private Hire Taxi', 'group' => '24', 'englishLegislation' => '44', 'welshLegislation' => '10000', 'issueType' => '1', 'minImageRequired' => '1', 'maxFine' => '500'),
			array('name' => 'Cigarette (V) - Hackney Taxi', 'group' => '24', 'englishLegislation' => '44', 'welshLegislation' => '10000', 'issueType' => '1', 'minImageRequired' => '1', 'maxFine' => '500'),
			array('name' => 'Cigarette (V) - Bus', 'group' => '24', 'englishLegislation' => '44', 'welshLegislation' => '10000', 'issueType' => '1', 'minImageRequired' => '1', 'maxFine' => '500'),
			array('name' => 'Cigarette (V) - Coach', 'group' => '24', 'englishLegislation' => '44', 'welshLegislation' => '10000', 'issueType' => '1', 'minImageRequired' => '1', 'maxFine' => '500'),
			array('name' => 'Cigarette (v) - Mini Bus', 'group' => '24', 'englishLegislation' => '44', 'welshLegislation' => '10000', 'issueType' => '1', 'minImageRequired' => '1', 'maxFine' => '500'),
			array('name' => 'Rolled Up Cigarette (V) - Company Vehicle', 'group' => '24', 'englishLegislation' => '44', 'welshLegislation' => '10000', 'issueType' => '1', 'minImageRequired' => '1', 'maxFine' => '500'),
			array('name' => 'Rolled Up Cigarette (V) - Private Hire Taxi', 'group' => '24', 'englishLegislation' => '44', 'welshLegislation' => '10000', 'issueType' => '1', 'minImageRequired' => '1', 'maxFine' => '500'),
			array('name' => 'Rolled Up Cigarette (V) - Hackney Taxi', 'group' => '24', 'englishLegislation' => '44', 'welshLegislation' => '10000', 'issueType' => '1', 'minImageRequired' => '1', 'maxFine' => '500'),
			array('name' => 'Rolled Up Cigarette (V) - Bus', 'group' => '24', 'englishLegislation' => '44', 'welshLegislation' => '10000', 'issueType' => '1', 'minImageRequired' => '1', 'maxFine' => '500'),
			array('name' => 'Rolled Up Cigarette (V) - Mini Bus', 'group' => '23', 'englishLegislation' => '44', 'welshLegislation' => '10000', 'issueType' => '1', 'minImageRequired' => '1', 'maxFine' => '500'),
			array('name' => 'Rolled Up Cigarette (V) - Van', 'group' => '24', 'englishLegislation' => '44', 'welshLegislation' => '10000', 'issueType' => '1', 'minImageRequired' => '1', 'maxFine' => '500'),
			array('name' => 'Cigarette (V) - heavy goods vehicle', 'group' => '24', 'englishLegislation' => '44', 'welshLegislation' => '10000', 'issueType' => '1', 'minImageRequired' => '1', 'maxFine' => '500'),
			array('name' => 'Cigarette (V) - Van', 'group' => '24', 'englishLegislation' => '44', 'welshLegislation' => '10000', 'issueType' => '1', 'minImageRequired' => '1', 'maxFine' => '500'),
			array('name' => 'Cigar (V) - Company Vehicle', 'group' => '24', 'englishLegislation' => '44', 'welshLegislation' => '10000', 'issueType' => '1', 'minImageRequired' => '1', 'maxFine' => '500'),
			array('name' => 'Cigar (V) - Hackney Taxi', 'group' => '24', 'englishLegislation' => '44', 'welshLegislation' => '10000', 'issueType' => '1', 'minImageRequired' => '1', 'maxFine' => '500'),
			array('name' => 'Cigar (V) - Van', 'group' => '24', 'englishLegislation' => '44', 'welshLegislation' => '10000', 'issueType' => '1', 'minImageRequired' => '1', 'maxFine' => '500'),
			array('name' => 'Cigar (V) - Heavy Goods Vehicle', 'group' => '24', 'englishLegislation' => '44', 'welshLegislation' => '10000', 'issueType' => '1', 'minImageRequired' => '1', 'maxFine' => '500'),
			array('name' => 'Cigar (V) - Bus', 'group' => '24', 'englishLegislation' => '44', 'welshLegislation' => '10000', 'issueType' => '1', 'minImageRequired' => '1', 'maxFine' => '500'),
			array('name' => 'Cigar (V) - Mini Bus', 'group' => '24', 'englishLegislation' => '44', 'welshLegislation' => '10000', 'issueType' => '1', 'minImageRequired' => '1', 'maxFine' => '500'),
			array('name' => 'Cigar (V) - Large Good Vehicle', 'group' => '24', 'englishLegislation' => '44', 'welshLegislation' => '10000', 'issueType' => '1', 'minImageRequired' => '1', 'maxFine' => '1500'),
			array('name' => 'Rolled Up Cigarette (V) - Large Goods Vehicle', 'group' => '24', 'englishLegislation' => '44', 'welshLegislation' => '10000', 'issueType' => '1', 'minImageRequired' => '1', 'maxFine' => '1500'),
			array('name' => 'Cigarette (V) - Large Good Vehicle', 'group' => '24', 'englishLegislation' => '44', 'welshLegislation' => '10000', 'issueType' => '1', 'minImageRequired' => '1', 'maxFine' => '1500'),
			array('name' => 'Cigar (V) - Coach', 'group' => '24', 'englishLegislation' => '44', 'welshLegislation' => '10000', 'issueType' => '1', 'minImageRequired' => '1', 'maxFine' => '1500'),
			array('name' => 'Rolled Up Cigarette (V) - Coach', 'group' => '24', 'englishLegislation' => '44', 'welshLegislation' => '10000', 'issueType' => '1', 'minImageRequired' => '1', 'maxFine' => '1500'),
			array('name' => 'Rolled Up Cigarette - Heavy Goods Vehicle', 'group' => '24', 'englishLegislation' => '44', 'welshLegislation' => '10000', 'issueType' => '1', 'minImageRequired' => '1', 'maxFine' => '1500'),
			array('name' => 'Cigar - Private Hire Taxi', 'group' => '24', 'englishLegislation' => '44', 'welshLegislation' => '10000', 'issueType' => '1', 'minImageRequired' => '1', 'maxFine' => '1500'),
			array('name' => 'Street Drinking', 'group' => '2', 'englishLegislation' => '25', 'welshLegislation' => '10000', 'issueType' => '1', 'minImageRequired' => '1', 'maxFine' => '1500'),
			array('name' => 'Failing to Surrender Alcohol', 'group' => '2', 'englishLegislation' => '25', 'welshLegislation' => '10000', 'issueType' => '1', 'minImageRequired' => '1', 'maxFine' => '1500'),
			array('name' => 'Business DOC 2', 'group' => '6', 'englishLegislation' => '27', 'welshLegislation' => '28', 'issueType' => '2', 'minImageRequired' => '1', 'maxFine' => '1500'),
			array('name' => 'Commercial Waste 2', 'group' => '29', 'englishLegislation' => '17', 'welshLegislation' => '10000', 'issueType' => '2', 'minImageRequired' => '1', 'maxFine' => '1500'),
			array('name' => 'Commercial Waste FPN', 'group' => '29', 'englishLegislation' => '17', 'welshLegislation' => '10000', 'issueType' => '1', 'minImageRequired' => '1', 'maxFine' => '1500'),
			array('name' => 'Household Duty of Care', 'group' => '6', 'englishLegislation' => '9', 'welshLegislation' => '10000', 'issueType' => '2', 'minImageRequired' => '1', 'maxFine' => '1500'),
			array('name' => 'Fly Tipping Business', 'group' => '5', 'englishLegislation' => '11', 'welshLegislation' => '10000', 'issueType' => '1', 'minImageRequired' => '1', 'maxFine' => '1500'),
			array('name' => 'Fly Tipping Domestic', 'group' => '5', 'englishLegislation' => '11', 'welshLegislation' => '10000', 'issueType' => '1', 'minImageRequired' => '1', 'maxFine' => '1500'),
			array('name' => 'Domestic Waste', 'group' => '10', 'englishLegislation' => '19', 'welshLegislation' => '10000', 'issueType' => '1', 'minImageRequired' => '1', 'maxFine' => '1500'),
			array('name' => 'Residential Duty of Care', 'group' => '6', 'englishLegislation' => '9', 'welshLegislation' => '10000', 'issueType' => '1', 'minImageRequired' => '1', 'maxFine' => '1500'),
			array('name' => 'Cardboard Box', 'group' => '25', 'englishLegislation' => '1', 'welshLegislation' => '10000', 'issueType' => '1', 'minImageRequired' => '1', 'maxFine' => '1500'),
			array('name' => 'Black Bag - Domestic', 'group' => '25', 'englishLegislation' => '1', 'welshLegislation' => '10000', 'issueType' => '1', 'minImageRequired' => '1', 'maxFine' => '1500'),
			array('name' => 'Black Bag - Business', 'group' => '25', 'englishLegislation' => '1', 'welshLegislation' => '10000', 'issueType' => '1', 'minImageRequired' => '1', 'maxFine' => '1500'),
			array('name' => 'Black Bag - Other', 'group' => '25', 'englishLegislation' => '1', 'welshLegislation' => '10000', 'issueType' => '1', 'minImageRequired' => '1', 'maxFine' => '1500'),
			array('name' => 'Small Box', 'group' => '25', 'englishLegislation' => '1', 'welshLegislation' => '10000', 'issueType' => '1', 'minImageRequired' => '1', 'maxFine' => '1500'),
			array('name' => 'Obstruction of Highways - Other', 'group' => '15', 'englishLegislation' => '49', 'welshLegislation' => '10000', 'issueType' => '1', 'minImageRequired' => '1', 'maxFine' => '1500'),
			array('name' => 'Obstruction of Highways - Domestic', 'group' => '15', 'englishLegislation' => '49', 'welshLegislation' => '10000', 'issueType' => '1', 'minImageRequired' => '1', 'maxFine' => '1500'),
			array('name' => 'Obstruction of Highways - Business', 'group' => '15', 'englishLegislation' => '49', 'welshLegislation' => '10000', 'issueType' => '1', 'minImageRequired' => '1', 'maxFine' => '1500'),
			array('name' => 'Coffee Cup', 'group' => '1', 'englishLegislation' => '1', 'welshLegislation' => '10000', 'issueType' => '1', 'minImageRequired' => '1', 'maxFine' => '1500'),
			array('name' => 'Presentation of Waste (Residential)', 'group' => '26', 'englishLegislation' => '50', 'welshLegislation' => '51', 'issueType' => '1', 'minImageRequired' => '1', 'maxFine' => '1500'),
			array('name' => 'Public Urination', 'group' => '26', 'englishLegislation' => '1', 'welshLegislation' => '2', 'issueType' => '1', 'minImageRequired' => '1', 'maxFine' => '1500'),
			array('name' => 'Pink Bag', 'group' => '25', 'englishLegislation' => '1', 'welshLegislation' => '10000', 'issueType' => '1', 'minImageRequired' => '1', 'maxFine' => '1500'),
			array('name' => 'Littering from Vehicles', 'group' => '7', 'englishLegislation' => '35', 'welshLegislation' => '2', 'issueType' => '1', 'minImageRequired' => '1', 'maxFine' => '1500'),
			array('name' => 'Anti-Idling', 'group' => '27', 'englishLegislation' => '52', 'welshLegislation' => '10000', 'issueType' => '1', 'minImageRequired' => '1', 'maxFine' => '1500'),
			array('name' => 'Canterbury City PSPO', 'group' => '2', 'englishLegislation' => '25', 'welshLegislation' => '10000', 'issueType' => '1', 'minImageRequired' => '1', 'maxFine' => '1500'),
			array('name' => 'Canterbury Coastal PSPO', 'group' => '2', 'englishLegislation' => '25', 'welshLegislation' => '10000', 'issueType' => '1', 'minImageRequired' => '1', 'maxFine' => '1500'),
			array('name' => 'Public Spaces Protection Order (Gas Canisters)', 'group' => '2', 'englishLegislation' => '25', 'welshLegislation' => '10000', 'issueType' => '1', 'minImageRequired' => '1', 'maxFine' => '1500'),
			array('name' => 'Mackerel', 'group' => '28', 'englishLegislation' => '25', 'welshLegislation' => '10000', 'issueType' => '1', 'minImageRequired' => '1', 'maxFine' => '1500'),
			array('name' => 'Caught Fish', 'group' => '28', 'englishLegislation' => '25', 'welshLegislation' => '10000', 'issueType' => '1', 'minImageRequired' => '1', 'maxFine' => '1500'),
			array('name' => 'Transporting Waste', 'group' => '30', 'englishLegislation' => '54', 'welshLegislation' => '10000', 'issueType' => '1', 'minImageRequired' => '1', 'maxFine' => '1500'),
			array('name' => 'Nuisance Parking', 'group' => '31', 'englishLegislation' => '23', 'welshLegislation' => '10000', 'issueType' => '1', 'minImageRequired' => '1', 'maxFine' => '1500'),
			array('name' => 'PSPO non-compliance', 'group' => '2', 'englishLegislation' => '25', 'welshLegislation' => '10000', 'issueType' => '1', 'minImageRequired' => '1', 'maxFine' => '1500'),
			array('name' => 'Public Urination - Littering', 'group' => '1', 'englishLegislation' => '1', 'welshLegislation' => '10000', 'issueType' => '1', 'minImageRequired' => '1', 'maxFine' => '1500'),
			array('name' => 'Rough Sleeping - 2', 'group' => '2', 'englishLegislation' => '25', 'welshLegislation' => '10000', 'issueType' => '2', 'minImageRequired' => '1', 'maxFine' => '1300'),
			array('name' => 'Test Payment Offence', 'group' => '32', 'englishLegislation' => '1', 'welshLegislation' => '2', 'issueType' => '1', 'minImageRequired' => '1', 'maxFine' => '1300'),
			array('name' => 'Failure to leave area', 'group' => '28', 'englishLegislation' => '25', 'welshLegislation' => '10000', 'issueType' => '1', 'minImageRequired' => '1', 'maxFine' => '1300'),
			array('name' => 'Camping', 'group' => '28', 'englishLegislation' => '25', 'welshLegislation' => '10000', 'issueType' => '1', 'minImageRequired' => '1', 'maxFine' => '1300'),
			array('name' => 'Erection of tent, shelter', 'group' => '28', 'englishLegislation' => '25', 'welshLegislation' => '10000', 'issueType' => '1', 'minImageRequired' => '1', 'maxFine' => '1300'),
			array('name' => 'Barbeque', 'group' => '28', 'englishLegislation' => '25', 'welshLegislation' => '10000', 'issueType' => '1', 'minImageRequired' => '1', 'maxFine' => '1300'),
			array('name' => 'Fire', 'group' => '28', 'englishLegislation' => '25', 'welshLegislation' => '10000', 'issueType' => '1', 'minImageRequired' => '1', 'maxFine' => '1300'),
			array('name' => 'Intimidation, obstruction, interference', 'group' => '28', 'englishLegislation' => '25', 'welshLegislation' => '10000', 'issueType' => '1', 'minImageRequired' => '1', 'maxFine' => '1300'),
			array('name' => 'Smoke-Free signs', 'group' => '33', 'englishLegislation' => '45', 'welshLegislation' => '10000', 'issueType' => '1', 'minImageRequired' => '1', 'maxFine' => '1300'),
			array('name' => 'Household DOC FPN', 'group' => '6', 'englishLegislation' => '9', 'welshLegislation' => '10000', 'issueType' => '1', 'minImageRequired' => '1', 'maxFine' => '1300'),
			array('name' => 'Carrier Bag containing waste', 'group' => '25', 'englishLegislation' => '1', 'welshLegislation' => '10000', 'issueType' => '1', 'minImageRequired' => '1', 'maxFine' => '1300'),
			array('name' => 'Free Printed Material', 'group' => '8', 'englishLegislation' => '21', 'welshLegislation' => '10000', 'issueType' => '1', 'minImageRequired' => '1', 'maxFine' => '1300'),
			array('name' => 'Aiding and abetting', 'group' => '34', 'englishLegislation' => '55', 'welshLegislation' => '10000', 'issueType' => '1', 'minImageRequired' => '1', 'maxFine' => '1300'),
			array('name' => 'Street Trading', 'group' => '34', 'englishLegislation' => '55', 'welshLegislation' => '10000', 'issueType' => '1', 'minImageRequired' => '1', 'maxFine' => '1300'),
			array('name' => 'Aiding and abetting (consent)', 'group' => '34', 'englishLegislation' => '56', 'welshLegislation' => '10000', 'issueType' => '1', 'minImageRequired' => '1', 'maxFine' => '1300'),
			array('name' => 'Terms of trading', 'group' => '34', 'englishLegislation' => '56', 'welshLegislation' => '10000', 'issueType' => '1', 'minImageRequired' => '1', 'maxFine' => '1300'),
			array('name' => 'Aiding and abetting (contravention)', 'group' => '34', 'englishLegislation' => '57', 'welshLegislation' => '10000', 'issueType' => '1', 'minImageRequired' => '1', 'maxFine' => '1300'),
			array('name' => 'Trading contravention', 'group' => '34', 'englishLegislation' => '57', 'welshLegislation' => '10000', 'issueType' => '1', 'minImageRequired' => '1', 'maxFine' => '1300'),
			array('name' => 'Waste Carrier Licence', 'group' => '6', 'englishLegislation' => '54', 'welshLegislation' => '10000', 'issueType' => '1', 'minImageRequired' => '1', 'maxFine' => '1300'),
			array('name' => 'Failure to nominate keyholder (Noise)', 'group' => '2', 'englishLegislation' => '46', 'welshLegislation' => '10000', 'issueType' => '1', 'minImageRequired' => '1', 'maxFine' => '1300'),
			array('name' => 'Vehicles for Sale (Road)', 'group' => '2', 'englishLegislation' => '46', 'welshLegislation' => '10000', 'issueType' => '1', 'minImageRequired' => '1', 'maxFine' => '1300'),
			array('name' => 'Repairing Vehicles (Road)', 'group' => '2', 'englishLegislation' => '46', 'welshLegislation' => '10000', 'issueType' => '1', 'minImageRequired' => '1', 'maxFine' => '1300'),
			array('name' => 'Residential Waste Receptacle (Waste)', 'group' => '10', 'englishLegislation' => '58', 'welshLegislation' => '10000', 'issueType' => '1', 'minImageRequired' => '1', 'maxFine' => '1300'),
			array('name' => 'Commercial Receptacle Offence (Waste)', 'group' => '29', 'englishLegislation' => '17', 'welshLegislation' => '10000', 'issueType' => '1', 'minImageRequired' => '1', 'maxFine' => '1300'),
			array('name' => 'EP80 Commercial Abatement 2 (Abatement 2', 'group' => '29', 'englishLegislation' => '59', 'welshLegislation' => '10000', 'issueType' => '1', 'minImageRequired' => '1', 'maxFine' => '1300'),
			array('name' => 'Domestic Abatement 2 (Abatement 2)', 'group' => '10', 'englishLegislation' => '59', 'welshLegislation' => '10000', 'issueType' => '1', 'minImageRequired' => '1', 'maxFine' => '1300'),
			array('name' => 'Depositing builders skip on highway', 'group' => '34', 'englishLegislation' => '61', 'welshLegislation' => '10000', 'issueType' => '1', 'minImageRequired' => '1', 'maxFine' => '1300'),
			array('name' => 'Failure to secure lighting builders skip', 'group' => '34', 'englishLegislation' => '62', 'welshLegislation' => '10000', 'issueType' => '1', 'minImageRequired' => '1', 'maxFine' => '1300'),
			array('name' => 'Failure to secure marking of builders skip with na', 'group' => '34', 'englishLegislation' => '63', 'welshLegislation' => '10000', 'issueType' => '1', 'minImageRequired' => '1', 'maxFine' => '1300'),
			array('name' => 'Failure to secure removal of builders skip', 'group' => '22', 'englishLegislation' => '64', 'welshLegislation' => '10000', 'issueType' => '1', 'minImageRequired' => '1', 'maxFine' => '1300'),
			array('name' => 'Failure to comply with conditions of permission', 'group' => '22', 'englishLegislation' => '65', 'welshLegislation' => '10000', 'issueType' => '1', 'minImageRequired' => '1', 'maxFine' => '1300'),
			array('name' => 'Application for street trading Licence', 'group' => '34', 'englishLegislation' => '66', 'welshLegislation' => '10000', 'issueType' => '1', 'minImageRequired' => '1', 'maxFine' => '1300'),
			array('name' => 'Contravention of street trading Licence', 'group' => '34', 'englishLegislation' => '66', 'welshLegislation' => '10000', 'issueType' => '1', 'minImageRequired' => '1', 'maxFine' => '1300'),
			array('name' => 'Failure to produce street trading license', 'group' => '34', 'englishLegislation' => '66', 'welshLegislation' => '10000', 'issueType' => '1', 'minImageRequired' => '1', 'maxFine' => '1300'),
			array('name' => 'Obstructing authorised officer', 'group' => '34', 'englishLegislation' => '66', 'welshLegislation' => '10000', 'issueType' => '1', 'minImageRequired' => '1', 'maxFine' => '1300'),
			array('name' => 'Unlicensed Street trading', 'group' => '34', 'englishLegislation' => '66', 'welshLegislation' => '10000', 'issueType' => '1', 'minImageRequired' => '1', 'maxFine' => '1300'),
			array('name' => 'Pitching booths/stalls/stands/encamping - highway', 'group' => '16', 'englishLegislation' => '68', 'welshLegislation' => '10000', 'issueType' => '1', 'minImageRequired' => '1', 'maxFine' => '1300'),
			array('name' => 'Wilful Obstruction', 'group' => '16', 'englishLegislation' => '69', 'welshLegislation' => '10000', 'issueType' => '1', 'minImageRequired' => '1', 'maxFine' => '1300'),
			array('name' => 'Erecting a building, fence or hedge on highway', 'group' => '16', 'englishLegislation' => '70', 'welshLegislation' => '10000', 'issueType' => '1', 'minImageRequired' => '1', 'maxFine' => '1300'),
			array('name' => 'Failure to remove or reposition builder’s skip', 'group' => '22', 'englishLegislation' => '71', 'welshLegislation' => '10000', 'issueType' => '1', 'minImageRequired' => '1', 'maxFine' => '1300'),
			array('name' => 'Removal of tree or shrub', 'group' => '16', 'englishLegislation' => '72', 'welshLegislation' => '10000', 'issueType' => '1', 'minImageRequired' => '1', 'maxFine' => '1300'),
			array('name' => 'Use of stall', 'group' => '16', 'englishLegislation' => '73', 'welshLegislation' => '10000', 'issueType' => '1', 'minImageRequired' => '1', 'maxFine' => '1300'),
			array('name' => 'Depositing material on a made-up carriageway', 'group' => '16', 'englishLegislation' => '74', 'welshLegislation' => '10000', 'issueType' => '1', 'minImageRequired' => '1', 'maxFine' => '1300'),
			array('name' => 'Deposit material within 15ft made-up carriageway', 'group' => '16', 'englishLegislation' => '75', 'welshLegislation' => '10000', 'issueType' => '1', 'minImageRequired' => '1', 'maxFine' => '1300'),
			array('name' => 'Depositing anything', 'group' => '16', 'englishLegislation' => '76', 'welshLegislation' => '10000', 'issueType' => '1', 'minImageRequired' => '1', 'maxFine' => '1300'),
			array('name' => 'Removal of projection from buildings', 'group' => '16', 'englishLegislation' => '78', 'welshLegislation' => '10000', 'issueType' => '1', 'minImageRequired' => '1', 'maxFine' => '1300'),
			array('name' => 'Door, gate or bar opening outwards onto street', 'group' => '16', 'englishLegislation' => '79', 'welshLegislation' => '10000', 'issueType' => '1', 'minImageRequired' => '1', 'maxFine' => '1300'),
			array('name' => 'Erecting Scaffolding', 'group' => '16', 'englishLegislation' => '80', 'welshLegislation' => '10000', 'issueType' => '1', 'minImageRequired' => '1', 'maxFine' => '1300'),
			array('name' => 'Keeping of Animals', 'group' => '16', 'englishLegislation' => '80', 'welshLegislation' => '10000', 'issueType' => '1', 'minImageRequired' => '1', 'maxFine' => '1300'),
			array('name' => 'Depositing things on highway which cause injury', 'group' => '16', 'englishLegislation' => '81', 'welshLegislation' => '10000', 'issueType' => '1', 'minImageRequired' => '1', 'maxFine' => '1300'),
			array('name' => 'Abandoning a vehicle', 'group' => '12', 'englishLegislation' => '15', 'welshLegislation' => '10000', 'issueType' => '1', 'minImageRequired' => '1', 'maxFine' => '1300'),
			array('name' => 'Community Protection 2', 'group' => '11', 'englishLegislation' => '13', 'welshLegislation' => '10000', 'issueType' => '1', 'minImageRequired' => '1', 'maxFine' => '1300'),
			array('name' => 'Commercial Noise from Premises', 'group' => '16', 'englishLegislation' => '67', 'welshLegislation' => '10000', 'issueType' => '1', 'minImageRequired' => '1', 'maxFine' => '1300'),
			array('name' => 'Domestic Noise from Premises', 'group' => '16', 'englishLegislation' => '67', 'welshLegislation' => '10000', 'issueType' => '1', 'minImageRequired' => '1', 'maxFine' => '1300'),
		));

    	// OFFENCE LOCATION PREFIX
        OffenceLocationPrefix::insert([
        	['id'=> 1, 'textOnMachine'=> 'in', 'textOnLetter'=> 'in', 'status'=> '1'],
        	['id'=> 2, 'textOnMachine'=> 'on', 'textOnLetter'=> 'on', 'status'=> '1'],
        	['id'=> 3, 'textOnMachine'=> 'outside', 'textOnLetter'=> 'outside', 'status'=> '1'],
        	['id'=> 4, 'textOnMachine'=> 'inside', 'textOnLetter'=> 'inside', 'status'=> '1'],
        	['id'=> 5, 'textOnMachine'=> 'other', 'textOnLetter'=> 'other', 'status'=> '1'],
        	['id'=> 6, 'textOnMachine'=> 'at', 'textOnLetter'=> 'at', 'status'=> '1'],
        	['id'=> 7, 'textOnMachine'=> 'by', 'textOnLetter'=> 'by', 'status'=> '1'],
        	['id'=> 8, 'textOnMachine'=> 'down', 'textOnLetter'=> 'down', 'status'=> '1'],
        	['id'=> 9, 'textOnMachine'=> 'opposite', 'textOnLetter'=> 'opposite', 'status'=> '1'],
        	['id'=> 10, 'textOnMachine'=> 'near', 'textOnLetter'=> 'near', 'status'=> '1']
        ]);
        // OFFENCE HOW
        OffenceHow::insert([
			['id'=> 1, 'textOnMachine'=> 'dropping', 'textOnLetter'=> 'to drop', 'status'=> '1'],
			['id'=> 2, 'textOnMachine'=> 'throwing', 'textOnLetter'=> 'to throw', 'status'=> '1'],
			['id'=> 3, 'textOnMachine'=> 'depositing', 'textOnLetter'=> 'to deposit', 'status'=> '1'],
			['id'=> 4, 'textOnMachine'=> 'smoking', 'textOnLetter'=> 'smoking within', 'status'=> '1'],
			['id'=> 5, 'textOnMachine'=> 'Dropping', 'textOnLetter'=> 'Dropping', 'status'=> '0'],
			['id'=> 6, 'textOnMachine'=> 'Throwing', 'textOnLetter'=> 'Throwing', 'status'=> '0'],
			['id'=> 7, 'textOnMachine'=> 'Depositing', 'textOnLetter'=> 'Depositing', 'status'=> '0'],
			['id'=> 8, 'textOnMachine'=> 'smoking within', 'textOnLetter'=> 'smoking within', 'status'=> '0'],
			['id'=> 9, 'textOnMachine'=> 'smoking within', 'textOnLetter'=> 'smoking within', 'status'=> '1'],
			['id'=> 10, 'textOnMachine'=> 'smoking within', 'textOnLetter'=> 'smoking within', 'status'=> '1']
        ]);
        // ADDRESS VERIFIED BY
        AddressVerifiedBy::insert([
			['id'=> 2, 'textOnMachine'=> 'Tracemart', 'textOnLetter'=> 'Tracemart', 'status'=> '0'],
			['id'=> 1, 'textOnMachine'=> 'Council Tax Register', 'textOnLetter'=> 'Council Tax Register', 'status'=> '1'],
			['id'=> 6, 'textOnMachine'=> 'Photo ID', 'textOnLetter'=> 'photo ID', 'status'=> '1'],
			['id'=> 3, 'textOnMachine'=> 'Electoral Register', 'textOnLetter'=> 'Electoral Register', 'status'=> '1'],
			['id'=> 4, 'textOnMachine'=> 'TracemartAuto', 'textOnLetter'=> 'TracemartAuto', 'status'=> '0'],
			['id'=> 5, 'textOnMachine'=> 'Other', 'textOnLetter'=> 'Other', 'status'=> '1'],
			['id'=> 7, 'textOnMachine'=> 'Driving Licence', 'textOnLetter'=> 'driving licence', 'status'=> '1'],
			['id'=> 8, 'textOnMachine'=> 'Not Verified', 'textOnLetter'=> 'Not Verified', 'status'=> '1'],
			['id'=> 9, 'textOnMachine'=> 'Tracemart (Office)', 'textOnLetter'=> 'Tracemart', 'status'=> '1']
        ]);
        // ETHNICITY
        Ethnicity::insert([
			['id'=> 1, 'textOnMachine'=> 'IC1 - White - North European', 'textOnLetter'=> 'IC1', 'status'=> '1'],
			['id'=> 2, 'textOnMachine'=> 'IC2 - White - South European', 'textOnLetter'=> 'IC2', 'status'=> '1'],
			['id'=> 3, 'textOnMachine'=> 'IC3 - Black', 'textOnLetter'=> 'IC3', 'status'=> '1'],
			['id'=> 4, 'textOnMachine'=> 'IC4 - Asian (India, Pakistan, Bangladesh, Napal)', 'textOnLetter'=> 'IC4', 'status'=> '1'],
			['id'=> 5, 'textOnMachine'=> 'IC5 - Chinese, Japanese or other South East Asian', 'textOnLetter'=> 'IC5', 'status'=> '1'],
			['id'=> 6, 'textOnMachine'=> 'IC6 - Arabic or North African', 'textOnLetter'=> 'IC6', 'status'=> '1'],
			['id'=> 7, 'textOnMachine'=> 'IC9 - Unknown', 'textOnLetter'=> 'IC9', 'status'=> '1']


        ]);
        // OFFENCE LOCATION SUFFIX
        OffenceLocationSuffix::insert([
			['id'=> 1, 'textOnMachine'=> 'The Floor', 'textOnLetter'=> 'onto the floor', 'status'=> '1'],
			['id'=> 2, 'textOnMachine'=> 'The Pavement', 'textOnLetter'=> 'onto the pavement', 'status'=> '1'],
			['id'=> 3, 'textOnMachine'=> 'Grass Verge', 'textOnLetter'=> 'on a grass verge', 'status'=> '1'],
			['id'=> 4, 'textOnMachine'=> 'The Grass', 'textOnLetter'=> 'on the grass', 'status'=> '1'],
			['id'=> 5, 'textOnMachine'=> 'Car Window', 'textOnLetter'=> 'out of the car window', 'status'=> '1'],
			['id'=> 6, 'textOnMachine'=> 'The Wall', 'textOnLetter'=> 'on the wall', 'status'=> '1'],
			['id'=> 7, 'textOnMachine'=> 'Down a drain', 'textOnLetter'=> 'down a drain', 'status'=> '1'],
			['id'=> 8, 'textOnMachine'=> 'Down a grid', 'textOnLetter'=> 'down a grid', 'status'=> '1'],
			['id'=> 9, 'textOnMachine'=> 'River', 'textOnLetter'=> 'in the river', 'status'=> '1'],
			['id'=> 10, 'textOnMachine'=> 'Electrical Box', 'textOnLetter'=> 'an electrical box', 'status'=> '1'],
			['id'=> 11, 'textOnMachine'=> 'On a Bench', 'textOnLetter'=> 'a bench', 'status'=> '1'],
			['id'=> 12, 'textOnMachine'=> 'OTHER', 'textOnLetter'=> 'OTHER', 'status'=> '1'],
			['id'=> 13, 'textOnMachine'=> 'On Farmland', 'textOnLetter'=> 'on farmland', 'status'=> '1'],
			['id'=> 14, 'textOnMachine'=> 'A Bush', 'textOnLetter'=> 'in a bush', 'status'=> '1'],
			['id'=> 15, 'textOnMachine'=> 'A shopping trolley', 'textOnLetter'=> 'in a shopping trolley', 'status'=> '1']


        ]);
        // WEATHER
        Weather::insert([
			['id'=> 1, 'textOnMachine'=> 'sunny', 'textOnLetter'=> 'sunny', 'status'=> '1'],
			['id'=> 2, 'textOnMachine'=> 'bright with a clear sky', 'textOnLetter'=> 'bright with a clear sky', 'status'=> '1'],
			['id'=> 3, 'textOnMachine'=> 'overcast', 'textOnLetter'=> 'overcast', 'status'=> '1'],
			['id'=> 4, 'textOnMachine'=> 'lightly raining', 'textOnLetter'=> 'lightly raining', 'status'=> '1'],
			['id'=> 5, 'textOnMachine'=> 'cloudy', 'textOnLetter'=> 'cloudy', 'status'=> '1'],
			['id'=> 6, 'textOnMachine'=> 'snowing', 'textOnLetter'=> 'snowing', 'status'=> '1'],
			['id'=> 7, 'textOnMachine'=> 'windy', 'textOnLetter'=> 'windy', 'status'=> '1'],
			['id'=> 8, 'textOnMachine'=> 'blowing a gale', 'textOnLetter'=> 'blowing a gale', 'status'=> '1'],
			['id'=> 9, 'textOnMachine'=> 'dull', 'textOnLetter'=> 'dull', 'status'=> '1'],
			['id'=> 10, 'textOnMachine'=> 'cold', 'textOnLetter'=> 'cold', 'status'=> '1'],
			['id'=> 11, 'textOnMachine'=> 'heavy rain', 'textOnLetter'=> 'heavy rain', 'status'=> '1']


        ]);
        // OFFENDER HAIR COLOUR
        OffenderHairColour::insert([
			['id'=> 1, 'textOnMachine'=> 'white', 'textOnLetter'=> 'white', 'status'=> '1'],
			['id'=> 2, 'textOnMachine'=> 'black', 'textOnLetter'=> 'black', 'status'=> '1'],
			['id'=> 3, 'textOnMachine'=> 'dark brown', 'textOnLetter'=> 'dark brown', 'status'=> '1'],
			['id'=> 4, 'textOnMachine'=> 'light brown', 'textOnLetter'=> 'light brown', 'status'=> '1'],
			['id'=> 5, 'textOnMachine'=> 'dark blonde', 'textOnLetter'=> 'dark blonde', 'status'=> '1'],
			['id'=> 6, 'textOnMachine'=> 'light blonde', 'textOnLetter'=> 'light blonde', 'status'=> '1'],
			['id'=> 7, 'textOnMachine'=> 'auburn', 'textOnLetter'=> 'auburn', 'status'=> '1'],
			['id'=> 8, 'textOnMachine'=> 'silver', 'textOnLetter'=> 'silver', 'status'=> '1'],
			['id'=> 9, 'textOnMachine'=> 'red', 'textOnLetter'=> 'red', 'status'=> '1'],
			['id'=> 10, 'textOnMachine'=> 'strawberry blonde', 'textOnLetter'=> 'strawberry blonde', 'status'=> '1'],
			['id'=> 11, 'textOnMachine'=> 'ginger', 'textOnLetter'=> 'ginger', 'status'=> '1'],
			['id'=> 12, 'textOnMachine'=> 'copper', 'textOnLetter'=> 'copper', 'status'=> '1'],
			['id'=> 13, 'textOnMachine'=> 'helmet', 'textOnLetter'=> 'helmet', 'status'=> '1']


        ]);
        // OFFENDER BUILD
        OffenderBuild::insert([
			['id'=> 1, 'textOnMachine'=> 'small', 'textOnLetter'=> 'small', 'status'=> '1'],
			['id'=> 2, 'textOnMachine'=> 'medium', 'textOnLetter'=> 'medium', 'status'=> '1'],
			['id'=> 3, 'textOnMachine'=> 'large', 'textOnLetter'=> 'large', 'status'=> '1'],
			['id'=> 4, 'textOnMachine'=> 'stocky', 'textOnLetter'=> 'stocky', 'status'=> '1'],
			['id'=> 5, 'textOnMachine'=> 'muscular', 'textOnLetter'=> 'muscular', 'status'=> '1'],
			['id'=> 6, 'textOnMachine'=> 'slim', 'textOnLetter'=> 'slim', 'status'=> '1']
        ]);
        // ID SHOWN
        IdShown::insert([
			['id'=> 1, 'textOnMachine'=> 'IDU verified', 'textOnLetter'=> 'This has been verified by the IDU system provided by LexisNexis', 'status'=> '0'],
			['id'=> 2, 'textOnMachine'=> 'Tracesmart', 'textOnLetter'=> 'tracesmart', 'status'=> '0'],
			['id'=> 3, 'textOnMachine'=> 'Passport', 'textOnLetter'=> 'Passport', 'status'=> '1'],
			['id'=> 4, 'textOnMachine'=> 'Photo ID', 'textOnLetter'=> 'photo ID', 'status'=> '1'],
			['id'=> 5, 'textOnMachine'=> 'Driving licence', 'textOnLetter'=> 'Driving licence', 'status'=> '1'],
			['id'=> 6, 'textOnMachine'=> 'Bank Card', 'textOnLetter'=> 'Bank Card', 'status'=> '1'],
			['id'=> 7, 'textOnMachine'=> 'Utility Bill', 'textOnLetter'=> 'utility bill', 'status'=> '1'],
			['id'=> 8, 'textOnMachine'=> 'Bus Pass', 'textOnLetter'=> 'Bus Pass', 'status'=> '1'],
			['id'=> 9, 'textOnMachine'=> 'DVLA Verified', 'textOnLetter'=> 'The vehicle owner has been identified by the DVLA', 'status'=> '1'],
			['id'=> 10, 'textOnMachine'=> 'PNC Checked', 'textOnLetter'=> 'The details of the offender were provided by the Police', 'status'=> '1'],
			['id'=> 11, 'textOnMachine'=> 'Not Verified', 'textOnLetter'=> 'Not Verified', 'status'=> '1'],
			['id'=> 12, 'textOnMachine'=> 'OFFICE USE ONLY', 'textOnLetter'=> 'Tracemart', 'status'=> '0']


        ]);
        // VISIBILITY
        Visibility::insert([
			['id'=> 3, 'visibility'=> 'Obstructed view', 'status'=> '1'],
			['id'=> 2, 'visibility'=> 'Clear view', 'status'=> '1'],
			['id'=> 1, 'visibility'=> 'Clear and unobstructed view', 'status'=> '1']
        ]);
        // WRITE OFF CODE(S)
        WriteOffCode::insert([
			['id'=> 1, 'type'=> 'Medic', 'description'=> 'WO14', 'status'=> '0'],
			['id'=> 2, 'type'=> 'W10', 'description'=> 'Valid Waste Transfer Notes Supplied', 'status'=> '1'],
			['id'=> 3, 'type'=> 'W15', 'description'=> 'Re-issued', 'status'=> '1'],
			['id'=> 4, 'type'=> 'W98', 'description'=> 'Formal Warning', 'status'=> '1'],
			['id'=> 5, 'type'=> 'W99', 'description'=> 'RTS', 'status'=> '1'],
			['id'=> 6, 'type'=> 'WO/1', 'description'=> 'Incorrect address/person', 'status'=> '1'],
			['id'=> 7, 'type'=> 'WO10', 'description'=> 'Underage (evidence supplied)', 'status'=> '1'],
			['id'=> 8, 'type'=> 'WO11', 'description'=> 'Case Withdrawn / Officer no longer with company', 'status'=> '1'],
			['id'=> 9, 'type'=> 'WO12', 'description'=> 'Circumstantial Evidence', 'status'=> '1'],
			['id'=> 10, 'type'=> 'WO13', 'description'=> 'Overseas address - unable to pursue', 'status'=> '1'],
			['id'=> 11, 'type'=> 'WO14', 'description'=> 'Medical Reason (evidence supplied)', 'status'=> '1'],
			['id'=> 12, 'type'=> 'WO2', 'description'=> 'Unable to pursue', 'status'=> '1'],
			['id'=> 13, 'type'=> 'WO3', 'description'=> 'Uneconomic to pursue', 'status'=> '1'],
			['id'=> 14, 'type'=> 'WO4', 'description'=> 'Time expired', 'status'=> '1'],
			['id'=> 15, 'type'=> 'WO5', 'description'=> 'Case referred for prosecution', 'status'=> '0'],
			['id'=> 16, 'type'=> 'WO6', 'description'=> 'Vulnerable Person (Mental illness)', 'status'=> '1'],
			['id'=> 17, 'type'=> 'WO7', 'description'=> 'Cancelled FPN - Council', 'status'=> '1'],
			['id'=> 18, 'type'=> 'WO8', 'description'=> 'PSPO exemption', 'status'=> '1'],
			['id'=> 19, 'type'=> 'WO9', 'description'=> 'Transfer of Liability', 'status'=> '1']


        ]);
        // CANCEL CODE(S)
        CancelCode::insert([
			['id'=> 1, 'type'=> 'C1', 'description'=> 'Evidential Shortfall', 'status'=> '1'],
			['id'=> 2, 'type'=> 'C10', 'description'=> 'Demo Ticket', 'status'=> '1'],
			['id'=> 3, 'type'=> 'C11', 'description'=> 'FPN Incorrectly Completed', 'status'=> '1'],
			['id'=> 4, 'type'=> 'C12', 'description'=> 'Compassionate Grounds', 'status'=> '0'],
			['id'=> 5, 'type'=> 'C13', 'description'=> 'Cancelled by NES - Client Request', 'status'=> '0'],
			['id'=> 6, 'type'=> 'C14', 'description'=> 'Cancelled by NES - NES Request', 'status'=> '1'],
			['id'=> 7, 'type'=> 'C15', 'description'=> 'Non-UK resident', 'status'=> '1'],
			['id'=> 8, 'type'=> 'C16', 'description'=> 'Out Of Area', 'status'=> '1'],
			['id'=> 9, 'type'=> 'C17', 'description'=> 'Vehicle on whitelist', 'status'=> '1'],
			['id'=> 10, 'type'=> 'C18', 'description'=> 'Private Land - Permission revoked by landowner', 'status'=> '1'],
			['id'=> 11, 'type'=> 'C19', 'description'=> 'Officer No Longer Works for Company', 'status'=> '0'],
			['id'=> 12, 'type'=> 'C2', 'description'=> 'Minor (Underage)', 'status'=> '0'],
			['id'=> 13, 'type'=> 'C20', 'description'=> 'No BWC Footage', 'status'=> '1'],
			['id'=> 14, 'type'=> 'C21', 'description'=> 'Waste Transfer Notes Supplied', 'status'=> '1'],
			['id'=> 15, 'type'=> 'C24', 'description'=> 'COVID 19', 'status'=> '1'],
			['id'=> 16, 'type'=> 'C3', 'description'=> 'Emergency, incident etc', 'status'=> '1'],
			['id'=> 17, 'type'=> 'C4', 'description'=> 'Duplicate Ticket', 'status'=> '1'],
			['id'=> 18, 'type'=> 'C5', 'description'=> 'Out of boundary/neighbouring Local Authority', 'status'=> '1'],
			['id'=> 19, 'type'=> 'C6', 'description'=> 'Officer misconduct', 'status'=> '1'],
			['id'=> 20, 'type'=> 'C7', 'description'=> 'Serious misconduct', 'status'=> '1'],
			['id'=> 21, 'type'=> 'C8', 'description'=> 'VOID Ticket', 'status'=> '1'],
			['id'=> 22, 'type'=> 'C9', 'description'=> 'Cancelled by Client', 'status'=> '0']


        ]);
        // PAYMENT METHOD(S)
        PaymentMethod::insert([
			['id'=> 1, 'paymentMethod'=> 'Manual Telephone', 'status'=> '1'],
			['id'=> 2, 'paymentMethod'=> 'Cash (Post office / PayZone)', 'status'=> '1'],
			['id'=> 3, 'paymentMethod'=> 'Post Office', 'status'=> '0'],
			['id'=> 4, 'paymentMethod'=> 'ONLINE (Ops Team)', 'status'=> '0'],
			['id'=> 5, 'paymentMethod'=> 'Paid into Santander Account', 'status'=> '1'],
			['id'=> 6, 'paymentMethod'=> 'Cheque', 'status'=> '1'],
			['id'=> 7, 'paymentMethod'=> 'Payment taken by Council', 'status'=> '1'],
			['id'=> 8, 'paymentMethod'=> 'AUTO. TEL.', 'status'=> '1'],
			['id'=> 9, 'paymentMethod'=> 'ONLINE', 'status'=> '1'],
			['id'=> 10, 'paymentMethod'=> 'Postal Order', 'status'=> '1'],
			['id'=> 11, 'paymentMethod'=> 'Magistrates Court', 'status'=> '1']
        ]);
        // LEGISLATION
        Legislation::insert(array(
			array('id' => '1', 'title' => 'Littering', 'legislation' => 'Section 87 and 88 Environmental Protection Act 1990 (as amended), Clean Neighbourhoods and Environment Act 2005', 'language' => 'English', 'status' => '1', 'offenceSpecificText' => ''),
			array('id' => '2', 'title' => 'Littering (Welsh)', 'legislation' => 'Adran 87 ac 88 Deddf Diogelu r Amgylchedd 1990 (fel y i diwygiwyd), Deddf Cymdogaethau Glân a r Amgylchedd 2005', 'language' => 'Welsh', 'status' => '1', 'offenceSpecificText' => ''),
			array('id' => '3', 'title' => 'Dog Fouling (Fouling of Land)', 'legislation' => 'Dogs (Fouling of Land) Act 1996', 'language' => 'English', 'status' => '1', 'offenceSpecificText' => ''),
			array('id' => '4', 'title' => 'Fly Posting', 'legislation' => 'Section 224(3) Town and Country Planning Act 1990. Section 43 Anti-Social Behaviour Act 2003', 'language' => 'English', 'status' => '1', 'offenceSpecificText' => ''),
			array('id' => '5', 'title' => 'Graffiti', 'legislation' => 'Section 43 Anti-Social Behaviour Act 2003 (ASBA)', 'language' => 'English', 'status' => '1', 'offenceSpecificText' => ''),
			array('id' => '6', 'title' => 'Graffiti (Welsh)', 'legislation' => 'Adran 43 Deddf Ymddygiad Gwrthgymdeithasol 2003 (ASBA)', 'language' => 'Welsh', 'status' => '1', 'offenceSpecificText' => ''),
			array('id' => '7', 'title' => 'Fly Posting (Welsh)', 'legislation' => 'Adran 224(3) Deddf Cynllunio Gwlad a Thref 1990. Adran 43 Deddf Ymddygiad Gwrthgymdeithasol 2003', 'language' => 'Welsh', 'status' => '1', 'offenceSpecificText' => ''),
			array('id' => '8', 'title' => 'Dog Fouling (Welsh) - Pembroke', 'legislation' => 'Gorchymyn Sir Benfro (Baeddu Tir) Rhif 2 2000', 'language' => 'Welsh', 'status' => '1', 'offenceSpecificText' => ''),
			array('id' => '9', 'title' => 'Household Duty of Care', 'legislation' => 'Section 34 (2A) Environmental Protection Act 1990', 'language' => 'English', 'status' => '1', 'offenceSpecificText' => ''),
			array('id' => '10', 'title' => 'Duty of Care (Welsh)', 'legislation' => 'Adran 34(2A) Deddf Diogelu r Amgylchedd 1990', 'language' => 'Welsh', 'status' => '1', 'offenceSpecificText' => ''),
			array('id' => '11', 'title' => 'Fly Tipping', 'legislation' => 'Section 33 Environmental Protection Act 1990', 'language' => 'English', 'status' => '1', 'offenceSpecificText' => ''),
			array('id' => '12', 'title' => 'Fly Tipping (Welsh)', 'legislation' => 'Adran 33 Deddf Diogelu r Amgylchedd 1990', 'language' => 'Welsh', 'status' => '1', 'offenceSpecificText' => ''),
			array('id' => '13', 'title' => 'Community Protection Notice', 'legislation' => 'Section 48 and 52 Anti-Social Behaviour, Crime & Policing Act 2014', 'language' => 'English', 'status' => '1', 'offenceSpecificText' => ''),
			array('id' => '14', 'title' => 'Community Protection Notice (W', 'legislation' => 'Adrannau 48 a 52 Deddf Ymddygiad Gwrthgymdeithasol, Troseddu a Phlismona 2014', 'language' => 'Welsh', 'status' => '1', 'offenceSpecificText' => ''),
			array('id' => '15', 'title' => 'Abandoned Vehicle', 'legislation' => 'Section 2A (1) Refuse Disposal (Amenity) Act 1978', 'language' => 'English', 'status' => '1', 'offenceSpecificText' => ''),
			array('id' => '16', 'title' => 'Abandoned Vehicle (Welsh)', 'legislation' => 'Adran 2A(1) Deddf Gwaredu Sbwriel (Amwynder) 1978', 'language' => 'Welsh', 'status' => '1', 'offenceSpecificText' => ''),
			array('id' => '17', 'title' => 'Commercial Waste', 'legislation' => 'Section 47 Environmental Protection Act 1990', 'language' => 'English', 'status' => '1', 'offenceSpecificText' => ''),
			array('id' => '18', 'title' => 'Commercial Waste (Welsh)', 'legislation' => 'Adran 47 Deddf Diogelu r Amgylchedd 1990', 'language' => 'Welsh', 'status' => '1', 'offenceSpecificText' => ''),
			array('id' => '19', 'title' => 'Domestic Waste', 'legislation' => 'Section 46 Environmental Protection Act 1990', 'language' => 'English', 'status' => '1', 'offenceSpecificText' => ''),
			array('id' => '20', 'title' => 'Domestic Waste (Welsh)', 'legislation' => 'Adran 46 Deddf Diogelu r Amgylchedd 1990', 'language' => 'Welsh', 'status' => '1', 'offenceSpecificText' => ''),
			array('id' => '21', 'title' => 'Free Printed Matter', 'legislation' => 'Section 94B Schedule 3A, para. 1 Environmental Protection Act 1990 (as amended) Clean Neighbourhoods and Environment Act 2005', 'language' => 'English', 'status' => '1', 'offenceSpecificText' => ''),
			array('id' => '22', 'title' => 'Free Printed Matter (Welsh)', 'legislation' => 'Adran 94B Atodlen 3A, para. 1 Deddf Diogelu r Amgylchedd 1990 (fel y i diwygiwyd) Deddf Cymdogaethau Glân a r Amgylchedd 2005', 'language' => 'Welsh', 'status' => '1', 'offenceSpecificText' => ''),
			array('id' => '23', 'title' => 'Nuisance Vehicle', 'legislation' => 'Section 6 (1) Clean Neighbourhoods and Environment Act 2005', 'language' => 'English', 'status' => '1', 'offenceSpecificText' => ''),
			array('id' => '24', 'title' => 'Nuisance Vehicle (Welsh)', 'legislation' => 'Adran 6(1) Deddf Cymdogaethau Glân a r Amgylchedd 2005', 'language' => 'Welsh', 'status' => '1', 'offenceSpecificText' => ''),
			array('id' => '25', 'title' => 'PSPO', 'legislation' => 'Sections 67/68 Anti Social Behaviour Crime & Policing Act 2014 - Failure To Comply With A Public Spaces Protection Order', 'language' => 'English', 'status' => '1', 'offenceSpecificText' => ''),
			array('id' => '26', 'title' => 'PSPO (Welsh)', 'legislation' => 'Adrannau 67/68 Deddf Ymddygiad Gwrthgymdeithasol, Trosedd a Phlismona 2014 - Methiant i Gydymffurfio â Gorchymyn Diogelu Mannau Cyhoeddus', 'language' => 'Welsh', 'status' => '1', 'offenceSpecificText' => ''),
			array('id' => '27', 'title' => 'Waste Transfer Notes', 'legislation' => 'Section 34(5) Environmental Protection Act 1990', 'language' => 'English', 'status' => '1', 'offenceSpecificText' => ''),
			array('id' => '28', 'title' => 'Waste Transfer Notes (Welsh)', 'legislation' => 'Adran 5B(2) Deddf Rheoli Llygredd (Diwygio) 1989', 'language' => 'Welsh', 'status' => '1', 'offenceSpecificText' => ''),
			array('id' => '29', 'title' => 'Waste Carriers Licence', 'legislation' => 'Section 5B(2) Control of Pollution (Amendment) Act 1989', 'language' => 'English', 'status' => '1', 'offenceSpecificText' => ''),
			array('id' => '30', 'title' => 'Waste Carriers Licence (Welsh)', 'legislation' => 'Adran 5B(2) Deddf Rheoli Llygredd (Diwygio) 1989', 'language' => 'Welsh', 'status' => '1', 'offenceSpecificText' => ''),
			array('id' => '31', 'title' => 'Abandoned Trolleys', 'legislation' => 'Section 99 and Schedule 4 of the Environmental Protection Act 1990 (as amended), Clean Neighbourhoods and Environment Act 2005', 'language' => 'English', 'status' => '1', 'offenceSpecificText' => ''),
			array('id' => '32', 'title' => 'Abandoned Trolleys (Welsh)', 'legislation' => 'Adran 99 ac Atodlen 4 i Ddeddf Diogelu r Amgylchedd 1990 (fel y i diwygiwyd), Deddf Cymdogaethau Glân a r Amgylchedd 2005', 'language' => 'Welsh', 'status' => '1', 'offenceSpecificText' => ''),
			array('id' => '33', 'title' => 'Wilful Obstruction', 'legislation' => 'Section 137 (1) Highways Act 1980', 'language' => 'English', 'status' => '1', 'offenceSpecificText' => ''),
			array('id' => '34', 'title' => 'Wilful Obstruction (Welsh)', 'legislation' => 'Adran 137(1) Deddf Priffyrdd 1980', 'language' => 'Welsh', 'status' => '1', 'offenceSpecificText' => ''),
			array('id' => '35', 'title' => 'Litter from Vehicles (Civil)', 'legislation' => 'Section 6 The Littering From Vehicles Outside London (Keepers: Civil Penalties) Regulations 2018 and Section 88A The Environmental Protection Act 1990', 'language' => 'English', 'status' => '1', 'offenceSpecificText' => ''),
			array('id' => '36', 'title' => 'Litter from Vehicle (London)', 'legislation' => 'Section 24 of the London Local Authorities Act 2007 (amended in 2012)', 'language' => 'English', 'status' => '1', 'offenceSpecificText' => ''),
			array('id' => '37', 'title' => 'Warning (Litter)', 'legislation' => 'Section 87 and 88 Environmental Protection Act 1990 (as amended), Clean Neighbourhoods and Environment Act 2005', 'language' => 'English', 'status' => '1', 'offenceSpecificText' => ''),
			array('id' => '38', 'title' => 'Warning (Dog Fouling) PSPO', 'legislation' => 'Sections 67/68 Anti Social Behaviour Crime & Policing Act 2014 - Failure To Comply With A Public Spaces Protection Order', 'language' => 'English', 'status' => '1', 'offenceSpecificText' => ''),
			array('id' => '39', 'title' => 'Warning (Dog Bags) PSPO', 'legislation' => 'Sections 67/68 Anti Social Behaviour Crime & Policing Act 2014 - Failure To Comply With A Public Spaces Protection Order', 'language' => 'English', 'status' => '1', 'offenceSpecificText' => ''),
			array('id' => '40', 'title' => 'Warning (Dog Exclusion) PSPO', 'legislation' => 'Section 68 (1) Anti-Social Behaviour, Crime and Policing Act 2014', 'language' => 'English', 'status' => '1', 'offenceSpecificText' => ''),
			array('id' => '41', 'title' => 'Warning (On Leads)', 'legislation' => 'Section 68 (1) Anti-Social Behaviour, Crime and Policing Act 2014', 'language' => 'English', 'status' => '1', 'offenceSpecificText' => ''),
			array('id' => '42', 'title' => 'Warning (Leads by Direct) PSPO', 'legislation' => 'Section 68 (1) Anti-Social Behaviour, Crime and Policing Act 2014', 'language' => 'English', 'status' => '1', 'offenceSpecificText' => ''),
			array('id' => '43', 'title' => 'Warning (Max Dogs) PSPO', 'legislation' => 'Section 68 (1) Anti-Social Behaviour, Crime and Policing Act 2014', 'language' => 'English', 'status' => '1', 'offenceSpecificText' => ''),
			array('id' => '44', 'title' => 'Smoking in a Smoke Free Place', 'legislation' => 'Section 7, Health Act 2006 (Offence of Smoking in a Smoke-Free Place)', 'language' => 'English', 'status' => '1', 'offenceSpecificText' => ''),
			array('id' => '45', 'title' => 'Smoke Free (No Smoking Signs)', 'legislation' => 'Section 6 (5), Health Act 2006', 'language' => 'English', 'status' => '1', 'offenceSpecificText' => ''),
			array('id' => '46', 'title' => 'CNEA', 'legislation' => 'Section 59 Clean Neighbourhoods and Environment Act 2005', 'language' => 'English', 'status' => '1', 'offenceSpecificText' => ''),
			array('id' => '47', 'title' => 'Business Duty of Care', 'legislation' => 'Section 34(5) Environmental Protection Act 1990', 'language' => 'English', 'status' => '1', 'offenceSpecificText' => ''),
			array('id' => '48', 'title' => 'Dog Fouling (FOL 1996)', 'legislation' => 'Section 3 and 4 Dogs (Fouling of Land) Act 1996', 'language' => 'English', 'status' => '1', 'offenceSpecificText' => ''),
			array('id' => '49', 'title' => 'Obstruction of Highways', 'legislation' => 'Section 148 (c) of The Highways Act 1980', 'language' => 'English', 'status' => '1', 'offenceSpecificText' => ''),
			array('id' => '50', 'title' => 'Presentation of Waste (Resi)', 'legislation' => 'Section 46C Environmental Protection Act 1990 (as amended), Clean Neighbourhoods and Environment Act 2005', 'language' => 'English', 'status' => '1', 'offenceSpecificText' => ''),
			array('id' => '51', 'title' => 'Arddangos Gwastraff (Cartref)', 'legislation' => 'Adran 46C Deddf Diogelu r Amgylchedd 1990 (fel y i diwygiwyd), Deddf Cymdogaethau Glân a r Amgylchedd 2005', 'language' => 'Welsh', 'status' => '1', 'offenceSpecificText' => ''),
			array('id' => '52', 'title' => 'Anti-Idling', 'legislation' => 'The Road Traffic (Vehicle Emissions) (Fixed Penalty) (England) Regulations 2002', 'language' => 'English', 'status' => '1', 'offenceSpecificText' => ''),
			array('id' => '53', 'title' => 'Graffiti (Canterbury)', 'legislation' => 'Clean Neighbourhoods and Environment Act 2005', 'language' => 'English', 'status' => '1', 'offenceSpecificText' => ''),
			array('id' => '54', 'title' => 'Control of Pollution', 'legislation' => 'Section 5 Control of Pollution (Amendment) (as amended), Clean Neighbourhoods and Environment Act 2005', 'language' => 'English', 'status' => '1', 'offenceSpecificText' => ''),
			array('id' => '55', 'title' => 'Street Trading (PEDLAR) Leeds', 'legislation' => 'Local Government Miscellaneous Provisions Act 1982, Schedule 4, Section 10 (1) (b)', 'language' => 'English', 'status' => '1', 'offenceSpecificText' => ''),
			array('id' => '56', 'title' => 'Street Trading (CONSENT) Leeds', 'legislation' => 'Local Government Miscellaneous Provisions Act 1982, Schedule 4, Section 10 (1) (d)', 'language' => 'English', 'status' => '1', 'offenceSpecificText' => ''),
			array('id' => '57', 'title' => 'Street Trading (CONTRAVENTION)', 'legislation' => 'Local Government Miscellaneous Provisions Act 1982, Schedule 4, Section 10 (1) (e)', 'language' => 'English', 'status' => '1', 'offenceSpecificText' => ''),
			array('id' => '58', 'title' => 'Residential Waste Receptacle', 'legislation' => 'Environmental Protection Act 1990 Section 46/46A/47ZA', 'language' => 'English', 'status' => '1', 'offenceSpecificText' => ''),
			array('id' => '59', 'title' => 'Abatement', 'legislation' => 'Environmental Protection Act 1990 Section 80', 'language' => 'English', 'status' => '1', 'offenceSpecificText' => ''),
			array('id' => '60', 'title' => 'Alcohol PSPO', 'legislation' => 'Section 63 of the Anti-Social Behaviour, Crime and Policing Act 2014.', 'language' => 'English', 'status' => '1', 'offenceSpecificText' => ''),
			array('id' => '61', 'title' => 'Skip (highway)', 'legislation' => 'Highways Act 1980 section 139(3)', 'language' => 'English', 'status' => '1', 'offenceSpecificText' => ''),
			array('id' => '62', 'title' => 'Skip (builder lighting)', 'legislation' => 'Highways Act 1980 section 139(4)(a)', 'language' => 'English', 'status' => '1', 'offenceSpecificText' => ''),
			array('id' => '63', 'title' => 'Skip (builder name & address)', 'legislation' => 'Highways Act 1980 section 139(4)(b)', 'language' => 'English', 'status' => '1', 'offenceSpecificText' => ''),
			array('id' => '64', 'title' => 'Skip (fail to remove)', 'legislation' => 'Highways Act 1980 section 139(4)(c)', 'language' => 'English', 'status' => '1', 'offenceSpecificText' => ''),
			array('id' => '65', 'title' => 'Highways', 'legislation' => 'Highways Act 1980 section 139(4)(d)', 'language' => 'English', 'status' => '1', 'offenceSpecificText' => ''),
			array('id' => '66', 'title' => 'London Local Authorities Act', 'legislation' => 'London Local Authorities Act 1990 (c.vii)', 'language' => 'English', 'status' => '1', 'offenceSpecificText' => ''),
			array('id' => '67', 'title' => 'Noise', 'legislation' => 'Noise Act 1996 section 8', 'language' => 'English', 'status' => '1', 'offenceSpecificText' => ''),
			array('id' => '68', 'title' => 'Pitching on highway', 'legislation' => 'London Local Authorities and Transport for London Act 2003 section 132(1)', 'language' => 'English', 'status' => '1', 'offenceSpecificText' => ''),
			array('id' => '69', 'title' => 'Wilful Obstruction (LONDON)', 'legislation' => 'London Local Authorities and Transport for London Act 2003 section 137(1)', 'language' => 'English', 'status' => '1', 'offenceSpecificText' => ''),
			array('id' => '70', 'title' => 'Erecting on highway', 'legislation' => 'London Local Authorities and Transport for London Act 2003 section 138', 'language' => 'English', 'status' => '1', 'offenceSpecificText' => ''),
			array('id' => '71', 'title' => 'Builder skip', 'legislation' => 'London Local Authorities and Transport for London Act 2003 section 140(3)', 'language' => 'English', 'status' => '1', 'offenceSpecificText' => ''),
			array('id' => '72', 'title' => 'Removal of tree or shrub', 'legislation' => 'London Local Authorities and Transport for London Act 2003 section 141(3)', 'language' => 'English', 'status' => '1', 'offenceSpecificText' => ''),
			array('id' => '73', 'title' => 'Use of stall', 'legislation' => 'London Local Authorities and Transport for London Act 2003 section 147A(2)', 'language' => 'English', 'status' => '1', 'offenceSpecificText' => ''),
			array('id' => '74', 'title' => 'Depositing material', 'legislation' => 'London Local Authorities and Transport for London Act 2003 section 148(a)', 'language' => 'English', 'status' => '1', 'offenceSpecificText' => ''),
			array('id' => '75', 'title' => 'Depositing material (15 feet)', 'legislation' => 'London Local Authorities and Transport for London Act 2003 section 148(b)', 'language' => 'English', 'status' => '1', 'offenceSpecificText' => ''),
			array('id' => '76', 'title' => 'Depositing anything', 'legislation' => 'London Local Authorities and Transport for London Act 2003 section 148(c)', 'language' => 'English', 'status' => '1', 'offenceSpecificText' => ''),
			array('id' => '77', 'title' => 'Pitching', 'legislation' => 'London Local Authorities and Transport for London Act 2003 section 148(d)', 'language' => 'English', 'status' => '1', 'offenceSpecificText' => ''),
			array('id' => '78', 'title' => 'Failure to remove projection', 'legislation' => 'London Local Authorities and Transport for London Act 2003 section 152(4)', 'language' => 'English', 'status' => '1', 'offenceSpecificText' => ''),
			array('id' => '79', 'title' => 'Alteration open to street', 'legislation' => 'London Local Authorities and Transport for London Act 2003 section 153(5)', 'language' => 'English', 'status' => '1', 'offenceSpecificText' => ''),
			array('id' => '80', 'title' => 'LLA 155(2)', 'legislation' => 'London Local Authorities and Transport for London Act 2003 section 155(2)', 'language' => 'English', 'status' => '1', 'offenceSpecificText' => ''),
			array('id' => '81', 'title' => 'Highway Danger', 'legislation' => 'London Local Authorities and Transport for London Act 2003 section 161(1)', 'language' => 'English', 'status' => '1', 'offenceSpecificText' => ''),
			array('id' => '82', 'title' => 'CNEA S.71/72/73(2)', 'legislation' => 'Clean Neighbourhoods and Environment Act 2005 Section 71/72/73(2)', 'language' => 'English', 'status' => '1', 'offenceSpecificText' => ''),
			array('id' => '83', 'title' => 'CNEA 3/4/6(1)', 'legislation' => 'Clean Neighbours Environmental Act 2005 Section 3/4/6(1)', 'language' => 'English', 'status' => '1', 'offenceSpecificText' => ''),
			array('id' => '84', 'title' => 'Commercial Receptacle Offence', 'legislation' => 'Environmental Protection Act 1990 Section 47/47ZA/47ZB', 'language' => 'English', 'status' => '1', 'offenceSpecificText' => ''),
		));
        // TYPE OF LAND
        TypeOfLand::insert([
			['id'=> 1, 'name'=> 'Public', 'status'=> '1'],
			['id'=> 2, 'name'=> 'Private', 'status'=> '1']
        ]);
        // TYPE OF DOG
        TypeOfDog::insert([
			['id'=> 1, 'name'=> 'German Shephard', 'status'=> '1'],
			['id'=> 2, 'name'=> 'Poodle', 'status'=> '1'],
			['id'=> 3, 'name'=> 'Golden Retriever', 'status'=> '1'],
			['id'=> 4, 'name'=> 'Other', 'status'=> '1'],
			['id'=> 5, 'name'=> 'Akita', 'status'=> '1'],
			['id'=> 6, 'name'=> 'Husky', 'status'=> '1'],
			['id'=> 7, 'name'=> 'Pug', 'status'=> '1'],
			['id'=> 8, 'name'=> 'Cocker Spaniel', 'status'=> '1'],
			['id'=> 9, 'name'=> 'Springer Spaniel', 'status'=> '1'],
			['id'=> 10, 'name'=> 'Staffordshire Bull Terrier', 'status'=> '1'],
			['id'=> 11, 'name'=> 'Cavalier King Charles Spaniel', 'status'=> '1'],
			['id'=> 12, 'name'=> 'West Highland Terrier', 'status'=> '1'],
			['id'=> 13, 'name'=> 'Boxer', 'status'=> '1'],
			['id'=> 14, 'name'=> 'Boxer Terrier', 'status'=> '1'],
			['id'=> 15, 'name'=> 'Labrador Retriever', 'status'=> '1'],
			['id'=> 16, 'name'=> 'Yorkshire Terrier', 'status'=> '1'],
			['id'=> 17, 'name'=> 'Beagle', 'status'=> '1'],
			['id'=> 18, 'name'=> 'Dachshund', 'status'=> '1'],
			['id'=> 19, 'name'=> 'Shih Tzu', 'status'=> '1'],
			['id'=> 20, 'name'=> 'Miniature Schnauzer', 'status'=> '1'],
			['id'=> 21, 'name'=> 'Bulldog', 'status'=> '1'],
			['id'=> 22, 'name'=> 'Bernese Mountain Dog', 'status'=> '1'],
			['id'=> 23, 'name'=> 'Border Collie', 'status'=> '1'],
			['id'=> 24, 'name'=> 'Dalmatian', 'status'=> '1'],
			['id'=> 25, 'name'=> 'Rottweiler', 'status'=> '1'],
			['id'=> 26, 'name'=> 'Shetland Sheepdog', 'status'=> '1'],
			['id'=> 27, 'name'=> 'English Setter', 'status'=> '1'],
			['id'=> 28, 'name'=> 'Segugio Maremmano', 'status'=> '1'],
			['id'=> 29, 'name'=> 'Segugio Italiano', 'status'=> '1'],
			['id'=> 30, 'name'=> 'Jack Russell Terrier', 'status'=> '1'],
			['id'=> 31, 'name'=> 'German Shorthaired Pointer', 'status'=> '1'],
			['id'=> 32, 'name'=> 'Chihuahua', 'status'=> '1'],
			['id'=> 33, 'name'=> 'German Spitz', 'status'=> '1'],
			['id'=> 34, 'name'=> 'French Bulldog', 'status'=> '1'],
			['id'=> 35, 'name'=> 'Maltese Terrier', 'status'=> '1'],
			['id'=> 36, 'name'=> 'Dobermann', 'status'=> '1'],
			['id'=> 37, 'name'=> 'Great Dane', 'status'=> '1'],
			['id'=> 38, 'name'=> 'Brittany Spaniel', 'status'=> '1']
        ]);
        // DOG SIZE
        DogSize::insert([
			['id'=> 1, 'name'=> 'Small', 'status'=> '1'],
			['id'=> 2, 'name'=> 'Medium', 'status'=> '1'],
			['id'=> 3, 'name'=> 'Large', 'status'=> '1'],
			['id'=> 4, 'name'=> 'other', 'status'=> '1'],
			['id'=> 5, 'name'=> 'Tiny', 'status'=> '1'],
			['id'=> 6, 'name'=> 'enormous', 'status'=> '1']
        ]);
        // DOG UNDER CONTROL
        DogUnderControl::insert([
			['id'=> 1, 'name'=> 'lead', 'status'=> '1'],
			['id'=> 2, 'name'=> 'rope', 'status'=> '1'],
			['id'=> 3, 'name'=> 'muzzle', 'status'=> '1'],
			['id'=> 4, 'name'=> 'not under control', 'status'=> '1']
        ]);

		//INSERT OFFERNDER DATA
		Offender::insert([
			['id'=> 1, 'salutation'=> 'Mr', 'first_name'=> 'David', 'last_name'=>'Amal','address'=>'K-Street Pali Hills', 'town' =>'Hyderabad', 'county'=>'India', 'post_code'=> '22103', 'ethnicity'=> 1, 'gender'=>'male','is_bwc_active'=>0],
			['id'=> 2, 'salutation'=> 'Mr', 'first_name'=> 'John', 'last_name'=>'Doe','address'=>'La decosla Street', 'town' =>'California', 'county'=>'USA', 'post_code'=> '77256', 'ethnicity'=> 2, 'gender'=>'male','is_bwc_active'=>0],
			['id'=> 3, 'salutation'=> 'Mr', 'first_name'=> 'Tim', 'last_name'=>'David','address'=>'121/42, Rajori Garden', 'town' =>'Delhi', 'county'=>'India', 'post_code'=> '33432', 'ethnicity'=> 3, 'gender'=>'male','is_bwc_active'=>0],
			['id'=> 4, 'salutation'=> 'Mr', 'first_name'=> 'Steve', 'last_name'=>'Smith','address'=>'124/22, Kangaro Lane', 'town' =>'Vienna', 'county'=>'Austria', 'post_code'=> '11343', 'ethnicity'=> 2, 'gender'=>'male','is_bwc_active'=>0],
			['id'=> 5, 'salutation'=> 'Mr', 'first_name'=> 'Tim', 'last_name'=>'Saudi','address'=>'Phogat lane flat no-2', 'town' =>'Mumbai', 'county'=>'India', 'post_code'=> '55433', 'ethnicity'=> 3, 'gender'=>'male','is_bwc_active'=>0],
        ]);

        // INSERT ENVIRO TABLE DATA
		Enviro::insert([
			['id'=> 1, 'fpn_number'=> 'CA0815105', 'site_id'=> '2', 'zone_id'=>1,'offence_id'=>1,'officer_id'=>1, 'offence_type_id'=>1, 'offender_id'=>1,'location_id'=>1,'visibility_id'=>1,'weather_id'=>1, 'action_id'=>1, 'offence_location'=> 'Park', 'offence_datetime'=>'2023-06-05 12:00', 'issue_datetime'=>'2023-06-07 12:00','land_type_id'=> 1,'enviro_issued_onspot'=>0],
			['id'=> 2, 'fpn_number'=> 'CA4843555', 'site_id'=> '1', 'zone_id'=>1,'offence_id'=>1,'officer_id'=>1, 'offence_type_id'=>2, 'offender_id'=>2,'location_id'=>3,'visibility_id'=>1,'weather_id'=>1, 'action_id'=>2, 'offence_location'=> 'Road', 'offence_datetime'=>'2023-06-04 12:00', 'issue_datetime'=>'2023-06-08 12:00','land_type_id'=> 2,'enviro_issued_onspot'=>1],
			['id'=> 3, 'fpn_number'=> 'CA2213333', 'site_id'=> '1', 'zone_id'=>1,'offence_id'=>1,'officer_id'=>1, 'offence_type_id'=>3, 'offender_id'=>3,'location_id'=>2,'visibility_id'=>1,'weather_id'=>1, 'action_id'=>3, 'offence_location'=> 'Office', 'offence_datetime'=>'2023-06-07 12:00', 'issue_datetime'=>'2023-06-09 12:00','land_type_id'=> 1,'enviro_issued_onspot'=>1],
			['id'=> 4, 'fpn_number'=> 'CA9937744', 'site_id'=> '1', 'zone_id'=>1,'offence_id'=>1,'officer_id'=>1, 'offence_type_id'=>4, 'offender_id'=>4,'location_id'=>4,'visibility_id'=>1,'weather_id'=>1, 'action_id'=>4, 'offence_location'=> 'Market', 'offence_datetime'=>'2023-06-08 12:00', 'issue_datetime'=>'2023-06-10 12:00','land_type_id'=> 2,'enviro_issued_onspot'=>1],
			['id'=> 5, 'fpn_number'=> 'CA0093764', 'site_id'=> '1', 'zone_id'=>1,'offence_id'=>1,'officer_id'=>1, 'offence_type_id'=>5, 'offender_id'=>5,'location_id'=>5,'visibility_id'=>1,'weather_id'=>1, 'action_id'=>6, 'offence_location'=> 'Street', 'offence_datetime'=>'2023-06-11 12:00', 'issue_datetime'=>'2023-06-18 12:00','land_type_id'=> 1,'enviro_issued_onspot'=>0],
        ]);
    }
}
