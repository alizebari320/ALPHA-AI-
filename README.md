# ALPHA AI

AI-powered learning platform for Kurdish and Arabic speakers.

## Features

- **Multi-language support**: Sorani, Badini, Arabic, English
- **Firebase integration**: Auth, Firestore, Realtime Database, Storage
- **Course platform**: Interactive coding lessons (Ferga)
- **AI Tools directory**: Curated AI tools with Kurdish localization
- **Academic guide**: University information for Kurdistan region
- **Automated news**: AI-curated tech news pipeline

## Tech Stack

- **Backend**: Laravel 11 (PHP 8.2+)
- **Frontend**: Vite + Tailwind CSS + Alpine.js
- **Database**: SQLite (local) / Firebase (production)
- **Deployment**: Hostinger via GitHub Actions

## Getting Started

```bash
composer install
npm install
cp .env.example .env
php artisan key:generate
php artisan migrate
npm run dev
```

## Configuration

### Firebase (Client-side)
Keys are read from `~/.config/alpha-ai/config.json` (server) or `storage/app/ai/config.json` (local override).

### Firebase Admin (Server-side)
Configure via `config/firebase.php` and environment variables.

### Admin Emails
Set `ADMIN_EMAILS` in `.env` (comma-separated).

## Deployment

Push to `main` branch triggers GitHub Actions deployment to Hostinger.

## License

MIT