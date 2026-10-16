# VMS-Fresh - Visitor Management System

نظام إدارة زوار وتسكين احترافي قابل للتوسّع، متعدد المستخدمين والصلاحيات، متعدد اللغات (EN/AR/IT)، مع تقارير، إشعارات، واستيراد/تصدير.

**Professional Visitor Management System - Scalable, Multi-user, Multi-language (EN/AR/IT) with Reports, Notifications, and Import/Export**

---

## 📚 التوثيق الكامل

- **[GUIDE_AR.md](GUIDE_AR.md)** - دليل شامل بالعربية (موصى به)
- **[INSTALLATION.md](INSTALLATION.md)** - دليل التثبيت التفصيلي
- **[DEPLOYMENT_COMPARISON.md](DEPLOYMENT_COMPARISON.md)** - مقارنة التنفيذ على Windows vs السيرفر

---

## ⚡ البدء السريع

### على Windows (محلي):

1. **تثبيت XAMPP** من https://www.apachefriends.org/
2. **تثبيت Composer** من https://getcomposer.org
3. **تشغيل Apache و MySQL** من لوحة تحكم XAMPP
4. **فتح Terminal** في مجلد المشروع:
```bash
cd C:\A1Hub\vms-fresh
composer install
copy .env.example .env
# عدّل .env: DB_DATABASE=vms_fresh
php artisan key:generate
php artisan migrate --seed
php artisan serve
```
5. **افتح المتصفح**: http://localhost:8000

### على سيرفر الاستضافة:

راجع **[GUIDE_AR.md](GUIDE_AR.md)** للخطوات التفصيلية.

---

## 🔑 الحسابات الافتراضية

بعد `php artisan migrate --seed`:

- **Super Admin**: `admin@vms.local` / `password`
- **Admin**: `admin2@vms.local` / `password`
- **Staff**: `staff@vms.local` / `password`

⚠️ **غيّر كلمات المرور فوراً بعد التثبيت!**

---

## ✨ الميزات

- ✅ نظام مصادقة مخصص (بدون Jetstream)
- ✅ نظام صلاحيات متقدم (Roles & Permissions)
- ✅ Pre-Arrival Module (روابط لمرة واحدة)
- ✅ Visitor Management
- ✅ Housing/Accommodation Management
- ✅ Reports Engine (Daily, Weekly, Monthly, Yearly)
- ✅ Import/Export Excel
- ✅ PDF Reports
- ✅ Email Notifications
- ✅ دعم 3 لغات: English, العربية (RTL), Italiano
- ✅ Dashboard Cards & Tables
- ✅ Responsive Design

---

## 🛠️ المتطلبات

- PHP 8.1+
- MySQL 5.7+ أو 8.0+
- Composer
- Apache/Nginx (للسيرفر)

---

## 📁 البنية

```
vms-fresh/
├── app/
│   ├── Models/
│   ├── Http/Controllers/
│   ├── Notifications/
│   ├── Imports/
│   └── Exports/
├── database/
│   ├── migrations/
│   └── seeders/
├── resources/
│   ├── views/
│   └── lang/ (en, ar, it)
└── routes/
```

---

## 🌍 اللغات المدعومة

- English (en)
- العربية (ar) - RTL Support
- Italiano (it)

---

## 📖 للمزيد من المعلومات

- راجع **[GUIDE_AR.md](GUIDE_AR.md)** للدليل الشامل
- راجع **[INSTALLATION.md](INSTALLATION.md)** لخطوات التثبيت التفصيلية
- راجع **[DEPLOYMENT_COMPARISON.md](DEPLOYMENT_COMPARISON.md)** لمقارنة Windows vs السيرفر

---

## 📝 الترخيص

MIT License

---

## 🆘 المساعدة

إذا واجهت أي مشاكل:
1. راجع ملفات التوثيق
2. تأكد من تثبيت جميع المتطلبات
3. تأكد من إعدادات قاعدة البيانات في `.env`

**بالتوفيق! 🚀**
