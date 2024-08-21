<?php

namespace App\Http\Validators;

use Illuminate\Support\Facades\Validator;

class PageValidator
{
    public function validateGetAllPages($requestData): \Illuminate\Contracts\Validation\Validator
    {
        $commonRules = [
            'language' => 'required|string|in:en,vi',
        ];

        return Validator::make($requestData, $commonRules);
    }
    public function validateUrl($requestData): \Illuminate\Contracts\Validation\Validator
    {
        $commonRules = [
            'language' => 'required|string|in:en,vi',
            'url' => 'required|string',
        ];

        return Validator::make($requestData, $commonRules);
    }
}
