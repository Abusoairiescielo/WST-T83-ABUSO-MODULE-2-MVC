<?php

namespace App\Http\Requests\Subject;

use Illuminate\Foundation\Http\FormRequest;

class StoreSubjectRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'subject_code' => 'required|unique:subjects',
            'name' => 'required',
            'description' => 'nullable',
            'units' => 'required|integer',
            'schedule' => 'nullable'
        ];
    }
}
