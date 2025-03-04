<?php

namespace App\Http\Controllers;

use App\Models\Student\Students;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Requests\Student\StudentDeleteRequest;
use App\Http\Requests\Student\StudentUpdateRequest;

class StudentController extends Controller
{
    public function index()
    {
        $students = Students::all();
        return view('Students.Students', compact('students'));
    }

    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'student_id' => 'required|unique:students',
                'name' => 'required',
                'email' => [
                    'required',
                    'email',
                    'unique:students',
                    'regex:/^[0-9]{10}@student\.buksu\.edu\.ph$/'  // Exactly 10 digits before @
                ],
                'status' => 'required|in:active,inactive'
            ], [
                'email.regex' => 'The email must be your 10-digit student number followed by @student.buksu.edu.ph'
            ]);

            Students::create($validated);
            
            return response()->json([
                'success' => true,
                'message' => 'Student added successfully!'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 422);
        }
    }

    public function show(Students $student)
    {
        // Instead of showing a view, return JSON response
        return response()->json([
            'success' => true,
            'data' => $student
        ]);
    }

    public function edit(Students $student)
    {
        return redirect()->route('students.index');
    }

    public function update(StudentUpdateRequest $request, Students $student)
    {
        try {
            $validated = $request->validated();
            $student->update($validated);
            
            return response()->json([   
                'success' => true,
                'message' => 'Student updated successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error updating student: ' . $e->getMessage()
            ], 422);
        }
    }

    public function destroy(StudentDeleteRequest $request, Students $student)
    {
        try {
            // Find and delete the associated user account
            $user = User::where('email', $student->email)->first();
            if ($user) {
                $user->delete();
            }

            // Delete the student record
            $student->delete();

            return response()->json([
                'success' => true,
                'message' => 'Student deleted successfully!'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error deleting student: ' . $e->getMessage()
            ], 422);
        }
    }
}