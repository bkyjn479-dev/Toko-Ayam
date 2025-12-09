@extends('layout')

@section('title', 'Detail Pesanan - ' . $order->order_number)

@section('content')
<nav aria-label="breadcrumb" class="mb-4">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('orders.index') }}">Pesanan Saya</a></li>
        <li class="breadcrumb-item active">{{ $order->order_number }}</li>
    </ol>
</nav>

<h2 class="mb-4">{{ $order->order_number }}</h2>

<div class="row">
    <div class="col-lg-8">
        <!-- Status Timeline -->
        <div class="card mb-4">
            <div class="card-body">
                <h5 class="mb-3">Status Pesanan</h5>
                
                <div class="row">
                    @foreach(['pending' => 'Pending', 'confirmed' => 'Dikonfirmasi', 'shipped' => 'Dikirim', 'delivered' => 'Diterima'] as $status => $label)
                        <div class="col-md-6 col-lg-3 text-center mb-3">
                            <div class="p-3 rounded @if(in_array($order->status, array_keys(array_slice(['pending' => 'Pending', 'confirmed' => 'Dikonfirmasi', 'shipped' => 'Dikirim', 'delivered' => 'Diterima'], 0, array_search($status, array_keys(['pending' => 'Pending', 'confirmed' => 'Dikonfirmasi', 'shipped' => 'Dikirim', 'delivered' => 'Diterima'])) + 1)))) bg-success bg-opacity-10 @else bg-light @endif">
                                <i class="fas @switch($status)
                                    @case('pending') fa-clock @break
                                    @case('confirmed') fa-check @break
                                    @case('shipped') fa-truck @break
                                    @case('delivered') fa-box-open @break
                                @endswitch fa-lg mb-2"></i>
                                <p class="mb-0"><small>{{ $label }}</small></p>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Items -->
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
        @if($shipment)
            <div class="card mb-4">
                <div class="card-header bg-light">
                    <h5 class="mb-0">Info Pengiriman</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <strong>Penerima</strong>
                            <p>{{ $shipment->recipient_name }}</p>
                        </div>
                        <div class="col-md-6 mb-3">
                            <strong>Telepon</strong>
                            <p>{{ $shipment->recipient_phone }}</p>
                        </div>
                        <div class="col-md-6 mb-3">
                            <strong>Alamat</strong>
                            <p>{{ $shipment->recipient_address }}</p>
                        </div>
                        <div class="col-md-6 mb-3">
                            <strong>Kota</strong>
                            <p>{{ $shipment->recipient_city }}</p>
                        </div>
                        @if($shipment->tracking_number)
                            <div class="col-md-6 mb-3">
                                <strong>No. Resi</strong>
                                <p><code>{{ $shipment->tracking_number }}</code></p>
                            </div>
                        @endif
                        <div class="col-md-6 mb-3">
                            <strong>Metode Pengiriman</strong>
                            <p>{{ ucfirst($shipment->shipping_method) }}</p>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        <!-- Payment Info -->
        @if($payment)
            <div class="card">
                <div class="card-header bg-light">
                    <h5 class="mb-0">Info Pembayaran</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <strong>Metode</strong>
                            <p>{{ ucfirst($payment->method) === 'Transfer' ? 'Transfer Bank' : 'QRIS' }}</p>
                        </div>
                        <div class="col-md-6 mb-3">
                            <strong>Status</strong>
                            <p>
                                @if($payment->status === 'pending')
                                    <span class="badge bg-warning">Menunggu</span>
                                @elseif($payment->status === 'paid')
                                    <span class="badge bg-success">Dibayar</span>
                                @else
                                    <span class="badge bg-danger">Gagal</span>
                                @endif
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>

    <div class="col-lg-4">
        <div class="card sticky-top" style="top: 80px;">
            <div class="card-header bg-light">
                <h5 class="mb-0">Ringkasan Pembayaran</h5>
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

                <hr>

                <div class="mb-3">
                    <small><strong>Status Pesanan</strong></small>
                    <div>
                        @switch($order->status)
                            @case('pending')
                                <span class="badge bg-secondary">Pending</span>
                                @break
                            @case('confirmed')
                                <span class="badge bg-info">Dikonfirmasi</span>
                                @break
                            @case('shipped')
                                <span class="badge bg-primary">Dikirim</span>
                                @break
                            @case('delivered')
                                <span class="badge bg-success">Diterima</span>
                                @break
                            @case('cancelled')
                                <span class="badge bg-danger">Dibatalkan</span>
                                @break
                        @endswitch
                    </div>
                </div>

                <div>
                    <small><strong>Status Pembayaran</strong></small>
                    <div>
                        @switch($order->payment_status)
                            @case('pending')
                                <span class="badge bg-warning">Menunggu</span>
                                @break
                            @case('paid')
                                <span class="badge bg-success">Dibayar</span>
                                @break
                            @case('failed')
                                <span class="badge bg-danger">Gagal</span>
                                @break
                        @endswitch
                    </div>
                </div>

                @if($order->payment_status === 'pending')
                    <a href="{{ route('checkout.payment', $order) }}" class="btn btn-primary btn-sm w-100 mt-3">
                        <i class="fas fa-credit-card"></i> Lanjut Bayar
                    </a>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
