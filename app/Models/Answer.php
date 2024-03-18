<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Answer extends Model
{
    use HasUuids;

    protected $fillable = [
        'question_id',
        'user_id',
        'answer',
        'is_select',
    ];

    public function user(): BelongsTo {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function question(): BelongsTo {
        return $this->belongsTo(Question::class, 'question_id');
    }
}
