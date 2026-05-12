<?php

namespace App\Http\Controllers;

use App\Models\Manager;
use App\Models\Student;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ManagerController extends Controller
{
      public function registerManager(Request $request)
    {
      
        $request->validate([
            'firstName' => 'required|string|max:100',
            'lastName' => 'required|string|max:100',   
            'dateOfBirth' => 'required|date_format:d-m-Y',   
            'mobile' => 'required|string|unique:users,mobile',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $manager = Manager::create([
            'firstName' => $request->firstName,
            'lastName' => $request->lastName,
            'dateOfBirth' => Carbon::createFromFormat('d-m-Y', $request->dateOfBirth)->format('Y-m-d'),
            
            'mobile' => $request->mobile,
            'password' => Hash::make($request->password),
        ]); 
   

     


         User::create([
            'mobile' => $request->mobile,
            'password' => Hash::make($request->password),
            'userType' => 'manager', 
            'related_id' => $manager->id, 
        ]);

        return response()->json([
            'message' => 'manager registered successfully',
            'manager' => $manager   
        ], 201);
    }
}
