<?php

namespace App\Http\Controllers\Auth;

use App\Mail\ResetPassword;
use App\Users\Models\PasswordReset;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use JWTAuth;
use Validator;
use App\Mail\VerifyMail;
use App\Users\Models\User;
use Illuminate\Http\Request;
use PulkitJalan\GeoIP\GeoIP;
use App\Locations\Models\Country;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Users\Models\UserVerification;
use Tymon\JWTAuth\Exceptions\JWTException;

class AuthController extends Controller {
    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct() {
        $this->middleware('jwt-auth', ['except' => ['login']]);
    }


    /**
     * Get a JWT via given credentials.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request) {
        $credentials = $request->only('email', 'password');
        $rules = ['email' => 'required|email', 'password' => 'required'];
        $validator = Validator::make($credentials, $rules);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'errors' => $validator->messages()], 401);
        }
        try {
            // attempt to verify the credentials and create a token for the user
            if (!$token = JWTAuth::attempt($credentials)) {
                return response()->json(['success' => false, 'errors' => ['non_field_errors' => ['We cant find an account with this credentials. Please make sure you entered the right information and you have verified your email address.']]], 404);
            }
        } catch (JWTException $e) {
            // something went wrong whilst attempting to encode the token
            return response()->json(['success' => false, 'errors' => ['non_field_errors' => ['Failed to login, please try again.']]], 400);
        }

        // all good so return the token
        return response()->json([
            'access_token' => $token,
            'expires_in' => 60 * 60 * 24 * 3,
            'token_type' => 'bearer'
        ], 200);
    }
}
