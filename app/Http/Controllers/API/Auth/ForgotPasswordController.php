<?php

namespace App\Http\Controllers\API\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController;
// use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Illuminate\Support\Facades\Password;
use Validator;

class ForgotPasswordController extends BaseController
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset emails and
    | includes a trait which assists in sending these notifications from
    | your application to your users. Feel free to explore this trait.
    |
    */

    // use SendsPasswordResetEmails;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    public function sendResetLinkEmail(Request $request)
    {        
        try {
            $validator = Validator::make($request->all(), [
                'email' => 'required|email'
            ]);

            if ($validator->fails()) {
                return $this->sendError('Validation Error.', $validator->errors());       
            }

            $response = Password::sendResetLink(
                request()->only('email')
            );

            switch ($response) {
                case Password::RESET_LINK_SENT:
                    return $this->sendResponse("Password reset link sent successfully.");
                case Password::INVALID_USER:
                    return $this->sendError(trans($response));
            }
        } catch (Exception $e) {
            return $this->sendError('Something went wrong.', $e->getMessage());
        }
    }
}
