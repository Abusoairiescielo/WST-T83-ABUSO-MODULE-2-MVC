<?php

namespace App\Http\Requests\Student;

use Illuminate\Foundation\Http\FormRequest;

class StudentUpdateRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'student_id' => 'required|string|max:10|unique:students,student_id,' . $this->student->id,
            'name' => 'required|string|max:255',
            'email' => [
                'required',
                'email',
                'unique:students,email,' . $this->student->id,
                'ends_with:@student.buksu.edu.ph'
            ],
            'status' => 'required|in:active,inactive'
        ];
    }

    public function messages()
    {
        return [
            'email.ends_with' => 'Email must be a valid BukSU student email address',
            'student_id.max' => 'Student ID must not exceed 10 characters',
            'email.unique' => 'This email is already taken by another student',
            'student_id.unique' => 'This Student ID is already taken'
        ];
    }
}