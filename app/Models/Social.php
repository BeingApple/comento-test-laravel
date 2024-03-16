<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Social extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'type',
        'social_id',
        'access_token',
        'refresh_token'
    ];
}
