<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1, user-scalable=no">
    <title>Pesanan Saya - MAMA Marketplace</title>
    <link rel="icon" type="image/png" href="{{ asset('img/logo-mama.png') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        html {
            font-family: 'Poppins', -apple-system, BlinkMacSystemFont, sans-serif;
        }

        body {
            background: #f5f5f5;
            min-height: 100vh;
            padding-bottom: 80px;
        }

        .header {
            background: linear-gradient(135deg, #1a9fff 0%, #0080e0 100%);
            padding: 16px 20px;
            display: flex;
            align-items: center;
            gap: 16px;
            position: sticky;
            top: 0;
            z-index: 100;
        }

        .back-btn {
            color: white;
            text-decoration: none;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .back-btn svg {
            width: 24px;
            height: 24px;
        }

        .header-title {
            color: white;
            font-size: 16px;
            font-weight: 600;
            flex: 1;
        }

        .main-content {
            max-width: 800px;
            margin: 0 auto;
            padding: 16px;
        }

        .empty-state {
            text-align: center;
            padding: 60px 20px;
        }

        .empty-icon {
            width: 80px;
            height: 80px;
            margin: 0 auto 16px;
            opacity: 0.3;
        }

        .empty-text {
            font-size: 16px;
            color: #999;
            margin-bottom: 20px;
        }

        /* Order Card */
        .order-card {
            background: white;
            border-radius: 12px;
            margin-bottom: 12px;
            overflow: hidden;
            text-decoration: none;
            display: block;
            transition: transform 0.2s;
        }

        .order-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        .order-header {
            padding: 12px 16px;
            background: #f9f9f9;
            border-bottom: 1px solid #e0e0e0;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .order-code {
            font-size: 13px;
            font-weight: 600;
            color: #333;
        }

        .order-date {
            font-size: 12px;
            color: #999;
        }

        .order-body {
            padding: 16px;
        }

        .product-item {
            display: flex;
            gap: 12px;
            margin-bottom: 12px;
        }

        .product-item:last-child {
            margin-bottom: 0;
        }

        .product-image {
            width: 60px;
            height: 60px;
            border-radius: 8px;
            object-fit: cover;
            background: #e0e0e0;
        }

        .product-details {
            flex: 1;
        }

        .product-name {
            font-size: 14px;
            font-weight: 600;
            color: #333;
            margin-bottom: 4px;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        .product-meta {
            font-size: 12px;
            color: #999;
        }

        .order-footer {
            padding: 12px 16px;
            border-top: 1px solid #f0f0f0;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .order-total {
            font-size: 14px;
        }

        .total-label {
            color: #666;
        }

        .total-amount {
            font-weight: 700;
            color: #ff6a00;
            font-size: 16px;
        }

        .status-badge {
            display: inline-block;
            padding: 6px 12px;
            border-radius: 12px;
            font-size: 12px;
            font-weight: 600;
        }

        .status-pending {
            background: #fff3e0;
            color: #ef6c00;
        }

        .status-paid {
            background: #e3f2fd;
            color: #1565c0;
        }

        .status-packed {
            background: #f3e5f5;
            color: #7b1fa2;
        }

        .status-shipped {
            background: #e1f5fe;
            color: #0277bd;
        }

        .status-delivered {
            background: #e8f5e9;
            color: #2e7d32;
        }

        .status-cancelled {
            background: #ffebee;
            color: #c62828;
        }

        /* Tabs */
        .tabs {
            display: flex;
            background: white;
            border-radius: 12px;
            padding: 8px;
            margin-bottom: 16px;
            gap: 8px;
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
        }

        .tab {
            flex: 1;
            min-width: fit-content;
            padding: 10px 16px;
            border-radius: 8px;
            font-size: 13px;
            font-weight: 600;
            text-align: center;
            background: transparent;
            color: #666;
            border: none;
            cursor: pointer;
            transition: all 0.2s;
            text-decoration: none;
            white-space: nowrap;
        }

        .tab.active {
            background: linear-gradient(135deg, #1a9fff 0%, #0080e0 100%);
            color: white;
        }

        .btn {
            display: inline-block;
            padding: 12px 24px;
            border-radius: 8px;
            font-size: 14px;
            font-weight: 600;
            text-align: center;
            cursor: pointer;
            border: none;
            transition: all 0.2s;
            text-decoration: none;
        }

        .btn-primary {
            background: linear-gradient(135deg, #0080e0 0%, #1a9fff 100%);
            color: white;
        }

        /* Bottom Navigation */
        .bottom-nav {
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            background: white;
            display: flex;
            justify-content: space-around;
            padding: 8px 0;
            box-shadow: 0 -2px 10px rgba(0, 0, 0, 0.1);
            z-index: 100;
        }

        .nav-item {
            display: flex;
            flex-direction: column;
            align-items: center;
            text-decoration: none;
            color: #999;
            font-size: 11px;
            padding: 4px 12px;
            transition: color 0.2s;
        }

        .nav-item svg {
            width: 24px;
            height: 24px;
            margin-bottom: 4px;
        }

        .nav-item.active {
            color: #ff6a00;
        }

        .nav-item:hover {
            color: #ff6a00;
        }
    </style>
</head>
<body>
    <header class="header">
        <a href="{{ route('home') }}" class="back-btn">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M19 12H5M12 19l-7-7 7-7"/>
            </svg>
        </a>
        <h1 class="header-title">Pesanan Saya</h1>
    </header>

    <main class="main-content">
        <div class="tabs">
            <a href="?status=all" class="tab {{ (!request('status') || request('status') == 'all') ? 'active' : '' }}">Semua</a>
            <a href="?status=pending" class="tab {{ request('status') == 'pending' ? 'active' : '' }}">Menunggu</a>
            <a href="?status=paid" class="tab {{ request('status') == 'paid' ? 'active' : '' }}">Dibayar</a>
            <a href="?status=packed" class="tab {{ request('status') == 'packed' ? 'active' : '' }}">Dikemas</a>
            <a href="?status=shipped" class="tab {{ request('status') == 'shipped' ? 'active' : '' }}">Dikirim</a>
            <a href="?status=delivered" class="tab {{ request('status') == 'delivered' ? 'active' : '' }}">Selesai</a>
        </div>

        @if($orders->count() === 0)
            <div class="empty-state">
                <svg class="empty-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <rect x="1" y="4" width="22" height="16" rx="2" ry="2"></rect>
                    <line x1="1" y1="10" x2="23" y2="10"></line>
                </svg>
                <p class="empty-text">Belum ada pesanan</p>
                <a href="{{ route('home') }}" class="btn btn-primary">Mulai Belanja</a>
            </div>
        @else
            @foreach($orders as $order)
                <a href="{{ route('orders.show', $order) }}" class="order-card">
                    <div class="order-header">
                        <span class="order-code">{{ $order->order_code }}</span>
                        <span class="order-date">{{ $order->created_at->format('d M Y') }}</span>
                    </div>
                    
                    <div class="order-body">
                        @foreach($order->items->take(2) as $item)
                            <div class="product-item">
                                @php
                                    $productImage = null;
                                    if ($item->product->images && is_array($item->product->images) && count($item->product->images) > 0) {
                                        $productImage = asset('storage/' . $item->product->images[0]);
                                    }
                                @endphp
                                @if($productImage)
                                    <img src="{{ $productImage }}" alt="{{ $item->product->name }}" class="product-image">
                                @else
                                    <div class="product-image"></div>
                                @endif
                                <div class="product-details">
                                    <div class="product-name">{{ $item->product->name }}</div>
                                    <div class="product-meta">{{ $item->quantity }} x Rp{{ number_format($item->price_at_order, 0, ',', '.') }}</div>
                                </div>
                            </div>
                        @endforeach
                        
                        @if($order->items->count() > 2)
                            <div style="font-size: 12px; color: #999; margin-top: 8px;">
                                +{{ $order->items->count() - 2 }} produk lainnya
                            </div>
                        @endif
                    </div>
                    
                    <div class="order-footer">
                        <div class="order-total">
                            <span class="total-label">Total: </span>
                            <span class="total-amount">Rp{{ number_format($order->total_amount, 0, ',', '.') }}</span>
                        </div>
                        <span class="status-badge status-{{ $order->status }}">
                            @if($order->status === 'pending')
                                @if($order->payment_method === 'transfer' && !$order->payment_proof)
                                    Bayar Sekarang
                                @elseif($order->payment_status === 'pending_confirmation')
                                    Menunggu Konfirmasi
                                @else
                                    Diproses
                                @endif
                            @elseif($order->status === 'paid')
                                Dibayar
                            @elseif($order->status === 'packed')
                                Dikemas
                            @elseif($order->status === 'shipped')
                                Dikirim
                            @elseif($order->status === 'delivered')
                                Selesai
                            @else
                                {{ ucfirst($order->status) }}
                            @endif
                        </span>
                    </div>
                </a>
            @endforeach

            @if($orders->hasPages())
                <div style="margin-top: 20px;">
                    {{ $orders->links() }}
                </div>
            @endif
        @endif
    </main>

    <!-- Bottom Navigation -->
    <nav class="bottom-nav">
        <a href="{{ route('home') }}" class="nav-item">
            <svg viewBox="0 0 24 24" fill="currentColor">
                <path d="M10 20v-6h4v6h5v-8h3L12 3 2 12h3v8z"/>
            </svg>
            <span>Beranda</span>
        </a>
        <a href="{{ route('trending') }}" class="nav-item">
            <svg viewBox="0 0 24 24" fill="currentColor">
                <path d="M16 6l2.29 2.29-4.88 4.88-4-4L2 16.59 3.41 18l6-6 4 4 6.3-6.29L22 12V6z"/>
            </svg>
            <span>Trending</span>
        </a>
        <a href="{{ route('orders.index') }}" class="nav-item active">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <rect x="1" y="4" width="22" height="16" rx="2" ry="2"></rect>
                <line x1="1" y1="10" x2="23" y2="10"></line>
            </svg>
            <span>Pesanan</span>
        </a>
        <a href="{{ route('profile.edit') }}" class="nav-item">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                <circle cx="12" cy="7" r="4"></circle>
            </svg>
            <span>Profil</span>
        </a>
    </nav>
</body>
</html>
