@extends('validator.layouts.app')

@php
    $active = 'orders';
@endphp

@section('title', 'Detail Pembayaran')

@section('content')
<div class="page-header">
    <div>
        <a href="{{ route('validator.orders') }}" class="btn-back">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>
        <h1 class="page-title">Detail Pembayaran {{ $order->order_code }}</h1>
        <p class="page-subtitle">Verifikasi bukti pembayaran</p>
    </div>
</div>

@if(session('success'))
    <div class="alert alert-success">
        <i class="fas fa-check-circle"></i>
        {{ session('success') }}
    </div>
@endif

<div class="row">
    <!-- Order Info -->
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h3>Informasi Pesanan</h3>
            </div>
            <div class="card-body">
                <div class="info-row">
                    <span class="label">Kode Order:</span>
                    <span class="value">{{ $order->order_code }}</span>
                </div>
                <div class="info-row">
                    <span class="label">Tanggal:</span>
                    <span class="value">{{ $order->created_at->format('d M Y H:i') }}</span>
                </div>
                <div class="info-row">
                    <span class="label">Total Pembayaran:</span>
                    <span class="value" style="color: #10b981; font-weight: 700; font-size: 20px;">
                        Rp{{ number_format($order->total_amount, 0, ',', '.') }}
                    </span>
                </div>
                <div class="info-row">
                    <span class="label">Status Pembayaran:</span>
                    <span class="value">
                        @if($order->payment_status === 'pending_confirmation')
                            <span class="badge badge-warning">Menunggu Konfirmasi</span>
                        @elseif($order->payment_status === 'confirmed')
                            <span class="badge badge-success">Sudah Dikonfirmasi</span>
                        @endif
                    </span>
                </div>
            </div>
        </div>

        <!-- Buyer Info -->
        <div class="card">
            <div class="card-header">
                <h3>Informasi Pembeli</h3>
            </div>
            <div class="card-body">
                <div class="info-row">
                    <span class="label">Nama:</span>
                    <span class="value">{{ $order->buyer->name }}</span>
                </div>
                <div class="info-row">
                    <span class="label">Email:</span>
                    <span class="value">{{ $order->buyer->email }}</span>
                </div>
                <div class="info-row">
                    <span class="label">NIM:</span>
                    <span class="value">{{ $order->buyer->nim ?? '-' }}</span>
                </div>
                <div class="info-row">
                    <span class="label">Prodi:</span>
                    <span class="value">{{ $order->buyer->prodi ?? '-' }}</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Payment Proof -->
    <div class="col-md-6">
        @if($order->payment_proof)
            <div class="card">
                <div class="card-header">
                    <h3>Bukti Pembayaran</h3>
                </div>
                <div class="card-body">
                    <div class="payment-proof-wrapper">
                        <img src="{{ asset('storage/' . $order->payment_proof) }}" 
                             alt="Bukti Pembayaran" 
                             class="payment-proof-image"
                             onclick="window.open(this.src, '_blank')">
                        <p class="hint">Klik gambar untuk memperbesar</p>
                    </div>

                    @if($order->payment_status === 'pending_confirmation')
                        <form action="{{ route('validator.orders.confirm-payment', $order) }}" 
                              method="POST"
                              onsubmit="return confirm('Apakah Anda yakin pembayaran ini valid?')">
                            @csrf
                            <button type="submit" class="btn btn-success btn-block">
                                <i class="fas fa-check-circle"></i>
                                Konfirmasi Pembayaran
                            </button>
                        </form>
                    @else
                        <div class="alert alert-success">
                            <i class="fas fa-check-circle"></i>
                            Pembayaran sudah dikonfirmasi pada {{ $order->confirmed_at?->format('d M Y H:i') }}
                        </div>
                    @endif
                </div>
            </div>
        @else
            <div class="card">
                <div class="card-body">
                    <div class="empty-state">
                        <i class="fas fa-receipt"></i>
                        <h3>Belum ada bukti pembayaran</h3>
                        <p>Pembeli belum upload bukti transfer</p>
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>

<!-- Order Items -->
<div class="card">
    <div class="card-header">
        <h3>Produk yang Dipesan</h3>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th>Produk</th>
                        <th>Penjual</th>
                        <th>Harga</th>
                        <th>Jumlah</th>
                        <th>Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($order->items as $item)
                        <tr>
                            <td>
                                <div class="product-info">
                                    @php
                                        $productImage = null;
                                        if ($item->product->images && is_array($item->product->images) && count($item->product->images) > 0) {
                                            $productImage = asset('storage/' . $item->product->images[0]);
                                        }
                                    @endphp
                                    @if($productImage)
                                        <img src="{{ $productImage }}" alt="{{ $item->product->name }}" class="product-thumb">
                                    @endif
                                    <span>{{ $item->product->name }}</span>
                                </div>
                            </td>
                            <td>{{ $item->product->seller->name }}</td>
                            <td>Rp{{ number_format($item->price_at_order, 0, ',', '.') }}</td>
                            <td>{{ $item->quantity }}</td>
                            <td><strong>Rp{{ number_format($item->price_at_order * $item->quantity, 0, ',', '.') }}</strong></td>
                        </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="4" style="text-align: right; font-weight: 600;">Total:</td>
                        <td style="font-size: 18px; font-weight: 700; color: #10b981;">
                            Rp{{ number_format($order->total_amount, 0, ',', '.') }}
                        </td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>

<style>
.btn-back {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    padding: 8px 16px;
    background: #e5e7eb;
    color: #374151;
    text-decoration: none;
    border-radius: 8px;
    font-size: 14px;
    margin-bottom: 12px;
    transition: all 0.3s;
}

.btn-back:hover {
    background: #d1d5db;
}

.row {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(400px, 1fr));
    gap: 24px;
    margin-bottom: 24px;
}

.card-header {
    padding: 16px 20px;
    border-bottom: 1px solid #e5e7eb;
}

.card-header h3 {
    font-size: 16px;
    font-weight: 600;
    color: #111827;
}

.card-body {
    padding: 20px;
}

.info-row {
    display: flex;
    justify-content: space-between;
    padding: 12px 0;
    border-bottom: 1px solid #f3f4f6;
}

.info-row:last-child {
    border-bottom: none;
}

.info-row .label {
    color: #6b7280;
    font-size: 14px;
}

.info-row .value {
    font-weight: 500;
    color: #111827;
    text-align: right;
}

.badge {
    padding: 4px 12px;
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

.payment-proof-wrapper {
    text-align: center;
}

.payment-proof-image {
    max-width: 100%;
    border-radius: 8px;
    box-shadow: 0 4px 6px rgba(0,0,0,0.1);
    cursor: pointer;
    transition: transform 0.3s;
    margin-bottom: 12px;
}

.payment-proof-image:hover {
    transform: scale(1.02);
}

.hint {
    font-size: 13px;
    color: #6b7280;
    margin-bottom: 20px;
}

.btn-block {
    width: 100%;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    padding: 12px;
    font-size: 15px;
    font-weight: 600;
}

.btn-success {
    background: linear-gradient(135deg, #10b981, #059669);
    color: white;
    border: none;
    border-radius: 8px;
    cursor: pointer;
    transition: all 0.3s;
}

.btn-success:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(16, 185, 129, 0.4);
}

.alert {
    padding: 16px;
    border-radius: 8px;
    margin-bottom: 20px;
    display: flex;
    align-items: center;
    gap: 12px;
}

.alert-success {
    background: #d1fae5;
    color: #065f46;
    border-left: 4px solid #10b981;
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

.table tfoot td {
    border-top: 2px solid #e5e7eb;
    padding-top: 16px;
}

.product-info {
    display: flex;
    align-items: center;
    gap: 12px;
}

.product-thumb {
    width: 50px;
    height: 50px;
    object-fit: cover;
    border-radius: 6px;
}
</style>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
@endsection
