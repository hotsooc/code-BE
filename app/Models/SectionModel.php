<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SectionModel extends Model
{
    protected $table = 'section';

    public function page(): BelongsTo
    {
        return $this->belongsTo(PageModel::class, 'page_id');
    }

    protected $hidden = [
    ];

    protected $guarded = [];
}

