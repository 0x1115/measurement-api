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

## License

The Lumen framework is open-sourced software licensed under the [MIT license](http://opensource.org/licenses/MIT)
