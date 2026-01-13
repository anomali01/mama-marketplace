@extends('validator.layouts.app')

@php
    $active = 'orders';
@endphp

@section('title', 'Konfirmasi Pembayaran')

@section('content')
<div class="page-header">
    <div>
        <h1 class="page-title">Konfirmasi Pembayaran</h1>
        <p class="page-subtitle">Verifikasi pembayaran dari pembeli</p>
    </div>
</div>

<!-- Tabs -->
<div class="tabs">
    <a href="{{ route('validator.orders', ['status' => 'pending_confirmation']) }}" 
       class="tab {{ $status === 'pending_confirmation' ? 'active' : '' }}">
        Menunggu Konfirmasi
        @if($pendingCount > 0)
            <span class="badge badge-warning">{{ $pendingCount }}</span>
        @endif
    </a>
    <a href="{{ route('validator.orders', ['status' => 'confirmed']) }}" 
       class="tab {{ $status === 'confirmed' ? 'active' : '' }}">
        Sudah Dikonfirmasi
        @if($confirmedCount > 0)
            <span class="badge badge-success">{{ $confirmedCount }}</span>
        @endif
    </a>
</div>

<!-- Orders List -->
<div class="card">
    @if($orders->isEmpty())
        <div class="empty-state">
            <i class="fas fa-money-check-alt"></i>
            <h3>Tidak ada pembayaran</h3>
            <p>{{ $status === 'pending_confirmation' ? 'Belum ada pembayaran yang perlu dikonfirmasi' : 'Belum ada pembayaran yang dikonfirmasi' }}</p>
        </div>
    @else
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th>Kode Order</th>
                        <th>Pembeli</th>
                        <th>Total</th>
                        <th>Tanggal Upload</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($orders as $order)
                        <tr>
                            <td>
                                <strong>{{ $order->order_code }}</strong>
                            </td>
                            <td>
                                <div>{{ $order->buyer->name }}</div>
                                <small class="text-muted">{{ $order->buyer->email }}</small>
                            </td>
                            <td>
                                <strong>Rp{{ number_format($order->total_amount, 0, ',', '.') }}</strong>
                            </td>
                            <td>{{ $order->updated_at->format('d M Y H:i') }}</td>
                            <td>
                                @if($order->payment_status === 'pending_confirmation')
                                    <span class="badge badge-warning">Menunggu</span>
                                @elseif($order->payment_status === 'confirmed')
                                    <span class="badge badge-success">Dikonfirmasi</span>
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('validator.orders.show', $order) }}" class="btn btn-sm btn-primary">
                                    Lihat Detail
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="pagination-wrapper">
            {{ $orders->links() }}
        </div>
    @endif
</div>

<style>
.tabs {
    display: flex;
    gap: 8px;
    margin-bottom: 24px;
    border-bottom: 2px solid #e5e7eb;
}

.tab {
    padding: 12px 24px;
    color: #6b7280;
    text-decoration: none;
    border-bottom: 2px solid transparent;
    margin-bottom: -2px;
    font-weight: 500;
    transition: all 0.3s;
    display: flex;
    align-items: center;
    gap: 8px;
}

.tab:hover {
    color: #3b82f6;
}

.tab.active {
    color: #3b82f6;
    border-bottom-color: #3b82f6;
}

.badge {
    padding: 2px 8px;
    border-radius: 12px;
    font-size: 12px;
    font-weight: 600;
}

.badge-warning {
    background: #fef3c7;
    color: #92400e;
}

.badge-success {
    background: #d1fae5;
    color: #065f46;
}

.table-responsive {
    overflow-x: auto;
}

.table {
    width: 100%;
    border-collapse: collapse;
}

.table thead {
    background: #f9fafb;
}

.table th {
    padding: 12px 16px;
    text-align: left;
    font-weight: 600;
    font-size: 13px;
    color: #6b7280;
    border-bottom: 2px solid #e5e7eb;
}

.table td {
    padding: 16px;
    border-bottom: 1px solid #e5e7eb;
}

.table tbody tr:hover {
    background: #f9fafb;
}

.text-muted {
    color: #6b7280;
    font-size: 13px;
}

.empty-state {
    text-align: center;
    padding: 60px 20px;
    color: #6b7280;
}

.empty-state i {
    font-size: 64px;
    color: #d1d5db;
    margin-bottom: 16px;
}

.empty-state h3 {
    font-size: 18px;
    margin-bottom: 8px;
    color: #374151;
}

.empty-state p {
    font-size: 14px;
}

.btn-sm {
    padding: 6px 12px;
    font-size: 13px;
}

.pagination-wrapper {
    padding: 16px;
    border-top: 1px solid #e5e7eb;
}
</style>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
@endsection
