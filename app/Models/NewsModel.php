<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class NewsModel extends Model
{
    protected $table = 'news';

    protected $hidden = [
    ];

    public function newsCategory(): BelongsTo
    {
        return $this->belongsTo(NewsCategoryModel::class, 'news_category_id');
    }

    protected $guarded = [];
}

