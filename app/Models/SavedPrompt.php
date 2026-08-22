<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SavedPrompt extends Model
{
    protected $fillable = ['user_id', 'prompt_id'];

    public function prompt(): BelongsTo { return $this->belongsTo(Prompt::class); }
}
