# 📝 Laravel Blog

[![tests](https://github.com/hasan123dayoub-del/laravel-blog/actions/workflows/tests.yml/badge.svg)](https://github.com/hasan123dayoub-del/laravel-blog/actions/workflows/tests.yml)
![PHP](https://img.shields.io/badge/PHP-8.2+-777BB4?logo=php&logoColor=white)
![Laravel](https://img.shields.io/badge/Laravel-12-FF2D20?logo=laravel&logoColor=white)

My first Laravel project: a blog with an admin panel, categories and favorites, built on Laravel 12 with the Livewire starter kit and Fortify.

## Features
- **Public blog:** latest posts with pagination, a post page, and filtering by category.
- **Admin panel (admins only):** create, edit and delete posts with a cover image and categories, plus category management.
- **Trash:** deleted posts go to the trash and can be restored (with their image and categories) or deleted permanently.
- **Favorites:** signed-in users can save posts and see them on their favorites page.
- **Accounts:** registration, login, password reset, email verification and two-factor authentication (Fortify).
- **Roles:** after login, admins go to the admin panel and other users go to the blog.

## Run it locally
```bash
composer install
npm install && npm run build
cp .env.example .env
php artisan key:generate
php artisan migrate
php artisan storage:link
php artisan serve
```
To make a user an admin, set `role` to `admin` on that user in the `users` table.

## Tests
```bash
php artisan test
```
40 feature tests cover authentication, settings, admin access (guests, regular users and admins) and the trash flow (restore and permanent delete). They run on every push with GitHub Actions.
