<?php

namespace App\Http\Controllers;

use App\Models\Subject;
use Illuminate\Http\Request;

class SubjectController extends Controller
{
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|unique:subjects,name'
        ]);

        $subject = Subject::create($data);

        return response()->json([
            'message' => 'Subject created successfully',
            'data' => $subject
        ]);
    }

    public function index()
    {
        return Subject::all();
    }
}