<?php

namespace App\Http\Validators;

use Illuminate\Support\Facades\Validator;

class NewsCategoryValidator
{
    public function validateGetAllNewsCategories($requestData): \Illuminate\Contracts\Validation\Validator
    {
        $commonRules = [
            'language' => 'required|string|in:en,vi',
        ];

        return Validator::make($requestData, $commonRules);
    }
}
