<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class LectureModel extends Model
{
    protected $table = 'lecture';

    public function lectureType(): BelongsTo
    {
        return $this->belongsTo(LectureTypeModel::class, 'lecture_type_id');
    }

    protected $hidden = [
    ];

    protected $guarded = [];
}

