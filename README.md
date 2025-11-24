# 📋 Sistem Manajemen Dokumen & Keuangan Multi-PT

Sistem manajemen berbasis Laravel 12 + Filament 4 untuk mengelola dokumen pemberkasan dan laporan keuangan multi-perusahaan dengan role-based access control.

## 🎯 Fitur Utama

### **Multi-Company Management**
- Manajemen Multi PT
- Manajemen lokasi perumahan per PT
- Role-based access per company

### **Dokumen Pemberkasan**
- Upload KTP, KK, NPWP
- Surat keterangan kerja & usaha
- Slip gaji & rekening koran
- Neraca keuangan
- Surat pengajuan rumah

### **Laporan Harian (Admin Pemberkasan)**
- Daily Report Westhom
- Control Report
- Rekap Proyek Subsidi
- Rekap Proyek Premio

### **Keuangan Proyek (Admin Keuangan)**
- Laporan Keuangan PT
- Petty Cash
- Data Pembayaran (Data Konsumen, Pembayaran, Reject)
- SP3K Konsumen
- Pencairan KPR
- Biaya Material & Tenaga Bangunan

### **Role Management**
- **Founder**: Akses semua PT
- **Direktur/Komisaris**: Akses PT sendiri
- **Admin Pemberkasan**: CRUD dokumen & laporan harian
- **Admin Keuangan**: CRUD laporan keuangan

---

## 🛠️ Tech Stack

- **Laravel**: 12.x
- **Filament**: 4.x
- **PHP**: 8.2+
- **Database**: MySQL 8.0+
- **Node.js**: 18+ (untuk assets)

---

## 📦 Installation

### **Prerequisites**

Pastikan sudah terinstall:
- PHP 8.2 or higher
- Composer
- MySQL 8.0 or higher
- Node.js 18+ & NPM

### **Step 1: Clone Repository**

```bash
git clone <repository-url>
cd <project-folder>
```

### **Step 2: Install Dependencies**

```bash
# Install PHP dependencies
composer install

# Install Node dependencies
npm install
```

### **Step 3: Environment Setup**

```bash
# Copy .env file
cp .env.example .env

# Generate application key
php artisan key:generate
```

### **Step 4: Configure Database**

Edit file `.env`:

```env
APP_NAME="Sistem Manajemen PT"
APP_URL=http://localhost:8000
APP_ENV=local
APP_DEBUG=true

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=nama_database_anda
DB_USERNAME=root
DB_PASSWORD=your_password

FILESYSTEM_DISK=local
```

### **Step 5: Database Migration & Seeder**

```bash
# Create database (jika belum ada)
mysql -u root -p
CREATE DATABASE nama_database_anda;
EXIT;

# Run migrations
php artisan migrate

# Seed initial data (3 companies)
php artisan db:seed --class=CompanySeeder
```

### **Step 6: Storage Link**

```bash
# Create storage link for file uploads
php artisan storage:link

# Set permissions (Linux/Mac)
chmod -R 775 storage
chmod -R 775 bootstrap/cache
```

### **Step 7: Create Admin User**

```bash
# Create first admin user (Founder)
php artisan make:filament-user
```

Input data:
- **Name**: Admin Founder
- **Email**: founder@example.com
- **Password**: password (ganti dengan password kuat)

Kemudian update role di database:

```bash
php artisan tinker
```

```php
$user = App\Models\User::where('email', 'founder@example.com')->first();
$user->role = 'founder';
$user->save();
exit;
```

### **Step 8: Build Assets**

```bash
# Development
npm run dev

# Production
npm run build
```

### **Step 9: Run Application**

```bash
php artisan serve
```

Akses aplikasi di: **http://localhost:8000/admin**

---

## 👥 Create Test Users

Jalankan di terminal:

```bash
php artisan tinker
```

Copy paste kode berikut:

```php
use App\Models\User;
use App\Models\Company;

// 1. Founder (sudah dibuat di step 7)

// 2. Direktur PT PAS
$pas = Company::where('code', 'PAS')->first();
User::create([
    'name' => 'Direktur PAS',
    'email' => 'direktur@pas.com',
    'password' => bcrypt('password'),
    'role' => 'direktur',
    'company_id' => $pas->id,
    'is_active' => true,
]);

// 3. Komisaris PT MBS
$mbs = Company::where('code', 'MBS')->first();
User::create([
    'name' => 'Komisaris MBS',
    'email' => 'komisaris@mbs.com',
    'password' => bcrypt('password'),
    'role' => 'komisaris',
    'company_id' => $mbs->id,
    'is_active' => true,
]);

// 4. Admin Pemberkasan PT PAS
User::create([
    'name' => 'Admin Pemberkasan PAS',
    'email' => 'pemberkasan@pas.com',
    'password' => bcrypt('password'),
    'role' => 'admin_pemberkasan',
    'company_id' => $pas->id,
    'is_active' => true,
]);

// 5. Admin Keuangan PT MBS
User::create([
    'name' => 'Admin Keuangan MBS',
    'email' => 'keuangan@mbs.com',
    'password' => bcrypt('password'),
    'role' => 'admin_keuangan',
    'company_id' => $mbs->id,
    'is_active' => true,
]);

// 6. Admin Pemberkasan PT YMS
$yms = Company::where('code', 'YMS')->first();
User::create([
    'name' => 'Admin Pemberkasan YMS',
    'email' => 'pemberkasan@yms.com',
    'password' => bcrypt('password'),
    'role' => 'admin_pemberkasan',
    'company_id' => $yms->id,
    'is_active' => true,
]);

// 7. Admin Keuangan PT YMS
User::create([
    'name' => 'Admin Keuangan YMS',
    'email' => 'keuangan@yms.com',
    'password' => bcrypt('password'),
    'role' => 'admin_keuangan',
    'company_id' => $yms->id,
    'is_active' => true,
]);

echo "✅ Test users created successfully!\n";
exit;
```

---

## 🔐 Default Credentials

### Founder (Full Access)
- Email: `founder@example.com`
- Password: `password`

### Direktur PT PAS
- Email: `direktur@pas.com`
- Password: `password`

### Admin Pemberkasan PT PAS
- Email: `pemberkasan@pas.com`
- Password: `password`

### Admin Keuangan PT MBS
- Email: `keuangan@mbs.com`
- Password: `password`

> ⚠️ **PENTING**: Ganti semua password default setelah login pertama!

---

## 📁 Project Structure

```
app/
├── Filament/
│   ├── Resources/
│   │   ├── CompanyResource.php
│   │   ├── UserResource.php
│   │   ├── DocumentResource.php
│   │   ├── FinancialReportResource.php
│   │   ├── HousingLocationResource.php
│   │   ├── DailyReportResource.php
│   │   └── ProjectFinanceResource.php
│   ├── Widgets/
│   │   └── StatsOverview.php
│   └── Pages/
│       └── Dashboard.php
├── Models/
│   ├── Company.php
│   ├── User.php
│   ├── Document.php
│   ├── FinancialReport.php
│   ├── HousingLocation.php
│   ├── DailyReport.php
│   └── ProjectFinance.php
├── Policies/
│   ├── DocumentPolicy.php
│   └── FinancialReportPolicy.php
└── Providers/
    └── AuthServiceProvider.php

database/
├── migrations/
│   ├── xxxx_create_companies_table.php
│   ├── xxxx_update_users_table.php
│   ├── xxxx_create_documents_table.php
│   ├── xxxx_create_financial_reports_table.php
│   ├── xxxx_create_housing_locations_table.php
│   ├── xxxx_create_daily_reports_table.php
│   └── xxxx_create_project_finances_table.php
└── seeders/
    └── CompanySeeder.php

storage/
└── app/
    └── private/          # File storage (KTP, reports, etc)
```

---

## 🎯 Usage Guide

### **1. Setup Lokasi Perumahan (Master Data)**

Login sebagai **Founder** atau **Direktur**:
1. Buka menu **Lokasi Perumahan**
2. Klik **New**
3. Isi: Nama, Kode, Alamat
4. Save

### **2. Upload Dokumen Pemberkasan**

Login sebagai **Admin Pemberkasan**:
1. Buka menu **Dokumen Pemberkasan**
2. Klik **New**
3. Isi nama lengkap & deskripsi
4. Upload file-file dokumen (KTP, KK, NPWP, dll)
5. Save

### **3. Input Laporan Harian**

Login sebagai **Admin Pemberkasan**:
1. Buka menu **Laporan Harian**
2. Klik **New**
3. Pilih lokasi perumahan
4. Pilih jenis laporan (Daily Report, Control Report, dll)
5. Upload file Excel
6. Save

### **4. Input Keuangan Proyek**

Login sebagai **Admin Keuangan**:
1. Buka menu **Keuangan Proyek**
2. Klik **New**
3. Pilih lokasi perumahan
4. Pilih jenis laporan keuangan
5. Upload file sesuai jenis (form dinamis)
6. Save

### **5. Review & Approval**

Login sebagai **Direktur** atau **Komisaris**:
1. Buka laporan yang ingin direview
2. Ubah status menjadi **Reviewed** atau **Approved**
3. Save

---

## 🔄 Common Commands

```bash
# Clear all cache
php artisan optimize:clear

# Recreate storage link
php artisan storage:link

# Run migrations
php artisan migrate

# Rollback migrations
php artisan migrate:rollback

# Fresh migration with seed
php artisan migrate:fresh --seed

# Clear Filament cache
php artisan filament:cache-components

# Generate Filament resource
php artisan make:filament-resource ModelName --generate --view

# Generate Filament widget
php artisan make:filament-widget WidgetName --stats-overview

# Create Filament user
php artisan make:filament-user
```

---

## 🐛 Troubleshooting

### **Problem: File upload error**

```bash
# Solution:
php artisan storage:link
chmod -R 775 storage
php artisan config:clear
```

### **Problem: Class not found**

```bash
# Solution:
composer dump-autoload
php artisan optimize:clear
```

### **Problem: Menu tidak muncul**

```bash
# Solution:
php artisan filament:cache-components
php artisan cache:clear
```

### **Problem: Migration error**

```bash
# Solution:
php artisan migrate:fresh --seed
```

### **Problem: Permission denied (Linux)**

```bash
# Solution:
sudo chown -R $USER:$USER storage
sudo chown -R $USER:$USER bootstrap/cache
chmod -R 775 storage
chmod -R 775 bootstrap/cache
```

---

## 📊 Database Tables

| Table | Description |
|-------|-------------|
| `companies` | Data perusahaan (3 PT) |
| `users` | User dengan role & company |
| `housing_locations` | Lokasi perumahan per PT |
| `documents` | Dokumen pemberkasan (KTP, KK, dll) |
| `financial_reports` | Laporan keuangan PT umum |
| `daily_reports` | Laporan harian pemberkasan |
| `project_finances` | Keuangan proyek per lokasi |

---

## 🔐 Roles & Permissions

| Role | Companies | Users | Housing | Documents | Financial | Daily Reports | Project Finance |
|------|-----------|-------|---------|-----------|-----------|---------------|-----------------|
| **Super Admin** | ✅ CRUD | ✅ CRUD | ✅ View All | ✅ View All | ✅ View All | ✅ View All | ✅ View All |
| **Founder** | ✅ CRUD | ✅ View All | ✅ View All | ✅ View All | ✅ View All | ✅ View All | ✅ View All |
| **Direktur** | ❌ | ✅ View | ✅ View | ✅ View | ✅ View | ✅ View | ✅ View |
| **Komisaris** | ❌ | ✅ View | ✅ View | ✅ View | ✅ View | ✅ View | ✅ View |
| **Admin Pemberkasan** | ❌ | ❌ | ✅ View | ✅ CRUD | ❌ | ✅ CRUD | ✅ View |
| **Admin Keuangan** | ❌ | ❌ | ✅ View | ❌ | ✅ CRUD | ✅ View | ✅ CRUD |

---

## 📝 File Upload Specifications

### Documents (Dokumen Pemberkasan)
- **Format**: PDF, JPG, PNG
- **Max Size**: 5MB per file
- **Storage**: `storage/app/private/documents/`

### Financial Reports (Laporan Keuangan)
- **Format**: PDF, XLS, XLSX
- **Max Size**: 10MB per file
- **Storage**: `storage/app/private/financial-reports/`

### Daily Reports (Laporan Harian)
- **Format**: XLS, XLSX
- **Max Size**: 10MB per file
- **Storage**: `storage/app/private/daily-reports/`

### Project Finances (Keuangan Proyek)
- **Format**: PDF, XLS, XLSX
- **Max Size**: 10MB per file
- **Storage**: `storage/app/private/project-finances/`

---

## 🚀 Production Deployment

### **1. Environment**

Update `.env` untuk production:

```env
APP_ENV=production
APP_DEBUG=false
APP_URL=https://yourdomain.com

# Database
DB_CONNECTION=mysql
DB_HOST=your_production_host
DB_DATABASE=production_db
DB_USERNAME=production_user
DB_PASSWORD=strong_password

# Cache
CACHE_DRIVER=redis
SESSION_DRIVER=redis
QUEUE_CONNECTION=redis

# Mail (if needed)
MAIL_MAILER=smtp
MAIL_HOST=smtp.mailtrap.io
MAIL_PORT=2525
MAIL_USERNAME=null
MAIL_PASSWORD=null
```

### **2. Optimization**

```bash
# Cache config
php artisan config:cache

# Cache routes
php artisan route:cache

# Cache views
php artisan view:cache

# Optimize composer autoload
composer install --optimize-autoloader --no-dev
```

### **3. File Permissions**

```bash
# Set proper permissions
chown -R www-data:www-data storage
chown -R www-data:www-data bootstrap/cache
chmod -R 775 storage
chmod -R 775 bootstrap/cache
```

### **4. Cron Jobs**

Add to crontab:

```bash
* * * * * cd /path-to-your-project && php artisan schedule:run >> /dev/null 2>&1
```

### **5. Queue Worker (Optional)**

```bash
php artisan queue:work --daemon
```

---

## 📧 Support & Contact

Untuk bantuan teknis atau pertanyaan:
- Email: support@yourcompany.com
- Documentation: /docs
- Issue Tracker: GitHub Issues

---

## 📄 License

Proprietary - All rights reserved © 2024 Your Company Name

---

## 🎉 Quick Start Checklist

- [ ] Clone repository
- [ ] Install dependencies (`composer install` & `npm install`)
- [ ] Copy `.env.example` to `.env`
- [ ] Configure database di `.env`
- [ ] Run `php artisan key:generate`
- [ ] Run `php artisan migrate`
- [ ] Run `php artisan db:seed --class=CompanySeeder`
- [ ] Run `php artisan storage:link`
- [ ] Create admin user: `php artisan make:filament-user`
- [ ] Update admin role ke 'founder' via tinker
- [ ] Create test users via tinker
- [ ] Run `npm run build`
- [ ] Run `php artisan serve`
- [ ] Login ke `http://localhost:8000/admin`
- [ ] ✅ Ready to use!

---

**Happy Coding! 🚀**