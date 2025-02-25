<?php

namespace App\Http\Controllers;

use App\Models\Student\Students;
use App\Models\Subject\Subjects;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        
        if ($user->user_type === 'student') {
            return redirect()->route('student.dashboard');
        }

        $totalStudents = Students::count();
        $activeStudents = Students::where('status', 'active')->count();
        $recentStudents = Students::latest()->take(5)->get();
        
        return view('dashboard', compact('totalStudents', 'activeStudents', 'recentStudents'));
    }
}