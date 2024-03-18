<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Social extends Model
{
    use HasUuids;

    protected $fillable = [
        'type',
        'social_id',
        'access_token',
        'refresh_token'
    ];

    public function user(): BelongsTo {
        return $this->belongsTo(User::class, 'user_id');
    }
}
