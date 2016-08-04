# Measurement API

## Installation
```bash
git clone https://github.com/0x1115/measurement-api.git && cd measurement-api
# If you use Measurement API in production, consider passing --no-dev option
composer install -vvv
```

## Configuration
```bash
cp .env.example .env
vim .env
```

## Migration & Seeding
#### Production
```bash
php artisan migrate:refresh && php artisan db:seed --class=ProductionSeeder
```
The seeding process should end up with the default user.

#### Development
```bash
php artisan migrate:refresh --seed
```

## Serving
Make sure to configure the database before serving. The application is shipped with a default `Caddyfile`
```bash
caddy -log stdout -agree=true -root=/var/tmp -conf=./Caddyfile
```
and you're good to go !

## License

The Lumen framework is open-sourced software licensed under the [MIT license](http://opensource.org/licenses/MIT)
