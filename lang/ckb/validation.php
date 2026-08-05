<?php

/*
 * Sorani validation messages. Only the rules used by the public-facing
 * forms are translated; anything else falls back to lang/en/validation.php.
 */

return [
    'required' => 'خانەی :attribute پێویستە.',
    'url' => 'خانەی :attribute دەبێت بەستەرێکی دروست بێت.',
    'integer' => 'خانەی :attribute دەبێت ژمارە بێت.',
    'in' => 'خانەی :attribute هەڵبژێردراوەکە نادروستە.',
    'string' => 'خانەی :attribute دەبێت دەق بێت.',

    'max' => [
        'string' => 'خانەی :attribute نابێت لە :max پیت زیاتر بێت.',
        'numeric' => 'خانەی :attribute نابێت لە :max زیاتر بێت.',
    ],

    'min' => [
        'string' => 'خانەی :attribute دەبێت لانیکەم :min پیت بێت.',
        'numeric' => 'خانەی :attribute دەبێت لانیکەم :min بێت.',
    ],

    'attributes' => [
        'name' => 'ناوی ئامراز',
        'tagline' => 'کورتەباس',
        'description' => 'وەسف',
        'website_url' => 'بەستەری ماڵپەڕ',
        'icon_url' => 'بەستەری ئایکۆن',
        'category' => 'پۆلێن',
        'pricing_type' => 'نرخ',
        'lang' => 'زمان',
        'rating' => 'هەڵسەنگاندن',
    ],
];
