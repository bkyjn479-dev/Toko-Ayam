@extends('admin.layout')

@section('title', 'Detail Pesanan - ' . $order->order_number)

@section('content')
<nav aria-label="breadcrumb" class="mb-4">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('admin.orders.index') }}">Pesanan</a></li>
        <li class="breadcrumb-item active">{{ $order->order_number }}</li>
    </ol>
</nav>

<h2 class="mb-4">{{ $order->order_number }}</h2>

<div class="row">
    <div class="col-lg-8">
        <!-- Customer Info -->
        <div class="card mb-4">
            <div class="card-header bg-light">
                <h5 class="mb-0">Informasi Pelanggan</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <strong>Nama</strong>
                        <p>{{ $order->user->name }}</p>
                    </div>
                    <div class="col-md-6 mb-3">
                        <strong>Email</strong>
                        <p>{{ $order->user->email }}</p>
                    </div>
                    <div class="col-md-6 mb-3">
                        <strong>Telepon</strong>
                        <p>{{ $order->user->phone }}</p>
                    </div>
                    <div class="col-md-6 mb-3">
                        <strong>Kota</strong>
                        <p>{{ $order->user->city }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Order Items -->
        <div class="card mb-4">
            <div class="card-header bg-light">
                <h5 class="mb-0">Item Pesanan</h5>
            </div>
            <div class="table-responsive">
                <table class="table table-sm mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Produk</th>
                            <th>Harga</th>
                            <th>Jumlah</th>
                            <th>Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($order->items as $item)
                            <tr>
                                <td>{{ $item->product->name }}</td>
                                <td>Rp {{ number_format($item->price, 0, ',', '.') }}</td>
                                <td>{{ $item->quantity }} {{ $item->product->unit }}</td>
                                <td>Rp {{ number_format($item->quantity * $item->price, 0, ',', '.') }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Shipping Info -->
        <div class="card mb-4">
            <div class="card-header bg-light">
                <h5 class="mb-0">Informasi Pengiriman</h5>
            </div>
            <div class="card-body">
                @if($order->shipment)
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <strong>Penerima</strong>
                            <p>{{ $order->shipment->recipient_name }}</p>
                        </div>
                        <div class="col-md-6 mb-3">
                            <strong>Telepon</strong>
                            <p>{{ $order->shipment->recipient_phone }}</p>
                        </div>
                        <div class="col-md-12 mb-3">
                            <strong>Alamat</strong>
                            <p>{{ $order->shipment->recipient_address }}, {{ $order->shipment->recipient_city }}</p>
                        </div>
                        <div class="col-md-6 mb-3">
                            <strong>Metode Pengiriman</strong>
                            <p>{{ ucfirst($order->shipment->shipping_method) }}</p>
                        </div>
                        <div class="col-md-6 mb-3">
                            <strong>No. Resi</strong>
                            <p>{{ $order->shipment->tracking_number ?? 'Belum tersedia' }}</p>
                        </div>
                    </div>

                    <form method="POST" action="{{ route('admin.orders.updateShipment', $order) }}" class="mt-3">
                        @csrf
                        @method('PUT')

                        <div class="row">
                            <div class="col-md-8 mb-3">
                                <label for="tracking_number" class="form-label">Nomor Resi</label>
                                <input type="text" class="form-control" id="tracking_number" name="tracking_number"
                                       value="{{ old('tracking_number', $order->shipment->tracking_number) }}">
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="shipped_at" class="form-label">Tanggal Kirim</label>
                                <input type="datetime-local" class="form-control" id="shipped_at" name="shipped_at"
                                       value="{{ old('shipped_at', $order->shipment->shipped_at?->format('Y-m-d\TH:i')) }}">
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary btn-sm">
                            <i class="fas fa-save"></i> Update Pengiriman
                        </button>
                    </form>
                @else
                    <p class="text-muted">Data pengiriman belum dibuat</p>
                @endif
            </div>
        </div>

        <!-- Payment Info -->
        @if($order->payment)
            <div class="card mb-4">
                <div class="card-header bg-light">
                    <h5 class="mb-0">Informasi Pembayaran</h5>
                </div>
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <strong>Metode</strong>
                            <p>{{ ucfirst($order->payment->method) === 'Transfer' ? 'Transfer Bank' : 'QRIS' }}</p>
                        </div>
                        <div class="col-md-6">
                            <strong>Jumlah</strong>
                            <p>Rp {{ number_format($order->payment->amount, 0, ',', '.') }}</p>
                        </div>
                    </div>

                    @if($order->payment->method === 'transfer' && $order->payment->proof_image)
                        <div class="mb-3">
                            <strong>Bukti Transfer</strong>
                            <br>
                            <img src="{{ asset('storage/' . $order->payment->proof_image) }}" 
                                 alt="Bukti" class="img-thumbnail" style="max-width: 300px; margin-top: 10px;">
                        </div>
                    @endif

                    <form method="POST" action="{{ route('admin.orders.updatePaymentStatus', $order) }}">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label for="payment_status" class="form-label">Status Pembayaran</label>
                            <select class="form-select" id="payment_status" name="payment_status">
                                <option value="pending" @if($order->payment->status === 'pending') selected @endif>Menunggu</option>
                                <option value="paid" @if($order->payment->status === 'paid') selected @endif>Dibayar</option>
                                <option value="failed" @if($order->payment->status === 'failed') selected @endif>Gagal</option>
                            </select>
                        </div>

                        <button type="submit" class="btn btn-primary btn-sm">
                            <i class="fas fa-save"></i> Update Status
                        </button>
                    </form>
                </div>
            </div>
        @endif
    </div>

    <div class="col-lg-4">
        <!-- Order Summary -->
        <div class="card mb-4">
            <div class="card-header bg-light">
                <h5 class="mb-0">Ringkasan Pesanan</h5>
            </div>
            <div class="card-body">
                <div class="d-flex justify-content-between mb-2">
                    <span>Subtotal</span>
                    <strong>Rp {{ number_format($order->subtotal, 0, ',', '.') }}</strong>
                </div>

                <div class="d-flex justify-content-between mb-3">
                    <span>Pengiriman</span>
                    <strong>Rp {{ number_format($order->shipping_cost, 0, ',', '.') }}</strong>
                </div>

                <hr>

                <div class="d-flex justify-content-between mb-3">
                    <span class="h5">Total</span>
                    <strong class="h5 text-danger">Rp {{ number_format($order->total, 0, ',', '.') }}</strong>
                </div>
            </div>
        </div>

        <!-- Status Management -->
        <div class="card">
            <div class="card-header bg-light">
                <h5 class="mb-0">Manajemen Status</h5>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('admin.orders.updateStatus', $order) }}">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label for="status" class="form-label">Status Pesanan</label>
                        <select class="form-select" id="status" name="status">
                            <option value="pending" @if($order->status === 'pending') selected @endif>Pending</option>
                            <option value="confirmed" @if($order->status === 'confirmed') selected @endif>Dikonfirmasi</option>
                            <option value="shipped" @if($order->status === 'shipped') selected @endif>Dikirim</option>
                            <option value="delivered" @if($order->status === 'delivered') selected @endif>Diterima</option>
                            <option value="cancelled" @if($order->status === 'cancelled') selected @endif>Dibatalkan</option>
                        </select>
                    </div>

                    <button type="submit" class="btn btn-primary w-100">
                        <i class="fas fa-save"></i> Update Status
                    </button>
                </form>

                <hr>

                <div class="alert alert-info small">
                    <i class="fas fa-info-circle"></i>
                    <strong>Status Saat Ini:</strong><br>
                    Pesanan: <span class="badge bg-secondary">{{ ucfirst($order->status) }}</span><br>
                    Pembayaran: <span class="badge bg-warning">{{ ucfirst($order->payment_status) }}</span>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
