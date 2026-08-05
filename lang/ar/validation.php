<?php

/*
 * Arabic validation messages. Only the rules used by the public-facing
 * forms are translated; anything else falls back to lang/en/validation.php.
 */

return [
    'required' => 'حقل :attribute مطلوب.',
    'url' => 'يجب أن يكون حقل :attribute رابطًا صحيحًا.',
    'integer' => 'يجب أن يكون حقل :attribute رقمًا صحيحًا.',
    'in' => 'قيمة :attribute المختارة غير صالحة.',
    'string' => 'يجب أن يكون حقل :attribute نصًا.',

    'max' => [
        'string' => 'يجب ألا يزيد حقل :attribute عن :max حرفًا.',
        'numeric' => 'يجب ألا تزيد قيمة :attribute عن :max.',
    ],

    'min' => [
        'string' => 'يجب ألا يقل حقل :attribute عن :min حرفًا.',
        'numeric' => 'يجب ألا تقل قيمة :attribute عن :min.',
    ],

    'attributes' => [
        'name' => 'اسم الأداة',
        'tagline' => 'الوصف المختصر',
        'description' => 'الوصف',
        'website_url' => 'رابط الموقع',
        'icon_url' => 'رابط الأيقونة',
        'category' => 'التصنيف',
        'pricing_type' => 'التسعير',
        'lang' => 'اللغة',
        'rating' => 'التقييم',
    ],
];
