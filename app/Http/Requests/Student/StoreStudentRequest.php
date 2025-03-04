<?php

namespace App\Http\Requests\Student;

use Illuminate\Foundation\Http\FormRequest;

class StoreStudentRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'student_id' => 'required|string|unique:students,student_id',
            'name' => 'required|string|max:255',
            'email' => [
                'required',
                'email',
                'unique:students,email',
                'regex:/^[0-9]{10}@student\.buksu\.edu\.ph$/'
            ],
            'status' => 'required|in:active,inactive'
        ];
    }

    public function messages()
    {
        return [
            'student_id.unique' => 'This Student ID is already registered.',
            'email.unique' => 'This email address is already registered.',
            'email.regex' => 'Email must be a valid BukSU student email address (e.g., 2201101589@student.buksu.edu.ph).'
        ];
    }
}