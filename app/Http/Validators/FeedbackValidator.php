<?php

namespace App\Http\Validators;

use Illuminate\Support\Facades\Validator;

class FeedbackValidator
{
    public function validateGetAllFeedbacks($requestData): \Illuminate\Contracts\Validation\Validator
    {
        $commonRules = [
            'language' => 'required|string|in:en,vi',
            'page' => 'nullable|integer|min:1',
            'size' => 'nullable|integer|min:1',
        ];

        return Validator::make($requestData, $commonRules);
    }
}
