<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DocumentModel extends Model
{
    protected $table = 'document';

    public function documentType(): BelongsTo
    {
        return $this->belongsTo(DocumentTypeModel::class, 'document_type_id');
    }

    protected $hidden = [
    ];

    protected $guarded = [];
}

