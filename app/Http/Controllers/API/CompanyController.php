<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Company;
use App\Http\Resources\CompanyResource;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;


class CompanyController extends Controller
{
    public function index()
    {
        $this->authorize('view', Company::class);
        $user = auth()->user();
        $company = Company::where('user_id',$user->id)->where('deleted',0)->with('role')->get();
        if(!$company){
            return response()->json([
                'message' => "No company available.",
            ],201);
        }
        return CompanyResource::collection($company);

    }

    public function show($id)
    {
        $this->authorize('view', Company::class);
        $user = auth()->user();
        $company = Company::where('user_id',$user->id)->where('deleted',0)->with('role')->find($id);
        if(!$company){
            return response()->json([
                'message' => "No company available.",
            ],201);
        }
        return new CompanyResource($company);
    }
}
