# Localizer API Backend

Laravel API Backend لإدارة لوحة التحكم والتشريعات.

## المتطلبات

- PHP >= 8.1
- Composer
- MySQL >= 5.7
- Laravel 10.x

## التثبيت

1. تثبيت المتطلبات:
```bash
composer install
```

2. نسخ ملف البيئة:
```bash
cp .env.example .env
```

3. إنشاء مفتاح التطبيق:
```bash
php artisan key:generate
```

4. تكوين قاعدة البيانات في `.env`:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=localizer_db
DB_USERNAME=root
DB_PASSWORD=
```

5. تشغيل Migrations:
```bash
php artisan migrate
```

6. تشغيل Seeders:
```bash
php artisan db:seed
```

## بيانات الدخول الافتراضية

- **Email:** admin@localizer.com
- **Password:** password

## تشغيل الخادم

```bash
php artisan serve
```

الخادم سيعمل على: `http://localhost:8000`

## API Endpoints

### Authentication
- `POST /api/login` - تسجيل الدخول
- `POST /api/logout` - تسجيل الخروج (محمي)
- `GET /api/user` - معلومات المستخدم الحالي (محمي)

### Cards (Public)
- `GET /api/cards` - الحصول على جميع الكاردات النشطة

### Cards (Admin)
- `POST /api/cards` - إضافة كارد جديد
- `GET /api/cards/{id}` - الحصول على كارد محدد
- `PUT /api/cards/{id}` - تحديث كارد
- `DELETE /api/cards/{id}` - حذف كارد

### Legislations (Admin)
- `GET /api/legislations` - الحصول على جميع التشريعات
- `POST /api/legislations` - إضافة تشريع جديد
- `GET /api/legislations/{id}` - الحصول على تشريع محدد
- `PUT /api/legislations/{id}` - تحديث تشريع
- `DELETE /api/legislations/{id}` - حذف تشريع

## CORS Configuration

تم تكوين CORS للسماح بالطلبات من:
- `http://localhost:5173` (Vite dev server)
- `http://localhost:3000` (React dev server)

## Authentication

يستخدم Laravel Sanctum للمصادقة. يجب إرسال Token في header:
```
Authorization: Bearer {token}
```

