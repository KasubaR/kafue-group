# Kafue Group website

Marketing site for **Kafue Group (Pty) Ltd**, an industrial sourcing and supply company in Kimberley, Northern Cape.
Built with Laravel 13 and Blade components, with plain CSS and JavaScript (no build step).

| Page | Route |
|---|---|
| Home | `/` |
| Products | `/products` |
| Services | `/services` |
| About | `/about` |
| Contact (quote form) | `/contact` |

## Run it locally

```bash
composer install
cp .env.example .env
php artisan key:generate
php artisan migrate
php artisan serve
```

Run the tests with `php artisan test`.

## Where things are

- `config/site.php`: company details, navigation, notification emails, attachment limits
- `config/content.php`: page copy (products, services, sectors, values)
- `resources/views/components/`: reusable Blade components
- `public/css`, `public/js`: global files plus `pages/` styles per page

Deployment steps are in [DEPLOY.md](DEPLOY.md).
