<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ComponentModel extends Model
{
    protected $table = 'component';

    public function section(): BelongsTo
    {
        return $this->belongsTo(SectionModel::class, 'section_id');
    }

    protected $hidden = [
    ];

    protected $guarded = [];
}

