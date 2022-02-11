<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\FormRequests\LoginFormRequest;
use App\Http\FormRequests\RegisterFormRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function register(RegisterFormRequest $request)
    {
        try {
            $input = $request->toArray();
            $name = data_get($input, 'name');
            $email = data_get($input, 'email');
            $password = data_get($input, 'password');

            $user = new User([
                'name' => $name,
                'email' => $email,
                'password' => bcrypt($password)
            ]);

            $user->save();
            return response()->json([
                'success' => true
            ], 201);
        } catch (ValidationException $validationException) {
            return response()->json([
                'error' => $validationException->errors(),
                'success' => false

            ], 400);
        }
    }

    public function login(LoginFormRequest $request)
    {
        try {
            $input = $request->toArray();
            $email = data_get($input, 'email');
            $password = data_get($input, 'password');
            if (Auth::attempt(['email' => $email, 'password' => $password])) {
                $user = Auth::user();
                $success['token'] = $user->createToken('login')->accessToken;
                return response()->json([
                    'token' => $success,
                    'success' => true
                ], 200);
            } else {
                return response()->json([
                    'error' => 'Email or password wrong!',
                    'success' => true
                ], 400);
            }
        } catch (ValidationException $validationException) {
            return response()->json([
                'error' => $validationException->errors(),
                'success' => false
            ], 400);
        }
    }

    public function logout(Request $request)
    {
        $request->user()->token()->revoke();
        return response()->json([
            'success' => true,
            'message' => 'You have successfully logout!'
        ], 200);
    }
}
