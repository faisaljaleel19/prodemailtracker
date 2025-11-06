Collecting workspace information```markdown
...existing code...
# Prod Email Tracker

A Laravel-based application for tracking product emails and user interactions.

## Table of contents
- [Requirements](#requirements)
- [Quick Start](#quick-start)
- [Environment & configuration](#environment--configuration)
- [Database](#database)
- [Mail & Logging](#mail--logging)
- [Building assets](#building-assets)
- [Testing](#testing)
- [Useful files](#useful-files)
- [Contributing](#contributing)
- [License](#license)

## Requirements
- PHP 8.x (compatible with your Laravel version)
- Composer
- Node.js & npm/yarn
- MySQL / PostgreSQL / SQLite (see [config/database.php](config/database.php))

## Quick Start
1. Install PHP dependencies:
   ```sh
   composer install
   ```
   See composer.json for dependencies.

2. Copy environment file and generate app key:
   ```sh
   cp .env.example .env
   php artisan key:generate
   ```

3. Configure your database and other environment variables in .env (you can use .env.example as a reference).

4. Run migrations (and seeders if required):
   ```sh
   php artisan migrate
   # php artisan db:seed
   ```

5. Install front-end dependencies and compile assets:
   ```sh
   npm install
   npm run dev
   ```
   See package.json and webpack.mix.js.

6. Serve the app:
   ```sh
   php artisan serve
   ```

## Environment & configuration
- Application providers and aliases are in app.php.
- Database connections and defaults in database.php.
- Mailers and transport configuration in mail.php.
- Logging channels and defaults in logging.php.

Update the .env values (DB_*, MAIL_*, LOG_*) to match your environment.

## Database
Default connection is set via `DB_CONNECTION` in .env. See database.php for available drivers and settings.

If you use MySQL make sure the PHP PDO driver for MySQL is installed. The `mysql` connection in database.php contains recommended charset/collation.

## Mail & Logging
- Mail transport is configured in mail.php. Update `MAIL_MAILER`, `MAIL_HOST`, `MAIL_USERNAME`, and `MAIL_PASSWORD` in your .env.
- Logging channel and level are configured in logging.php.

## Building assets
Frontend assets are managed using Laravel Mix. See webpack.mix.js. Use:
- `npm run dev` — compile for development
- `npm run prod` — compile/minify for production

## Testing
Run the test suite with PHPUnit:
```sh
vendor/bin/phpunit -c phpunit.xml
```
See phpunit.xml.

## Useful files
- Application entry: artisan
- Composer settings: composer.json
- Frontend settings: package.json, webpack.mix.js
- Env example: .env.example
- Core configs: app.php, database.php, mail.php, logging.php
- Admin views:
  - create_tracker.blade.php
  - product_track_list.blade.php
  - home.blade.php
  - others.blade.php

These views include client-side scripts (e.g., intl-tel-input) and form handling — inspect the files above for implementation details.

## Contributing
- Follow PSR-12 coding style for PHP.
- Add tests for new features in tests.
- Run `composer test` / `vendor/bin/phpunit` before submitting PR.

## License
This project follows the license in the repository. See the root files for license details.