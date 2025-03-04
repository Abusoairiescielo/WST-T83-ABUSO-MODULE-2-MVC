<?php

namespace App\Http\Controllers\Student;

use Illuminate\Http\Request;
use App\Models\Student\Students;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;

class StudentDashboardController extends Controller
{
    public function index()
    {
        $student = Students::with(['subjects', 'grades'])
            ->where('email', Auth::user()->email)
            ->first();

        if (!$student) {
            // Create a new student record
            $student = Students::create([
                'student_id' => 'STU' . str_pad(mt_rand(1, 99999), 5, '0', STR_PAD_LEFT),
                'name' => Auth::user()->name,
                'email' => Auth::user()->email,
                'status' => 'active'
            ]);
        }

        $enrolledSubjects = $student->subjects ?? collect();

        return view('Students.StudentDashboard', compact('enrolledSubjects'));
    }

    public function subjects()
    {
        $student = Students::with('subjects')
            ->where('email', Auth::user()->email)
            ->first();

        return view('Students.studentSubjects', compact('student'));
    }

    public function grades()
    {
        $student = Students::with(['subjects', 'grades'])
            ->where('email', Auth::user()->email)
            ->first();

        return view('Students.studentGrades', compact('student'));
    }
}