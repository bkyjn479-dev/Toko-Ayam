@extends('layout')

@section('title', 'Checkout')

@section('content')
<h2 class="mb-4"><i class="fas fa-receipt"></i> Checkout</h2>

<div class="row">
    <div class="col-lg-7">
        <div class="card mb-4">
            <div class="card-header bg-light">
                <h5 class="mb-0">Data Pengiriman</h5>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('checkout.store') }}" id="checkoutForm">
                    @csrf

                    <div class="mb-3">
                        <label class="form-label">Nama</label>
                        <input type="text" class="form-control" value="{{ auth()->user()->name }}" disabled>
                    </div>

                    <div class="mb-3">
                        <label for="phone" class="form-label">Nomor Telepon</label>
                        <input type="tel" class="form-control @error('phone') is-invalid @enderror" 
                               id="phone" name="phone" value="{{ old('phone', auth()->user()->phone) }}" required>
                        @error('phone')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="address" class="form-label">Alamat Lengkap</label>
                        <textarea class="form-control @error('address') is-invalid @enderror" 
                                  id="address" name="address" rows="3" required>{{ old('address', auth()->user()->address) }}</textarea>
                        @error('address')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="city" class="form-label">Kota</label>
                        <input type="text" class="form-control @error('city') is-invalid @enderror" 
                               id="city" name="city" value="{{ old('city', auth()->user()->city) }}" required>
                        @error('city')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <hr>

                    <h5>Opsi Pengiriman</h5>
                    
                    <div class="mb-3">
                        @foreach(['pickup' => ['Ambil Sendiri', '0'], 'courier' => ['Kurir (Rp 50.000)', '50000'], 'delivery' => ['Delivery (Rp 75.000)', '75000']] as $method => $info)
                            <div class="form-check">
                                <input class="form-check-input shipping-method" type="radio" name="shipping_method" 
                                       id="{{ $method }}" value="{{ $method }}" 
                                       data-cost="{{ $info[1] }}"
                                       @if(old('shipping_method') == $method || $loop->first) checked @endif
                                       onchange="updateTotal()">
                                <label class="form-check-label" for="{{ $method }}">
                                    {{ $info[0] }}
                                </label>
                            </div>
                        @endforeach
                    </div>

                    <hr>

                    <h5>Metode Pembayaran</h5>

                    <div class="mb-3">
                        @foreach(['transfer' => ['Transfer Bank', 'fas fa-bank'], 'qris' => ['QRIS', 'fas fa-qrcode']] as $method => $info)
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="payment_method" 
                                       id="{{ $method }}" value="{{ $method }}"
                                       @if(old('payment_method') == $method || $loop->first) checked @endif>
                                <label class="form-check-label" for="{{ $method }}">
                                    <i class="{{ $info[1] }}"></i> {{ $info[0] }}
                                </label>
                            </div>
                        @endforeach
                    </div>

                    <button type="submit" class="btn btn-primary btn-lg w-100">
                        <i class="fas fa-arrow-right"></i> Lanjut ke Pembayaran
                    </button>
                </form>
            </div>
        </div>
    </div>

    <div class="col-lg-5">
        <div class="card sticky-top" style="top: 80px;">
            <div class="card-header bg-light">
                <h5 class="mb-0">Ringkasan Pesanan</h5>
            </div>
            <div class="card-body">
                @foreach($cartItems as $item)
                    <div class="d-flex justify-content-between mb-2">
                        <div>
                            <strong>{{ $item->product->name }}</strong>
                            <br>
                            <small class="text-muted">{{ $item->quantity }} {{ $item->product->unit }}</small>
                        </div>
                        <strong>Rp {{ number_format($item->subtotal, 0, ',', '.') }}</strong>
                    </div>
                @endforeach

                <hr>

                <div class="d-flex justify-content-between mb-2">
                    <span>Subtotal</span>
                    <strong id="subtotal">Rp {{ number_format($subtotal, 0, ',', '.') }}</strong>
                </div>

                <div class="d-flex justify-content-between mb-3">
                    <span>Pengiriman</span>
                    <strong id="shipping">Rp 0</strong>
                </div>

                <hr>

                <div class="d-flex justify-content-between">
                    <span class="h5">Total</span>
                    <strong class="h5 text-danger" id="total">Rp {{ number_format($subtotal, 0, ',', '.') }}</strong>
                </div>
            </div>
        </div>
    </div>
</div>

@push('js')
<script>
const subtotal = {{ $subtotal }};

function updateTotal() {
    const shippingMethod = document.querySelector('.shipping-method:checked');
    const shippingCost = parseInt(shippingMethod.dataset.cost);
    const total = subtotal + shippingCost;

    document.getElementById('shipping').textContent = 'Rp ' + shippingCost.toLocaleString('id-ID');
    document.getElementById('total').textContent = 'Rp ' + total.toLocaleString('id-ID');
}

document.querySelectorAll('.shipping-method').forEach(el => {
    el.addEventListener('change', updateTotal);
});

updateTotal();
</script>
@endpush
@endsection
