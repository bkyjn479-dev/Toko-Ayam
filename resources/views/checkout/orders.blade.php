@extends('layout')

@section('title', 'Pesanan Saya')

@section('content')
<h2 class="mb-4"><i class="fas fa-list"></i> Pesanan Saya</h2>

@if($orders->isEmpty())
    <div class="alert alert-info text-center">
        <i class="fas fa-inbox"></i> Anda belum memiliki pesanan.
        <a href="{{ route('shop.index') }}">Mulai berbelanja sekarang</a>
    </div>
@else
    <div class="table-responsive">
        <table class="table table-hover">
            <thead class="table-light">
                <tr>
                    <th>No. Pesanan</th>
                    <th>Tanggal</th>
                    <th>Total</th>
                    <th>Status Pesanan</th>
                    <th>Status Pembayaran</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($orders as $order)
                    <tr>
                        <td>
                            <a href="{{ route('orders.detail', $order) }}">
                                <strong>{{ $order->order_number }}</strong>
                            </a>
                        </td>
                        <td>{{ $order->created_at->format('d M Y H:i') }}</td>
                        <td>
                            <strong>Rp {{ number_format($order->total, 0, ',', '.') }}</strong>
                        </td>
                        <td>
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
                        </td>
                        <td>
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
                        </td>
                        <td>
                            <a href="{{ route('orders.detail', $order) }}" class="btn btn-sm btn-primary">
                                <i class="fas fa-eye"></i> Lihat
                            </a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    @if($orders->hasPages())
        <nav class="mt-4">
            {{ $orders->links() }}
        </nav>
    @endif
@endif
@endsection
