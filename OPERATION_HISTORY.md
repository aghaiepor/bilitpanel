# تاریخچه عملیات پروژه

مسیر پروژه: `C:\Users\aghaepor\Desktop\bilitpaanelv2\bilitpanel_v2`

## عملیات انجام‌شده

- حذف image خصوصی `municipality-spv2-2-4-2` و ساخت image محلی Docker.
- تنظیم سرویس روی `127.0.0.1:8081` و حذف HTTPS و certificateهای `/etc/ssls`.
- انتقال لاگ Nginx به `/dev/stdout` و `/dev/stderr`.
- ارتقای Ubuntu از 20.04 به 24.04.
- ارتقای PHP و PHP-FPM از 7.4 به 8.3.
- افزودن افزونه‌های PHP موردنیاز Laravel.
- ارتقای Laravel از 7 به 13 و Composer PHP به `^8.3`.
- حذف پکیج‌های قدیمی `fideloper/proxy`، `fruitcake/laravel-cors`، `facade/ignition` و `fzaninotto/faker`.
- جایگزینی Faker با `fakerphp/faker` و ارتقای PHPUnit به نسخه 12.
- ارتقای Tinker، Collision، Laravel Excel، PhpSpreadsheet و Predis.
- حذف `composer.lock` قدیمی و انتقال نصب dependencyها به Docker build.
- اصلاح middlewareهای CORS، maintenance و `TrustProxies`.
- اصلاح PSR-4 در `SeanceController`.
- اصلاح `.env`: `HAS_LDAP=true`.
- اصلاح Intervention Image از API قدیمی به `Image::read()` و `toJpeg()`.
- حذف redirect آزمایشی SSO و IPهای hardcoded.
- تنظیم `APP_URL` روی `http://127.0.0.1:8081`.
- افزودن بررسی `composer.json` و `vendor/autoload.php` در startup.

## اجرای نهایی

```bash
cd /path/to/bilitpanel_v2
docker compose down --remove-orphans
docker builder prune -af
docker compose build --no-cache --progress=plain
docker compose up -d --force-recreate
```

## بررسی

```bash
docker compose ps
docker compose logs --tail=300 sibpanel-v2
docker compose exec sibpanel-v2 php -v
docker compose exec sibpanel-v2 composer check-platform-reqs
docker compose exec sibpanel-v2 php artisan --version
docker compose exec sibpanel-v2 php artisan optimize:clear
docker compose exec sibpanel-v2 php artisan route:list
curl -i http://127.0.0.1:8081/
```

## وضعیت

فایل‌های پروژه پس از آخرین اصلاحات بررسی شدند. نتیجه build و تست HTTP باید با دستورات بالا ثبت شود.