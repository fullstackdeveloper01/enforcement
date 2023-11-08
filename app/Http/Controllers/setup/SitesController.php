<?php

namespace App\Http\Controllers\setup;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\setup\SiteResource;
use Illuminate\Http\JsonResponse;
use App\Models\casemanagement\enviro\master\OffenceGroup;
use App\Models\casemanagement\enviro\master\Offence;
use App\Models\Setup\Site;
use App\Models\Setup\Zone;
use App\Models\Setup\Area;
use App\Models\Setup\SiteOffence;
use DB;
use Log;

class SitesController extends Controller
{
    public function list(Request $request)
    {
        $user = auth()->user();
        $searchQuery  = $request->get('q');
        $status = $request->get('status');
        $perPage = $request->get('perPage', 10);
        $currentPage = $request->get('currentPage', 1);
        $data = Site::when($searchQuery , function ($query) use ($searchQuery ) {
            $query->where(function($query) use ($searchQuery) {
             $query->where('name', 'LIKE', '%' . $searchQuery  . '%');
            });
        })
        ->when(isset($status), function ($query) use ($status) {
            $query->where('status', $status);
        })
        ->paginate($perPage, ['*'], 'page', $currentPage);

        return response()->json([
            'data' => SiteResource::collection($data),
            'pagination' => [
                'currentPage' => $data->currentPage(),
                'perPage' => $data->perPage(),
                'last_page' => $data->lastPage(),
                'total' => $data->total(),
            ],
        ]);

    }

    public function create(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string',
            'slug' => 'required',
            'geographical_area_id' => 'required',
            'address_line1' => 'required',
            'district' => 'required',
            'town' => 'required',
            'postal_code' => 'required',
            'country' => 'required',
            'geo_color' => 'required',
            'region_id' => 'required',
            'logo' => 'required'
        ]);

        if(auth()->check())
        {
            $user = auth()->user();
        }else{
            return response()->json(['message'=> 'Authentication Failed. Try to reload the page']);
        }
        
        // check for slug uniquness
        $slug = $request->slug;
        $slug_check = Site::where('slug', $slug)->first();
        if($slug_check)
        {
            $slug = \Str::slug($request->name);
        }


        $file = $request->logo;
        $ext = $file->getClientOriginalExtension();

        if(
            $ext !== 'jpg' && $ext !== 'JPG' && $ext !== 'jpeg' &&  $ext !== 'JPEG' &&
            $ext !== 'png' && $ext !== 'PNG' && $ext !== 'gif' && $ext !== 'GIF'
        )
        {
            return response()->json([
                'message' => 'Error! Allowed image extensions are jpg, png, and gif'
            ]);
        }

        $logo = uniqid(rand(9999, 999999)).date('dmY').'.'.$ext;
        $path = 'uploads/sites/logos/'.$logo;

        if(!is_dir('uploads/sites/logos'))
        {
            mkdir('uploads/sites/logos', 0777, true);
        }

        try {
            move_uploaded_file($file, $path);
        } catch (\Throwable $th) {
            return response()->json([
                'message' => 'Processing Error! Please try again later!'
            ]);
        }

        $site = new Site();
        $site->user_id = $user->id;
        $site->name = $request['name'];
        $site->slug = $slug;
        $site->geographical_area_id = $request['geographical_area_id'];
        $site->address_line1 = $request['address_line1'];
        $site->address_line2 = $request['address_line2'];
        $site->address_line3 = $request['address_line3'];
        $site->address_line4 = $request['address_line4'];
        $site->district = $request['district'];
        $site->town = $request['town'];
        $site->postal_code = $request['postal_code'];
        $site->county = $request['county'];
        $site->country = $request['country'];
        $site->geo_color = $request['geo_color'];
        $site->region_id = $request['region_id'];
        $site->logo = $logo;
        $site->save();


        // Create site_offences
        $site_id = $site->id;

        $offences = Offence::get();
        if(count($offences) > 0)
        {
            foreach($offences as $obj)
            {
                $offence_id = $obj->id;
                $group_id = $obj->group;
                $max_fine = $obj->maxFine;
                SiteOffence::create([
                    'site_id' => $site_id,
                    'offence_id' => $offence_id,
                    'offence_group_id' => $group_id,
                    'max_fine' => $max_fine
                ]);
            }
        }

        return response()->json(['message' => 'Site has been created successfully'], 200);
    }

    public function update_enviro_tab(Request $request, $id)
    {
        $validatedData = $request->validate([
            'notice_charge_amount_reduced' => 'required',
            'notice_charge_days_reduced' => 'required',
            'notice_charge_amount_full' => 'required',
            'notice_charge_days_full' => 'required',
            'default_extension_days' => 'required',
            'gdpr_url_expiry_hours' => 'required'
        ]);


        $site = Site::find($id);
        if (!$site) {
            return response()->json(['message' => 'Item not found'], 404);
        }

        $site->notice_charge_amount_reduced = $request['notice_charge_amount_reduced'];
        $site->notice_charge_days_reduced = $request['notice_charge_days_reduced'];
        $site->notice_charge_amount_full = $request['notice_charge_amount_full'];
        $site->notice_charge_days_full = $request['notice_charge_days_full'];
        $site->default_extension_days = $request['default_extension_days'];
        $site->gdpr_url_expiry_hours = $request['gdpr_url_expiry_hours'];

        $site->save();

        SiteOffence::where('site_id', $id)->update([
            'charge_amount_reduced' => $request['notice_charge_amount_reduced'],
            'charge_days_reduced' => $request['notice_charge_days_reduced'],
            'charge_amount_full' => $request['notice_charge_amount_full'],
            'charge_days_full' => $request['notice_charge_days_full'],
        ]);      

        return response()->json(['message' => 'Enviro details updated successfully'], 200);

    }

    public function findById($id)
    {
        $sites = Site::find($id);
        if(!$sites){
            return response()->json([
                'message' => "No data available.",
            ],201);
        }

        return response()->json([
            'message' => "Site details.",
            'data' => new SiteResource($sites)
        ],200);
    }
    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'name' => 'required|string',
            'slug' => 'required',
            'geographical_area_id' => 'required',
            'address_line1' => 'required',
            'district' => 'required',
            'town' => 'required',
            'postal_code' => 'required',
            'country' => 'required',
            'geo_color' => 'required',
            'region_id' => 'required',
        ]);


        $site = Site::find($id);
        if (!$site) {
            return response()->json(['message' => 'Item not found'], 404);
        }

        // Check for logo
        if(isset($request['logo']) && $request['logo'] !== null)
        {
            $file = $request['logo'];
            $ext = $file->getClientOriginalExtension();

            if(
                $ext !== 'jpg' && $ext !== 'JPG' && $ext !== 'jpeg' &&  $ext !== 'JPEG' &&
                $ext !== 'png' && $ext !== 'PNG' && $ext !== 'gif' && $ext !== 'GIF'
            )
            {
                return response()->json([
                    'message' => 'Error! Allowed image extensions are jpg, png, and gif'
                ]);
            }

            $logo = uniqid(rand(9999, 999999)).date('dmY').'.'.$ext;
            $path = 'uploads/sites/logos/'.$logo;

            if(!is_dir('uploads/sites/logos'))
            {
                mkdir('uploads/sites/logos', 0777, true);
            }

            try {
                move_uploaded_file($file, $path);
            } catch (\Throwable $th) {
                return response()->json([
                    'message' => 'Processing Error! Please try again later!'
                ]);
            }

            $site->logo = $logo;
        }

        $site->name = $request['name'];
        $site->slug = $request['slug'];
        $site->geographical_area_id = $request['geographical_area_id'];
        $site->address_line1 = $request['address_line1'];
        $site->address_line2 = $request['address_line2'];
        $site->address_line3 = $request['address_line3'];
        $site->address_line4 = $request['address_line4'];
        $site->district = $request['district'];
        $site->town = $request['town'];
        $site->postal_code = $request['postal_code'];
        $site->county = $request['county'];
        $site->country = $request['country'];
        $site->geo_color = $request['geo_color'];
        $site->region_id = $request['region_id'];
        $site->save();
        
        return response()->json(['message' => 'Site has been updated successfully'], 200);
    }

    public function fetch_zones($site_id)
    {
        if(!$site_id)
        {
            return response()->json(['message','Unknow error occured. Please try again'], 400);
        }

        $zones = Zone::where('site_id', $site_id)->get();
        
        return response()->json($zones);
    }

    public function create_zone(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string',
            'site_id' => 'required',
        ]);

        if($request['is_hotspot'] == true)
        {
            $is_hotspot = "1";
        }else{
            $is_hotspot = "0";
        }

        // check uniqueness
        $check = Zone::where('name', $request->name)->first();
        if($check)
        {
            return response()->json(['message' => 'Zone name should be unique!'], 400);
        }

        $user = auth()->user();

        $zone = new Zone();
        $zone->user_id = $user->id;
        $zone->site_id = $request['site_id'];
        $zone->name = $request['name'];
        $zone->town = $request['town'];
        $zone->address_line1 = $request['address_line1'];
        $zone->address_line2 = $request['address_line2'];
        $zone->post_code = $request['post_code'];
        $zone->is_hotspot = $is_hotspot;
        $zone->save();

        return response()->json(['message' => 'Zone has been added successfully'], 200);

    }

    public function update_status(Request $request, $id)
    {
        Log::info($request);
        // $id = $request->id;
        $site = Site::find($id);
        if($site)
        {
            $new = ($site->status == '1') ? '0': '1';
            
            Site::whereId($id)->update([
                'status' => $new
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Status updated successfully'
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Unknow error occured!'
        ]);
    }

    public function listZonesBySite($site_id)
    {
        $zones = Zone::where('site_id', $site_id)->get();
        $data = [];
        if(count($zones) > 0)
        {
            foreach($zones as $zone)
            {
                $item = [
                    'id' => $zone->id,
                    'name' => $zone->name
                ];

                array_push($data, $item);
            }
        }
        return response()->json([
            'success' => true,
            'data' => $data
        ]);
    }

    public function fetch_towns($site_id)
    {
        $areas = Area::where('site_id', $site_id)->get();

        $data = [];
        if(count($areas) > 0)
        {
            foreach($areas as $obj)
            {
                $item = [
                    'id' => $obj->id,
                    'name' => $obj->name
                ];

                array_push($data, $item);
            }
        }
        return response()->json($data);
    }

    public function check_slug(Request $request)
    {
        $slug = $request->slug;

        $res = Site::where('slug', $slug)->first();
        if($res)
        {
            return response()->json([
                'success' => true,
                'found' => true,
            ]);
        }

        return response()->json([
            'success' => true,
            'found' => false,
        ]);
    }

    public function create_area(Request $request, $id)
    {
        $validatedData = $request->validate([
            'name' => 'required',
        ]);

        $name = $request->name;
        $zones = $request->zone_list;
        $zone_list = null;

        if(!empty($zones))
        {
            $zone_list = implode(',', $zones);
        }

        Area::create([
            'site_id' => $id,
            'name' => $name, 
            'zone_list' => $zone_list 
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Area/Town created successfully',
        ]);
    }

    public function fetch_areas($id)
    {
        $areas = [];

        $data = Area::where('site_id', $id)->get();
        if(count($data) > 0)
        {
            foreach($data as $obj)
            {
                $id = $obj->id;
                $name = $obj->name;
                $zones = [];
                $zone_list = $obj->zone_list;
                if($zone_list !== null)
                {
                    $zones = explode(',', $zone_list);
                }

                $item = [
                    'id' => $id,
                    'name' => $name,
                    'zones' => $zones
                ];

                array_push($areas, $item);
            }
        }

        return response()->json([
            'success' => true,
            'data' => $areas
        ]);
    }

    public function update_area(Request $request, $id)
    {
        $validatedData = $request->validate([
            'name' => 'required',
        ]);

        $name = $request->name;
        $zones = $request->zones;
        $zone_list = null;

        if(!empty($zones))
        {
            $zone_list = implode(',', $zones);
        }

        Area::where('id', $request->id)->update([
            'name' => $name, 
            'zone_list' => $zone_list 
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Areas/Towns updated successfully',
        ]);
    }

    public function delete_area(Request $request, $id)
    {
        $area = Area::find($id);
        if($area)
        {
            $area->delete();
        }

        return response()->json([
            'success' => true,
            'message' => 'Areas deleted successfully',
        ]);
    }

    public function fetch_site_offences($site_id)
    {
        $data = SiteOffence::where('site_id', $site_id)->get();

        if(count($data) > 0)
        {
            foreach($data as $obj)
            {
                $offence_id = $obj->offence_id;
                $offence = Offence::find($offence_id);
                $offence_group = OffenceGroup::find($offence->group); 

                $obj->offence = $offence;
                $obj->offence_group = $offence_group;

                $obj->status = ($obj->status == 1) ? true : false;
            }
        }

        return response()->json([
            'success' => true,
            'data' => $data
        ]);
    }

    public function update_offence(Request $request)
    {
        $id = $request->id;

        SiteOffence::where('id', $id)->update([
            'charge_amount_reduced' => $request->charge_amount_reduced,
            'charge_days_reduced' => $request->charge_days_reduced,
            'charge_amount_full' => $request->charge_amount_full,
            'charge_days_full' => $request->charge_days_full,
            'court_fees' => $request->court_fees,
            'max_fine' => $request->max_fine
        ]); 

        return response()->json([
            'success' => true,
            'message' => 'Offence details updated successfully'
        ]);
    }

    public function delete_offence(Request $request, $id)
    {
        $offence = SiteOffence::find($id);
        if($offence)
        {
            $offence->delete();
        }

        return response()->json([
            'success' => true,
            'message' => 'Offence data deleted for this site'
        ]);
    }

    public function update_zones(Request $request)
    {
        $request->validate([
            'name' => 'required'
        ]);

        $id = $request->id;
        $name = $request->name;
        $town = $request->town;
        $address_line1 = $request->address_line1;
        $address_line2 = $request->address_line2;
        $post_code = $request->post_code;
        
        if($request['is_hotspot'] == true)
        {
            $is_hotspot = "1";
        }else{
            $is_hotspot = "0";
        }

        Zone::where('id', $id)->update([
            'name' => $name,
            'town' => $town,
            'address_line1' => $address_line1,
            'address_line2' => $address_line2,
            'post_code' => $post_code,
            'is_hotspot' => $is_hotspot
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Record successfully updated'
        ]);
    }

    public function delete_zones($id)
    {
        $data = Zone::find($id);
        if($data)
        {
            $data->delete();
        }

        return response()->json([
            'success' => true,
            'message' => 'Zone/Ward deleted successfully'
        ]);
    }

    public function change_site_offences_status(Request $request, $id)
    {
        $data = SiteOffence::find($id);
        if($data)
        {
            $status = ($data->status == 1) ? 0 : 1;
            
            SiteOffence::whereId($id)->update([
                'status' => $status
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Status updated successfully'
            ]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Something went wrong. Please try again later'
        ], 400);
    }
}
