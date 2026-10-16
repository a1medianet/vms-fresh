# دليل التثبيت - VMS-Fresh

## المتطلبات

### على Windows (محلي):
1. **XAMPP** أو **Laragon** أو **WAMP**
   - يحتوي على PHP 8.1+ و MySQL
   - تحميل من: https://www.apachefriends.org/ أو https://laragon.org/

2. **Composer**
   - تحميل من: https://getcomposer.org/download/
   - تأكد من إضافة Composer إلى PATH

3. **Node.js & NPM** (اختياري - للـ Frontend Assets)
   - تحميل من: https://nodejs.org/

### على سيرفر الاستضافة (Business Plan):
- PHP 8.1+
- MySQL 5.7+ أو 8.0+
- Composer
- SSH Access
- Apache/Nginx مع mod_rewrite

## خطوات التثبيت

### على Windows (محلي):

1. **نسخ المشروع**
   ```bash
   cd C:\A1Hub\vms-fresh
   ```

2. **تثبيت التبعيات**
   ```bash
   composer install
   ```

3. **إعداد ملف البيئة**
   ```bash
   copy .env.example .env
   ```

4. **تعديل ملف .env**
   افتح `.env` وعدّل:
   ```env
   DB_DATABASE=vms_fresh
   DB_USERNAME=root
   DB_PASSWORD=        # اتركه فارغاً إذا لم يكن هناك كلمة مرور
   ```

5. **إنشاء قاعدة البيانات**
   - افتح phpMyAdmin (http://localhost/phpmyadmin)
   - أنشئ قاعدة بيانات جديدة باسم `vms_fresh`

6. **توليد مفتاح التطبيق**
   ```bash
   php artisan key:generate
   ```

7. **تشغيل Migrations والـ Seeders**
   ```bash
   php artisan migrate --seed
   ```

8. **تشغيل السيرفر**
   ```bash
   php artisan serve
   ```

9. **الوصول للتطبيق**
   افتح المتصفح على: http://localhost:8000

### على سيرفر الاستضافة:

1. **رفع الملفات**
   - استخدم FTP/SFTP لرفع جميع ملفات المشروع إلى المجلد المطلوب

2. **إعداد ملف .env**
   ```bash
   cp .env.example .env
   nano .env
   ```
   عدّل:
   ```env
   APP_ENV=production
   APP_DEBUG=false
   DB_HOST=localhost
   DB_DATABASE=your_database_name
   DB_USERNAME=your_database_user
   DB_PASSWORD=your_database_password
   ```

3. **تثبيت التبعيات**
   ```bash
   composer install --no-dev --optimize-autoloader
   ```

4. **توليد المفتاح**
   ```bash
   php artisan key:generate
   ```

5. **تشغيل Migrations**
   ```bash
   php artisan migrate --seed
   ```

6. **تخزين التكوين**
   ```bash
   php artisan config:cache
   php artisan route:cache
   php artisan view:cache
   ```

7. **إعداد الصلاحيات**
   ```bash
   chmod -R 755 storage bootstrap/cache
   chown -R www-data:www-data storage bootstrap/cache
   ```

## الحسابات الافتراضية

بعد تشغيل `php artisan migrate --seed`:

- **Super Admin**:
  - Email: `admin@vms.local`
  - Password: `password`

- **Admin**:
  - Email: `admin2@vms.local`
  - Password: `password`

- **Staff**:
  - Email: `staff@vms.local`
  - Password: `password`

## استكشاف الأخطاء

### خطأ: "Class not found"
```bash
composer dump-autoload
```

### خطأ: "Permission denied"
```bash
chmod -R 755 storage bootstrap/cache
```

### خطأ: "Database connection failed"
- تأكد من إعدادات قاعدة البيانات في `.env`
- تأكد من تشغيل MySQL
- تأكد من وجود قاعدة البيانات

## ملاحظات مهمة

1. **على Windows**: استخدم XAMPP أو Laragon لتشغيل PHP و MySQL محلياً
2. **على السيرفر**: تأكد من أن PHP 8.1+ مثبت
3. **الأمان**: غيّر كلمات المرور الافتراضية فوراً بعد التثبيت
4. **النسخ الاحتياطي**: قم بعمل نسخة احتياطية من قاعدة البيانات بانتظام
