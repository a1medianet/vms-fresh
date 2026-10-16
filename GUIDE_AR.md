# دليل VMS-Fresh الشامل

## نظرة عامة

**VMS-Fresh** هو نظام إدارة زوار وتسكين احترافي مبني على Laravel، قابل للتوسّع، متعدد المستخدمين والصلاحيات، متعدد اللغات (الإنجليزية، العربية RTL، الإيطالية)، مع تقارير شاملة، إشعارات، واستيراد/تصدير.

## الميزات الرئيسية

### 1. نظام المصادقة والصلاحيات
- نظام مصادقة مخصص (بدون Jetstream)
- نظام Roles & Permissions متقدم
- 3 أدوار افتراضية: Super Admin, Admin, Staff
- صلاحيات قابلة للتخصيص

### 2. Pre-Arrival Module
- إنشاء روابط لمرة واحدة للزوار
- رابط فريد لكل Pre-Arrival
- عند استخدام الرابط، يُنشأ Visitor تلقائياً
- إشعارات فورية للمسؤولين

### 3. Visitor Management
- إدارة كاملة للزوار
- حالات: Pending, Checked-In, Checked-Out
- ربط مع Pre-Arrival
- تتبع كامل للزوار

### 4. Housing/Accommodation
- إدارة المباني (Buildings)
- إدارة الطوابق (Floors)
- إدارة الغرف (Rooms)
- نظام التعيينات (Assignments)
- تتبع الإشغال

### 5. Reports Engine
- تقارير يومية
- تقارير أسبوعية
- تقارير شهرية
- تقارير سنوية
- تصدير PDF و Excel

### 6. Import/Export
- استيراد الزوار من Excel
- استيراد المباني والغرف من Excel
- تصدير الزوار
- تصدير Pre-Arrivals
- تصدير التقارير

### 7. Notifications
- إشعارات Email
- إشعارات Database
- إشعارات عند:
  - تقديم Pre-Arrival جديد
  - إنشاء Visitor جديد
  - Visitor في انتظار Check-In

### 8. Multi-Language Support
- الإنجليزية (EN)
- العربية (AR) - مع دعم RTL
- الإيطالية (IT)

## البنية التقنية

### Stack
- **Framework**: Laravel 10 (LTS)
- **PHP**: 8.1+
- **Database**: MySQL 5.7+ / 8.0+
- **Frontend**: Blade Templates + Bootstrap 5
- **Excel**: maatwebsite/laravel-excel
- **PDF**: barryvdh/laravel-dompdf

### البنية
```
vms-fresh/
├── app/
│   ├── Models/          # Models مع العلاقات
│   ├── Http/
│   │   ├── Controllers/ # جميع Controllers
│   │   └── Middleware/  # Middleware للصلاحيات
│   ├── Notifications/   # إشعارات Email
│   ├── Imports/         # استيراد Excel
│   └── Exports/         # تصدير Excel
├── database/
│   ├── migrations/      # جميع Migrations
│   └── seeders/         # Seeders للبيانات الافتراضية
├── resources/
│   ├── views/           # Blade Templates
│   └── lang/            # ملفات الترجمة (en, ar, it)
└── routes/
    └── web.php          # جميع Routes
```

## خطوات التنفيذ

### الخيار 1: على Windows (محلي)

#### المتطلبات:
1. **XAMPP** أو **Laragon** أو **WAMP**
   - يحتوي على PHP 8.1+ و MySQL
   - تحميل من:
     - XAMPP: https://www.apachefriends.org/
     - Laragon: https://laragon.org/
     - WAMP: https://www.wampserver.com/

2. **Composer**
   - تحميل من: https://getcomposer.org/download/
   - تأكد من إضافة Composer إلى PATH

3. **Node.js & NPM** (اختياري)
   - تحميل من: https://nodejs.org/

#### خطوات التثبيت:

1. **فتح Terminal/PowerShell**
   ```powershell
   cd C:\Users\qiyam\vms-fresh
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
   افتح المتصفح على: **http://localhost:8000**

### الخيار 2: على سيرفر الاستضافة (Business Plan)

#### المتطلبات:
- PHP 8.1+
- MySQL 5.7+ أو 8.0+
- Composer
- SSH Access
- Apache/Nginx مع mod_rewrite

#### خطوات التثبيت:

1. **رفع الملفات**
   - استخدم FTP/SFTP (FileZilla, WinSCP)
   - ارفع جميع ملفات المشروع إلى المجلد المطلوب (مثلاً: `public_html` أو `www`)

2. **الاتصال عبر SSH**
   ```bash
   ssh username@your-domain.com
   cd /path/to/your/project
   ```

3. **إعداد ملف .env**
   ```bash
   cp .env.example .env
   nano .env
   ```
   عدّل:
   ```env
   APP_ENV=production
   APP_DEBUG=false
   APP_URL=https://your-domain.com

   DB_HOST=localhost
   DB_DATABASE=your_database_name
   DB_USERNAME=your_database_user
   DB_PASSWORD=your_database_password
   ```

4. **تثبيت التبعيات**
   ```bash
   composer install --no-dev --optimize-autoloader
   ```

5. **توليد المفتاح**
   ```bash
   php artisan key:generate
   ```

6. **تشغيل Migrations**
   ```bash
   php artisan migrate --seed
   ```

7. **تخزين التكوين**
   ```bash
   php artisan config:cache
   php artisan route:cache
   php artisan view:cache
   ```

8. **إعداد الصلاحيات**
   ```bash
   chmod -R 755 storage bootstrap/cache
   chown -R www-data:www-data storage bootstrap/cache
   ```

9. **إعداد Apache/Nginx**

   **لـ Apache (.htaccess موجود في public):**
   ```apache
   <IfModule mod_rewrite.c>
       RewriteEngine On
       RewriteRule ^(.*)$ public/$1 [L]
   </IfModule>
   ```

   **لـ Nginx:**
   ```nginx
   server {
       listen 80;
       server_name your-domain.com;
       root /path/to/your/project/public;

       add_header X-Frame-Options "SAMEORIGIN";
       add_header X-Content-Type-Options "nosniff";

       index index.php;

       charset utf-8;

       location / {
           try_files $uri $uri/ /index.php?$query_string;
       }

       location = /favicon.ico { access_log off; log_not_found off; }
       location = /robots.txt  { access_log off; log_not_found off; }

       error_page 404 /index.php;

       location ~ \.php$ {
           fastcgi_pass unix:/var/run/php/php8.1-fpm.sock;
           fastcgi_param SCRIPT_FILENAME $realpath_root$fastcgi_script_name;
           include fastcgi_params;
       }

       location ~ /\.(?!well-known).* {
           deny all;
       }
   }
   ```

## الحسابات الافتراضية

بعد تشغيل `php artisan migrate --seed`:

### Super Admin
- **Email**: `admin@vms.local`
- **Password**: `password`
- **الصلاحيات**: جميع الصلاحيات

### Admin
- **Email**: `admin2@vms.local`
- **Password**: `password`
- **الصلاحيات**: جميع الصلاحيات ما عدا إدارة المستخدمين

### Staff
- **Email**: `staff@vms.local`
- **Password**: `password`
- **الصلاحيات**: إدارة الزوار وعرض التقارير فقط

**⚠️ مهم جداً**: غيّر كلمات المرور الافتراضية فوراً بعد التثبيت!

## استخدام النظام

### 1. تسجيل الدخول
- افتح المتصفح على: `http://localhost:8000` (محلي) أو `https://your-domain.com` (سيرفر)
- استخدم أحد الحسابات الافتراضية

### 2. إنشاء Pre-Arrival
1. اذهب إلى **Pre-Arrival** من القائمة الجانبية
2. اضغط **Create Pre-Arrival**
3. املأ البيانات
4. بعد الإنشاء، ستحصل على رابط فريد
5. أرسل الرابط للزائر

### 3. الزائر يملأ النموذج
- الزائر يفتح الرابط
- يملأ النموذج
- عند الإرسال:
  - يُنشأ Visitor تلقائياً
  - يُغلق الرابط (لا يمكن استخدامه مرة أخرى)
  - تُرسل إشعارات للمسؤولين

### 4. إدارة الزوار
- عرض جميع الزوار
- البحث والفلترة
- Check-In / Check-Out
- عرض التفاصيل

### 5. إدارة السكن
- إنشاء المباني
- إضافة الطوابق
- إضافة الغرف
- تعيين الزوار للغرف

### 6. التقارير
- تقارير يومية/أسبوعية/شهرية/سنوية
- تصدير PDF أو Excel
- إحصائيات شاملة

### 7. Import/Export
- استيراد الزوار من Excel
- تصدير البيانات
- استيراد المباني والغرف

## استكشاف الأخطاء

### خطأ: "Class not found"
```bash
composer dump-autoload
```

### خطأ: "Permission denied"
```bash
# على Linux/Mac
chmod -R 755 storage bootstrap/cache

# على Windows (PowerShell)
icacls storage /grant Users:F /T
icacls bootstrap\cache /grant Users:F /T
```

### خطأ: "Database connection failed"
- تأكد من إعدادات قاعدة البيانات في `.env`
- تأكد من تشغيل MySQL
- تأكد من وجود قاعدة البيانات
- تأكد من صحة اسم المستخدم وكلمة المرور

### خطأ: "500 Internal Server Error"
- تأكد من `APP_DEBUG=true` في `.env` لرؤية الخطأ
- تأكد من الصلاحيات على `storage` و `bootstrap/cache`
- تأكد من وجود ملف `.env`

### خطأ: "Route not found"
```bash
php artisan route:clear
php artisan route:cache
```

## الأمان

### بعد التثبيت:
1. **غيّر كلمات المرور الافتراضية**
2. **غيّر `APP_KEY`** (إذا كان موجوداً مسبقاً)
3. **عطّل `APP_DEBUG`** في الإنتاج:
   ```env
   APP_DEBUG=false
   ```
4. **استخدم HTTPS** على السيرفر
5. **قم بعمل نسخ احتياطي** من قاعدة البيانات بانتظام

## النسخ الاحتياطي

### قاعدة البيانات:
```bash
# Export
mysqldump -u username -p vms_fresh > backup.sql

# Import
mysql -u username -p vms_fresh < backup.sql
```

### الملفات:
- قم بنسخ مجلد `storage` بانتظام
- قم بنسخ ملف `.env`

## الدعم والمساعدة

إذا واجهت أي مشاكل:
1. راجع ملف `INSTALLATION.md`
2. راجع ملف `README.md`
3. تأكد من أن جميع المتطلبات مثبتة
4. تأكد من الصلاحيات على المجلدات

## الخلاصة

**VMS-Fresh** نظام كامل وجاهز للاستخدام. يمكنك:
- ✅ تشغيله على Windows محلياً باستخدام XAMPP/Laragon
- ✅ نشره على سيرفر الاستضافة (Business Plan)
- ✅ تخصيصه حسب احتياجاتك
- ✅ توسيعه بإضافة ميزات جديدة

**نصيحة**: ابدأ بالتشغيل محلياً للتجربة، ثم انشره على السيرفر بعد التأكد من أن كل شيء يعمل بشكل صحيح.
