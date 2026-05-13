<?php

namespace App\Http\Controllers;

use App\Models\Teacher;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class TeacherController extends Controller
{
    public function registerTeacher(Request $request)
    {
        $data = $request->validate([
            'firstName' => 'required|string|max:100',
            'lastName'  => 'required|string|max:100',
            'gender' => 'required|in:male,female', 
            'dateOfBirth' => 'required|date_format:d-m-Y',   
            'personalPhoto' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'subject_id' => 'required|exists:subjects,id',
            'class_id'   => 'required|exists:classes,id',
            'division'   => 'required|integer|between:1,5',
            'mobile'  => 'required|string|unique:users,mobile',
            'password' => 'required|string|min:8|confirmed',
        ]);

        
        $personalPhotoPath = null;

        if ($request->hasFile('personalPhoto')) {
            $image = $request->file('personalPhoto');
            $personalPhotoName = time() . '_personal.' . $image->getClientOriginalExtension();
            $image->move(public_path('images'), $personalPhotoName);
            $personalPhotoPath = 'images/' . $personalPhotoName;
        }

        
        $teacher = Teacher::create([
            'firstName' => $data['firstName'],
            'lastName'  => $data['lastName'],

            'personalPhoto' => $personalPhotoPath,

            'subject_id' => $data['subject_id'],
            'class_id'   => $data['class_id'],
            'division'   => $data['division'],
            'gender' => $data['gender'],
            'dateOfBirth' => Carbon::createFromFormat('d-m-Y', $data['dateOfBirth'])->format('Y-m-d'),
            'mobile'   => $data['mobile'],
            'password' => Hash::make($data['password']),
        ]);

        // 👤 إنشاء user (للتسجيل والدخول)
        User::create([
            'mobile' => $data['mobile'],
            'password' => Hash::make($data['password']),
            'userType' => 'teacher',
            'related_id' => $teacher->id,
        ]);

        return response()->json([
            'message' => 'Teacher registered successfully',
            'teacher' => $teacher
        ], 201);
    }
}
