# KinoWEB — Movie Discovery App

A full-stack web application for browsing, rating, and managing a personal watchlist of movies.

---

## Tech Stack

### Frontend
- React 19
- TypeScript 5.8
- Vite 6
- Tailwind CSS (via CDN)
- Lucide React (icons)

### Backend
- Node.js + Express 4
- TypeScript 5.8
- mysql2

### Database
- MySQL

---

## Features

### Authentication
- Client-side sign in / register (stored in `localStorage`)
- Session persistence across browser refreshes
- Password minimum 6 characters

### Movie Browsing
- Grid layout with 3 views: **Home**, **Watchlist**, **Top Rated** (rating ≥ 8.5)
- Hero section with random movie picker
- Movie detail modal (description, cast, duration, rating)

### Filtering & Sorting
- Real-time search by title
- Genre filter: All, Action, Drama, Comedy, Sci-Fi, Thriller, Adventure, Fantasy, Crime
- Sort by: Rating (High to Low), Year (New to Old), Title (A–Z)

### Watchlist
- Add/remove movies, persisted in `localStorage` per user

### Ratings
- 1–10 rating per movie, persisted in `localStorage` per user

---

## Project Structure

```
/
├── App.tsx                  # Main app component
├── index.tsx                # React entry point
├── index.html               # HTML entry (Tailwind CDN, custom scrollbar styles)
├── types.ts                 # TypeScript interfaces (Movie, User, UserData, SortOption)
├── constants.ts             # Genre list + 12 demo movies
├── vite.config.ts
├── tsconfig.json
├── components/
│   ├── AuthOverlay.tsx      # Login / Register overlay
│   ├── Navbar.tsx           # Top navigation (desktop + mobile)
│   ├── Hero.tsx             # Hero banner with random movie button
│   ├── MovieCard.tsx        # Grid card component
│   ├── MovieModal.tsx       # Full movie detail modal
│   └── InfoModal.tsx        # About modal
├── services/
│   └── storage.ts           # localStorage helpers
└── backend/
    ├── src/
    │   ├── index.ts         # Express server
    │   └── db.ts            # MySQL connection pool
    └── .env                 # Database credentials (not committed)
```

---

## System Requirements

- Node.js v18+
- MySQL v8+
- npm

---

## Installation

### 1. Install frontend dependencies

```bash
npm install
```

### 2. Install backend dependencies

```bash
cd backend
npm install
```

### 3. Configure environment variables

Create `backend/.env`:

```env
PORT=3001
DB_HOST=localhost
DB_PORT=3306
DB_USER=root
DB_PASSWORD=your_password
DB_NAME=movieweb
```

### 4. Set up the database

Create a MySQL database named `movieweb` and a `movies` table with columns:

| Column          | Type          |
|-----------------|---------------|
| id              | INT (PK)      |
| title           | VARCHAR       |
| year            | INT           |
| rating          | DECIMAL       |
| genres          | JSON          |
| duration        | VARCHAR       |
| description     | TEXT          |
| cast            | JSON          |
| posterGradient  | VARCHAR       |

---

## Running the Application

### Start backend

```bash
cd backend
npm run dev
```

Runs at: `http://localhost:3001`

### Start frontend

In a separate terminal:

```bash
npm run dev
```

Runs at: `http://localhost:3000`

---

## API Endpoints

| Method | Path      | Description                           |
|--------|-----------|---------------------------------------|
| GET    | `/`       | API status check                      |
| GET    | `/health` | Health check — returns `{ "ok": true }` |
| GET    | `/movies` | Returns all movies ordered by ID      |

### GET /movies — response shape

```json
[
  {
    "id": 1,
    "title": "Inception",
    "year": 2010,
    "rating": 8.8,
    "genres": ["Sci-Fi", "Thriller"],
    "duration": "2h 28m",
    "description": "...",
    "cast": ["Leonardo DiCaprio", "..."],
    "posterGradient": "linear-gradient(...)"
  }
]
```

> The frontend falls back to 12 hardcoded demo movies (`constants.ts`) if the backend is unavailable.

---

## Notes

- Authentication is **client-side only** — passwords are stored in `localStorage` as plaintext. For demonstration purposes only.
- Watchlist and ratings are stored in `localStorage`, not the database.
- CORS is configured to allow only `http://localhost:3000`.

---

## License

Educational / demonstration project.
