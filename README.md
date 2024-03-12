## Installation

-   Composer version 2.6.6
-   NodeJS v19.4.0
-   NPM 9.2.0
-   PHP 8.2/8.3
-   Mysql
-   Redis

## Run Locally

Clone the project

```bash
git clone {this-project}
```

Go to the project directory

```bash
cd {this-project}
```

Install dependencies

```bash
composer install
npm install
cp .env.example .env
php artisan key:generate
php artisan storage:link
php artisan migrate --seed
```

Start the server

CLI:

```bash
npm run dev
```

```bash
php artisan serve
```

Valet / Laragon:

```bash
{this-project}.test
```

## Deployment

To deploy this project run

```php
composer install
npm run build
cp .env.example .env
php artisan key:generate
php artisan storage:link
php artisan migrate --seed
```

## env

```bash
REDIS_HOST=
REDIS_PASSWORD=
REDIS_PORT=
REDIS_CLIENT=
```

## Demo

| Peran      | E-Mail                                       | Kata Sandi |
| ---------- | -------------------------------------------- | ---------- |
| superadmin | [superadmin@gmail.com](superadmin@gmail.com) | 000000     |
