<?php

namespace App\Models\Student;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Subject\Subjects;
use App\Models\Grade\Grades;

class Students extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_id',
        'name',
        'email',
        'course',
        'year',
        'status',
        'enrollment_status'
    ];

    // Relationship with subjects (many-to-many)
    public function subjects()
    {
        return $this->belongsToMany(Subjects::class, 'student_subject', 'student_id', 'subject_id')
                    ->withTrashed()
                    ->withPivot('grade')
                    ->withTimestamps();
    }

    public function grades()
    {
        return $this->hasMany(Grades::class, 'student_id');
    }
}