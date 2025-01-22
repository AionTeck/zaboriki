# Проект zaboriki

## Основные зависимости
- php 8.2
- redis 6.2
- mysql 8.0


## Развертывание проекта

### Установка зависимостей проекта
```bash
composer install
```

### Копирование .env
```bash
cp .env.example .env
```

### Установка ключа приложения
```bash
php artisan key:generate
```

### Описание окружения в .env

Приведенные ниже параметры обязательны к изменению

```dotenv
APP_ENV=
APP_URL=

DB_CONNECTION=
DB_HOST=
DB_PORT=
DB_DATABASE=
DB_USERNAME=
DB_PASSWORD=

CACHE_DRIVER=redis
FILESYSTEM_DISK=public
QUEUE_CONNECTION=redis

REDIS_HOST=
REDIS_PASSWORD=
REDIS_PORT=

MAIL_MAILER=
MAIL_HOST=
MAIL_PORT=
MAIL_USERNAME=
MAIL_PASSWORD=
MAIL_ENCRYPTION=
MAIL_FROM_ADDRESS=
MAIL_FROM_NAME="${APP_NAME}"
```

### Создание базы данных
```bash
php artisan migrate
```

### Создание пользователя в админке

```bash
php artisan filament:user
```

