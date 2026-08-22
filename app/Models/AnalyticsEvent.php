<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AnalyticsEvent extends Model
{
    protected $fillable = ['user_id', 'event', 'path', 'entity_type', 'entity_key', 'metadata', 'session_hash'];
    protected $casts = ['metadata' => 'array'];
}
