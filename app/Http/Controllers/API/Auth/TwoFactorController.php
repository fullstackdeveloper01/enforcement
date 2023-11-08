<?php

namespace App\Http\Controllers\API\Auth;

use App\Http\Controllers\API\BaseController;
use App\Http\Resources\UserPermissionResource;

use App\Http\Resources\UserResource;
use App\Models\User;
use App\Notifications\TwoFactorCode;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Validator;
class TwoFactorController extends BaseController
{
    public function __construct()
    {
        $this->middleware(['auth:api']);
    }

    public function verify(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'key' => 'required',
                'two_factor_code' => 'required',
            ]);
    
            if ($validator->fails()) {
                return $this->sendError('Validation Error.', $validator->errors());       
            }
            
            $user = User::where('user_key', $request->key)->where('two_factor_code', $request->two_factor_code)->first();
            if ($user) {
                $tokenTime = Carbon::parse($user->two_factor_expires_at);
                $currentTime = Carbon::now();
                if($currentTime->diffInMinutes($tokenTime) > 5) {
                    return $this->sendError("The two factor code verification time is over. Please resend the two factor.");
                }
                $user->resetTwoFactorCode(); 
                
                $tokenResult = $user->createToken('Personal Access Token');
                $token = $tokenResult->token;
                $token->save();
                $data['accessToken'] = $tokenResult->accessToken;

                $data['userData'] = ['id' => $user->id,'name' => $user->name, 
                                   'email' => $user->email, 
                                    'role' => $user->role ,
                                    "abilities" => UserPermissionResource::collection($user->role->roleHasPermissions)
                                ];
                return $this->sendResponse("Two factor verification successfully.", $data);
            }
            
           return $this->sendError("The two factor code you have entered does not match.");
        } catch (\Throwable $th) {
            return $this->sendError($th->getMessage());
        }
    }

    public function resend()
    {
        try {
            $user = auth()->user();
            $user->generateTwoFactorCode();
            $user->notify(new TwoFactorCode($user));
            $data['key'] = $user->user_key;
            return $this->sendResponse("The two factor code has been sent again.", $data);
        } catch (\Throwable $th) {
            return $this->sendError($th->getMessage());
        }
    }
}

