# KinoWEB — Setup Guide

## Tech Stack

| Layer    | Technology                         |
|----------|------------------------------------|
| Frontend | Vue 3 + Vuetify 3 + Pinia + Vite   |
| Backend  | PHP 8.2 + Laravel 11 + Sanctum     |
| Database | MySQL 8                            |

---

## Prerequisites

- **PHP 8.2+** — https://www.php.net/downloads
- **Composer** — https://getcomposer.org/download/
- **Node.js 18+** (already installed)
- **MySQL 8** (already installed)

---

## Backend Setup (`backend/`)

### 1. Install PHP dependencies

```bash
cd backend
composer install
```

### 2. Generate app key

```bash
php artisan key:generate
```

### 3. Configure database

Edit `backend/.env`:
```env
DB_DATABASE=movieweb
DB_USERNAME=root
DB_PASSWORD=your_password
```

### 4. Run migrations

```bash
php artisan migrate
```

### 5. Seed demo movies (optional)

```bash
php artisan db:seed
```

This inserts 12 demo movies (Inception, The Dark Knight, etc.)

### 6. Start the server

```bash
php artisan serve --port=8000
```

Backend API available at: **http://localhost:8000/api**

---

## Frontend Setup (`frontend/`)

### 1. Install dependencies

```bash
cd frontend
npm install
```

### 2. Start dev server

```bash
npm run dev
```

Frontend available at: **http://localhost:3000**

---

## API Endpoints

| Method | Endpoint              | Auth     | Description              |
|--------|-----------------------|----------|--------------------------|
| GET    | /api/health           | —        | Health check             |
| GET    | /api/movies           | —        | All movies               |
| POST   | /api/auth/register    | —        | Register (returns token) |
| POST   | /api/auth/login       | —        | Login (returns token)    |
| POST   | /api/auth/logout      | Bearer   | Logout                   |
| GET    | /api/auth/user        | Bearer   | Current user             |
| GET    | /api/watchlist        | Bearer   | User's watchlist IDs     |
| POST   | /api/watchlist/{id}   | Bearer   | Add to watchlist         |
| DELETE | /api/watchlist/{id}   | Bearer   | Remove from watchlist    |
| GET    | /api/ratings          | Bearer   | User's ratings map       |
| POST   | /api/ratings/{id}     | Bearer   | Rate a movie (1–10)      |

---

## Database Tables

| Table                   | Description                    |
|-------------------------|--------------------------------|
| users                   | Registered users               |
| movies                  | Movie catalog                  |
| personal_access_tokens  | Sanctum auth tokens            |
| watchlists              | User ↔ Movie watchlist records |
| ratings                 | User ↔ Movie rating records    |
