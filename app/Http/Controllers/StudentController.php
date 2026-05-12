<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class StudentController extends Controller
{
     public function registerStudent(Request $request)
    {
      
        $request->validate([
            'firstName' => 'required|string|max:100',
            'lastName' => 'required|string|max:100',
            'dateOfBirth' => 'required|date_format:d-m-Y',
            'personalPhoto' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'class_id' => 'required|exists:classes,id',
            'division' => 'required|string|max:100',
            'mobile' => 'required|string|max:10|unique:students,mobile',
            'password' => 'required|string|min:8|confirmed',
        ]);

        if ($request->hasFile('personalPhoto')) {
            $image = $request->file('personalPhoto');
            $personalPhotoName = time() . '_personal.' . $image->getClientOriginalExtension();
            $image->move(public_path('images'), $personalPhotoName);
            $personalPhotoPath = 'images/' . $personalPhotoName;
        } else {
            return response()->json(['error' => 'The personal photo was not uploaded'], 400);
        }

   

     
        $student = Student::create([
            'firstName' => $request->firstName,
            'lastName' => $request->lastName,
            'dateOfBirth' => Carbon::createFromFormat('d-m-Y', $request->dateOfBirth)->format('Y-m-d'),
            'personalPhoto' => $personalPhotoPath,
            'class_id' => $request->class_id,
            'division' => $request->division,
            'mobile' => $request->mobile,
            'password' => Hash::make($request->password),
        ]);


         User::create([
            'mobile' => $request->mobile,
            'password' => Hash::make($request->password),
            'userType' => 'student', 
            'related_id' => $student->id, 
        ]);

        return response()->json([
            'message' => 'student registered successfully',
            'student' => $student
        ], 201);
    }
}
