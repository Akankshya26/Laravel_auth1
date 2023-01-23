<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class ApiUserController extends Controller
{
    public function register(Request $request)
    {
        $validateData = $request->validate([
            'name' => 'required',
            'email' => ['required', 'email'],
            'password' => 'required',
        ]);
        $user = User::create($validateData);
        // echo "<pre>";
        // print_r($user);
        $token = $user->createToken("auth_token")->accessToken;
        return response()->json(
            [
                'token' => $token,
                'user' => $user,
                'message' => 'user Created successfully',
                'status' => 1
            ]
        );
    }
    public function login(Request $request)
    {
        $validateData = $request->validate([
            'email' => ['required', 'email'],
            'password' => 'required',
        ]);
        $user = User::where(['email' => $validateData['email'], 'password' => $validateData['password']])->first();
        $token = $user->createToken("auth_token")->accessToken;
        return response()->json(
            [
                'token' => $token,
                'user' => $user,
                'message' => 'Logged in Successfully',
                'status' => 1
            ]
        );
    }
    public function getUser($id)
    {
        $user = User::find($id);
        if (is_null($user)) {
            return response()->json(
                [
                    'user' => null,
                    'message' => 'User not Found',
                    'status' => 0
                ]
            );
        } else {
            return response()->json(
                [
                    'user' => $user,
                    'message' => 'User Found',
                    'status' => 1
                ]
            );
        }
    }
}
