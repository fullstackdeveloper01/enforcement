<?php

namespace App\Http\Controllers\srmanagement;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ServiceRequest;
use Validator;

class ServiceRequestController extends Controller
{
    public function index(){
      
    }
    public function createServiceRequest(Request $request){
        try{
            $validator = Validator::make($request->all(), [
                'site_id' => ['required'],
                'request_type_id' => ['required'],
                'busniness_waste_status' => ['required'],
                'complaint_option_status' => ['required'],
                'title' => ['required'],
                'job_title' => ['required'],
                'first_name' => ['required'],
                'last_name' => ['required'],
                'home_telephone' => ['required'],
                'work_telephone' => ['required'],
                'address' => ['required'],
                'email' => ['required'],
                'busniness_name' => ['required'],
                'busniness_address' => ['required'],
                'busniness_town' => ['required'],
                'busniness_country' => ['required'],
                'busniness_post_code' => ['required'],
                'reported_via_id' => ['required'],
                'address2' => ['required'],
                'ethnicity' => ['required'],
                'complaint_town' => ['required'],
                'gender' => ['required'],
                'complaint_country' => ['required'],
                'date_of_birth' => ['required'],
                'complaint_postal_code' => ['required'],

            ]);
            if ($validator->fails()) {
                return response()->json(['success'=>false,'message' => $validator->messages()], 200);
            }
            $post = $request->all();
            $service = ServiceRequest::create($post);
            if(empty($service)){
                return response()->json = [
                    'status' => false,
                    'message' => trans('message.service_error'),
                 ];
            }
            else{
                return response()->json = [
                    'status' => true,
                    'data'    => $service,
                    'message' => trans('message.service_success'),
                 ];
            }

        }catch(Exception $ex){
        return response()->json = [
            'status' => false,
            'message' => $ex->getMessage(),
            ];
        }
    }
    public function getAllService(){
        try{
            $getService = ServiceRequest::select('tbl_service_requests.*','sites.name as site_name')
            ->leftJoin("sites", "sites.id", "=", "tbl_service_requests.site_id")
            ->get();
            if(!empty($getService)){
                return response()->json = [
                    'success' => true,
                    'data'    => $getService,
                    'message' => trans('message.service_list'),
                 ];
            }else{
                return response()->json = [
                    'success' => false,
                    'data'    => $service,
                    'message' => trans('Data not found'),
                 ];
            }
        }catch(Exception $ex){
            return response()->json = [
            'status' => false,
            'message' => $ex->getMessage(),
            ];
        }
    }
}
