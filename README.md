- [Environment](#environment)
- [Environment Variables](#environment-variables)
- [Configurations](#configurations)
- [Installed Packages](#installed-packages)
  - [Laravel Spatie Permissions](#laravel-spatie-permissions)
  - [Laravel IDE Helper](#laravel-ide-helper)
  - [Laravel Excel](#laravel-excel)
  - [AdminLTE](#adminlte)
  - [Offline JS](#offline-js)
  - [Axios](#axios)
- [Developer](#developer)

# Environment
Laravel v11.8.0 (PHP v8.3.6)

# Environment Variables
APP_NAME
APP_ENV
APP_DEBUG
APP_URL
DB_CONNECTION
DB_HOST
DB_PORT
DB_DATABASE
DB_USERNAME
DB_PASSWORD
FILESYSTEM_DISK
MAIL_MAILER
MAIL_HOST
MAIL_PORT
MAIL_USERNAME
MAIL_PASSWORD
MAIL_ENCRYPTION
MAIL_FROM_ADDRESS
MAIL_FROM_NAME

APP_DEV_NAME
APP_DEV_URL
APP_VERSION
APP_DESC
APP_KW
APP_DISPLAY_TIMEZONE

# Configurations
```sh
# CLEAR CACHE
$ php artisan optimize:clear

# RESET DATABASE
$ php artisan migrate:fresh --seed
```
```php
// config/app.php
'name' => env('APP_NAME', '<APP_NAME>'),
'app_dev_name' => env('APP_DEV_NAME', '<APP_DEV_NAME>'),
'app_dev_url' => env('APP_DEV_URL', '<APP_DEV_URL>'),
'app_version' => env('APP_VERSION', '<APP_VERSION>'),
'app_desc' => env('APP_DESC', '<APP_DESC>'),
'app_kw' => env('APP_KW', '<APP_KW>'),
'app_display_timezone' => env('APP_DISPLAY_TIMEZONE', '<APP_DISPLAY_TIMEZONE>'),
```
```sh
# FILESYSTEM_DISK="public"
$ php artisan storage:link

# QUEUE
$ php artisan queue:work

# SCHEDULER
$ php artisan schedule:work
# OR
$ php artisan schedule:run
```

# Installed Packages
## Laravel Spatie Permissions
* Docs: [https://spatie.be/docs/laravel-permission/v6/introduction](https://spatie.be/docs/laravel-permission/v6/introduction)
* Version: 6.7.0

## Laravel IDE Helper
* Docs: [https://github.com/barryvdh/laravel-ide-helper](https://github.com/barryvdh/laravel-ide-helper)
* Version: 3.0.0

## Laravel Excel
* Docs: [https://laravel-excel.com/](https://laravel-excel.com/)
* Version: 3.1.55

## AdminLTE
* Docs: [https://adminlte.io/](https://adminlte.io/)
* Version: 3.2.0

## Offline JS
* Docs: [https://github.hubspot.com/offline/docs/welcome/](https://github.hubspot.com/offline/docs/welcome/)
* Version: 0.7.14

## Axios
* Docs: [https://axios-http.com/](https://axios-http.com/)
* Version: 1.7.2


# Developer
* [Sandip Bhambre](https://github.com/sandy2196)
* sandip@algopacific.com
* https://algopacific.com