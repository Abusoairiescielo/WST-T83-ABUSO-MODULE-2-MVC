<?php

namespace App\Http\Requests\Subject;

use Illuminate\Foundation\Http\FormRequest;

class UpdateSubjectRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'subject_code' => 'required|unique:subjects,subject_code,' . $this->subject->id,
            'name' => 'required',
            'description' => 'nullable',
            'units' => 'required|integer',
            'schedule' => 'nullable'
        ];
    }
}