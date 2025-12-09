@extends('layout')

@section('title', 'Beranda')

@section('content')
<!-- Hero Section -->
<div style="background: linear-gradient(135deg, #ff6b35 0%, #004e89 100%);" class="text-white rounded-lg p-8 mb-5">
    <div class="row align-items-center">
        <div class="col-lg-6 mb-4 mb-lg-0 d-flex flex-column justify-content-center">
            <h1 class="display-4 fw-bold mb-3" style="line-height:1.05;">
                <i class="fas fa-drumstick-bite"></i> Selamat Datang di Stock Wings
            </h1>
            @auth
                <a href="{{ route('shop.index') }}" class="btn btn-light btn-lg">
                    <i class="fas fa-shopping-bag"></i> Mulai Belanja
                </a>
            @endauth
        </div>
        <div class="col-lg-6">
            <div class="d-flex align-items-center justify-content-center bg-white rounded p-4" style="height: 300px; box-shadow: 0 2px 8px rgba(0,0,0,0.08);">
                <i class="fas fa-drumstick-bite fa-8x text-opacity-25" style="color: #ff6b35;"></i>
            </div>
        </div>
    </div>
</div>

<!-- Features Section -->
<div class="row mb-5">
    <div class="col-md-4 mb-4">
        <div class="card h-100 text-center">
            <div class="card-body">
                <i class="fas fa-check-circle fa-3x text-success mb-3"></i>
                <h5 class="card-title">Kualitas Premium</h5>
                <p class="card-text">Ayam matang siap santap, diolah dari bahan berkualitas dengan kontrol mutu ketat.</p>
            </div>
        </div>
    </div>
    <div class="col-md-4 mb-4">
        <div class="card h-100 text-center">
            <div class="card-body">
                <i class="fas fa-truck fa-3x text-primary mb-3"></i>
                <h5 class="card-title">Pengiriman Cepat</h5>
                <p class="card-text">Pesanan Anda akan kami kirim dengan aman dan tepat waktu ke seluruh kota.</p>
            </div>
        </div>
    </div>
    <div class="col-md-4 mb-4">
        <div class="card h-100 text-center">
            <div class="card-body">
                <i class="fas fa-money-bill fa-3x text-danger mb-3"></i>
                <h5 class="card-title">Harga Terjangkau</h5>
                <p class="card-text">Nikmati harga kompetitif dengan kualitas terbaik untuk produk unggulan kami.</p>
            </div>
        </div>
    </div>
</div>

<!-- Why Choose Us -->
<div class="card mb-5 bg-light">
    <div class="card-body p-5">
        <h2 class="mb-4 text-center">Mengapa Memilih Stock Wings?</h2>
        <div class="row">
            <div class="col-md-6 mb-3">
                <h5><i class="fas fa-star text-warning"></i> Bahan Baku Terbaik</h5>
                <p>Kami hanya menggunakan ayam berkualitas premium dari peternak terpilih.</p>
            </div>
            <div class="col-md-6 mb-3">
                <h5><i class="fas fa-certificate text-info"></i> Tersertifikasi</h5>
                <p>Produk kami memiliki sertifikasi kesehatan dan keamanan pangan yang lengkap.</p>
            </div>
            <div class="col-md-6 mb-3">
                <h5><i class="fas fa-users text-success"></i> Tim Profesional</h5>
                <p>Tim kami siap melayani Anda dengan profesional 24/7 untuk kepuasan pelanggan.</p>
            </div>
            <div class="col-md-6 mb-3">
                <h5><i class="fas fa-leaf text-danger"></i> Ramah Lingkungan</h5>
                <p>Proses produksi kami ramah lingkungan dan berkelanjutan untuk masa depan.</p>
            </div>
        </div>
    </div>
</div>

<!-- CTA Section -->
<div class="alert alert-info mb-5" role="alert">
    <div class="row align-items-center">
        <div class="col-lg-8">
            <h4 class="mb-2"><i class="fas fa-bullhorn"></i> Penawaran Spesial!</h4>
            <p class="mb-0">Dapatkan potongan harga hingga 15% untuk pembelian pertama Anda. Segera daftar dan nikmati penawaran terbatas ini!</p>
        </div>
        <div class="col-lg-4 text-lg-end mt-3 mt-lg-0">
            @auth
                <a href="{{ route('shop.index') }}" class="btn btn-info">
                    <i class="fas fa-shopping-bag"></i> Belanja Sekarang
                </a>
            @else
                <a href="{{ route('register') }}" class="btn btn-info">
                    <i class="fas fa-user-plus"></i> Daftar Sekarang
                </a>
            @endauth
        </div>
    </div>
</div>

<!-- Testimonials / Stats -->
<div class="row text-center mb-5">
    <div class="col-md-3 mb-4">
        <div class="p-4">
            <h3 class="text-danger fw-bold">5000+</h3>
            <p>Pelanggan Puas</p>
        </div>
    </div>
            <div class="col-md-3 mb-4">
        <div class="p-4">
            <h3 class="text-danger fw-bold">100%</h3>
            <p>Ayam Matang Siap Santap</p>
        </div>
    </div>
    <div class="col-md-3 mb-4">
        <div class="p-4">
            <h3 class="text-danger fw-bold">24/7</h3>
            <p>Layanan Online</p>
        </div>
    </div>
    <div class="col-md-3 mb-4">
        <div class="p-4">
            <h3 class="text-danger fw-bold">Gratis</h3>
            <p>Konsultasi</p>
        </div>
    </div>
</div>
@endsection
