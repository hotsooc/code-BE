<?php

namespace App\Http\Validators;

use Illuminate\Support\Facades\Validator;

class ClassValidator
{
    public function validateHighlightClass($requestData): \Illuminate\Contracts\Validation\Validator
    {
        $commonRules = [
            'language' => 'required|string|in:en,vi',
            'page' => 'nullable|integer|min:1',
            'size' => 'nullable|integer|min:1',
        ];

        return Validator::make($requestData, $commonRules);
    }
    public function validateGetClassById($requestData): \Illuminate\Contracts\Validation\Validator
    {
        $commonRules = [
            'language' => 'required|string|in:en,vi',
            'id' => 'required|integer|exists:class,id',
        ];

        return Validator::make($requestData, $commonRules);
    }
}
