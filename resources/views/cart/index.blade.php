@extends('layout')

@section('title', 'Keranjang Belanja')

@section('content')
<div class="row">
    <div class="col-lg-8">
        <h2 class="mb-4"><i class="fas fa-shopping-cart"></i> Keranjang Belanja</h2>

        @if($cartItems->isEmpty())
            <div class="alert alert-info text-center">
                <i class="fas fa-inbox"></i> Keranjang Anda kosong. 
                <a href="{{ route('shop.index') }}">Mulai berbelanja</a>
            </div>
        @else
            <div class="card">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Produk</th>
                                <th>Harga</th>
                                <th>Jumlah</th>
                                <th>Subtotal</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($cartItems as $item)
                                <tr>
                                    <td>
                                        <div>
                                            <strong>{{ $item->product->name }}</strong>
                                            <br>
                                            <small class="text-muted">{{ $item->product->unit }}</small>
                                        </div>
                                    </td>
                                    <td>
                                        Rp {{ number_format($item->price, 0, ',', '.') }}
                                    </td>
                                    <td>
                                        <form method="POST" action="{{ route('cart.update', $item) }}" style="display: inline;">
                                            @csrf
                                            @method('PUT')
                                            <div class="input-group" style="width: 100px;">
                                                <input type="number" class="form-control" name="quantity" 
                                                       value="{{ $item->quantity }}" min="1" 
                                                       onchange="this.form.submit();">
                                            </div>
                                        </form>
                                    </td>
                                    <td>
                                        <strong>Rp {{ number_format($item->subtotal, 0, ',', '.') }}</strong>
                                    </td>
                                    <td>
                                        <form method="POST" action="{{ route('cart.remove', $item) }}" style="display: inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger" 
                                                    onclick="return confirm('Hapus item ini?');">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="mt-3">
                <form method="POST" action="{{ route('cart.clear') }}" style="display: inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-outline-danger" 
                            onclick="return confirm('Kosongkan seluruh keranjang?');">
                        <i class="fas fa-broom"></i> Kosongkan Keranjang
                    </button>
                </form>
            </div>
        @endif
    </div>

    @if(!$cartItems->isEmpty())
        <div class="col-lg-4">
            <div class="card sticky-top" style="top: 80px;">
                <div class="card-body">
                    <h5 class="card-title">Ringkasan Pembelian</h5>
                    
                    <hr>

                    <div class="d-flex justify-content-between mb-2">
                        <span>Subtotal:</span>
                        <strong>Rp {{ number_format($total, 0, ',', '.') }}</strong>
                    </div>

                    <div class="d-flex justify-content-between mb-3">
                        <span class="text-muted">Ongkir:</span>
                        <span class="text-muted">Dihitung saat checkout</span>
                    </div>

                    <hr>

                    <div class="d-flex justify-content-between mb-3">
                        <strong>Total:</strong>
                        <strong class="h5 text-danger">Rp {{ number_format($total, 0, ',', '.') }}</strong>
                    </div>

                    @if(auth()->user() && auth()->user()->isAdmin())
                        <div class="alert alert-warning">Akun admin tidak dapat melakukan checkout atau pemesanan.</div>
                        <a href="{{ route('shop.index') }}" class="btn btn-outline-secondary w-100 mt-2">
                            <i class="fas fa-shopping-bag"></i> Kembali ke Toko
                        </a>
                    @else
                        <a href="{{ route('checkout.index') }}" class="btn btn-primary w-100 btn-lg">
                            <i class="fas fa-credit-card"></i> Lanjut ke Checkout
                        </a>

                        <a href="{{ route('shop.index') }}" class="btn btn-outline-secondary w-100 mt-2">
                            <i class="fas fa-shopping-bag"></i> Lanjut Belanja
                        </a>
                    @endif
                </div>
            </div>
        </div>
    @endif
</div>
@endsection
