<?php

namespace App\Http\Validators;

use Illuminate\Support\Facades\Validator;

class LectureValidator
{
    public function validateGetLectureByLectureType($requestData): \Illuminate\Contracts\Validation\Validator
    {
        $commonRules = [
            'language' => 'required|string|in:en,vi',
            'lecture_type_id' => 'required|integer|exists:lecture_type,id',
            'page' => 'nullable|integer|min:1',
            'size' => 'nullable|integer|min:1',
        ];

        return Validator::make($requestData, $commonRules);
    }
}
