<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class userController extends Controller
{
        public function login(Request $request){

    $request->validate([
    'mobile'=>'required|string',
    'password'=>'required|string'

    ]);
        if(!Auth::attempt($request->only('mobile','password')))
    return response()->json([
    'messege'=>'invalid mobile or password '
    ],
    401);

    $user=User::where('mobile',$request->mobile)->firstOrFail();
    $token = $user->createToken('user_token')->plainTextToken;
    return response()->json([
                'message' => 'user log in successful',
                'user' => $user,
                'Token'=>$token
            ], 201);
        }


            
    public function logout(Request $request){
    $request->user()->currentAccessToken()->delete();
    return response()->json([
                'message' => 'user log out successful']);
    }


}
