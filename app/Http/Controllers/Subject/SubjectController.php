<?php

namespace App\Http\Controllers\Subject;

use App\Models\Subject\Students;
use App\Models\Subject\Subjects;
use Illuminate\Http\Request;
use App\Http\Requests\Subject\StoreSubjectRequest;
use App\Http\Requests\Subject\UpdateSubjectRequest;
use App\Http\Controllers\Controller;

class SubjectController extends Controller
{
    public function index()
    {
        $subjects = Subjects::all();
        return view('Subjects.Subjects', compact('subjects'));
    }

    public function store(StoreSubjectRequest $request)
    {
        try {
            $validated = $request->validated();
            Subjects::create($validated);
            
            return response()->json([
                'success' => true,
                'message' => 'Subject added successfully!'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Subject already exists.'
            ], 422);
        }
    }

    public function show(Subjects $subject)
    {
        return view('Subjects.show', compact('subject'));
    }

    public function edit(Subjects $subject)
    {
        return view('Subjects.edit', compact('subject'));
    }

    public function update(UpdateSubjectRequest $request, Subjects $subject)
    {
        try {
            $validated = $request->validated();
            $subject->update($validated);
            
            return response()->json([
                'success' => true,
                'message' => 'Subject updated successfully!'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error updating subject: ' . $e->getMessage()
            ], 422);
        }
    }

    public function destroy(Subjects $subject)
    {
        try {
            // Check if subject has enrolled students with grades
            if ($subject->students()->whereHas('grades')->exists()) {
                // Soft delete the subject instead of hard delete
                $subject->delete();
                return redirect()->back()->with('success', 'Subject archived successfully');
            }

            // If no students with grades, perform hard delete
            $subject->forceDelete();
            return redirect()->back()->with('success', 'Subject deleted successfully');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error deleting subject: ' . $e->getMessage());
        }
    }
}