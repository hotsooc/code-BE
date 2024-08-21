<?php

namespace App\Http\Validators;

use Illuminate\Support\Facades\Validator;

class SectionValidator
{
    public function validateSectionByPage($requestData): \Illuminate\Contracts\Validation\Validator
    {
        $commonRules = [
            'language' => 'required|string|in:en,vi',
            'page_id' => 'required|integer|exists:page,id',
        ];

        return Validator::make($requestData, $commonRules);
    }

    public function validateGetByPageUrl($requestData): \Illuminate\Contracts\Validation\Validator
    {
        $commonRules = [
            'language' => 'required|string|in:en,vi',
            'url' => 'required|string',
        ];

        return Validator::make($requestData, $commonRules);
    }
}
