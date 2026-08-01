<p align="center">
    <span style="font-size:2.5rem;font-weight:900;letter-spacing:.1em;font-family:monospace">
        ALPHA<span style="color:#f0b429">/AI</span>
    </span>
</p>

<p align="center">پلاتفۆرمی کوردی بۆ فێربوونی پرۆگرامسازی، دۆزینەوەی ئامرازەکانی AI، و ڕێنمایی ئەکادیمی.</p>

## About

**ALPHA/AI** is a Kurdish-language learning platform built with:

- Laravel 12 + PHP 8.5
- Firebase (Authentication + Realtime Database) via the Kreait SDK
- Vite + Tailwind CSS (Gold & Graphite theme)
- SQLite for local sessions/FAQ data

## Features

- فێرگە (Ferga) — learn Python & C++ with a live code playground (Pyodide / Skulpt)
- کۆرسەکان (Courses) — course management with admin CRUD
- تووڵەکانی AI (AI Tools) — curated AI tool directory
- ڕێنیشاندەری ئەکادیمی (Academic Guide) — academic advice & university list
- هەواڵەکان (News), زانکۆکان (Universities), دەربارە (About)
- Firebase Auth — Google + email/password login

## Setup

```bash
cp .env.example .env        # set FIREBASE_CREDENTIALS path + FIREBASE_DATABASE_URL
composer install
npm install
npm run dev                 # runs php artisan serve + vite concurrently
```

## Admin

Admin email: `alphaaiteam@gmail.com` (configured in `routes/web.php` / `AdminController`).

## License

All rights reserved.
