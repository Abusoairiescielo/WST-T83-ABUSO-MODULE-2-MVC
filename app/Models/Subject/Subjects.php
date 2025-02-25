<?php

namespace App\Models\Subject;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Student\Students;

class Subjects extends Model
{
    use HasFactory;

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
}