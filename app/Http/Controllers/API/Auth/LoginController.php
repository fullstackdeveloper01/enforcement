<?php

namespace App\Http\Controllers\API\Auth;

use Illuminate\Http\Request;
use App\Notifications\TwoFactorCode;
use App\Http\Controllers\API\BaseController;
use App\Http\Resources\UserRolePermissionResource;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Models\User;
use Illuminate\Support\Facades\Validator;

class LoginController extends BaseController
{
    /**
     * Handle a login request to the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\Response
     */
    public function login(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'email' => 'required|email',
                'password' => 'required',
            ]);
            
            if ($validator->fails()) {
                return $this->sendError('Validation Error.', $validator->errors());
            }
            if (auth()->attempt(['email' => $request->email, 'password' => $request->password], false, false)) {
                if (Auth::user()->two_factor_status) {
                    $authUser = Auth::user();
                    //Generate and send two factor notification code to user in email.
                    $authUser->generateTwoFactorCode();
                    Auth::user()->notify(
                        new TwoFactorCode($authUser)
                    );
                    
                    $data['key'] =  Auth::user()->user_key;

                    return $this->sendResponse(
                        "Please check your email we have sent you a code to verify your accout.",
                        $data
                    );
                }
            } else {
                return $this->sendError("Your email or password is incorrect.");
            }
        } catch (\Throwable $th) {
            return $this->sendError($th->getMessage());
        }
    }

    /**
     * Logout user (Revoke the token)
     *
     * @return [string] message
     */
    public function logout(Request $request)
    {
        $request->user()->token()->revoke();
        return $this->sendResponse("You are successfully logout from the system.");
    }
}
