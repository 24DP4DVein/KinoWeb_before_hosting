# KinoWeb

Full-stack movie discovery app built with Vue 3 and Laravel 11.

## Stack

**Frontend:** Vue 3, Vuetify 3, Pinia, Vite, TypeScript  
**Backend:** Laravel 11, Sanctum (REST API)  
**Database:** MySQL

## Features

- Browse movies with search, genre filter, and sorting
- User registration and token-based auth (Sanctum)
- Personal watchlist — add/remove movies
- Rate movies 1–10
- Write personal notes per movie
- Admin panel: create/edit/delete movies, upload posters, view statistics
- Movie posters stored as binary data in MySQL (no external storage)

## Project Structure

```
├── backend/           # Laravel 11 API
│   ├── app/
│   ├── database/
│   ├── routes/api.php
│   └── .env.example
└── frontend/          # Vue 3 SPA
    ├── src/
    │   ├── components/
    │   ├── views/
    │   ├── stores/    # Pinia
    │   ├── services/api.ts
    │   └── types/
    └── .env.example
```

## Getting Started

### Backend

```bash
cd backend
composer install
cp .env.example .env
# Fill in DB credentials in .env
php artisan key:generate
php artisan migrate --seed
php artisan serve
```

Runs at `http://localhost:8000`

Default admin account: `admin@admin.com` / `admin123`

### Frontend

```bash
cd frontend
npm install
cp .env.example .env
# .env already has: VITE_API_URL=http://localhost:8000/api
npm run dev
```

Runs at `http://localhost:3000`

## API Overview

Base URL: `/api`

| Method | Path | Auth | Description |
|--------|------|------|-------------|
| POST | `/auth/register` | — | Register |
| POST | `/auth/login` | — | Login |
| POST | `/auth/logout` | ✓ | Logout |
| GET | `/movies` | — | List movies |
| GET | `/movies/{id}/poster` | — | Movie poster image |
| GET | `/watchlist` | ✓ | User's watchlist |
| POST/DELETE | `/watchlist/{id}` | ✓ | Add/remove from watchlist |
| GET | `/ratings` | ✓ | User's ratings |
| POST | `/ratings/{id}` | ✓ | Rate a movie |
| GET/POST/DELETE | `/notes/{id}` | ✓ | Personal notes |
| GET/POST/PUT/DELETE | `/admin/movies` | admin | Manage movies |
| GET | `/admin/stats` | admin | Statistics |

## License

Educational project.
