# 🎉 Stock Wings - Sistem Penjualan Ayam Lengkap

## 🎯 Selamat Datang!

Anda telah mendapatkan **sistem e-commerce lengkap untuk penjualan ayam** yang siap digunakan. Sistem ini dibangun dengan teknologi Laravel 12 modern dan telah diuji untuk semua fitur utama.

---

## 📚 Dokumentasi Panduan Cepat

Pilih panduan sesuai kebutuhan Anda:

### 🚀 Ingin Mulai Sekarang? (5 Menit)
👉 **Baca**: `QUICKSTART.md`

Berisi:
- Cara start server
- Test accounts
- Flowchart testing customer & admin
- Common issues

### 📖 Ingin Setup Lengkap? (30 Menit)
👉 **Baca**: `INSTALLATION.md`

Berisi:
- Prerequisites
- Step-by-step installation
- Konfigurasi environment
- Troubleshooting detail
- Deployment guide

### 📊 Ingin Mengerti Sistemnya? 
👉 **Baca**: `PROJECT_SUMMARY.md`

Berisi:
- Ringkasan lengkap project
- Database schema
- Fitur-fitur utama
- Technology stack
- File structure

### ✅ Ingin Verifikasi Kompleteness?
👉 **Baca**: `IMPLEMENTATION_CHECKLIST.md`

Berisi:
- Checklist semua komponen
- Testing checklist
- Completion status
- Verification points

### 📝 Dokumentasi Lengkap?
👉 **Baca**: `README.md`

Berisi dokumentasi umum, teknologi, dan penggunaan.

---

## 🏗️ Arsitektur Sistem

```
┌─────────────────────────────────────────────────────────────┐
│                    STOCK WING ARCHITECTURE                  │
└─────────────────────────────────────────────────────────────┘

┌─ FRONTEND LAYER ──────────────────────────────────────────┐
│                                                             │
│  ┌─ Customer Interface ──────────────────────────────┐   │
│  │ • Home Page                   · /                 │   │
│  │ • Shop/Products              · /shop              │   │
│  │ • Product Detail             · /shop/{id}         │   │
│  │ • Shopping Cart              · /cart              │   │
│  │ • Checkout                   · /checkout          │   │
│  │ • Payment                    · /checkout/payment  │   │
│  │ • Order History              · /orders            │   │
│  │ • Auth (Login/Register)      · /login, /register  │   │
│  └─────────────────────────────────────────────────────┘   │
│                                                             │
│  ┌─ Admin Interface ──────────────────────────────────┐   │
│  │ • Dashboard                  · /admin/dashboard   │   │
│  │ • Product Management (CRUD)  · /admin/products    │   │
│  │ • Order Management           · /admin/orders      │   │
│  │ • Payment Verification       · /admin/orders/{id} │   │
│  │ • Shipment Tracking          · /admin/orders/{id} │   │
│  └─────────────────────────────────────────────────────┘   │
│                                                             │
│  Built with: Bootstrap 5, Blade Template, Font Awesome   │
└─────────────────────────────────────────────────────────────┘

┌─ ROUTE LAYER ─────────────────────────────────────────────┐
│ routes/web.php                                              │
│ • Public routes (guest)                                     │
│ • Customer routes (auth)                                    │
│ • Admin routes (auth + admin middleware)                    │
└─────────────────────────────────────────────────────────────┘

┌─ CONTROLLER LAYER ────────────────────────────────────────┐
│                                                             │
│ Authentication:                                             │
│ • RegisteredUserController     (signup)                    │
│ • AuthenticatedSessionController (login/logout)           │
│ • Email Verification Controllers                           │
│                                                             │
│ Customer:                                                   │
│ • ShopController (browsing)                                │
│ • CartController (CRUD cart)                               │
│ • CheckoutController (checkout flow)                       │
│                                                             │
│ Admin:                                                      │
│ • DashboardController (stats)                              │
│ • ProductController (CRUD products)                        │
│ • OrderController (order management)                       │
│                                                             │
└─────────────────────────────────────────────────────────────┘

┌─ MIDDLEWARE LAYER ────────────────────────────────────────┐
│                                                             │
│ • 'auth' - Require authentication                          │
│ • 'guest' - Only for non-authenticated users               │
│ • 'admin' - Custom middleware checking role                │
│                                                             │
└─────────────────────────────────────────────────────────────┘

┌─ MODEL LAYER (Eloquent ORM) ──────────────────────────────┐
│                                                             │
│ User                                                        │
│  ├── CartItem (hasMany)                                    │
│  ├── Order (hasMany)                                       │
│  └── Properties: id, name, email, password, role,          │
│                 phone, address, city                       │
│                                                             │
│ Product                                                     │
│  ├── CartItem (hasMany)                                    │
│  ├── OrderItem (hasMany)                                   │
│  └── Properties: id, name, description, price,             │
│                 stock, unit, image                         │
│                                                             │
│ CartItem                                                    │
│  ├── User (belongsTo)                                      │
│  ├── Product (belongsTo)                                   │
│  └── Properties: id, user_id, product_id, quantity, price  │
│                                                             │
│ Order                                                       │
│  ├── User (belongsTo)                                      │
│  ├── OrderItem (hasMany)                                   │
│  ├── Shipment (hasOne)                                     │
│  ├── Payment (hasOne)                                      │
│  └── Properties: id, user_id, order_number, subtotal,      │
│                 shipping_cost, total, status, ...          │
│                                                             │
│ OrderItem                                                   │
│  ├── Order (belongsTo)                                     │
│  ├── Product (belongsTo)                                   │
│  └── Properties: id, order_id, product_id, qty, price      │
│                                                             │
│ Shipment                                                    │
│  ├── Order (belongsTo)                                     │
│  └── Properties: id, order_id, method, tracking_number,    │
│                 shipped_at, delivered_at, ...              │
│                                                             │
│ Payment                                                     │
│  ├── Order (belongsTo)                                     │
│  └── Properties: id, order_id, method, status, amount,     │
│                 bank_account, qris_code, proof_image       │
│                                                             │
└─────────────────────────────────────────────────────────────┘

┌─ DATABASE LAYER ──────────────────────────────────────────┐
│                                                             │
│ SQLite (default) atau MySQL                                │
│                                                             │
│ Tables:                                                     │
│ • users (extended with role, phone, address, city)         │
│ • products (name, desc, price, stock, unit, image)         │
│ • cart_items (user_id, product_id, qty, price)             │
│ • orders (order_number, status, payment_method, ...)       │
│ • order_items (order_id, product_id, qty, price)           │
│ • shipments (order_id, method, tracking_number, ...)       │
│ • payments (order_id, method, status, amount, ...)         │
│                                                             │
└─────────────────────────────────────────────────────────────┘

┌─ FILE STORAGE ────────────────────────────────────────────┐
│                                                             │
│ storage/app/public/products/  → Product images             │
│ storage/app/public/proofs/    → Payment proof images       │
│ public/storage/ (symlink)     → Public access              │
│                                                             │
└─────────────────────────────────────────────────────────────┘

┌─ EXTERNAL SERVICES ───────────────────────────────────────┐
│                                                             │
│ • QR Code API (for QRIS)                                   │
│ • Email Service (optional for notifications)               │
│                                                             │
└─────────────────────────────────────────────────────────────┘
```

---

## 📊 Data Flow Diagram

### Customer Purchasing Flow

```
START
  ↓
┌─ BROWSING ────────────────────────────┐
│ Customer visits /shop                 │
│ • Views product grid                  │
│ • Filters by stock availability       │
│ • Clicks product for details          │
└──────────────────────────────────────┘
  ↓
┌─ ADD TO CART ─────────────────────────┐
│ Select quantity → Click "Add"         │
│ • Price snapshot saved                │
│ • Stock validated                     │
│ • Cart item created                   │
└──────────────────────────────────────┘
  ↓
┌─ CHECKOUT ────────────────────────────┐
│ /checkout                             │
│ • Review cart items                   │
│ • Verify/edit delivery address        │
│ • Select shipping method              │
│ • Shipping cost calculated            │
└──────────────────────────────────────┘
  ↓
┌─ PAYMENT METHOD ──────────────────────┐
│ Choose: Transfer Bank OR QRIS         │
│ • Proceed to payment page             │
│ • Order created (status: pending)     │
│ • Stock decremented                   │
│ • Cart cleared                        │
└──────────────────────────────────────┘
  ↓
┌─ PAYMENT ─────────────────────────────┐
│ Transfer Bank:                        │
│ • Show bank details                   │
│ • Upload proof image                  │
│ • Manual verification                 │
│                                       │
│ QRIS:                                 │
│ • Show QR code                        │
│ • Customer scans & pays               │
│ • Auto verification (if integrated)   │
└──────────────────────────────────────┘
  ↓
┌─ WAIT FOR CONFIRMATION ───────────────┐
│ Order status: Pending                 │
│ Payment status: Pending               │
│ • Customer can check order history    │
│ • Admin verifies payment              │
│ • Status updates to "Paid"            │
└──────────────────────────────────────┘
  ↓
┌─ ADMIN PROCESSING ────────────────────┐
│ • Confirms order (Confirmed status)   │
│ • Inputs tracking number              │
│ • Changes to "Shipped" status         │
│ • Sends shipment notification         │
└──────────────────────────────────────┘
  ↓
┌─ DELIVERY ────────────────────────────┐
│ • Product shipped                     │
│ • Customer tracks progress            │
│ • Admin marks as "Delivered"          │
│ • Order complete                      │
└──────────────────────────────────────┘
  ↓
END
```

---

## 🎮 Quick Start Commands

```bash
# Start the server
cd d:\ayamsuwir\stock_wing
php artisan serve

# In another terminal, start Vite (optional)
npm run dev

# Open browser
http://localhost:8000

# Login as admin
Email: admin@stockwing.com
Password: password123

# Login as customer
Email: customer@example.com
Password: password123
```

---

## 🔗 Navigation Map

```
HOME (/)
├── Public Routes
│   ├── Shop (/shop)
│   │   ├── Product Grid
│   │   └── Product Detail (/shop/{id})
│   └── Auth
│       ├── Login (/login)
│       └── Register (/register)
│
├── Customer Routes (Authenticated)
│   ├── Cart (/cart)
│   ├── Checkout (/checkout)
│   │   ├── Checkout Form
│   │   └── Payment (/checkout/payment/{id})
│   │       ├── Transfer Bank Page
│   │       └── QRIS Page
│   └── Orders (/orders)
│       ├── Order History
│       └── Order Detail (/orders/{id})
│
└── Admin Routes (Authenticated + Admin)
    ├── Dashboard (/admin/dashboard)
    │   ├── Statistics
    │   ├── Recent Orders
    │   └── Low Stock Alerts
    │
    ├── Products (/admin/products)
    │   ├── Product List
    │   ├── Create (/admin/products/create)
    │   ├── Edit (/admin/products/{id}/edit)
    │   └── Delete (/admin/products/{id})
    │
    └── Orders (/admin/orders)
        ├── Order List
        └── Order Detail (/admin/orders/{id})
            ├── View Items
            ├── Update Status
            ├── Verify Payment
            └── Update Shipment
```

---

## 📊 Feature Checklist

### ✅ Implemented Features
- [x] Product Management (Create, Read, Update, Delete)
- [x] Shopping Cart (Add, Update, Remove, Clear)
- [x] Checkout with Address Form
- [x] Multiple Shipping Options
- [x] Multiple Payment Methods
- [x] Order Tracking
- [x] Payment Proof Upload
- [x] Admin Dashboard
- [x] Order Management
- [x] Payment Verification
- [x] Shipment Tracking
- [x] Stock Management
- [x] User Authentication
- [x] Role-Based Access Control
- [x] Responsive Design
- [x] Email Verification (Optional)

### 🎯 Future Enhancements (Optional)
- [ ] Email Notifications
- [ ] Real Payment Gateway Integration
- [ ] Product Reviews & Ratings
- [ ] Wishlist Functionality
- [ ] Discount Codes
- [ ] Customer Analytics
- [ ] Advanced Search & Filter
- [ ] Mobile App API
- [ ] SMS Notifications
- [ ] Automated Invoices

---

## 🤔 Frequently Asked Questions

### Q: Bagaimana cara start aplikasi?
**A**: Baca `QUICKSTART.md` - ada panduan 5 menit lengkap dengan 2 terminal yang harus dibuka.

### Q: Akun apa yang sudah tersedia?
**A**: Ada 2 akun:
- Admin: `admin@stockwing.com` / `password123`
- Customer: `customer@example.com` / `password123`

### Q: Bagaimana cara setup database?
**A**: Database sudah otomatis di-setup saat instalasi:
```bash
php artisan migrate  # Create tables
php artisan db:seed  # Add test data
```

### Q: Bagaimana cara ubah warna/brand?
**A**: Edit file `layout.blade.php` dan ubah warna/logo sesuai brand Anda.

### Q: Bagaimana cara tambah admin user baru?
**A**: Gunakan tinker:
```bash
php artisan tinker
User::create([
    'name' => 'Admin Baru',
    'email' => 'admin2@example.com',
    'password' => Hash::make('password'),
    'role' => 'admin'
]);
```

### Q: Bagaimana cara upload foto produk?
**A**: Di halaman `/admin/products/create`, ada field "Upload Foto". Foto akan tersimpan di `storage/app/public/products/`

### Q: Bagaimana cara ubah metode pembayaran?
**A**: Edit `CheckoutController.php` di method `payment()` untuk menambah/mengubah metode.

### Q: Bagaimana cara deploy ke production?
**A**: Baca bagian "Deployment" di `INSTALLATION.md`

---

## 📞 Perlu Bantuan?

### Level 1: Dokumentasi
1. Baca `QUICKSTART.md` (5 menit)
2. Baca `INSTALLATION.md` (30 menit)
3. Baca `README.md` (lengkap)
4. Baca `PROJECT_SUMMARY.md` (overview)

### Level 2: Troubleshooting
1. Lihat bagian "Troubleshooting" di `INSTALLATION.md`
2. Cek error di `storage/logs/laravel.log`
3. Coba `php artisan cache:clear` & `composer dump-autoload`

### Level 3: Stack Overflow / GitHub
- Cari error message di Google + "Laravel"
- Buka Stack Overflow dengan tag "laravel"
- Check Laravel documentation di laravel.com

---

## 📝 File Structure Reference

```
stock_wing/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── Auth/               ← Authentication
│   │   │   ├── Admin/              ← Admin controllers
│   │   │   ├── ShopController.php  ← Browse products
│   │   │   ├── CartController.php  ← Shopping cart
│   │   │   └── CheckoutController.php ← Checkout flow
│   │   └── Middleware/
│   │       └── IsAdmin.php         ← Admin authorization
│   └── Models/                     ← Database models (7 models)
│
├── database/
│   ├── migrations/                 ← Database schema (7 migrations)
│   ├── seeders/                    ← Test data
│   └── factories/                  ← Model factories
│
├── resources/
│   ├── views/
│   │   ├── layout.blade.php        ← Customer base layout
│   │   ├── auth/                   ← Login/Register views
│   │   ├── shop/                   ← Product views
│   │   ├── cart/                   ← Cart views
│   │   ├── checkout/               ← Checkout views
│   │   └── admin/                  ← Admin views
│   ├── css/
│   └── js/
│
├── routes/
│   └── web.php                     ← All web routes
│
├── bootstrap/
│   └── app.php                     ← Middleware registration
│
├── storage/
│   └── app/public/
│       ├── products/               ← Product images
│       └── proofs/                 ← Payment proofs
│
├── public/
│   ├── index.php                   ← Entry point
│   └── storage/ (symlink)
│
├── config/                         ← Configuration files
├── vendor/                         ← PHP dependencies
├── node_modules/                   ← Node.js dependencies
│
├── README.md                       ← Documentation
├── QUICKSTART.md                   ← Quick start guide
├── INSTALLATION.md                 ← Installation guide
├── PROJECT_SUMMARY.md              ← Project overview
└── IMPLEMENTATION_CHECKLIST.md    ← Completion checklist
```

---

## 🎓 Next Steps

1. **Immediately**: 
   - Buka QUICKSTART.md
   - Start server dengan `php artisan serve`
   - Test di browser

2. **Dalam 30 Menit**:
   - Test complete customer flow (register → shop → checkout)
   - Test admin functions (login → manage products → manage orders)
   - Explore semua fitur

3. **Dalam 1 Jam**:
   - Customize warna/brand
   - Edit data bank
   - Tambah/edit produk sample

4. **Sebelum Go Live**:
   - Ubah password semua test account
   - Setup email notifications (optional)
   - Setup real payment gateway (optional)
   - Configure HTTPS/SSL
   - Setup domain custom
   - Deploy ke server production

---

## ✨ Bonus

### Tips & Tricks

```bash
# Clear all caches
php artisan cache:clear
php artisan config:clear
php artisan view:clear

# Reset database dengan data baru
php artisan migrate:fresh --seed

# Generate route list
php artisan route:list

# Database tinker REPL
php artisan tinker

# Optimize for production
php artisan optimize

# Create admin user via tinker
php artisan tinker
User::create([
    'name' => 'New Admin',
    'email' => 'admin@example.com',
    'password' => Hash::make('password'),
    'role' => 'admin'
]);
```

---

## 🙏 Terima Kasih

Anda sekarang memiliki sistem e-commerce **produksi-ready** untuk penjualan ayam. 

**Nikmati dan semoga sukses dengan Stock Wings!** 🎉

---

**Stock Wings © 2025** - Sistem Manajemen Penjualan Ayam Terpercaya

Dikembangkan dengan ❤️ menggunakan Laravel 12 & Bootstrap 5

