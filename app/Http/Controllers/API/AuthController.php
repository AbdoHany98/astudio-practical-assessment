<?php

namespace App\Http\Controllers\API;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
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
        try {
            DB::beginTransaction();
            $validatedData = $request->validated();
            $validatedData['password'] = Hash::make($validatedData['password']);
            $user = User::create($validatedData);

            $token = $user->createToken('API Token')->accessToken;

            DB::commit();
            return response()->json([
                'status' => 1,
                'message' => "User Registered",
                'token' => $token
            ], 201);
        } catch (\Exception $e) {
            DB::rollBack();
            dd($e);
            return response()->json(['message' => $e->getMessage()], ResponseAlias::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
    public function login(UserLoginRequest $request)
    {
        $credentials = $request->validated();

        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            $token = $user->createToken('API Token')->accessToken;
            return response()->json([
                'user' => $user,
                'token' => $token
            ]);
        }

        return response()->json(['message' => 'Invalid Credentials'], 401);
    }
    public function logout(Request $request)
    {
        $token = $request->user()->token();
        $token->revoke();

        return response()->json([
            'message' => 'Successfully logged out'
        ]);
    }
}