<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Administrator Emails
    |--------------------------------------------------------------------------
    |
    | Accounts whose email appears here pass the `admin` middleware and may
    | mutate Firebase-backed content (courses, ai_tools, academic_guide,
    | ferga_lessons). Override in .env with a comma-separated list:
    |
    |   ADMIN_EMAILS=alphaaiteam@gmail.com,second@example.com
    |
    */

    'admin_emails' => array_values(array_filter(array_map(
        'trim',
        explode(',', (string) env('ADMIN_EMAILS', 'alphaaiteam@gmail.com'))
    ))),

    /*
    |--------------------------------------------------------------------------
    | Supported Locales
    |--------------------------------------------------------------------------
    |
    | Single source of truth for the language switcher, the SetLocale
    | middleware, the <html lang|dir> attributes and the Firebase
    | multilingual field fallback chain.
    |
    | `dir`      — text direction applied to <html>.
    | `native`   — label shown in the language switcher.
    | `fallback` — ordered locales to try when a tool is missing a translation.
    |
    */

    'locales' => [
        'en' => [
            'native' => 'English',
            'dir' => 'ltr',
            'fallback' => ['en', 'ckb', 'badini', 'ar'],
        ],
        'ar' => [
            'native' => 'العربية',
            'dir' => 'rtl',
            'fallback' => ['ar', 'en', 'ckb', 'badini'],
        ],
        'ckb' => [
            'native' => 'کوردی (سۆرانی)',
            'dir' => 'rtl',
            'fallback' => ['ckb', 'badini', 'en', 'ar'],
        ],
        'badini' => [
            'native' => 'کوردی (بادینی)',
            'dir' => 'rtl',
            'fallback' => ['badini', 'ckb', 'en', 'ar'],
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | AI Tools Directory
    |--------------------------------------------------------------------------
    */

    'tools' => [
        'categories' => ['dev', 'writing', 'design', 'audio_video', 'research', 'kurdish_ai'],
        'pricing_types' => ['free', 'freemium', 'paid'],
        'statuses' => ['approved', 'pending'],
    ],

    'prompt_categories' => [
        'coding', 'writing', 'research', 'study', 'design', 'marketing', 'business', 'translation', 'image_generation', 'productivity',
    ],

];
