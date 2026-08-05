<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Faq extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'question_ckb',
        'question_kmr',
        'question_en',
        'question_ar',
        'answer',
    ];
}
