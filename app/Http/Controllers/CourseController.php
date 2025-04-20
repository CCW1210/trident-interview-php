<?php

namespace App\Http\Controllers;

use App\Models\Course;
use Illuminate\Http\Request;

class CourseController extends Controller
{
    // GET  /api/courses
    public function index()
    {
        return response()->json(
            Course::with('teacher')->get()
        );
    }

    // POST /api/courses
    public function store(Request $request)
    {
        $data = $request->validate([
            'name'        => 'required|string',
            'description' => 'nullable|string',
            'startTime'   => 'required|date_format:H:i',
            'endTime'     => 'required|date_format:H:i',
            'teacherId'   => 'required|integer|exists:teachers,id',
        ]);

        $course = Course::create([
            'name'        => $data['name'],
            'description' => $data['description'] ?? null,
            'start_time'  => $data['startTime'],
            'end_time'    => $data['endTime'],
            'teacher_id'  => $data['teacherId'],
        ]);

        // 回傳時帶出關聯老師資料
        return response()->json(
            $course->load('teacher'),
            201
        );
    }

    // PUT /api/courses/{courseId}
    public function update(Request $request, $courseId)
    {
        $course = Course::findOrFail($courseId);

        $data = $request->validate([
            'name'        => 'sometimes|required|string',
            'description' => 'sometimes|nullable|string',
            'startTime'   => 'sometimes|required|date_format:H:i',
            'endTime'     => 'sometimes|required|date_format:H:i',
            'teacherId'   => 'sometimes|required|integer|exists:teachers,id',
        ]);

        $course->update([
            'name'        => $data['name']        ?? $course->name,
            'description' => $data['description'] ?? $course->description,
            'start_time'  => $data['startTime']   ?? $course->start_time,
            'end_time'    => $data['endTime']     ?? $course->end_time,
            'teacher_id'  => $data['teacherId']   ?? $course->teacher_id,
        ]);

        return response()->json($course->load('teacher'));
    }

    // DELETE /api/courses/{courseId}
    public function destroy($courseId)
    {
        $course = Course::findOrFail($courseId);
        $course->delete();
        return response()->noContent();
    }
}
