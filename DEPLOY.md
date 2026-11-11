# Deploying Kafue Group

Laravel 13 site. Needs **PHP 8.3+**, Composer and a MySQL/MariaDB database. There is no Node build step:
the CSS and JavaScript are plain files in `public/`.

The web server's document root must point at the project's **`public/`** folder
(for example `~/kafuegroup.co.za/public`), never at the project root.

## First-time setup (SSH or the cPanel Terminal)

```bash
# 1. Get the code (the folder that contains public/ is the project root)
git clone https://github.com/KasubaR/kafue-group.git kafuegroup.co.za
cd kafuegroup.co.za

# 2. Install PHP dependencies (no dev tools on the server)
composer install --no-dev --optimize-autoloader

# 3. Create the environment file and an app key
cp .env.example .env
php artisan key:generate
```

Then edit `.env` (cPanel File Manager or `nano .env`) and set these values:

```dotenv
APP_NAME="Kafue Group"
APP_ENV=production
APP_DEBUG=false
APP_URL=https://kafuegroup.co.za

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=<database name>
DB_USERNAME=<database user>
DB_PASSWORD=<database password>

# No queue worker on shared hosting: run jobs immediately
QUEUE_CONNECTION=sync

# Quote request notifications. Leave empty until the addresses are confirmed:
# requests are still saved to the database, but no email is sent.
MAIL_SALES_TO=
MAIL_TOOLS_TO=

# Real outgoing mail (use the SMTP details from the hosting control panel)
MAIL_MAILER=smtp
MAIL_HOST=
MAIL_PORT=587
MAIL_USERNAME=
MAIL_PASSWORD=
MAIL_FROM_ADDRESS="no-reply@kafuegroup.co.za"
MAIL_FROM_NAME="Kafue Group"
```

Never commit `.env`. It is already in `.gitignore`.

Finish the setup:

```bash
# 4. Create the database tables
php artisan migrate --force

# 5. Make sure these folders are writable by the web user
chmod -R ug+rwx storage bootstrap/cache

# 6. Cache configuration, routes and views for speed
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

Open the site. If a page shows a 500 error, set `APP_DEBUG=true` briefly, reload, read the message,
then set it back to `false` (also check `storage/logs/laravel.log`).

## Updating after a change

```bash
cd ~/kafuegroup.co.za
git pull
composer install --no-dev --optimize-autoloader
php artisan migrate --force
php artisan config:cache && php artisan route:cache && php artisan view:cache
```

Run `php artisan config:clear` before `config:cache` if a changed `.env` value does not seem to apply.

## Notes

- **Quote requests** are stored in the `quote_requests` table. Uploaded files go to `storage/app/private/quote-attachments`
  (not publicly reachable). Back both up.
- **Company details and page copy** live in `config/site.php` and `config/content.php`.
- **Photos** are in `public/images/` (the hero and product cards are Unsplash stock photos; replace them with the
  company's own photos using the same filenames).
- **PHP version:** if the host defaults to an older PHP, pick 8.3 or newer for the domain in cPanel (MultiPHP Manager).
