<?php

namespace App\Http\Controllers;

use App\Models\Grade\Grades;
use App\Models\Student;
use App\Models\Subject;
use Illuminate\Http\Request;
use App\Http\Requests\Grade\GradeUpdateRequest;
use App\Http\Requests\Grade\GradeDeleteRequest;
use App\Models\Student\Students;

class GradeController extends Controller
{
    public function index()
    {
        $students = Students::with(['subjects', 'grades'])->get();
        return view('Grade.Grade', compact('students'));
    }

    public function update(GradeUpdateRequest $request, Grades $grade)
    {
        try {
            $validated = $request->validated();
            
            // Calculate average
            if (isset($validated['midterm']) && isset($validated['finals'])) {
                $validated['average'] = ($validated['midterm'] + $validated['finals']) / 2;
                
                // Set remarks based on average
                $validated['remarks'] = $validated['average'] >= 75 ? 'Passed' : 'Failed';
            }
            
            $grade->update($validated);

            return response()->json([
                'success' => true,
                'message' => 'Grades updated successfully!'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error updating grades: ' . $e->getMessage()
            ], 422);
        }
    }

    public function destroy(GradeDeleteRequest $request, $studentId, $subjectId)
    {
        try {
            $grade = Grades::where('student_id', $studentId)
                         ->where('subject_id', $subjectId)
                         ->firstOrFail();
            
            $grade->delete();

            return response()->json([
                'success' => true,
                'message' => 'Grade deleted successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error deleting grade: ' . $e->getMessage()
            ], 422);
        }
    }

    public function store(GradeUpdateRequest $request)
    {
        try {
            $validated = $request->validated();
            
            // Calculate average
            if (isset($validated['midterm']) && isset($validated['finals'])) {
                $validated['average'] = ($validated['midterm'] + $validated['finals']) / 2;
                $validated['remarks'] = $validated['average'] >= 3 ? 'Failed' : 'Passed';
            }
            
            $grade = Grades::updateOrCreate(
                [
                    'student_id' => $validated['student_id'],
                    'subject_id' => $validated['subject_id']
                ],
                $validated
            );

            return response()->json([
                'success' => true,
                'message' => 'Grades saved successfully!'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error saving grades: ' . $e->getMessage()
            ], 422);
        }
    }

    private function convertToGradePoint($percentage)
    {
        if ($percentage >= 97) return 1.00;
        if ($percentage >= 94) return 1.25;
        if ($percentage >= 91) return 1.50;
        if ($percentage >= 88) return 1.75;
        if ($percentage >= 85) return 2.00;
        if ($percentage >= 82) return 2.25;
        if ($percentage >= 79) return 2.50;
        if ($percentage >= 76) return 2.75;
        if ($percentage >= 75) return 3.00;
        return 5.00;
    }
}