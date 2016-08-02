# Measurement API

## Installation
```bash
git clone git@github.com:hiendv/measurement-api.git && cd measurement-api
composer install -vvv
```

## Configuration
```bash
cp .env.example .env
vim .env
```

## Migration & Seeding
```bash
php artisan migrate:refresh --seed
```
If your `APP_ENV` is `production`, the process should end up with the default user.

## Serving
Make sure to configure the database before serving. The application is shipped with a default `Caddyfile`
```bash
caddy -log stdout -agree=true -root=/var/tmp -conf=./Caddyfile
```
and you're good to go !

## License

The Lumen framework is open-sourced software licensed under the [MIT license](http://opensource.org/licenses/MIT)
