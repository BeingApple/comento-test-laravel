<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Question extends Model
{
    use HasUuids;

    protected $fillable = [
        'category',
        'user_id',
        'title',
        'question',
    ];

    public function user(): BelongsTo {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function answers(): HasMany
    {
        return $this->hasMany(Answer::class);
    }

    public function isFulllAnswer(): bool {
        // 답변이 3개 이상인지 확인
        return $this->answers()->count() >= 3;
    }

    public function isChooseAnswer(): bool {
        // 채택된 답변이 있는지 확인
        return $this->answers()->where('is_select', true)->count() > 0;
    }
}
