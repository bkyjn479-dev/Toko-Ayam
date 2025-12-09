@extends('layout')

@section('title', 'Toko')

@section('content')
<div class="mb-5">
    <h2 class="mb-1"><i class="fas fa-store"></i> Toko Online</h2>
    <div class="d-flex justify-content-between align-items-center">
        <p class="text-muted mb-0">Pilih produk ayam matang siap santap yang Anda inginkan</p>
        <form method="GET" action="{{ route('shop.index') }}" class="d-flex" style="max-width:420px;">
            <input type="search" name="q" value="{{ request('q') }}" class="form-control form-control-sm me-2" placeholder="Cari produk...">
            <button class="btn btn-sm btn-primary" type="submit"><i class="fas fa-search"></i> Cari</button>
        </form>
    </div>
</div>

<div class="row">
    @forelse($products as $product)
        <div class="col-md-4 col-lg-3 mb-4">
            <div class="card h-100">
                @if($product->image)
                    <img src="{{ asset('storage/' . $product->image) }}" class="card-img-top product-image" alt="{{ $product->name }}">
                @else
                    <div class="product-image d-flex align-items-center justify-content-center">
                        <i class="fas fa-drumstick-bite fa-3x text-muted"></i>
                    </div>
                @endif
                
                <div class="card-body">
                    <h5 class="card-title">{{ $product->name }}</h5>
                    <p class="card-text text-muted" style="font-size: 0.9rem; height: 2.7em; overflow: hidden;">
                        {{ Str::limit($product->description, 50) }}
                    </p>
                </div>

                <div class="card-footer bg-white border-top pt-3">
                    <div class="mb-2">
                        <span class="h5 text-danger">Rp {{ number_format($product->price, 0, ',', '.') }}</span>
                        <small class="text-muted">/ {{ $product->unit }}</small>
                    </div>

                    <div class="mb-2">
                        @if($product->stock > 0)
                            <span class="badge bg-success">Stok: {{ $product->stock }}</span>
                        @else
                            <span class="badge bg-danger">Habis</span>
                        @endif
                    </div>

                    <a href="{{ route('shop.show', $product) }}" class="btn btn-primary btn-sm w-100">
                        <i class="fas fa-eye"></i> Lihat Detail
                    </a>
                </div>
            </div>
        </div>
    @empty
        <div class="col-12">
            <div class="alert alert-info text-center">
                <i class="fas fa-info-circle"></i> Tidak ada produk tersedia saat ini.
            </div>
        </div>
    @endforelse
</div>

@if($products->hasPages())
    <nav aria-label="Page navigation" class="mt-4">
        <ul class="pagination justify-content-center">
            {{ $products->links() }}
        </ul>
    </nav>
@endif
@endsection
