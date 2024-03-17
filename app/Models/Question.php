<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Question extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'category',
        'user_id',
        'title',
        'question',
    ];

    public function answers(): HasMany
    {
        return $this->hasMany(Answer::class);
    }

    public function isFulllAnswer(): bool {
        // 답변이 3개 이상인지 확인
        return $this->answers()->count() >= 3;
    }
}
