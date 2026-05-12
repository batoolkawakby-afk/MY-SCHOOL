<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Schedule;
class ScheduleController extends Controller
{
   public function index()
    {
        $schedules = Schedule::with(['teacher','subject','class'])
            ->orderBy('day')
            ->orderBy('period')
            ->paginate(20);

        return response()->json($schedules);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'teacher_id' => 'required|exists:teachers,id',
            'subject_id' => 'required|exists:subjects,id',
            'section_id' => 'required|exists:sections,id',
            'class_id' => 'required|exists:classes,id',
          'day' => 'required|in:sunday,monday,tuesday,wednesday,thursday',
             'period' => 'required|integer|min:1|max:8',
        ]);

        
        $exists = Schedule::where('day', $data['day'])
            ->where('period', $data['period'])
            ->where(function ($q) use ($data) {
                $q->where('teacher_id', $data['teacher_id'])
                  ->orWhere('section_id', $data['section_id']);
            })
            ->exists();

        if ($exists) {
            return response()->json([
                'message' => 'Teacher or section already has a class at this time'
            ], 422);
        }

        $schedule = Schedule::create($data);

        return response()->json([
            'message' => 'Created successfully',
            'data' => $schedule
        ], 201);
    }

    
    public function show(int $id)
    {
        $schedule = Schedule::with(['teacher','subject','section'])
            ->findOrFail($id);

        return response()->json($schedule);
    }

    
    public function update(Request $request, int $id)
    {
        $schedule = Schedule::findOrFail($id);

        $data = $request->validate([
            'teacher_id' => 'required|exists:teachers,id',
            'subject_id' => 'required|exists:subjects,id',
            'section_id' => 'required|exists:sections,id',
            'day' => 'required',
            'period' => 'required|integer',
        ]);

        // 🔥 تحقق من التعارض (مع استثناء السجل الحالي)
        $exists = Schedule::where('day', $data['day'])
            ->where('period', $data['period'])
            ->where('id', '!=', $id)
            ->where(function ($q) use ($data) {
                $q->where('teacher_id', $data['teacher_id'])
                  ->orWhere('section_id', $data['section_id']);
            })
            ->exists();

        if ($exists) {
            return response()->json([
                'message' => 'Teacher or section already has a class at this time'
            ], 422);
        }

        $schedule->update($data);

        return response()->json([
            'message' => 'Updated successfully',
            'data' => $schedule
        ]);
    }

    
    public function destroy(int $id)
    {
        $schedule = Schedule::findOrFail($id);
        $schedule->delete();

        return response()->json([
            'message' => 'Deleted successfully'
        ]);
    }

    
    public function filter(Request $request)
    {
        $query = Schedule::with(['teacher','subject','section']);

        if ($request->section_id) {
            $query->where('section_id', $request->section_id);
        }

        if ($request->teacher_id) {
            $query->where('teacher_id', $request->teacher_id);
        }

        if ($request->day) {
            $query->where('day', $request->day);
        }

        $data = $query->orderBy('day')
                      ->orderBy('period')
                      ->get();

        return response()->json($data);
    }

    
    public function bySection(int $section_id)
    {
        $data = Schedule::with(['teacher','subject'])
            ->where('section_id', $section_id)
            ->orderBy('day')
            ->orderBy('period')
            ->get();

        return response()->json($data);
    }

}
