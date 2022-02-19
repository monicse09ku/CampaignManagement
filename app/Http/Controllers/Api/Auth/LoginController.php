<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api')->except(['login', 'register']);
    }

    /**
     * Handle a login request to the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function login(Request $request)
    {
        $validator = \Validator::make($request->all(), [
            'email' => 'required',
            'password' => 'required'
        ]);

        if ($validator->fails()) {
            $failedRules = $validator->failed();
            return respondError('Parameters failed validation');
        }

        $credentials = ['email' => $request->email, 'password' => $request->password];

        try {
            if (Auth::attempt($credentials)) {
                $user = auth()->user();
                $user->token = $user->createToken('Nilamhut Password Grant Client')->accessToken;
                return respondSuccess($user);
            }

            return respondError(UNAUTHORIZED, 401);
        } catch (\Exception $e) {
            return respondError($e->getMessage());
        }
    }

    /**
     * Create auth user access token
     * @param  Object $user
     * @return Token
     */
    protected function createAccessToken($user)
    {
        if ($token = $user->createToken('Eskimi Password Grant Client')->accessToken) {
            return (new UserResource($user))->additional([
                'token' => $token,
            ]);
        }

        throw new \Exception('Failed to create generate token!');
    }

    /**
     * Log the user out of the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function logout(Request $request)
    {
        try {
            $request->user()->tokens->each(function ($token, $key) {
                $token->delete();
            });

            return respondSuccess('You have been successfully logged out');
        } catch (\Exception $e) {
            return respondError('Failed to logged out');
        }
    }
}
