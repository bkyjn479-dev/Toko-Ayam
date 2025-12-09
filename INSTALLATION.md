# 📝 Panduan Lengkap Stock Wing - Sistem Penjualan Ayam

Dokumen ini berisi panduan lengkap instalasi dan penggunaan sistem Stock Wing.

## 📋 Daftar Isi
1. [Persyaratan Sistem](#persyaratan-sistem)
2. [Instalasi](#instalasi)
3. [Konfigurasi](#konfigurasi)
4. [Login Test](#login-test)
5. [Panduan Pengguna](#panduan-pengguna)
6. [Troubleshooting](#troubleshooting)

---

## 🖥️ Persyaratan Sistem

### Server Requirements
- **PHP**: 8.2 atau lebih tinggi
- **Composer**: Versi terbaru
- **Node.js**: v18+
- **npm**: v9+
- **Database**: SQLite (built-in) atau MySQL/PostgreSQL

### PHP Extensions
- OpenSSL
- PDO
- Mbstring
- Tokenizer
- XML
- Ctype
- JSON
- BCMath
- Fileinfo

### Browser Support
- Chrome 90+
- Firefox 88+
- Safari 14+
- Edge 90+

---

## 🚀 Instalasi

### Step 1: Download dan Setup Project

```bash
# Navigasi ke folder project
cd d:\ayamsuwir\stock_wing

# Atau jika belum di dalam project
cd path/ke/stock_wing
```

### Step 2: Install Dependencies

```bash
# Install PHP dependencies
composer install

# Install Node.js dependencies
npm install
```

### Step 3: Setup Environment

```bash
# Copy .env.example ke .env
cp .env.example .env

# Atau di Windows PowerShell
Copy-Item .env.example .env
```

### Step 4: Generate Application Key

```bash
php artisan key:generate
```

Output:
```
INFO  Application key set successfully.
```

### Step 5: Database Migration

```bash
php artisan migrate
```

Output akan menampilkan:
```
INFO  Running migrations.

2025_12_03_000001_add_role_and_address_to_users  37.51ms DONE
2025_12_03_000002_create_products_table ......... 7.74ms DONE
2025_12_03_000003_create_cart_items_table ...... 18.12ms DONE
2025_12_03_000004_create_orders_table .......... 14.69ms DONE
2025_12_03_000005_create_order_items_table ...... 7.54ms DONE
2025_12_03_000006_create_shipments_table ....... 27.15ms DONE
2025_12_03_000007_create_payments_table ........ 16.33ms DONE
```

### Step 6: Create Storage Link

```bash
php artisan storage:link
```

Output:
```
INFO  The [D:\ayamsuwir\stock_wing\public\storage] link has been connected to [D:\ayamsuwir\stock_wing\storage\app/public].
```

### Step 7: Seed Database (Optional - Untuk Test Data)

```bash
php artisan db:seed
```

Output:
```
INFO  Seeding database.

Database\Seeders\AdminUserSeeder ................ DONE
Database\Seeders\ProductSeeder ................. DONE
```

---

## ⚙️ Konfigurasi

### File .env Configuration

Edit file `.env` sesuai kebutuhan:

```env
# App Configuration
APP_NAME="Stock Wings"
APP_ENV=local
APP_DEBUG=true
APP_URL=http://localhost:8000

# Database Configuration (default SQLite)
DB_CONNECTION=sqlite
DB_DATABASE=database/database.sqlite

# Atau untuk MySQL:
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=stock_wing
DB_USERNAME=root
DB_PASSWORD=

# Mail Configuration (optional)
MAIL_MAILER=log
MAIL_FROM_ADDRESS="info@stockwing.com"
MAIL_FROM_NAME="Stock Wings"

# File Storage
FILESYSTEM_DISK=public
```

### Direktori yang Harus Writable

Pastikan folder berikut memiliki permission 755:

```
storage/
bootstrap/cache/
public/storage/
```

Command untuk mengatur permission (Linux/Mac):

```bash
chmod -R 755 storage
chmod -R 755 bootstrap/cache
chown -R www-data:www-data storage bootstrap
```

---

## 🔑 Login Test

Setelah seeding, Anda dapat login dengan akun berikut:

### Akun Admin

- **Email**: `admin@stockwing.com`
- **Password**: `password123`
- **URL**: `http://localhost:8000/admin/dashboard`

### Akun Customer (Test)

- **Email**: `customer@example.com`
- **Password**: `password123`
- **URL**: `http://localhost:8000/shop`

---

## 👥 Panduan Pengguna

### A. Untuk Customer (Pembeli)

#### 1. Registrasi Akun Baru

**URL**: `http://localhost:8000/register`

Form yang diisi:
- Nama Lengkap
- Email
- Password (minimal 8 karakter)
- Telepon
- Alamat
- Kota

Klik tombol "Daftar" untuk membuat akun.

#### 2. Login

**URL**: `http://localhost:8000/login`

- Masukkan email dan password
- Centang "Ingat saya" jika ingin tetap login
- Klik tombol "Masuk"

#### 3. Jelajahi Toko

**URL**: `http://localhost:8000/shop`

- Lihat daftar produk dalam bentuk grid
- Setiap produk menampilkan: foto, nama, harga, stok
- Klik "Lihat Detail" untuk melihat informasi lengkap

#### 4. Lihat Detail Produk

**URL**: `http://localhost:8000/shop/{id}`

Informasi yang ditampilkan:
- Foto produk
- Nama dan deskripsi lengkap
- Harga per unit
- Stok tersedia
- Pilihan jumlah dengan spinner
- Tombol "Tambah ke Keranjang"

#### 5. Kelola Keranjang Belanja

**URL**: `http://localhost:8000/cart`

Operasi:
- Update jumlah item dengan spinner
- Hapus item individual dengan tombol "Hapus"
- Lihat subtotal otomatis
- Klik "Lanjut ke Checkout" untuk melanjutkan

#### 6. Checkout

**URL**: `http://localhost:8000/checkout`

Langkah-langkah:
1. **Verifikasi Data Pengiriman**
   - Nama penerima
   - Telepon penerima
   - Alamat pengiriman
   - Kota tujuan

2. **Pilih Opsi Pengiriman**
   - Ambil Sendiri (Rp0)
   - Kurir (Rp50.000)
   - Delivery (Rp75.000)

3. **Pilih Metode Pembayaran**
   - Transfer Bank
   - QRIS

4. Klik "Lanjut ke Pembayaran"

#### 7. Proses Pembayaran

**URL**: `http://localhost:8000/checkout/payment/{order}`

**Jika Transfer Bank:**
- Lihat detail rekening (Bank: BCA)
- Salin nomor rekening
- Lakukan transfer sesuai nominal yang ditampilkan
- Upload bukti transfer (foto/screenshot)
- Klik "Verifikasi Pembayaran"

**Jika QRIS:**
- Tampilkan QR code di layar
- Scan dengan aplikasi e-wallet
- Transfer sesuai nominal
- Status akan berubah otomatis ketika pembayaran berhasil

#### 8. Riwayat Pesanan

**URL**: `http://localhost:8000/orders`

- Lihat semua pesanan yang pernah dibuat
- Status pesanan: Pending, Confirmed, Shipped, Delivered
- Klik pesanan untuk melihat detail lengkap

#### 9. Detail Pesanan

**URL**: `http://localhost:8000/orders/{id}`

Informasi yang ditampilkan:
- Nomor pesanan dan tanggal
- Daftar item yang dipesan
- Total harga dengan breakdown biaya pengiriman
- Status pesanan dengan timeline
- Informasi pengiriman (alamat, nomor resi)
- Informasi pembayaran (metode, status, bukti transfer)

---

### B. Untuk Admin (Pengelola)

#### 1. Login Admin

**URL**: `http://localhost:8000/login`

- Gunakan email: `admin@stockwing.com`
- Password: `password123`
- Akan diarahkan ke dashboard admin

#### 2. Dashboard Admin

**URL**: `http://localhost:8000/admin/dashboard`

Menampilkan:
- **Statistik Penjualan**
  - Total Pesanan
  - Total Revenue (dari pembayaran yang dikonfirmasi)
  - Jumlah Customer
  - Jumlah Produk

- **Pesanan Terbaru** (tabel 10 pesanan terakhir)
- **Produk Stok Rendah** (< 10 unit)

#### 3. Manajemen Produk

##### A. Lihat Daftar Produk

**URL**: `http://localhost:8000/admin/products`

Menampilkan:
- Tabel produk dengan pagination (10 item per halaman)
- Kolom: Foto, Nama, Deskripsi, Harga, Stok, Unit, Tanggal, Aksi
- Tombol "Edit" dan "Hapus" untuk setiap produk
- Tombol "Tambah Produk" di atas

##### B. Tambah Produk Baru

**URL**: `http://localhost:8000/admin/products/create`

Form:
```
Nama Produk *        : [text input]
Deskripsi *          : [textarea]
Harga (Rp) *         : [number input]
Stok *               : [number input]
Unit *               : [select: kg, pack, pcs]
Upload Foto *        : [file input]
```

Validasi:
- Semua field wajib diisi
- Harga dan stok harus angka positif
- Foto harus format JPG/PNG/WEBP (max 2MB)

Setelah klik "Simpan":
- Foto akan disimpan ke `storage/app/public/products/`
- Product ditambahkan ke database
- Redirect ke halaman daftar produk

##### C. Edit Produk

**URL**: `http://localhost:8000/admin/products/{id}/edit`

- Form yang sama seperti tambah produk
- Field sudah terisi dengan data saat ini
- Preview foto saat ini ditampilkan
- Foto dapat diganti atau dibiarkan (tidak wajib)
- Klik "Update" untuk menyimpan perubahan

##### D. Hapus Produk

**URL**: `http://localhost:8000/admin/products/{id}` (DELETE)

- Klik tombol "Hapus" di tabel produk
- Akan muncul konfirmasi
- Klik "Hapus" untuk konfirmasi
- Produk akan dihapus dari database

#### 4. Manajemen Pesanan

##### A. Lihat Daftar Pesanan

**URL**: `http://localhost:8000/admin/orders`

Menampilkan:
- Tabel pesanan dengan pagination (15 item per halaman)
- Kolom: No Pesanan, Customer, Total, Status Pesanan, Status Pembayaran, Aksi
- Badge warna berbeda untuk status:
  - Pending (abu-abu)
  - Confirmed (biru)
  - Shipped (oranye)
  - Delivered (hijau)
  - Cancelled (merah)

##### B. Detail Pesanan

**URL**: `http://localhost:8000/admin/orders/{id}`

Menampilkan empat bagian:

**1. Informasi Customer**
```
Nama          : John Doe
Email         : john@example.com
Telepon       : 08123456789
Alamat        : Jalan Pelanggan No. 5
Kota          : Jakarta
```

**2. Item Pesanan** (Tabel)
```
Produk          | Qty | Harga Unit | Subtotal
Ayam Kampung    | 2kg | 65.000     | 130.000
```

**3. Ringkasan Pesanan**
```
Subtotal Produk      : Rp XXX.XXX
Biaya Pengiriman     : Rp XX.XXX
Total Pesanan        : Rp XXX.XXX
```

**4. Form Manajemen**

**A. Update Status Pesanan**
```
Status Saat Ini: Pending
Pilih Status Baru: [dropdown]
  - Confirmed
  - Shipped
  - Delivered
  - Cancelled

[Tombol Update Status]
```

**B. Informasi Pengiriman** (Form)
```
Metode Pengiriman: Kurir
Penerima         : [nama dari checkout]
Telepon Penerima : [telepon dari checkout]
Alamat Penerima  : [alamat dari checkout]
Kota             : [kota dari checkout]

Nomor Resi       : [text input - opsional]
Tanggal Pengiriman: [date picker - opsional]

[Tombol Update Pengiriman]
```

**C. Informasi Pembayaran**
```
Metode: Transfer Bank

Status Pembayaran: [dropdown]
  - Pending
  - Paid
  - Failed

Jumlah: Rp XXX.XXX

[Jika Transfer Bank - bukti upload]
[Foto bukti: ...........]

[Tombol Update Status Pembayaran]
```

---

## 📊 Alur Kerja Lengkap

### Scenario 1: Customer Melakukan Pembelian

1. Customer registrasi → Login → Jelajahi toko
2. Pilih produk → Lihat detail → Tambah ke keranjang
3. Bisa lanjut belanja atau checkout
4. Checkout → Isi data pengiriman → Pilih pengiriman
5. Pilih metode pembayaran → Lanjut ke pembayaran
6. Proses pembayaran (transfer/QRIS)
7. Pesanan dibuat dengan status "Pending" + "Pending" payment
8. Admin menerima pesanan → Verifikasi pembayaran
9. Admin update status pesanan ke "Confirmed"
10. Admin input nomor resi → Update ke "Shipped"
11. Customer tracking di "Riwayat Pesanan"
12. Admin ubah ke "Delivered" setelah barang sampai

### Scenario 2: Admin Mengelola Produk

1. Admin login → Dashboard
2. Sidebar → Produk → Daftar Produk
3. Klik "Tambah Produk" → Isi form → Upload foto → Simpan
4. Produk muncul di toko untuk customer
5. Edit produk: Klik edit → Update data → Simpan
6. Hapus produk: Klik hapus → Konfirmasi

---

## 🔧 Troubleshooting

### 1. Error "Storage link tidak ditemukan"

**Masalah**: Foto produk tidak muncul atau error saat upload

**Solusi**:
```bash
# Hapus symlink lama
rmdir public/storage

# Buat symlink baru
php artisan storage:link
```

### 2. Error "Class 'App\Models\Product' not found"

**Masalah**: Model tidak ditemukan saat menjalankan aplikasi

**Solusi**:
```bash
# Clear semua cache
php artisan cache:clear
php artisan config:clear
php artisan view:clear

# Regenerate optimized class loader
composer dump-autoload

# Jalankan aplikasi lagi
php artisan serve
```

### 3. Error Database Connection

**Masalah**: "Connection refused" atau database error

**Solusi**:
```bash
# Cek .env file sudah benar
cat .env | grep DB_

# Untuk SQLite
php artisan migrate

# Untuk MySQL - pastikan server MySQL berjalan
# Windows: Buka Services → Cari MySQL → Start
# Linux: sudo systemctl start mysql
```

### 4. Permission Denied pada folder storage

**Masalah**: Error saat upload file atau generate cache

**Solusi (Windows PowerShell)**:
```powershell
# Beri full control ke storage
icacls "D:\ayamsuwir\stock_wing\storage" /grant:r "%USERNAME%":F /t

# Atau di Command Prompt biasa:
takeown /F "D:\ayamsuwir\stock_wing\storage" /R /D Y
```

**Solusi (Linux/Mac)**:
```bash
chmod -R 755 storage
chmod -R 755 bootstrap/cache
chown -R www-data:www-data storage bootstrap
```

### 5. Node Modules tidak install dengan benar

**Masalah**: Error saat npm run dev atau build

**Solusi**:
```bash
# Hapus node_modules dan package-lock.json
rm -r node_modules
rm package-lock.json

# Install ulang
npm install

# Run dev
npm run dev
```

### 6. Port 8000 sudah digunakan

**Masalah**: "Address already in use" saat `php artisan serve`

**Solusi**:
```bash
# Gunakan port berbeda
php artisan serve --port=8001

# Atau cari process yang menggunakan port 8000
# Windows PowerShell:
Get-NetTCPConnection -LocalPort 8000

# Linux:
sudo lsof -i :8000
sudo kill -9 <PID>
```

### 7. Lupa password admin

**Masalah**: Tidak bisa login dengan password admin

**Solusi**:
```bash
# Reset password melalui tinker
php artisan tinker

# Ketik:
$user = User::find(1);
$user->password = Hash::make('password123');
$user->save();

# Keluar: exit
```

### 8. Foto tidak muncul setelah upload

**Masalah**: Upload foto berhasil tapi tidak muncul

**Solusi**:
```bash
# Pastikan storage link aktif
php artisan storage:link

# Check permission file
ls -la public/storage/products/

# Verifikasi di .env
cat .env | grep FILESYSTEM_DISK
# Pastikan bernilai "public"
```

### 9. Email verification tidak bekerja

**Masalah**: Proses verifikasi email error

**Solusi**:
Fitur email verification bersifat opsional. Untuk menonaktifkan:

Edit `app/Models/User.php`:
```php
// Comment baris ini:
// implements MustVerifyEmail

// Atau di controller login, comment:
// return redirect('/verify-email');
```

### 10. QRIS QR Code tidak muncul

**Masalah**: QR code untuk QRIS tidak menampilkan

**Solusi**:
Sistem menggunakan QR code API eksternal. Pastikan:
- Koneksi internet aktif
- API server tidak down

Untuk QR code manual:
```php
// Di CheckoutController.php
$payment->qris_code = 'https://api.qrserver.com/v1/create-qr-code/?size=300x300&data=00020126360014com.midtrans.www2152033002123456789520400005303360406170000070679823240008STOCK001234567890050300000000IDRIDR165000063047E1F';
```

---

## 📞 Support & Contact

Jika mengalami masalah atau ada pertanyaan:

1. Baca dokumentasi README.md
2. Cek bagian Troubleshooting di atas
3. Check Laravel logs: `storage/logs/laravel.log`
4. Hubungi tim development

---

## 📝 Version History

- **v1.0.0** (2025-03-07)
  - Release pertama
  - Fitur dasar: Shop, Cart, Checkout, Admin, Auth

---

**Stock Wing © 2025** - Sistem Penjualan Ayam Terpercaya
