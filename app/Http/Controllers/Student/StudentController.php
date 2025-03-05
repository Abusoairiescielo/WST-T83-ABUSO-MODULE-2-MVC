<?php

namespace App\Http\Controllers\Student;

use App\Models\Student\Students;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Requests\Student\StudentDeleteRequest;
use App\Http\Requests\Student\StudentUpdateRequest;
use App\Http\Requests\Student\StoreStudentRequest;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Enrollment\EnrollmentController;

class StudentController extends Controller
{
    public function index()
    {
        $students = Students::all();
        return view('Students.Students', compact('students'));
    }

    public function store(StoreStudentRequest $request)
    {
        try {
            // Create new student
            $student = Students::create($request->validated());

            // Create user account with the provided password
            User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password), // Use only the provided password
                'role' => 'student'
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Student added successfully!',
                'data' => $student
            ]);

        } catch (\Exception $e) {
            \Log::error('Error adding student: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while adding the student. Please try again.'
            ]);
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
            // First unenroll the student (this will handle grades and subjects)
            app(EnrollmentController::class)->unenroll($student);

            // Find and delete the associated user account
            $user = User::where('email', $student->email)->first();
            if ($user) {
                $user->delete();
            }

            // Then delete the student record
            $student->delete();

            return response()->json([
                'success' => true,
                'message' => 'Student deleted successfully!'
            ]);
        } catch (\Exception $e) {
            \Log::error('Error deleting student: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error deleting student: ' . $e->getMessage()
            ], 422);
        }
    }

    public function markReady(Students $student)
    {
        try {
            $student->update(['enrollment_status' => 'ready']);
            
            return response()->json([
                'success' => true,
                'message' => 'Student marked as ready for enrollment'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error updating student status'
            ]);
        }
    }
}