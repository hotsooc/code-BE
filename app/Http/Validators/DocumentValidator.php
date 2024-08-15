<?php

namespace App\Http\Validators;

use Illuminate\Support\Facades\Validator;

class DocumentValidator
{
    public function validateGetDocumentByDocumentType($requestData): \Illuminate\Contracts\Validation\Validator
    {
        $commonRules = [
            'language' => 'required|string|in:en,vi',
            'document_type_id' => 'required|integer|exists:document_type,id',
            'page' => 'nullable|integer|min:1',
            'size' => 'nullable|integer|min:1',
        ];

        return Validator::make($requestData, $commonRules);
    }
}
