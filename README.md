# Portfolio CMS

A Laravel-based content management system for managing portfolio content, blog posts, projects, and site settings through an admin panel.

## Requirements

- PHP 8.2+
- PostgreSQL
- Node.js & npm
- Composer

## Setup

```bash
# Install PHP dependencies
composer install

# Install JS dependencies and build assets
npm install
npm run build

# Copy environment file and configure database
cp .env.example .env
php artisan key:generate

# Run migrations and seed
php artisan migrate
php artisan db:seed

# Create symbolic link for storage
php artisan storage:link
```

## Default Admin Credentials

- **Email:** admin@portfolio.dev
- **Password:** password

## Access

| URL | Description |
|-----|-------------|
| `/` | Welcome page |
| `/login` | Admin login |

All admin routes are under `/admin/*` and require authentication with the `admin` middleware.

## Tech Stack

- **Backend:** Laravel 13, PHP 8.5
- **Database:** PostgreSQL
- **Frontend:** Blade, SCSS, Vite
- **Auth:** Laravel Breeze (customized)

## License

MIT
