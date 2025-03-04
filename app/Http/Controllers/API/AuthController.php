<?php

namespace App\Http\Controllers\API;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\UserLoginRequest;
use App\Http\Requests\UserRegistrationRequest;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

class AuthController extends Controller
{
    public function register(UserRegistrationRequest $request)
    {
        try{
            $validatedData = $request->validated();
            $validatedData['password'] = Hash::make($validatedData['password']);
            $user = User::create($validatedData);
            $token = $user->createToken('API Token')->accessToken;

            return response()->json([
                'user' => $user,
                'access_token' => $token
            ], 201);

        }catch(\Exception $e){
            return response()->json(['message' => 'Something went wrong'], ResponseAlias::HTTP_INTERNAL_SERVER_ERROR);
        }

    }

    public function login(UserLoginRequest $request)
    {
        $credentials = $request->validated();
        if(Auth::attempt($credentials)){
            $user = Auth::user();
            $token = $user->createToken('API Token')->accessToken;
            return response()->json(['access_token' => $token]);
        }
        return response()->json(['message'=> 'Invalid Credentials'], 401);
    }

    public function logout(Request $request)
    {
        $request->user()->token()->revoke();
        return response()->json(['message' => 'Successfully logged out']);
    }
}
