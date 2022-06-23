<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function login(Request $request)
    {
        $valid = Validator::validate($request->all(), [
            'email' => 'required|email',
            'password' => 'required|min:8'
        ]);
        if (!isset($valid))
            return response()->json([
                'code' => 300,
                'msg' => 'not all required field is sended',
                'token' => null,
                'type' => null
            ], 200);

        $user = User::where('email', $request->email)->first();
        if (!isset($user)) {
            return response()->json([
                'code' => 301,
                'msg' => 'this user not found',
                'token' => null,
                'type' => null
            ], 200);
        }

        if (!Hash::check($request->password, $user->password))
            return response()->json([
                'code' => 302,
                'msg' => 'the sended data does not match our data',
                'token' => null,
                'type' => null
            ], 200);

        $token = $user->createToken('auth')->plainTextToken;
        return response()->json([
            'code' => 200,
            'msg' => 'logged in successfully',
            'token' => $token,
            'type' => $user->user_type
        ], 200);
    }

    public function signUp(Request $request)
    {
        $user = User::create([
            'name' => $request->name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'phone' => $request->phone,
            'user_type' => $request->user_type,
            'password' => Hash::make($request->password),
        ]);
        $token = $user->createToken('auth')->plainTextToken;
        return response()->json([
            'code' => 200,
            'message' => "user created successfully",
            'type' => $user->user_type,
            'user' => $user,
            'token' => $token
        ], 200);
    }
}
