<?php

namespace App\Http\Controllers\API\App;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        if(!isset($request->id) || $request->id == '' || $request->id == null)
        {
            return response()->json([
                'success' => false,
                'error_code' => 'id_required',
                'message' => "ID is a required field"
            ]);
        }

        if(!isset($request->pin) || $request->pin == '' || $request->pin == null)
        {
            return response()->json([
                'success' => false,
                'error_code' => 'pin_required',
                'message' => "Pin is a required field"
            ]);
        }

        $operator_number = $request->id;
        $pin = $request->pin;

        $user = User::where('operator_number', $operator_number)->where('pin_number', $pin)->first();
        if(!$user)
        {
            return response()->json([
                'success' => false,
                'error_code' => 'invalid_login',
                'message' => "Invalid login details"
            ]); 
        }

        $token = $user->createToken('App Password Grant')->accessToken;

        $userData = [
            'id' => $user->id,
            'name' => $user->name,
            'first_name' => $user->first_name,
            'last_name' => $user->last_name,
            'email' => $user->email
        ];
        
        return response()->json([
            'success' => true,
            'access_token' => $token,
            'user' => $userData
        ]);

    }
}
