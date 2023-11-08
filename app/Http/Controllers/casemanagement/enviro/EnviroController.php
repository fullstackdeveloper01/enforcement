<?php

namespace App\Http\Controllers\casemanagement\enviro;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\casemanagement\enviro\Enviro;
use App\Models\casemanagement\enviro\EnviroImage;
use App\Models\casemanagement\enviro\Offender;
use App\Models\casemanagement\enviro\master\AddressVerifiedBy;
use App\Models\casemanagement\enviro\master\IdShown;
use App\Models\casemanagement\enviro\master\Offence;
use App\Models\casemanagement\enviro\master\OffenceLocationPrefix;
use App\Models\casemanagement\enviro\master\OffenceLocationSuffix;
use App\Models\casemanagement\enviro\master\OffenceHow;
use App\Models\casemanagement\enviro\master\TypeOfLand;
use App\Models\casemanagement\enviro\master\Visibility;
use App\Models\casemanagement\enviro\master\Ethnicity;
use App\Models\casemanagement\enviro\master\Weather;
use App\Models\casemanagement\enviro\master\Representation;
use App\Models\Setup\Site;
use App\Models\Setup\Area;
use App\Models\Setup\SiteOffence;
use App\Models\User;
use App\Models\UserPayment;
use Carbon\Carbon;

class EnviroController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $perPage = $request->get('perPage', 10);
        $currentPage = $request->get('currentPage', 1);
        $enviroList = Enviro::with('site')->with('offender')->with('offence')->latest()->paginate($perPage, ['*'], 'page', $currentPage);

        return response()->json($enviroList);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $site = Site::find($request->site_id);
        $old = Enviro::first();
        if($old)
        {
            $old_id = $old->id;
        }else{
            $old_id = 0;
        }
        // $prefix = strtoupper(substr($site->name, 0, 2));
        $digits = str_pad(strval(rand(0, 999999999)), 10, '0', STR_PAD_LEFT);
        
        $fpn_number = $old_id . $digits;
        $fpn_number = substr($fpn_number, 0, 9);

        $offender = Offender::create([
            'salutation' => $request->salutation,
            'first_name' => $request->forename,
            'last_name' => $request->surname,
            'address' => $request->houseNo,
            'town' => $request->town,
            'county' => $request->county,
            'post_code' => $request->postalCode,
            'phone' => $request->mobile,
            'date_of_birth' => $request->dateofbirth,
            'ethnicity' => $request->ethnicity,
            'gender' => $request->gender,
            'is_bwc_active' => ($request->activeBWC == 'yes') ? 1 : 0,
            'proof_of_address' => $request->proofOfAddress,
            'proof_of_id' => $request->proofId,
            'ref_no' => $request->refNo
        ]);

        $offender_id = $offender->id;

        // Generate Barcode
        $iin = 982651900 . $fpn_number;

        $iin_str = str_split((string)$iin);
        $refactered = [];
        foreach($iin_str as $i => $val)
        {
            $num = $val;
            if($i % 2 == 0){
                array_push($refactered, $num);
            }
            else{
                $multiple = $num * 2;
                array_push($refactered, $multiple);
            }
        }

        $count = 0;
        $luhn = 0;
        foreach($refactered as $i => $val)
        {
            if(is_nan($val))
            {
                $count = $count + (int)$val;
            }else{
                $count = $count + $val;
            }
        }  

        $lastDigit = $count % 10;

        if($lastDigit > 0)
        {
            $nextMultiple = ceil($count / 10) * 10;
            $luhn = abs($nextMultiple - $count);
        }
        
        $barcode = $iin . $luhn;

        $enviro = Enviro::create([
            'fpn_number' => $fpn_number,
            'barcode' => $barcode,
            'site_id' => $request->site_id,
            'zone_id' => $request->zone_id,
            'officer_id' => $request->officer_id,
            'offence_id' => $request->offence_id,
            'offence_type_id' => $request->offence_type_id,
            'language' => $request->language,

            'admin_id' => $request->admin,
            'offender_id' => $offender_id,
            'prefix_id' => $request->prefix,
            'location_id' => $request->location,
            'action_id' => $request->action,
            'caution' => $request->caution,
            'second_caution' => $request->secondCaution,
            'offender_reply' => ($request->offenderReply == 'yes') ? 1 : 0,
            'description' => $request->description,
            'description_waste' => $request->descriptionOfWaste,
            'offence_location' => $request->offenceLocation,
            'land_type_id' => $request->typeOfLand,
            'town_area' => $request->townArea,
            'poi_prefix_id' => $request->POIprefix,
            'poi' => $request->POI,
            'visibility_id' => $request->visibility,
            'weather_id' => $request->weather,
            'offence_datetime' => $request->offenceDateTime,
            'issue_datetime' => $request->issueDateTime,
            'enviro_issued_onspot' => ($request->enviroIssueOnSpot == true) ? 1 : 0,
            'is_witness_available' => ($request->isWitnessAvailable == 'yes' ? 1 : 0 ),
            'officer_statement' => $request->officerStatement
        ]);

        return response()->json($enviro);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $enviro = Enviro::with('site', 'zone', 'offence', 'offender')->find($id);
        if(!$enviro)
        {
            return response()->json([
                'success' => false,
                'error_type' => 'not_found',
            ]);
        }

        $officer_id = $enviro->officer_id;
        $ethnicity_id = $enviro->offender->ethnicity;
        $offence_type_id = $enviro->offence_type_id;
        $admin_id = $enviro->admin_id;
        $prefix_id = $enviro->prefix_id;
        $location_id = $enviro->location_id;
        $action_id = $enviro->action_id;
        $land_type_id = $enviro->land_type_id;
        $area_id = $enviro->town_area;
        $poi_prefix_id = $enviro->poi_prefix_id;
        $visibility_id = $enviro->visibility_id;
        $weather_id = $enviro->weather_id;


        // Proof of Address
        $address_proof_id = $enviro->offender->proof_of_address;
        if($address_proof_id)
        {
            $verified_address = AddressVerifiedBy::find($address_proof_id);
            if($verified_address)
            {
                $enviro->offender->verified_address = $verified_address->textOnMachine;
            }else{
                $enviro->offender->verified_address = null;
            }
        }else{
            $enviro->offender->verified_address = null;
        }

        // Proof of ID
        $id_proof_id = $enviro->offender->proof_of_id;
        if($id_proof_id)
        {
            $id_shown = IdShown::find($id_proof_id);
            if($id_shown)
            {
                $enviro->offender->id_shown = $id_shown->textOnMachine;
            }else{
                $enviro->offender->id_shown = null;
            }
        }else{
            $enviro->offender->id_shown = null;
        }

        // Officer
        $officer = User::find($officer_id);
        if($officer)
        {
            $item = [
                'name' => $officer->name,
                'first_name' => $officer->first_name,
                'last_name' => $officer->last_name,
                'email' => $officer->email
            ];
            $enviro->officer = $item;
        }else{
            $enviro->officer = null;
        }

        // Site Offences for Amount
        $site_offence = SiteOffence::find($offence_type_id);
        $amount = [];
        $amount = [
            'amount_reduced' => 'Undefined',
            'days_reduced' => 'Undefined',
            'amount_full' => 'Undefined',
            'days_full' => 'Undefined',
            'court_fees' => 'Undefined',
            'max_fine' => 'Undefined',
            'show_reduced' => false
        ];

        $enviro->offence_type_name = null;

        if($site_offence)
        {
            $amount_reduced = $site_offence->charge_amount_reduced;
            $days_reduced = (int)$site_offence->charge_days_reduced;
            $amount_full = $site_offence->charge_amount_full;
            $days_full = $site_offence->charge_days_full;
            $court_fees = $site_offence->court_fees;
            $max_fine = $site_offence->max_fine;

            $offence_type = Offence::find($site_offence->offence_id); 
            $enviro->offence_type_name = $offence_type->name;
            $issue_date = Carbon::createFromFormat('Y-m-d H:i', $enviro->issue_datetime);
            $now = Carbon::now();

            $diffInDays = $now->diffInDays($issue_date);
            $deadline = null;

            if($diffInDays > $days_reduced)
            {
                $show_reduced = false;
            }else{
                $show_reduced = true;
                $deadline = $issue_date->addDays($days_reduced);
                $deadline = date('d M, Y', strtotime($deadline));
            }

            $amount = [
                'amount_reduced' => $amount_reduced,
                'days_reduced' => $days_reduced,
                'amount_full' => $amount_full,
                'days_full' => $days_full,
                'court_fees' => $court_fees,
                'max_fine' => $max_fine,
                'show_reduced' => $show_reduced,
                'deadline' => $deadline
            ];
        }

        $enviro->amount = $amount;

        // Offence Type
        $data = Offence::find($offence_type_id);
        if($data)
        {
            $item = [
                'name' => $data->name
            ];
            $enviro->offence_type = $item;
        }else{
            $enviro->offence_type = null;
        }

        // Admin
        $data = User::find($admin_id);
        if($data)
        {
            $item = [
                'name' => $data->name,
                'first_name' => $data->first_name,
                'last_name' => $data->last_name,
                'email' => $data->email
            ];
            $enviro->admin = $item;
        }else{
            $enviro->admin = null;
        }

        // Location Prefix
        $data = OffenceLocationPrefix::find($prefix_id);
        if($data)
        {
            $item = [
                'id' => $data->id,
                'name' => $data->textOnMachine
            ];
            $enviro->location_prefix = $item;
        }else{
            $enviro->location_prefix = null;
        }

        // Location Suffix
        $data = OffenceLocationSuffix::find($location_id);
        if($data)
        {
            $item = [
                'id' => $data->id,
                'name' => $data->textOnMachine
            ];
            $enviro->location = $item;
        }else{
            $enviro->location = null;
        }

        // Action
        $data = OffenceHow::find($action_id);
        if($data)
        {
            $item = [
                'id' => $data->id,
                'name' => $data->textOnMachine
            ];
            $enviro->action = $item;
        }else{
            $enviro->action = null;
        }

        // Ethnicity
        $data = Ethnicity::find($ethnicity_id);
        if($data)
        {
            $item = [
                'id' => $data->id,
                'name' => $data->textOnMachine
            ];
            $enviro->ethnicity = $item;
        }else{
            $enviro->ethnicity = null;
        }

        // Type of Land
        $data = TypeOfLand::find($land_type_id);
        if($data)
        {
            $item = [
                'id' => $data->id,
                'name' => $data->name
            ];
            $enviro->type_of_land = $item;
        }else{
            $enviro->type_of_land = null;
        }

        // Town/Area
        $data = Area::find($area_id);
        if($data)
        {
            $item = [
                'id' => $data->id,
                'name' => $data->name
            ];
            $enviro->area = $item;
        }else{
            $enviro->area = null;
        }

        // POI Prefix
        $data = OffenceLocationPrefix::find($poi_prefix_id);
        if($data)
        {
            $item = [
                'id' => $data->id,
                'name' => $data->textOnMachine
            ];
            $enviro->poi_prefix = $item;
        }else{
            $enviro->poi_prefix = null;
        }

        // Visibility
        $data = Visibility::find($visibility_id);
        if($data)
        {
            $item = [
                'id' => $data->id,
                'name' => $data->visibility
            ];
            $enviro->visibility = $item;
        }else{
            $enviro->visibility = null;
        }

        // Weather
        $data = Weather::find($weather_id);
        if($data)
        {
            $item = [
                'id' => $data->id,
                'name' => $data->textOnMachine
            ];
            $enviro->weather = $item;
        }else{
            $enviro->weather = null;
        }

        // Fetch Images
        $images = EnviroImage::where('enviro_id', $enviro->id)->get();
        $enviro->images = $images;
        // Fetch Enviro Payments
        $payments = UserPayment::where('enviro_id', $enviro->id)->orderBy('id','desc')->get();
        foreach($payments as $pay)
        {
            $cdate = $pay->created_at;
            $pay->date = date('d M, Y', strtotime($cdate));
        }
        $enviro->payments = $payments;

        // Fetch Representations
        $reps = Representation::where('enviro_id', $enviro->id)->orderBy('id','desc')->get();
        foreach($reps as $rep)
        {
            $cdate = $rep->created_at;
            $rep->date = date('d M, Y', strtotime($cdate));
        }
        $enviro->representations = $reps;

        return response()->json([
            'success' => true,
            'data' => $enviro
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $enviro = Enviro::findOrFail($id);
        $enviro->update($request->all());

        return response()->json($enviro);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $enviro = Enviro::findOrFail($id);
        $enviro->delete();

        return response()->json(['message' => 'Enviro deleted successfully']);
    }
}
