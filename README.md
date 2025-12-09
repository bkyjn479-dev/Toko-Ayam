# Stock Wings - Sistem Manajemen Penjualan Ayam

Sistem e-commerce lengkap untuk penjualan ayam matang (siap santap) dengan fitur manajemen produk, keranjang belanja, checkout, dan admin panel.

## Fitur Utama

### 1. **Manajemen Produk (Admin)**
- ✅ Tambah, edit, hapus produk
- ✅ Upload foto produk
- ✅ Kelola stok produk
- ✅ Set harga per kg/pack
- ✅ Deskripsi produk lengkap
- ✅ Monitoring stok rendah

### 2. **Toko Online (Customer)**
- ✅ Tampilkan daftar produk dengan filter
- ✅ Lihat detail produk
- ✅ Foto produk berkualitas
- ✅ Harga dan ketersediaan stok real-time
- ✅ Responsive design untuk mobile

### 3. **Keranjang Belanja**
- ✅ Tambah produk ke keranjang
- ✅ Update jumlah item
- ✅ Hapus item dari keranjang
- ✅ Kosongi keranjang
- ✅ Ringkasan total belanja otomatis

### 4. **Checkout**
- ✅ Form data pembeli (nama, alamat, kota, telepon)
- ✅ Opsi pengiriman (Ambil Sendiri/Gratis, Kurir/Rp50.000, Delivery/Rp75.000)
- ✅ Perhitungan biaya pengiriman otomatis
- ✅ Pilihan metode pembayaran (Transfer Bank, QRIS)
- ✅ Otomatis update stok setelah checkout
- ✅ Generate nomor pesanan unik

### 5. **Pembayaran**
- ✅ Transfer Bank (dengan detail rekening BCA)
- ✅ QRIS (barcode pembayaran)
- ✅ Upload bukti transfer untuk manual confirmation
- ✅ Tracking status pembayaran

### 6. **Admin Panel**
- ✅ Dashboard dengan statistik penjualan
- ✅ Kelola produk (CRUD)
- ✅ Lihat semua pesanan
- ✅ Update status pesanan (Pending → Confirmed → Shipped → Delivered)
- ✅ Update status pembayaran
- ✅ Kelola pengiriman dengan nomor resi
- ✅ Monitor stok rendah

### 7. **Autentikasi**
- ✅ Registrasi customer dengan data lengkap
- ✅ Login untuk customer dan admin
- ✅ Enkripsi password
- ✅ Session management
- ✅ Role-based access (admin vs customer)

### 8. **Fitur Pelanggan**
- ✅ Riwayat pesanan
- ✅ Detail pesanan lengkap
- ✅ Tracking status pesanan
- ✅ Download invoice (optional)
- ✅ Akses riwayat pembayaran

## Teknologi yang Digunakan

- **Backend**: Laravel 12 (PHP 8.2+)
- **Database**: SQLite/MySQL
- **Frontend**: Blade Template, Bootstrap 5, FontAwesome
- **Authentication**: Laravel Built-in Auth
- **File Storage**: Laravel Storage dengan public disk

## Instalasi

### Prerequisites
- PHP 8.2 atau lebih tinggi
- Composer
- Node.js & npm
- Database (SQLite/MySQL)

### Langkah Instalasi

```bash
# 1. Clone atau download project
cd stock_wing

# 2. Install dependencies
composer install
npm install

# 3. Setup environment
cp .env.example .env

# 4. Generate key
php artisan key:generate

# 5. Setup database
php artisan migrate

# 6. Buat symlink untuk storage public
php artisan storage:link

# 7. Seed database (optional - untuk data dummy)
php artisan db:seed

# 8. Jalankan aplikasi
php artisan serve

# 9. Di terminal lain, jalankan Vite
npm run dev
```

Aplikasi akan berjalan di `http://localhost:8000`

## Struktur Database

### Users Table
```
- id
- name
- email
- password
- role (admin/customer)
- phone
- address
- city
- email_verified_at
- timestamps
```

### Products Table
```
- id
- name
- description
- price (decimal)
- stock (integer)
- unit (kg/pack)
- image (path)
- timestamps
```

### Cart Items Table
```
- id
- user_id (FK)
- product_id (FK)
- quantity
- price (harga saat ditambahkan)
- timestamps
```

### Orders Table
```
- id
- user_id (FK)
- order_number (unique)
- subtotal
- shipping_cost
- total
- status (pending/confirmed/shipped/delivered/cancelled)
- payment_method (transfer/qris)
- payment_status (pending/paid/failed)
- notes
- timestamps
```

### Order Items Table
```
- id
- order_id (FK)
- product_id (FK)
- quantity
- price
- timestamps
```

### Shipments Table
```
- id
- order_id (FK, unique)
- recipient_name
- recipient_phone
- recipient_address
- recipient_city
- shipping_method (pickup/courier/delivery)
- tracking_number
- shipped_at
- delivered_at
- timestamps
```

### Payments Table
```
- id
- order_id (FK, unique)
- method (transfer/qris)
- status (pending/paid/failed)
- amount
- bank_account (JSON: bank, account_number, account_name)
- qris_code (URL/base64)
- proof_image (path untuk transfer)
- confirmed_at
- timestamps
```

## Penggunaan

### Untuk Customer

#### 1. Daftar Akun
- Klik "Daftar" di halaman utama
- Isi data lengkap: nama, email, password, telepon, alamat, kota
- Klik "Daftar"

#### 2. Berbelanja
- Lihat produk di halaman "Toko"
- Klik produk untuk melihat detail
- Masukkan jumlah dan klik "Tambah ke Keranjang"
- Lanjutkan belanja atau ke keranjang

#### 3. Checkout
- Klik "Keranjang" atau "Lanjut ke Checkout"
- Verifikasi data pengiriman
- Pilih opsi pengiriman
- Pilih metode pembayaran
- Klik "Lanjut ke Pembayaran"

#### 4. Pembayaran
- **Jika Transfer Bank**: Lihat detail rekening, transfer jumlah yang ditentukan, upload bukti transfer
- **Jika QRIS**: Scan QR code menggunakan e-wallet Anda

#### 5. Riwayat Pesanan
- Klik "Pesanan Saya" di menu
- Lihat status pesanan
- Klik pesanan untuk detail lengkap

### Untuk Admin

#### 1. Login Admin
- Akses `/login` dan login dengan akun admin
- Akan diarahkan ke `/admin/dashboard`

#### 2. Kelola Produk
- Menu "Produk" di sidebar admin
- "Tambah Produk" untuk produk baru
- Edit/Hapus untuk ubah produk yang ada
- Upload foto saat membuat/edit produk

#### 3. Lihat Pesanan
- Menu "Pesanan" di sidebar
- Klik pesanan untuk lihat detail
- Update status pesanan
- Update status pembayaran
- Verifikasi bukti transfer jika transfer bank

#### 4. Kelola Pengiriman
- Di halaman detail pesanan
- Input nomor resi
- Set tanggal pengiriman
- Update status shipping

#### 5. Dashboard
- Lihat statistik penjualan
- Monitor stok rendah
- Lihat pesanan terbaru
- Data revenue dan customer

## URL Routes

### Public Routes
- `/` - Halaman utama
- `/shop` - Daftar produk
- `/shop/{product}` - Detail produk
- `/login` - Login
- `/register` - Daftar

### Customer Routes (Authenticated)
- `/cart` - Keranjang belanja
- `/checkout` - Checkout
- `/checkout/payment/{order}` - Pembayaran
- `/orders` - Riwayat pesanan
- `/orders/{order}` - Detail pesanan

### Admin Routes (Authenticated + Admin Role)
- `/admin/dashboard` - Dashboard admin
- `/admin/products` - Kelola produk
- `/admin/products/create` - Tambah produk
- `/admin/products/{product}/edit` - Edit produk
- `/admin/orders` - Kelola pesanan
- `/admin/orders/{order}` - Detail pesanan

## Konfigurasi

### .env Variables
```
APP_NAME="Stock Wings"
APP_URL=http://localhost:8000
DB_CONNECTION=sqlite
# atau
DB_CONNECTION=mysql
DB_HOST=localhost
DB_PORT=3306
DB_DATABASE=stock_wing
DB_USERNAME=root
DB_PASSWORD=
```

### Storage Configuration
- Foto produk disimpan di `storage/app/public/products/`
- Bukti transfer disimpan di `storage/app/public/proofs/`
- Pastikan jalankan `php artisan storage:link` untuk membuat symlink

## Fitur Keamanan

✅ CSRF Protection (Laravel built-in)
✅ Password Hashing (bcrypt)
✅ SQL Injection Prevention (Eloquent ORM)
✅ Authorization (role-based access)
✅ Validation (server-side form validation)
✅ HTTPS Ready (can be deployed with HTTPS)

## Troubleshooting

### 1. Storage Link Error
```bash
php artisan storage:link
# atau jika sudah ada
rm public/storage
php artisan storage:link
```

### 2. Database Migration Error
```bash
php artisan migrate:fresh --seed
```

### 3. Permission Issues
```bash
chmod -R 755 storage
chmod -R 755 bootstrap/cache
```

### 4. Tidak bisa upload foto
- Pastikan folder `storage/app/public` writable
- Jalankan `php artisan storage:link`
- Check file size limit di php.ini

## Deployment

### Hosting Requirements
- PHP 8.2+
- OpenSSL PHP Extension
- PDO PHP Extension
- Mbstring PHP Extension
- Tokenizer PHP Extension
- XML PHP Extension
- Ctype PHP Extension
- JSON PHP Extension
- BCMath PHP Extension

### Deploy Steps
```bash
# 1. Push ke server
git clone <repo> /var/www/stock_wing
cd /var/www/stock_wing

# 2. Install dependencies
composer install --optimize-autoloader --no-dev
npm install && npm run build

# 3. Setup environment
cp .env.example .env
php artisan key:generate

# 4. Database
php artisan migrate --force
php artisan storage:link

# 5. Permissions
chown -R www-data:www-data /var/www/stock_wing
chmod -R 755 storage bootstrap/cache

# 6. Setup web server (nginx/apache)
# Point public folder ke domain
```

## API Documentation (Optional)

Sistem ini bisa diperluas dengan REST API untuk mobile app atau integrasi pihak ketiga.

## Support & Kontribusi

Untuk pertanyaan atau kontribusi, silakan hubungi tim development.

## License

MIT License - 2025

---

**Stock Wings © 2025** - Sistem Manajemen Penjualan Ayam Terpercaya
