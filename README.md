# laravel-mysql-library-manager

Laravel MySQL library management system with genres, books, members, book loans, returns with fine calculation, users, roles, dashboard, and activity logs.

## Tech Stack

- PHP 8.5
- Laravel 13
- MySQL / MariaDB
- Blade + Bootstrap 5 + Font Awesome

## Features

- Dashboard with book count, member count, active loans, overdue loans, and fines collected
- Genre CRUD with book counts
- Book catalog with ISBN, author, genre, copies tracking, and shelf location
- Member registry with member codes and loan history
- Book loans: checkout with due date (default 14 days), copy availability enforcement
- Returns with automatic fine calculation: **10 per day late** (0.00 when on time)
- Overdue badges on borrowed loans past their due date
- Role-based access: owner, librarian, viewer
- Search and filter controls on every list page (books include an "available only" filter)
- Activity logs

## Roles

| Role | Access |
|------|--------|
| owner | Everything |
| librarian | Genres, books, members, loans |
| viewer | Dashboard and activity logs only |

## Setup

```bash
composer install
cp .env.example .env
php artisan key:generate
```

Create database:

```sql
CREATE DATABASE library_manager CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
```

Set `.env`:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=library_manager
DB_USERNAME=root
DB_PASSWORD=
```

Run:

```bash
php artisan migrate --seed
php artisan serve
php artisan test
```

## Fine Rule

When a borrowed book is returned after its due date, the fine is `days_late * 10`. Returns on or before the due date carry no fine.

## Demo Login

| Email | Role | Password |
|-------|------|----------|
| owner@example.com | Owner | password |
| librarian@example.com | Librarian | password |
| viewer@example.com | Viewer (inactive account) | password |

## Branching & promote

```
feature/*  →  develop (dev)  →  qa  →  main (production)
```

1. Open a PR from `feature/<name>` into `develop`.
2. After QA sign-off on `develop`, run **Actions → Promote** (`develop` → `qa`).
3. After QA environment verification, run **Promote** (`qa` → `main`).
4. CI (PHPUnit) must pass on every PR to `develop`, `qa`, and `main`.
