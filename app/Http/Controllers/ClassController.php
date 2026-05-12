<?php

namespace App\Http\Controllers;
use App\Models\Classes;
use Illuminate\Http\Request;
use App\Models\Section;
class ClassController extends Controller
{
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|unique:classes,name'
        ]);

        
        $class = Classes::create($data);

        
        $sections = ['A', 'B', 'C', 'D', 'E'];

        foreach ($sections as $section) {
            Section::create([
                'name' => $section,
                'class_id' => $class->id
            ]);
        }

        return response()->json([
            'message' => 'تم إنشاء الصف مع 5 شعب',
            'class' => $class
        ]);
    }

    
    public function index()
    {
        return response()->json(Classes::all());
    }

    
    public function show(int $id)
    {
        $class = Classes::with([
            'sections',
            'schedules.teacher',
            'schedules.subject',
            'students'
        ])->findOrFail($id);

        return response()->json($class);
    }
 
    public function update(Request $request, int $id)
    {
        $class = Classes::findOrFail($id);

        $data = $request->validate([
            'name' => 'required|string|unique:classes,name,' . $id
        ]);

        $class->update($data);

        return response()->json([
            'message' => 'Class updated',
            'data' => $class
        ]);
    }

    
    public function destroy(int $id)
    {
        $class = Classes::findOrFail($id);
        $class->delete();

        return response()->json([
            'message' => 'Class deleted'
        ]);
    }
}
