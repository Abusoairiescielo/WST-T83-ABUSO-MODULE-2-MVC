<?php

namespace App\Http\Controllers;

use App\Models\Subject\Students;
use App\Models\Subject\Subjects;
use Illuminate\Http\Request;

class SubjectController extends Controller
{
    public function index()
    {
        $subjects = Subjects::all();
        return view('Subjects.Subjects', compact('subjects'));
    }

    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'subject_code' => 'required|unique:subjects',
                'name' => 'required',
                'description' => 'nullable',
                'units' => 'required|integer',
                'schedule' => 'nullable'
            ]);

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

    public function update(Request $request, Subjects $subject)
    {
        try {
            $validated = $request->validate([
                'subject_code' => 'required|unique:subjects,subject_code,' . $subject->id,
                'name' => 'required',
                'description' => 'nullable',
                'units' => 'required|integer',
                'schedule' => 'nullable'
            ]);

            $subject->update($validated);
            
            return response()->json([
                'success' => true,
                'message' => 'Subject updated successfully!'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error updating subject. ' . $e->getMessage()
            ], 422);
        }
    }

    public function destroy(Subjects $subject)
    {
        $subject->delete();
        return redirect()->back()->with('success', 'Subject deleted successfully');
    }
}