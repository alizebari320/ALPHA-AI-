<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ChatHistory extends Model
{
    protected $fillable = ['user_id', 'title', 'messages', 'last_message_at'];
    protected $casts = ['messages' => 'array', 'last_message_at' => 'datetime'];
}
