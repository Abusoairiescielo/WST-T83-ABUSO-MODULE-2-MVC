<?php

namespace App\Http\Controllers;

use App\Models\Student\Students;
use App\Models\User;
use Illuminate\Http\Request;

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
                    'regex:/^[a-zA-Z0-9._%+-]+@student\.buksu\.edu\.ph$/'
                ],
                'status' => 'required|in:active,inactive'
            ], [
                'email.regex' => 'The email must be a valid BukSU student email address (@student.buksu.edu.ph)'
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
        return view('students.show', compact('student'));
    }

    public function edit(Students $student)
    {
        return redirect()->route('students.index');
    }

    public function update(Request $request, Students $student)
    {
        try {
            $validated = $request->validate([
                'student_id' => 'required|unique:students,student_id,' . $student->id,
                'name' => 'required',
                'email' => 'required|email|unique:students,email,' . $student->id,
                'status' => 'required|in:active,inactive'
            ]);

            $student->update($validated);
            
            return response()->json([
                'success' => true,
                'message' => 'Student updated successfully!'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error updating student. ' . $e->getMessage()
            ], 422);
        }
    }

    public function destroy(Students $student)
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