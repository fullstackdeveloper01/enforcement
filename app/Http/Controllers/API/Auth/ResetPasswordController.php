<?php

namespace App\Http\Controllers\API\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Hash;
use Illuminate\Auth\Events\PasswordReset;
use Validator;

class ResetPasswordController extends BaseController
{
    use ResetsPasswords;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest:api');
    }

    public function reset(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), $this->rules());

            if ($validator->fails()) {
                return $this->sendError('Validation Error.', $validator->errors());       
            }

            $response = Password::reset(
                $request->only('email', 'password', 'password_confirmation', 'token'),
                function ($user) use ($request) {
                    $user->password = Hash::make($request->password);
                    $user->setRememberToken(Str::random(60));
                    if ($user->save()) {
                        $user->tokens()->delete();
                        event(new PasswordReset($user));
                    }
                }
            );

            switch ($response) {
                case Password::PASSWORD_RESET:
                    return $this->sendResponse("Your password has been updated successfully.");
                default:
                    return $this->sendError(trans($response));
            }
        } catch (\Exception $e) {
            $message = $e->getMessage() . ' at ' . $e->getLine() . ' in ' . $e->getFile();
            return $this->sendError('Something went wrong.', $message);
        }
    }

    // Create rules for the valiation.
    public function rules()
    {
        return [
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required',
            'password_confirmation' => 'required|same:password',
        ];
    }
}
