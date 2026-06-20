# InkPress

InkPress is a modern blog and content management platform built with Laravel, Blade, Tailwind CSS, JavaScript, AJAX, and MySQL-compatible schema design. The project is structured like a production-ready SaaS publishing product with repository and service layers, author workflows, analytics, media management, and a polished reader experience.

## Highlights

- Role-based authentication for `admin`, `author`, and `reader`
- Email verification, password reset, profile editing, avatar upload, and password change
- Admin dashboard with analytics, recent activity, notifications, and content insights
- Blog publishing workflow with drafts, review state, scheduling, SEO fields, slug generation, reading-time calculation, and preview mode
- Public-facing pages for home, blog listings, blog detail, author profiles, category pages, tag pages, about, contact, and search
- Engagement features including comments, likes, bookmarks, reading history, view counters, featured/trending/popular sections, and related posts
- Media library with upload, download, replace, metadata editing, queued image processing, and folder-ready schema
- Repository pattern, service layer, form requests, policies, eager loading, pagination, caching, and queue job hooks

## Stack

- PHP `8.3+`
- Laravel `13.x` in the current repository baseline
- MySQL or SQLite for local development
- Blade templates with Tailwind CSS
- JavaScript, AJAX, and jQuery-enhanced interactions

## Setup

```bash
composer install
cp .env.example .env
php artisan key:generate
php artisan storage:link
```

Configure your database credentials in `.env`, then run:

```bash
php artisan migrate:fresh --seed
npm install
npm run build
```

For local development:

```bash
composer run dev
```

## Demo Accounts

After seeding:

- Admin: `admin@inkpress.test`
- Password: `password`

Additional author and reader accounts are seeded automatically with random profile data.

## Architecture

- `app/Repositories`: repository contracts and Eloquent implementations
- `app/Services`: business logic for blogs, dashboard analytics, media, and search
- `app/Http/Requests`: request validation for auth, profile, blog, comments, and media
- `app/Policies`: authorization for blogs, comments, and media access
- `resources/views`: public website, auth flows, dashboard, and reusable Blade components
- `database/seeders`: sample data that makes the UI feel like a populated product

## Notes

- The app currently targets the installed Laravel version in this repository, which is Laravel `13.8`, even though the requested brief mentioned Laravel 12.
- The schema and code are MySQL-friendly, but the repository also works with SQLite for quick local demos and automated tests.
