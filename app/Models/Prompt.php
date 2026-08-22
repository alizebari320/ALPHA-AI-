<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Prompt extends Model
{
    protected $fillable = ['user_id', 'title', 'body', 'category', 'locale', 'tool_key', 'is_public', 'copy_count'];
    protected $casts = ['is_public' => 'boolean'];

    public function user(): BelongsTo { return $this->belongsTo(User::class); }
}
