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
            'midterm' => 'required|numeric|min:1|max:5',
            'finals' => 'required|numeric|min:1|max:5',
            'student_id' => 'required|exists:students,id',
            'subject_id' => 'required|exists:subjects,id'
        ];
    }
}
