<?php

namespace App\Http\Validators;

use Illuminate\Support\Facades\Validator;

class NewsValidator
{
    public function validateNewsByCategory($requestData): \Illuminate\Contracts\Validation\Validator
    {
        $commonRules = [
            'language' => 'required|string|in:en,vi',
            'news_category_id' => 'nullable|integer|exists:news_category,id',
            'page' => 'nullable|integer|min:1',
            'size' => 'nullable|integer|min:1',
        ];

        return Validator::make($requestData, $commonRules);
    }

    public function validateNewsBySlug($requestData): \Illuminate\Contracts\Validation\Validator
    {
        $commonRules = [
            'language' => 'required|string|in:en,vi',
            'slug' => 'required|string'
        ];

        return Validator::make($requestData, $commonRules);
    }
    public function validateGetRelatedNews($requestData): \Illuminate\Contracts\Validation\Validator
    {
        $commonRules = [
            'language' => 'required|string|in:en,vi',
            'news_category_id' => 'required|integer|exists:news_category,id',
            'id' => 'required|integer|exists:news,id',
            'size' => 'nullable|integer|min:1',
        ];

        return Validator::make($requestData, $commonRules);
    }
}
