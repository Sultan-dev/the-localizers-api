# دليل التثبيت والإعداد

## متطلبات النظام

- PHP >= 8.1
- Composer
- MySQL >= 5.7
- Node.js & npm (للتطوير)

## خطوات التثبيت

### 1. تثبيت Laravel Dependencies

```bash
cd api-backend
composer install
```

### 2. إعداد ملف البيئة

```bash
cp .env.example .env
php artisan key:generate
```

### 3. تكوين قاعدة البيانات

قم بتعديل ملف `.env`:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=localizer_db
DB_USERNAME=root
DB_PASSWORD=your_password
```

### 4. إنشاء قاعدة البيانات

```sql
CREATE DATABASE localizer_db CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
```

### 5. تشغيل Migrations

```bash
php artisan migrate
```

### 6. تشغيل Seeders (لإنشاء بيانات تجريبية)

```bash
php artisan db:seed
```

سيتم إنشاء:
- مستخدم Admin: `admin@localizer.com` / `password`
- كاردات تجريبية
- تشريعات تجريبية

### 7. تشغيل الخادم

```bash
php artisan serve
```

الخادم سيعمل على: `http://localhost:8000`

## إعداد Frontend

### 1. إضافة متغير البيئة

أنشئ ملف `.env` في مجلد `pixel-perfect-ui`:

```env
VITE_API_URL=http://localhost:8000/api
```

### 2. تشغيل Frontend

```bash
cd pixel-perfect-ui
npm install
npm run dev
```

## API Endpoints

### Authentication
- `POST /api/login` - تسجيل الدخول
- `POST /api/logout` - تسجيل الخروج (محمي)
- `GET /api/user` - معلومات المستخدم (محمي)

### Cards
- `GET /api/cards` - الحصول على جميع الكاردات (عام)
- `POST /api/cards` - إضافة كارد (Admin)
- `GET /api/cards/{id}` - الحصول على كارد محدد (Admin)
- `PUT /api/cards/{id}` - تحديث كارد (Admin)
- `DELETE /api/cards/{id}` - حذف كارد (Admin)

### Legislations
- `GET /api/legislations` - الحصول على جميع التشريعات (Admin)
- `POST /api/legislations` - إضافة تشريع (Admin)
- `GET /api/legislations/{id}` - الحصول على تشريع محدد (Admin)
- `PUT /api/legislations/{id}` - تحديث تشريع (Admin)
- `DELETE /api/legislations/{id}` - حذف تشريع (Admin)

## هيكل قاعدة البيانات

### جدول users
- id, name, email, password, role, timestamps

### جدول cards
- id, title, subtitle, description, link, badge, preview_url
- is_coming_soon, order, is_active, timestamps

### جدول legislations
- id, title, type, description, date, number, status, timestamps

### جدول personal_access_tokens
- id, tokenable_type, tokenable_id, name, token, abilities, timestamps

## ملاحظات

- تأكد من تشغيل CORS بشكل صحيح
- جميع طلبات API المحمية تتطلب Bearer Token في Header
- Token يتم حفظه في localStorage في Frontend

