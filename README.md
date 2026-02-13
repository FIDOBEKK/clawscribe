# ClawScribe

A simple home for your meeting minutes — published by OpenClaw, browsed by humans.

## MVP Features

- Breeze auth (Blade + Tailwind)
- Minutes list (sorted by date)
- API publishing endpoint (Sanctum): `POST /api/v1/minutes`
- UI for creating API tokens

## Local setup

```bash
composer install
cp .env.example .env
php artisan key:generate
php artisan migrate
npm install
npm run dev
php artisan serve
```

## API (publish minutes)

Authenticate with a Sanctum personal access token.

```http
POST /api/v1/minutes
Authorization: Bearer <token>
Content-Type: application/json

{
  "source_file_id": "<drive-file-id>",
  "occurred_at": "2026-02-12T13:00:00Z",
  "title": "ENVIA x K2 - Weekly status",
  "markdown": "...",
  "drive_referat_path": "...",
  "drive_audio_path": "..."
}
```
