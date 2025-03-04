<?php

namespace App\Http\Controllers\Enrollment;

use App\Models\Student\Students;
use App\Models\Subject\Subjects;
use App\Http\Requests\Enrollment\EnrollmentStoreRequest;
use App\Http\Requests\Enrollment\EnrollmentUpdateRequest;
use App\Http\Controllers\Controller;

class EnrollmentController extends Controller
{
    public function index()
    {
        $students = Students::where('enrollment_status', 'ready')
                           ->where('status', 'active')
                           ->whereDoesntHave('subjects')
                           ->get();
                           
        $enrolledStudents = Students::whereHas('subjects')
                                   ->with('subjects')
                                   ->get();

        $subjects = Subjects::all();
                               
        return view('enrollment', compact('students', 'enrolledStudents', 'subjects'));
    }

    public function enroll(EnrollmentStoreRequest $request)
    {
        try {
            $validated = $request->validated();
            $student = Students::findOrFail($validated['student_id']);
            
            // Check if subjects were selected
            if (empty($validated['subjects'])) {
                return response()->json([
                    'success' => false,
                    'message' => 'Please select at least one subject to enroll.'
                ], 422);
            }
            
            // Check for existing subjects and only attach new ones
            $existingSubjects = $student->subjects->pluck('id')->toArray();
            $newSubjects = array_diff($validated['subjects'], $existingSubjects);
            
            if (empty($newSubjects)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Student is already enrolled in these subjects'
                ], 422);
            }

            $student->subjects()->attach($newSubjects);

            return response()->json([
                'success' => true,
                'message' => 'Student enrolled successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Unable to complete enrollment.'
            ], 422);
        }
    }

    public function updateSubjects(EnrollmentUpdateRequest $request)
    {
        try {
            $validated = $request->validated();
            $student = Students::findOrFail($validated['student_id']);
            $student->subjects()->sync($validated['subjects']);
            
            return response()->json([
                'success' => true,
                'message' => 'Subjects updated successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error updating subjects: ' . $e->getMessage()
            ], 422);
        }
    }

    public function getStudentSubjects($id)
    {
        $student = Students::findOrFail($id);
        return response()->json($student->subjects->pluck('id'));
    }

    public function unenroll(Students $student)
    {
        try {
            // Delete all grades for the student's subjects
            foreach ($student->grades as $grade) {
                $grade->delete();
            }

            // Detach all subjects from the student
            $student->subjects()->detach();

            return response()->json([
                'success' => true,
                'message' => 'Student has been unenrolled successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error unenrolling student: ' . $e->getMessage()
            ], 422);
        }
    }
}