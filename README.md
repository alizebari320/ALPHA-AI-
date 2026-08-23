# ALPHA/AI

ALPHA/AI is a Laravel 12 platform for discovering AI tools, learning resources,
prompts, news, and Kurdish-first educational content.

## Stack

- Laravel 12 / PHP 8.2+
- Blade, Tailwind CSS 3, Alpine.js, Vite
- SQLite locally; use a managed relational database in production
- Firebase Authentication and Firebase Realtime Database

## Local Setup

1. Install PHP 8.2+, Composer, Node.js 20+, and npm.
2. Copy `.env.example` to `.env` and run `php artisan key:generate`.
3. Set `ADMIN_EMAILS`, `FIREBASE_CREDENTIALS`, and `FIREBASE_DATABASE_URL`.
4. Set the `FIREBASE_WEB_*` values from Firebase Console project settings.
5. Run `composer install && npm install`.
6. Run `php artisan migrate`.
7. Start development with `composer run dev`.

The Firebase Admin service-account JSON must remain outside Git. It is ignored by
`.gitignore`; use a deployment secret or workload identity in production.

## Production Checklist

- Set `APP_ENV=production`, `APP_DEBUG=false`, and the real `APP_URL`.
- Configure a managed database, Redis-backed cache/session/queue, and HTTPS.
- Set every Firebase Admin and browser configuration variable.
- Set an explicit comma-separated `ADMIN_EMAILS` value.
- Deploy Firebase Authentication providers and deny direct Realtime Database access
  unless a documented client feature requires it.
- Run `php artisan migrate --force`, `php artisan optimize`, and `npm run build`.
- Configure the custom domain at the chosen PHP host and point DNS records there.

## Verification

```bash
php artisan test
npm run build
```
