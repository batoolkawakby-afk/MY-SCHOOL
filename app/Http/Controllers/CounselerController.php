<?php

namespace App\Http\Controllers;

use App\Models\Counseler;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class CounselerController extends Controller
{
      public function registerCounseler (Request $request)
    {
      
        $request->validate([
            'firstName' => 'required|string|max:100',
            'lastName' => 'required|string|max:100',
            'dateOfBirth' => 'required|date_format:d-m-Y',
            'gender' =>  'required|in:male,female'  ,
            'mobile' => 'required|string|unique:users,mobile',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $counseler = Counseler::create([
            'firstName' => $request->firstName,
            'lastName' => $request->lastName,
            'dateOfBirth' => Carbon::createFromFormat('d-m-Y', $request->dateOfBirth)->format('Y-m-d'),
            'gender' => $request->gender,
            'mobile' => $request->mobile,
            'password' => Hash::make($request->password),
        ]);
   

     
      


         User::create([
            'mobile' => $request->mobile,
            'password' => Hash::make($request->password),
            'userType' => 'counseler', 
            'related_id' => $counseler  ->id, 
        ]);

        return response()->json([
            'message' => 'counseler registered successfully',
            'counseler' => $counseler          
        ], 201);
    }
}
