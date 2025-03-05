<?php

namespace App\Http\Requests\Grade;

use Illuminate\Foundation\Http\FormRequest;

class GradeUpdateRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'midterm' => 'required|numeric|in:1.00,1.25,1.50,1.75,2.00,2.25,2.50,2.75,3.00,5.00',
            'finals' => 'required|numeric|in:1.00,1.25,1.50,1.75,2.00,2.25,2.50,2.75,3.00,5.00',
            'student_id' => 'required|exists:students,id',
            'subject_id' => 'required|exists:subjects,id'
        ];
    }

    public function messages()
    {
        return [
            'midterm.in' => 'The midterm grade must be one of these values: 1.00, 1.25, 1.50, 1.75, 2.00, 2.25, 2.50, 2.75, 3.00, 5.00',
            'finals.in' => 'The finals grade must be one of these values: 1.00, 1.25, 1.50, 1.75, 2.00, 2.25, 2.50, 2.75, 3.00, 5.00'
        ];
    }
}
