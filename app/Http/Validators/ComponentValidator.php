<?php

namespace App\Http\Validators;

use Illuminate\Support\Facades\Validator;

class ComponentValidator
{
    public function validateComponentByPage($requestData): \Illuminate\Contracts\Validation\Validator
    {
        $commonRules = [
            'language' => 'required|string|in:en,vi',
            'section_id' => 'required|integer|exists:section,id',
        ];

        return Validator::make($requestData, $commonRules);
    }
}
