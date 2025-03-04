<?php

namespace App\Http\Requests\Grade;

use Illuminate\Foundation\Http\FormRequest;

class DeleteGradeRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [];  // Remove validation rules since we're using route parameters
    }
}