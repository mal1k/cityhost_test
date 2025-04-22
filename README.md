# 🕒 Время выполнения
### **Общее время:** 2ч 24мин

- **Инициализация Laravel + сбор информации**: 0:42:24  
- **Парсинг серверов TLD**: 0:17:41  
- **Бэкенд для получения информации о домене**: 0:08:02  
- **Отрисовка на сайте (фронтенд)**: 0:24:02  
- **Парсинг WHOIS в JSON**: 0:33:10
- **Изменил формат парсинга данных**: 0:18:53  


---

# 🚀 Установка и запуск

```bash
# 1) Клонируем репозиторий
git clone <project-link>

# 2) Переходим в проект
cd <project-directory>

# 3) Копируем env
cp .env.example .env

# 4) Генерируем ключ
php artisan key:generate

# 5) Создаем символическую ссылку для стореджа
php artisan storage:link

# 6) Устанавливаем зависимости
composer install

# 7) Устанавливаем JS‑зависимости
npm install

# 8) Запускаем встроенный сервер Laravel 
composer run dev

# если по какой-то причине 8 пункт отдает ошибку, то:
# в первом терминале:
php artisan serve
# во втором терминале:
npm run dev

# 9) Загружаем список TLD серверов
php artisan whois:update-servers 
```

---

# 🧪 Тестирование
## Front
Откройте URL (например http://127.0.0.1:8000) или https://ch.adavay.agency

Введите домен (например cityhost.ua) для теста и нажмите Check.

Должен появиться raw блок с отформатированным текстом WHOIS 

## API
### Команды написаны для тестирования в терминале

JSON формат самого Whois
```bash
curl -s "https://ch.adavay.agency/api/whois?domain=cityhost.ua&format=json" | jq
```

RAW Whois в JSON ответе
```bash
curl -s "https://ch.adavay.agency/api/whois?domain=cityhost.ua&format=raw"
```

---

# 💡 Возможные улучшения
- Кэширование TLD‑списка в Redis при высокой нагрузке
- Использование RDAP (Registration Data Access Protocol) вместо TCP‑WHOIS
- Покрытие unit‑тестами парсера и сервиса
- Поставить автообновление списка TLD серверов через Kernel в laravel или через cron напрямую

---

<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## About Laravel

Laravel is a web application framework with expressive, elegant syntax. We believe development must be an enjoyable and creative experience to be truly fulfilling. Laravel takes the pain out of development by easing common tasks used in many web projects, such as:

- [Simple, fast routing engine](https://laravel.com/docs/routing).
- [Powerful dependency injection container](https://laravel.com/docs/container).
- Multiple back-ends for [session](https://laravel.com/docs/session) and [cache](https://laravel.com/docs/cache) storage.
- Expressive, intuitive [database ORM](https://laravel.com/docs/eloquent).
- Database agnostic [schema migrations](https://laravel.com/docs/migrations).
- [Robust background job processing](https://laravel.com/docs/queues).
- [Real-time event broadcasting](https://laravel.com/docs/broadcasting).

Laravel is accessible, powerful, and provides tools required for large, robust applications.

## Learning Laravel

Laravel has the most extensive and thorough [documentation](https://laravel.com/docs) and video tutorial library of all modern web application frameworks, making it a breeze to get started with the framework.

You may also try the [Laravel Bootcamp](https://bootcamp.laravel.com), where you will be guided through building a modern Laravel application from scratch.

If you don't feel like reading, [Laracasts](https://laracasts.com) can help. Laracasts contains thousands of video tutorials on a range of topics including Laravel, modern PHP, unit testing, and JavaScript. Boost your skills by digging into our comprehensive video library.

## Laravel Sponsors

We would like to extend our thanks to the following sponsors for funding Laravel development. If you are interested in becoming a sponsor, please visit the [Laravel Partners program](https://partners.laravel.com).

### Premium Partners

- **[Vehikl](https://vehikl.com/)**
- **[Tighten Co.](https://tighten.co)**
- **[Kirschbaum Development Group](https://kirschbaumdevelopment.com)**
- **[64 Robots](https://64robots.com)**
- **[Curotec](https://www.curotec.com/services/technologies/laravel/)**
- **[DevSquad](https://devsquad.com/hire-laravel-developers)**
- **[Redberry](https://redberry.international/laravel-development/)**
- **[Active Logic](https://activelogic.com)**

## Contributing

Thank you for considering contributing to the Laravel framework! The contribution guide can be found in the [Laravel documentation](https://laravel.com/docs/contributions).

## Code of Conduct

In order to ensure that the Laravel community is welcoming to all, please review and abide by the [Code of Conduct](https://laravel.com/docs/contributions#code-of-conduct).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
