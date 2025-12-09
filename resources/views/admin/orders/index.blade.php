@extends('admin.layout')

@section('title', 'Kelola Pesanan')

@section('content')
<h1 class="mb-4"><i class="fas fa-shopping-bag"></i> Kelola Pesanan</h1>

<div class="card">
    <div class="table-responsive">
        <table class="table table-hover mb-0">
            <thead class="table-light">
                <tr>
                    <th>No. Pesanan</th>
                    <th>Pelanggan</th>
                    <th>Total</th>
                    <th>Status</th>
                    <th>Pembayaran</th>
                    <th>Tanggal</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($orders as $order)
                    <tr>
                        <td>
                            <a href="{{ route('admin.orders.show', $order) }}">
                                <strong>{{ $order->order_number }}</strong>
                            </a>
                        </td>
                        <td>
                            {{ $order->user->name }}<br>
                            <small class="text-muted">{{ $order->user->email }}</small>
                        </td>
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
                        <td>{{ $order->created_at->format('d M Y H:i') }}</td>
                        <td>
                            <a href="{{ route('admin.orders.show', $order) }}" class="btn btn-sm btn-primary">
                                <i class="fas fa-eye"></i> Lihat
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center text-muted py-4">
                            <i class="fas fa-inbox fa-2x mb-2"></i>
                            <p>Belum ada pesanan</p>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@if($orders->hasPages())
    <nav class="mt-4">
        {{ $orders->links() }}
    </nav>
@endif
@endsection
