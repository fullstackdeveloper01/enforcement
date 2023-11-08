<?php

namespace App\Http\Controllers\API\App;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use App\Models\Setup\Site;
use App\Models\Setup\Zone;
use App\Models\Setup\Area;
use App\Models\Setup\SiteOffence;
use App\Models\AssignedSite;
use App\Models\casemanagement\enviro\Offender;
use App\Models\casemanagement\enviro\Enviro;
use App\Models\casemanagement\enviro\EnviroImage;
use App\Models\casemanagement\enviro\master\Offence;
use App\Models\casemanagement\enviro\master\OffenceGroup;
use App\Models\casemanagement\enviro\master\AddressVerifiedBy;
use App\Models\casemanagement\enviro\master\IdShown;
use App\Models\casemanagement\enviro\master\Ethnicity;
use App\Models\casemanagement\enviro\master\OffenceLocationSuffix;
use App\Models\casemanagement\enviro\master\OffenceHow;
use App\Models\casemanagement\enviro\master\TypeOfLand;
use App\Models\casemanagement\enviro\master\OffenceLocationPrefix;
use App\Models\casemanagement\enviro\master\Visibility;
use App\Models\casemanagement\enviro\master\Weather;
use App\Models\User;
use Carbon\Carbon;
use Validator;

class FpnController extends Controller
{
    public function fetch_enviro_data(Request $request)
    {
        if(!isset($request->site_id))
        {
            return response()->json([
                'success' => false,
                'message' => 'site_id is a required parameter'
            ]);
        }else{
            if($request->site_id == null || $request->site_id == '')
            {
                return response()->json([
                    'success' => false,
                    'message' => 'site_id is a required parameter'
                ]);
            }
        }

        $site_id = $request->site_id;

        // Check for site validity
        $site = Site::select('id', 'name','slug')->find($site_id);

        if(!$site)
        {
            return response()->json([
                'success' => false,
                'message' => 'Invalid `site_id` provided.'
            ]);
        }

        // Fetch Admins
        $admins = User::where('role_id', 1)->select('id', 'name','first_name','last_name', 'email')->get();
        $site->admins = $admins;

        // Fetch Officers
        $officers = User::where('is_officer', 1)->select('id', 'name','first_name','last_name', 'email')->get();
        $site->officers = $officers;

        // Fetch Zones
        $zones = Zone::where('site_id', $site_id)->select('id', 'name')->get();
        $site->zones = $zones;

        // Fetch Active Offence Groups
        $offence_groups = OffenceGroup::where('status', '1')->select('id','englishName as name')->get();
        $site->offence_groups = $offence_groups;

        // Fetch Active Proof of Address
        $address_proofs = AddressVerifiedBy::where('status', '1')->select('id','textOnMachine as name')->get();
        $site->address_proofs = $address_proofs;

        // Fetch Active Proof of ID
        $id_proofs = IdShown::where('status', '1')->select('id','textOnMachine as name')->get();
        $site->id_proofs = $id_proofs;

        // Fetch Active Ethnicities
        $ethnicities = Ethnicity::where('status', '1')->select('id','textOnMachine as name')->get();
        $site->ethnicities = $ethnicities;

        // Fetch Active Locations (Suffix)
        $locations = OffenceLocationSuffix::where('status', '1')->select('id','textOnMachine as name')->get();
        $site->locations = $locations;

        // Fetch Active Actions
        $actions = OffenceHow::where('status', '1')->select('id','textOnMachine as name')->get();
        $site->actions = $actions;

        // Fetch Land Types
        $land_types = TypeOfLand::where('status', '1')->select('id','name')->get();
        $site->land_types = $land_types;

        // Fetch Towns
        $towns = Area::where('site_id', $site_id)->select('id','name')->get();
        $site->towns = $towns;

        // Fetch POI Prefix
        $poi_prefix = OffenceLocationPrefix::where('status', '1')->select('id','textOnMachine as name')->get();
        $site->poi_prefix = $poi_prefix;

        // Fetch Visibility List
        $visibility = Visibility::where('status', '1')->select('id','visibility as name')->get();
        $site->visibility = $visibility;

        // Fetch Weathers
        $weathers = Weather::where('status', '1')->select('id','textOnMachine as name')->get();
        $site->weathers = $weathers;
        
        return response()->json([
            'success' => true,
            'data' => $site
        ]);

    }

    public function fetch_offence_types(Request $request, $site_id, $offence_group_id)
    {
        $site_offences = SiteOffence::where('offence_group_id', $offence_group_id)->where('site_id', $site_id)->where('status', 1)->get();
        $data = [];
        if(count($site_offences) > 0)
        {
            foreach($site_offences as $obj)
            {
                $offence_id = $obj->offence_id;
                $offence = Offence::find($offence_id);
                $item = [
                    'id' => $offence->id,
                    'name' => $offence->name,
                    'min_images_required' => $offence->minImageRequired
                ];

                array_push($data, $item);
            }
        }

        return response()->json([
            'success' => true,
            'data' => $data
        ]);
    }

    public function fetch_all_sites()
    {
        $searchQuery = false;

        $user = Auth::guard('api')->user();

        if(isset($_GET['q']))
        {
            $searchQuery = $_GET['q'];
        }

        // Get Assigned Sites of this user;
        $sites = [];
        $site_ids = AssignedSite::where('user_id', $user->id)->get()->pluck('site_id');

        if(count($site_ids) > 0)
        {
            $siteIds = $site_ids->toArray();
            
            $sites = Site::when($searchQuery , function ($query) use ($searchQuery ) {
                $query->where(function($query) use ($searchQuery) {
                $query->where('name', 'LIKE', '%' . $searchQuery  . '%');
                });
            })
            ->whereIn('id', $siteIds)
            ->with('offences')
            ->select('id', 'name', 'slug', 'geographical_area_id as geographical_area', 'address_line1', 'address_line2', 'district', 'town', 'postal_code', 'county', 'country', 'geo_color', 'logo', 'region_id as region', 'notice_charge_amount_reduced', 'notice_charge_days_reduced', 'notice_charge_amount_full', 'notice_charge_days_full', 'default_extension_days', 'gdpr_url_expiry_hours', 'status','created_at')
            ->get();

            if(count($sites) > 0)
            {
                foreach($sites as $site)
                {
                    $site_id = $site->id;
                    $offences = $site->offences;

                    if($site->logo !== null)
                    {
                        $site->logo = 'uploads/sites/logos/'.$site->logo;
                    }

                    $offenceData = [];

                    if(count($offences) > 0)
                    {
                        foreach($offences as $offence)
                        {
                            $offence_type = Offence::find($offence->offence_id);
                            if($offence_type)
                            {
                                $offence_type_name = $offence_type->name;
                                $offence_group_id = $offence_type->group;
                                $offence_group = null;
                                $group = OffenceGroup::find($offence_group_id);
                                if($group)
                                {
                                    $offence_group = $group->englishName;
                                } 

                                $offence->name = $offence_type_name;
                                $offence->group = $offence_group;
                            }
                        }
                    }
                }
            }
        }

        return response()->json([
            'success' => true,
            'data' => $sites
        ]);
    }

    public function create_enviro(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'site_id' => 'required',
            'zone_id' => 'required',
            'officer_id' => 'required',
            'offence_id' => 'required',
            'offence_type_id' => 'required',
            'language' => 'required',
            'salutation' => 'required',
            'first_name' => 'required',
            'last_name' => 'required',
            'address' => 'required',
            'town' => 'required',
            'post_code' => 'required',
            'gender' => 'required',
            'ethnicity_id' => 'required',
            'location_id' => 'required',
            'action_id' => 'required',
            'offence_location_id' => 'required',
            'land_type_id' => 'required',
            'visibility_id' => 'required',
            'weather_id' => 'required',
            'offence_datetime' => 'required|date_format:Y-m-d H:i',
            'issue_datetime' => [
                'required',
                'date_format:Y-m-d H:i',
                function ($attribute, $value, $fail) use ($request) {
                    $offenceDatetime = strtotime($request->input('offence_datetime'));
                    $issueDatetime = strtotime($value);
        
                    if ($offenceDatetime > $issueDatetime) {
                        $fail('The issue_datetime must be greater than the offence datetime.');
                    }
                },
            ],
            'signature' => 'required',
            'offence_images' => 'required'
        ]);

        if($validator->fails())
        {
            return response()->json([
                'success' => false,
                'message' => $validator->messages()->first()
            ]);
        }

        $site = Site::find($request->site_id);
        $prefix = strtoupper(substr($site->name, 0, 2));
        $digits = str_pad(strval(rand(0, 999999999)), 10, '0', STR_PAD_LEFT);

        $old = Enviro::first();
        if($old)
        {
            $old_id = $old->id;
        }else{
            $old_id = 0;
        }

        $digits = str_pad(strval(rand(0, 999999999)), 10, '0', STR_PAD_LEFT);
        
        $fpn_number = $old_id . $digits;
        $fpn_number = substr($fpn_number, 0, 9);

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

        // Check signature file
        $file = $request->file('signature');
        $ext = $file->getClientOriginalExtension();

        if(
            $ext !== 'jpg' && $ext !== 'JPG' && $ext !== 'jpeg' &&  $ext !== 'JPEG' &&
            $ext !== 'png' && $ext !== 'PNG'
        )
        {
            return response()->json([
                'success' => false,
                'message' => 'Error! Allowed file extensions are jpg, and png.'
            ]);
        }

        $sign = uniqid(rand(9999, 999999)).date('dmY').'.'.$ext;
        $path = 'uploads/enviro/signatures/'.$sign;

        if(!is_dir('uploads/enviro/signatures'))
        {
            mkdir('uploads/enviro/signatures', 0777, true);
        }

        try {
            move_uploaded_file($file, $path);
        } catch (\Throwable $th) {
            return response()->json([
                'success' => false,
                'message' => 'Processing Error! Please try again later!'
            ]);
        }

        $offender = Offender::create([
            'salutation' => $request->salutation,
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'address' => $request->address,
            'town' => $request->town,
            'county' => $request->county,
            'post_code' => $request->post_code,
            'phone' => $request->phone,
            'date_of_birth' => $request->date_of_birth,
            'ethnicity' => $request->ethnicity_id,
            'gender' => $request->gender,
            'is_bwc_active' => ($request->is_bwc_active == 'yes') ? 1 : 0,
            'proof_of_address' => $request->proof_of_address,
            'proof_of_id' => $request->proof_of_id,
            'ref_no' => $request->ref_no
        ]);

        $offender_id = $offender->id;

        $enviro = Enviro::create([
            'fpn_number' => $fpn_number,
            'barcode' => $barcode,
            'site_id' => $request->site_id,
            'zone_id' => $request->zone_id,
            'officer_id' => $request->officer_id,
            'offence_id' => $request->offence_id,
            'offence_type_id' => $request->offence_type_id,
            'language' => $request->language,
            'admin_id' => $request->admin_id,
            'offender_id' => $offender_id,
            'prefix_id' => $request->prefix_id,
            'location_id' => $request->location_id,
            'action_id' => $request->action_id,
            'caution' => $request->caution,
            'second_caution' => $request->second_caution,
            'offender_reply' => ($request->offender_reply == 'yes') ? 1 : 0,
            'description' => $request->description,
            'description_waste' => $request->description_waste,
            'offence_location' => $request->offence_location_id,
            'land_type_id' => $request->land_type_id,
            'town_area' => $request->area_id,
            'poi_prefix_id' => $request->poi_prefix_id,
            'poi' => $request->poi,
            'visibility_id' => $request->visibility_id,
            'weather_id' => $request->weather_id,
            'offence_datetime' => $request->offence_datetime,
            'issue_datetime' => $request->issue_datetime,
            'enviro_issued_onspot' => ($request->enviro_issued_onspot == 'yes') ? 1 : 0,
            'is_witness_available' => ($request->is_witness_available == 'yes' ? 1 : 0 ),
            'officer_statement' => $request->officer_statement,
            'signature' => $sign
        ]);

        // Upload Offence Images
        $offence_images = [];
        if($request->has('offence_images'))
        {
            $images = $request->offence_images;
            foreach($images as $file)
            {
                $ext = $file->getClientOriginalExtension();

                if(
                    $ext !== 'jpg' && $ext !== 'JPG' && $ext !== 'jpeg' &&  $ext !== 'JPEG' &&
                    $ext !== 'png' && $ext !== 'PNG'
                )
                {
                    // return response()->json([
                    //     'success' => false,
                    //     'message' => 'Error! Allowed file extensions are jpg, and png.'
                    // ]);
                    continue;
                }

                $file_name = uniqid(rand(9999, 999999)).date('dmY').'.'.$ext;
                $path = 'uploads/enviro/offences/'.$file_name;

                if(!is_dir('uploads/enviro/offences'))
                {
                    mkdir('uploads/enviro/offences', 0777, true);
                }

                try {
                    move_uploaded_file($file, $path);
                } catch (\Throwable $th) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Processing Error! Please try again later!'
                    ]);
                }
                $rec = EnviroImage::create([
                    'enviro_id' => $enviro->id,
                    'file' => $file_name
                ]);

                $item = [
                    'id' => $rec->id,
                    'file' => 'uploads/enviro/offences/'.$rec->file
                ];

                array_push($offence_images, $item);
            }
        }   

        $enviro->offence_images = $offence_images;

        // Gather Payable amount W.R.T site
        $site_offence = SiteOffence::where('site_id', $request->site_id)->where('offence_id', $request->offence_type_id)->first();
        
        $amount = [
            'notice_charge_days_reduced' => 0,
            'notice_charge_amount_reduced' => 0,
            'notice_charge_days_full' => 0,
            'notice_charge_amount_full' => 0
        ];

        if($site_offence)
        {
            $reduced_days = (int)$site_offence->charge_days_reduced;
            $full_days = (int)$site_offence->charge_days_full;
            $reduced_amount = $site_offence->charge_amount_reduced;
            $full_amount = $site_offence->charge_amount_full;

            $amount['notice_charge_days_reduced'] = $reduced_days;
            $amount['notice_charge_amount_reduced'] = $reduced_amount;
            $amount['notice_charge_days_full'] = $full_days;
            $amount['notice_charge_amount_full'] = $full_amount;
        }

        $enviro->amount = $amount;

        $enviro->signature = 'uploads/enviro/signatures/'.$sign;

        return response()->json([
            'success' => true,
            'data' => $enviro
        ]);

    }

}
 