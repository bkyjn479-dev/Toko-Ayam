@extends('layout')

@section('title', $product->name)

@section('content')
<div class="row">
    <div class="col-md-6 mb-4">
        @if($product->image)
            <img src="{{ asset('storage/' . $product->image) }}" class="img-fluid rounded" alt="{{ $product->name }}">
        @else
            <div class="bg-light rounded d-flex align-items-center justify-content-center" style="height: 400px;">
                <i class="fas fa-drumstick-bite fa-5x text-muted"></i>
            </div>
        @endif
    </div>

    <div class="col-md-6">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('shop.index') }}">Toko</a></li>
                <li class="breadcrumb-item active" aria-current="page">{{ $product->name }}</li>
            </ol>
        </nav>

        <h2 class="mb-2">{{ $product->name }}</h2>

        <div class="mb-3">
            <span class="h4 text-danger">Rp {{ number_format($product->price, 0, ',', '.') }}</span>
            <small class="text-muted">/ {{ $product->unit }}</small>
        </div>

        <div class="mb-3">
            @if($product->stock > 0)
                <span class="badge bg-success p-2">Stok Tersedia: {{ $product->stock }}</span>
            @else
                <span class="badge bg-danger p-2">Habis</span>
            @endif
        </div>

        <hr>

        <h5>Deskripsi Produk</h5>
        <p>{{ $product->description }}</p>

        <hr>

        @auth
            @if(auth()->user()->isAdmin())
                <div class="alert alert-warning">
                    <i class="fas fa-user-shield"></i> Akun admin tidak dapat melakukan pemesanan di toko.
                </div>
            @else
                @if($product->stock > 0)
                    <form method="POST" action="{{ route('cart.add') }}">
                        @csrf
                        <input type="hidden" name="product_id" value="{{ $product->id }}">
                        
                        <div class="mb-3">
                            <label for="quantity" class="form-label">Jumlah ({{ $product->unit }})</label>
                            <input type="number" class="form-control" id="quantity" name="quantity" 
                                   min="1" max="{{ $product->stock }}" value="1" required>
                        </div>

                        <button type="submit" class="btn btn-primary btn-lg w-100">
                            <i class="fas fa-shopping-cart"></i> Tambah ke Keranjang
                        </button>
                    </form>
                @else
                    <div class="alert alert-warning">
                        <i class="fas fa-exclamation-triangle"></i> Produk tidak tersedia
                    </div>
                @endif
            @endif
        @else
            <div class="alert alert-info">
                <i class="fas fa-info-circle"></i> 
                Silakan <a href="{{ route('login') }}">login</a> terlebih dahulu untuk menambahkan ke keranjang.
            </div>
        @endauth

        <a href="{{ route('shop.index') }}" class="btn btn-outline-secondary btn-lg w-100 mt-2">
            <i class="fas fa-arrow-left"></i> Kembali ke Toko
        </a>
    </div>
</div>
@endsection
