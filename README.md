# KinoWeb

KinoWeb is a small full-stack movie app. It has a Vue frontend for browsing movies and a Laravel API for auth, personal lists, ratings, notes, and admin tools.

## Stack

Frontend:
- Vue 3
- Vuetify 3
- Pinia
- Vite
- TypeScript

Backend:
- Laravel 11
- Laravel Sanctum
- MySQL

## Features

- Movie catalog with search, genre filters, and sorting
- User registration and login through Laravel Sanctum
- Personal watchlist
- 1-10 movie ratings
- Private notes for each movie
- Admin panel for creating, editing, and deleting movies
- Poster uploads stored in MySQL
- Basic admin statistics

## Project Structure

```text
backend/
  app/
  config/
  database/
  routes/api.php
  Dockerfile

frontend/
  src/
    components/
    services/api.ts
    stores/
    views/
  vite.config.ts
```

## Backend Setup

```bash
cd backend
composer install
cp .env.example .env
php artisan key:generate
php artisan migrate --seed
php artisan serve
```

The API runs on:

```text
http://localhost:8000/api
```

Default admin user:

```text
email: admin@admin.com
password: admin123
```

## Frontend Setup

```bash
cd frontend
npm install
cp .env.example .env
npm run dev
```

For local development, `frontend/.env` should contain:

```env
VITE_API_URL=http://localhost:8000/api
```

The frontend runs on:

```text
http://localhost:3000
```

## Useful Commands

Backend:

```bash
php artisan migrate
php artisan db:seed --class=AdminSeeder
php artisan serve
```

Frontend:

```bash
npm run dev
npm run build
```

## Deployment Notes

The frontend is configured for Vercel with:

```env
VITE_API_URL=https://kinoweb-hosting.onrender.com/api
```

The backend Dockerfile is prepared for Render. On startup it runs migrations, seeds the admin user, and starts Laravel on port `10000`.
