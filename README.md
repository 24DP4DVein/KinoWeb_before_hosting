# KinoWeb

KinoWeb ir neliela full-stack filmu aplikācija. Frontend daļa ir veidota filmu pārlūkošanai, bet Laravel API nodrošina autorizāciju, personīgos sarakstus, vērtējumus, piezīmes un administratora funkcijas.

## Tehnoloģijas

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

## Iespējas

- Filmu katalogs ar meklēšanu, žanru filtriem un kārtošanu
- Lietotāju reģistrācija un pieslēgšanās ar Laravel Sanctum
- Personīgais skatāmo filmu saraksts
- Filmu vērtēšana no 1 līdz 10
- Privātas piezīmes katrai filmai
- Administratora panelis filmu izveidei, rediģēšanai un dzēšanai
- Filmu plakātu augšupielāde un glabāšana MySQL datubāzē
- Vienkārša administratora statistika

## Projekta struktūra

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

## Backend palaišana

```bash
cd backend
composer install
cp .env.example .env
php artisan key:generate
php artisan migrate --seed
php artisan serve
```

API adrese:

```text
http://localhost:8000/api
```

Noklusētais administratora lietotājs:

```text
email: admin@admin.com
password: admin123
```

## Frontend palaišana

```bash
cd frontend
npm install
cp .env.example .env
npm run dev
```

Lokālās izstrādes videi failā `frontend/.env` jānorāda:

```env
VITE_API_URL=http://localhost:8000/api
```

Frontend adrese:

```text
http://localhost:3000
```

## Noderīgas komandas

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

## Deploy piezīmes

Frontend daļa ir sagatavota Vercel videi ar:

```env
VITE_API_URL=https://kinoweb-hosting.onrender.com/api
```

Backend Dockerfile ir sagatavots Render videi. Starta brīdī tas izpilda migrācijas, izveido administratora lietotāju un palaiž Laravel serveri uz porta `10000`.
