# ⚡ Quick Start Guide - Stock Wings

Panduan cepat untuk memulai Stock Wings dalam 5 menit!

## 🚀 Start Aplikasi (Paling Penting!)

Setelah instalasi selesai, buka 2 terminal terpisah:

### Terminal 1: Laravel Server

```bash
cd d:\ayamsuwir\stock_wing
php artisan serve
```

Output:
```
INFO  Server running on [http://127.0.0.1:8000]
```

✅ Server Laravel berjalan di `http://localhost:8000`

### Terminal 2: Vite Build Tool

```bash
cd d:\ayamsuwir\stock_wing
npm run dev
```

Output:
```
VITE v5.x.x  ready in XXX ms

➜  Local:   http://localhost:5173/
```

✅ Frontend assets dicompile otomatis

---

## 📱 Akses Aplikasi

Buka browser dan kunjungi:

| Halaman | URL | Keterangan |
|---------|-----|-----------|
| **Home** | http://localhost:8000 | Halaman utama publik |
| **Toko** | http://localhost:8000/shop | Daftar produk untuk customer |
| **Login** | http://localhost:8000/login | Form login |
| **Daftar** | http://localhost:8000/register | Buat akun baru |
| **Admin Dashboard** | http://localhost:8000/admin/dashboard | Dashboard admin |

---

## 🔑 Test Accounts

### Admin Account
```
Email    : admin@stockwing.com
Password : password123
```

**Cara akses:**
1. Buka http://localhost:8000/login
2. Masukkan email dan password admin
3. Klik "Masuk"
4. Otomatis redirect ke `/admin/dashboard`

### Customer Account
```
Email    : customer@example.com
Password : password123
```

**Cara akses:**
1. Buka http://localhost:8000/login
2. Masukkan email dan password customer
3. Klik "Masuk"
4. Redirect ke homepage
5. Bisa mulai belanja di `/shop`

---

## 📋 Test Flow

### Sebagai Customer

1. **Login**
   - Buka http://localhost:8000/login
   - Email: `customer@example.com`
   - Password: `password123`
   - Klik "Masuk"

2. **Lihat Produk**
   - Klik "Toko" di navbar
   - Lihat daftar 6 produk sample
   - Klik produk untuk detail

3. **Tambah ke Keranjang**
   - Di halaman detail, masukkan qty
   - Klik "Tambah ke Keranjang"
   - Lihat badge jumlah item di navbar

4. **Checkout**
   - Klik "Keranjang" di navbar
   - Klik "Lanjut ke Checkout"
   - Isi form (atau sudah terisi otomatis)
   - Pilih pengiriman (Ambil Sendiri/Kurir/Delivery)
   - Pilih pembayaran (Transfer/QRIS)
   - Klik "Lanjut ke Pembayaran"

5. **Pembayaran**
   - Lihat detail pembayaran
   - Jika Transfer: upload bukti transfer (dummy)
   - Klik "Verifikasi Pembayaran"
   - Pesanan dibuat ✅

6. **Riwayat Pesanan**
   - Klik "Pesanan Saya" di navbar
   - Lihat pesanan yang dibuat
   - Klik untuk melihat detail

### Sebagai Admin

1. **Login**
   - Buka http://localhost:8000/login
   - Email: `admin@stockwing.com`
   - Password: `password123`
   - Klik "Masuk"

2. **Dashboard**
   - Lihat statistik penjualan
   - Lihat pesanan terbaru
   - Monitor stok rendah

3. **Kelola Produk**
   - Sidebar → "Produk"
   - Lihat daftar produk sample
   - Klik "Edit" untuk ubah
   - Klik "Hapus" untuk delete
   - Klik "Tambah Produk" untuk produk baru

4. **Kelola Pesanan**
   - Sidebar → "Pesanan"
   - Klik pesanan yang dibuat customer
   - Update status pesanan
   - Verifikasi pembayaran
   - Input nomor resi pengiriman
   - Update status pengiriman

---

## 🛠️ Command Penting

```bash
# Jalankan server
php artisan serve

# Jalankan Vite
npm run dev

# Clear cache jika ada masalah
php artisan cache:clear
php artisan config:clear

# Jika perlu reset database
php artisan migrate:fresh --seed

# Tinker REPL
php artisan tinker
```

---

## 📁 File Penting

| File | Fungsi |
|------|--------|
| `.env` | Konfigurasi environment |
| `routes/web.php` | Definisi semua routes |
| `app/Models/` | Model database |
| `app/Http/Controllers/` | Business logic |
| `resources/views/` | Template HTML |
| `database/migrations/` | Schema database |
| `database/seeders/` | Dummy data |

---

## 🎨 Customization

### Ubah Logo/Brand Name

Edit file layout:
- `resources/views/layout.blade.php` (customer)
- `resources/views/admin/layout.blade.php` (admin)

Ubah "Stock Wings" menjadi nama brand Anda

### Ubah Warna

Edit di layout template:
```html
<!-- Warna: #ff6b35 (orange), #004e89 (blue) -->
<nav class="navbar" style="background: linear-gradient(90deg, #ff6b35 0%, #004e89 100%);">
```

### Ubah Data Bank

Edit `app/Http/Controllers/CheckoutController.php`:
```php
'bank_account' => [
    'bank' => 'BCA', // Ubah bank
    'account_number' => '123456789', // Ubah nomor
    'account_name' => 'Toko Ayam', // Ubah nama
]
```

### Ubah Biaya Pengiriman

Edit `app/Http/Controllers/CheckoutController.php`:
```php
$shippingCosts = [
    'pickup' => 0,        // Gratis ambil sendiri
    'courier' => 50000,   // Ubah Rp50.000
    'delivery' => 75000,  // Ubah Rp75.000
];
```

---

## ⚠️ Common Issues

### ❌ "Storage link not found"
```bash
php artisan storage:link
```

### ❌ "Class not found"
```bash
composer dump-autoload
php artisan cache:clear
```

### ❌ "Port 8000 in use"
```bash
php artisan serve --port=8001
```

### ❌ "Database error"
```bash
php artisan migrate
php artisan db:seed
```

---

## 📞 Need Help?

1. Baca file `README.md` untuk dokumentasi lengkap
2. Baca file `INSTALLATION.md` untuk panduan instalasi detail
3. Baca `storage/logs/laravel.log` untuk error details
4. Google error message + "Laravel"

---

## ✅ Checklist Sebelum Go Live

- [ ] Ubah password admin dan customer (jangan gunakan default)
- [ ] Edit .env dengan konfigurasi production
- [ ] Setup email notification
- [ ] Setup payment gateway real (bukan dummy)
- [ ] Backup database
- [ ] Test semua fitur
- [ ] Setup HTTPS/SSL
- [ ] Setup domain custom
- [ ] Configure backup & monitoring

---

**Stock Wings © 2025** - Siap digunakan! 🚀

