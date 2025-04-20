<?php

namespace App\Http\Controllers;

use App\Models\Teacher;
use Illuminate\Http\Request;

class TeacherController extends Controller
{
    // GET  /api/teachers
    public function index()
    {
        return response()->json(Teacher::all());
    }

    // POST /api/teachers
    public function store(Request $request)
    {
        $data = $request->validate([
            'name'     => 'required|string',
            'email'    => 'required|email|unique:teachers,email',
            'username' => 'required|string|unique:teachers,username',
            'password' => 'required|string|min:6',
        ]);

        $data['password'] = bcrypt($data['password']);

        $teacher = Teacher::create($data);

        return response()->json($teacher, 201);
    }

    // GET  /api/teachers/{teacherId}/courses
    public function courses($teacherId)
    {
        $teacher = Teacher::findOrFail($teacherId);
        return response()->json($teacher->courses);
    }
}
