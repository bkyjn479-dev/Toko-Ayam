@extends('layout')

@section('title', 'Pembayaran - ' . $order->order_number)

@section('content')
<h2 class="mb-4"><i class="fas fa-money-check"></i> Pembayaran Pesanan</h2>

<div class="row">
    <div class="col-lg-8">
        <div class="card mb-4">
            <div class="card-body">
                <h5 class="mb-3">Nomor Pesanan: <span class="text-danger">{{ $order->order_number }}</span></h5>

                <hr>

                <div class="alert alert-info">
                    <i class="fas fa-info-circle"></i>
                    <strong>Status Pembayaran:</strong> 
                    @if($order->payment_status === 'pending')
                        <span class="badge bg-warning">Menunggu Pembayaran</span>
                    @elseif($order->payment_status === 'paid')
                        <span class="badge bg-success">Sudah Dibayar</span>
                    @else
                        <span class="badge bg-danger">Gagal</span>
                    @endif
                </div>

                @if($order->payment_method === 'transfer')
                    <div class="card bg-light mb-4">
                        <div class="card-body">
                            <h5 class="mb-3"><i class="fas fa-bank"></i> Transfer Bank</h5>

                            @php
                                $bankData = $order->payment->bank_account ? json_decode($order->payment->bank_account, true) : [];
                            @endphp

                            <table class="table table-sm mb-3">
                                <tr>
                                    <td><strong>Bank</strong></td>
                                    <td>{{ $bankData['bank'] ?? 'BCA' }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Nomor Rekening</strong></td>
                                    <td>
                                        <code>{{ $bankData['account_number'] ?? '1234567890' }}</code>
                                        <button class="btn btn-sm btn-outline-secondary" onclick="copyToClipboard('{{ $bankData['account_number'] ?? '1234567890' }}')">
                                            <i class="fas fa-copy"></i>
                                        </button>
                                    </td>
                                </tr>
                                <tr>
                                    <td><strong>Atas Nama</strong></td>
                                    <td>{{ $bankData['account_name'] ?? 'Stock Wings' }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Jumlah Transfer</strong></td>
                                    <td>
                                        <strong class="text-danger">Rp {{ number_format($order->total, 0, ',', '.') }}</strong>
                                    </td>
                                </tr>
                            </table>

                            <div class="alert alert-warning">
                                <i class="fas fa-exclamation-triangle"></i> 
                                Transfer ke rekening di atas sebesar <strong>Rp {{ number_format($order->total, 0, ',', '.') }}</strong> 
                                kemudian upload bukti transfer di bawah.
                            </div>

                            @if($order->payment_status === 'pending')
                                <form method="POST" action="{{ route('checkout.uploadProof', $order) }}" enctype="multipart/form-data">
                                    @csrf

                                    <div class="mb-3">
                                        <label for="proof_image" class="form-label">Upload Bukti Transfer</label>
                                        <input type="file" class="form-control @error('proof_image') is-invalid @enderror" 
                                               id="proof_image" name="proof_image" accept="image/*" required>
                                        <small class="form-text text-muted">
                                            Format: JPG, PNG, GIF (Max 2MB)
                                        </small>
                                        @error('proof_image')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <button type="submit" class="btn btn-primary">
                                        <i class="fas fa-upload"></i> Upload Bukti Transfer
                                    </button>
                                </form>
                            @elseif($order->payment->proof_image)
                                <div class="mt-3">
                                    <strong>Bukti Transfer yang Diupload:</strong>
                                    <br>
                                    <img src="{{ asset('storage/' . $order->payment->proof_image) }}" 
                                         class="img-thumbnail mt-2" style="max-width: 300px;">
                                </div>
                            @endif
                        </div>
                    </div>
                @else
                    <div class="card bg-light mb-4">
                        <div class="card-body">
                            <h5 class="mb-3"><i class="fas fa-qrcode"></i> Pembayaran QRIS</h5>

                            @if($order->payment->qris_code)
                                <div class="text-center mb-3">
                                    <img src="{{ $order->payment->qris_code }}" alt="QRIS" class="img-fluid" style="max-width: 300px;">
                                </div>
                            @endif

                            <div class="alert alert-info">
                                <i class="fas fa-info-circle"></i>
                                Scan QR Code di atas menggunakan aplikasi e-wallet Anda untuk melakukan pembayaran sebesar 
                                <strong>Rp {{ number_format($order->total, 0, ',', '.') }}</strong>
                            </div>

                            @if($order->payment_status === 'pending')
                                <p class="text-muted">
                                    Pembayaran akan diverifikasi otomatis setelah Anda menyelesaikan transaksi.
                                </p>
                            @endif
                        </div>
                    </div>
                @endif

                <hr>

                <h5>Detail Pengiriman</h5>
                <table class="table table-sm">
                    <tr>
                        <td><strong>Nama</strong></td>
                        <td>{{ $order->shipment->recipient_name ?? auth()->user()->name }}</td>
                    </tr>
                    <tr>
                        <td><strong>Telepon</strong></td>
                        <td>{{ $order->shipment->recipient_phone ?? auth()->user()->phone }}</td>
                    </tr>
                    <tr>
                        <td><strong>Alamat</strong></td>
                        <td>{{ $order->shipment->recipient_address ?? auth()->user()->address }}</td>
                    </tr>
                    <tr>
                        <td><strong>Kota</strong></td>
                        <td>{{ $order->shipment->recipient_city ?? auth()->user()->city }}</td>
                    </tr>
                </table>
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="card sticky-top" style="top: 80px;">
            <div class="card-header bg-light">
                <h5 class="mb-0">Ringkasan Pesanan</h5>
            </div>
            <div class="card-body">
                @foreach($order->items as $item)
                    <div class="d-flex justify-content-between mb-2">
                        <div>
                            <strong>{{ $item->product->name }}</strong>
                            <br>
                            <small class="text-muted">{{ $item->quantity }} {{ $item->product->unit }}</small>
                        </div>
                        <strong>Rp {{ number_format($item->quantity * $item->price, 0, ',', '.') }}</strong>
                    </div>
                @endforeach

                <hr>

                <div class="d-flex justify-content-between mb-2">
                    <span>Subtotal</span>
                    <strong>Rp {{ number_format($order->subtotal, 0, ',', '.') }}</strong>
                </div>

                <div class="d-flex justify-content-between mb-3">
                    <span>Pengiriman</span>
                    <strong>Rp {{ number_format($order->shipping_cost, 0, ',', '.') }}</strong>
                </div>

                <hr>

                <div class="d-flex justify-content-between">
                    <span class="h5">Total</span>
                    <strong class="h5 text-danger">Rp {{ number_format($order->total, 0, ',', '.') }}</strong>
                </div>

                <a href="{{ route('orders.detail', $order) }}" class="btn btn-outline-secondary btn-sm w-100 mt-3">
                    <i class="fas fa-info-circle"></i> Lihat Detail Pesanan
                </a>
            </div>
        </div>
    </div>
</div>

@push('js')
<script>
function copyToClipboard(text) {
    navigator.clipboard.writeText(text).then(function() {
        alert('Nomor rekening telah disalin!');
    });
}
</script>
@endpush
@endsection
