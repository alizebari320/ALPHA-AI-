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

];
