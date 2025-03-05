<?php

namespace App\Models\Subject;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Student\Students;

class Subjects extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'subject_code',
        'name',
        'description',
        'units',
        'schedule'
    ];

    // Relationship with students (many-to-many)
    public function students()
    {
        return $this->belongsToMany(Students::class, 'student_subject', 'subject_id', 'student_id')
                    ->withPivot('grade')
                    ->withTimestamps();
    }

    protected static function boot()
    {
        parent::boot();
        
        static::deleting(function($subject) {
            // If subject has students with grades, prevent hard delete
            if ($subject->students()->whereHas('grades')->exists()) {
                return true; // Allow soft delete
            }
            return true; // Allow hard delete if no grades
        });
    }
}