<?php

/*
 * Badini validation messages. Only the rules used by the public-facing
 * forms are translated; anything else falls back to lang/en/validation.php.
 */

return [
    'required' => 'خانا :attribute پێدڤی یە.',
    'url' => 'خانا :attribute دڤێت لینکەکێ دروست بیت.',
    'integer' => 'خانا :attribute دڤێت ژمارە بیت.',
    'in' => 'هەلبژارتنا :attribute نەدروست e.',
    'string' => 'خانا :attribute دڤێت دەق بیت.',

    'max' => [
        'string' => 'خانا :attribute نابیت ژ :max پیتان زێدەتر بیت.',
        'numeric' => 'خانا :attribute نابیت ژ :max زێدەتر بیت.',
    ],

    'min' => [
        'string' => 'خانا :attribute دڤێت ب کێمی :min پیت بیت.',
        'numeric' => 'خانا :attribute دڤێت ب کێمی :min بیت.',
    ],

    'attributes' => [
        'name' => 'ناڤێ ئامرازی',
        'tagline' => 'کورتەبێژە',
        'description' => 'پێناسە',
        'website_url' => 'لینکێ ماڵپەڕی',
        'icon_url' => 'لینکێ ئایکۆنێ',
        'category' => 'جور',
        'pricing_type' => 'بها',
        'lang' => 'زمان',
        'rating' => 'هەلسەنگاندن',
    ],
];
