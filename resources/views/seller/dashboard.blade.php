<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1, user-scalable=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Dashboard Penjual - MAMA Marketplace</title>
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

        /* Header */
        .header {
            background: linear-gradient(135deg, #1a9fff 0%, #0080e0 100%);
            padding: 20px 20px 80px;
            position: relative;
        }

        .header-top {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }

        .back-btn {
            width: 40px;
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            text-decoration: none;
            border-radius: 50%;
            transition: background 0.2s;
        }

        .back-btn:hover {
            background: rgba(255, 255, 255, 0.2);
        }

        .back-btn svg {
            width: 24px;
            height: 24px;
        }

        .header-actions {
            display: flex;
            gap: 8px;
        }

        .header-btn {
            width: 40px;
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            background: rgba(255, 255, 255, 0.2);
            border-radius: 50%;
            text-decoration: none;
            transition: background 0.2s;
        }

        .header-btn:hover {
            background: rgba(255, 255, 255, 0.3);
        }

        .header-btn svg {
            width: 22px;
            height: 22px;
        }

        /* Earnings Section */
        .earnings-section {
            text-align: center;
            color: white;
        }

        .earnings-label {
            font-size: 13px;
            opacity: 0.9;
            margin-bottom: 8px;
        }

        .earnings-amount {
            font-size: 36px;
            font-weight: 700;
            margin-bottom: 4px;
        }

        .earnings-info {
            font-size: 11px;
            opacity: 0.8;
        }

        .earnings-buttons {
            display: flex;
            justify-content: center;
            gap: 12px;
            margin-top: 16px;
        }

        .btn-withdraw {
            padding: 10px 24px;
            background: #ff6a00;
            color: white;
            font-size: 13px;
            font-weight: 600;
            border: none;
            border-radius: 20px;
            cursor: pointer;
            transition: all 0.2s;
            text-decoration: none;
        }

        .btn-withdraw:hover {
            background: #e55f00;
        }

        .btn-history {
            padding: 10px 24px;
            background: rgba(255, 255, 255, 0.2);
            color: white;
            font-size: 13px;
            font-weight: 600;
            border: none;
            border-radius: 20px;
            cursor: pointer;
            transition: all 0.2s;
            text-decoration: none;
        }

        .btn-history:hover {
            background: rgba(255, 255, 255, 0.3);
        }

        /* Main Content */
        .main-content {
            padding: 0 16px 16px;
            margin-top: -50px;
            position: relative;
            z-index: 10;
        }

        /* Stats Card */
        .stats-card {
            background: white;
            border-radius: 16px;
            padding: 20px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
            margin-bottom: 16px;
        }

        .stats-title {
            font-size: 14px;
            font-weight: 600;
            color: #333;
            margin-bottom: 16px;
        }

        .stats-grid {
            display: flex;
            justify-content: space-around;
        }

        .stat-item {
            text-align: center;
            flex: 1;
            padding: 8px;
        }

        .stat-number {
            font-size: 32px;
            font-weight: 700;
            color: #333;
            margin-bottom: 4px;
        }

        .stat-label {
            font-size: 12px;
            color: #666;
        }

        .stat-divider {
            width: 1px;
            background: #e0e0e0;
        }

        /* Add Product Button */
        .btn-add-product {
            width: 100%;
            padding: 14px;
            background: linear-gradient(135deg, #ff6a00 0%, #ff8533 100%);
            color: white;
            font-size: 14px;
            font-weight: 600;
            border: none;
            border-radius: 12px;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            transition: all 0.2s;
            text-decoration: none;
            box-shadow: 0 4px 15px rgba(255, 106, 0, 0.3);
            margin-top: 16px;
        }

        .btn-add-product:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(255, 106, 0, 0.4);
        }

        .btn-add-product svg {
            width: 20px;
            height: 20px;
        }

        /* Products Section */
        .section {
            background: white;
            border-radius: 16px;
            padding: 16px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.04);
            margin-bottom: 16px;
        }

        .section-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 16px;
        }

        .section-title {
            font-size: 14px;
            font-weight: 600;
            color: #333;
        }

        .section-link {
            font-size: 12px;
            color: #1a9fff;
            text-decoration: none;
        }

        /* Product Item */
        .product-item {
            display: flex;
            gap: 12px;
            padding: 12px 0;
            border-bottom: 1px solid #f0f0f0;
        }

        .product-item:last-child {
            border-bottom: none;
            padding-bottom: 0;
        }

        .product-item:first-child {
            padding-top: 0;
        }

        .product-image {
            width: 70px;
            height: 70px;
            border-radius: 10px;
            object-fit: cover;
            background: #f0f0f0;
            flex-shrink: 0;
        }

        .product-no-image {
            width: 70px;
            height: 70px;
            border-radius: 10px;
            background: #e0e0e0;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .product-no-image svg {
            width: 28px;
            height: 28px;
            color: #999;
        }

        .product-details {
            flex: 1;
            min-width: 0;
        }

        .product-name {
            font-size: 13px;
            font-weight: 500;
            color: #333;
            margin-bottom: 4px;
            display: -webkit-box;
            -webkit-line-clamp: 1;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        .product-prices {
            display: flex;
            flex-direction: column;
            gap: 2px;
            font-size: 11px;
            color: #666;
            margin-bottom: 4px;
        }

        .product-price-original {
            text-decoration: line-through;
            color: #999;
        }

        .product-price-selling {
            color: #333;
        }

        .product-status {
            display: inline-block;
            padding: 4px 10px;
            border-radius: 12px;
            font-size: 10px;
            font-weight: 600;
        }

        .status-pending {
            background: #fff3e0;
            color: #ef6c00;
        }

        .status-active {
            background: #e8f5e9;
            color: #2e7d32;
        }

        .status-inactive {
            background: #ffebee;
            color: #c62828;
        }

        .status-sold {
            background: #e3f2fd;
            color: #1565c0;
        }

        /* Empty State */
        .empty-state {
            text-align: center;
            padding: 40px 20px;
            color: #999;
        }

        .empty-state svg {
            width: 60px;
            height: 60px;
            margin-bottom: 12px;
            opacity: 0.5;
        }

        .empty-state p {
            font-size: 13px;
        }

        /* Success Message */
        .success-message {
            background: #d4edda;
            color: #155724;
            padding: 12px 16px;
            border-radius: 12px;
            font-size: 13px;
            margin-bottom: 16px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .success-message svg {
            width: 20px;
            height: 20px;
            flex-shrink: 0;
        }

        /* Verification Badge */
        .verification-badge {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 11px;
            font-weight: 500;
            margin-top: 8px;
        }

        .badge-verified {
            background: rgba(255, 255, 255, 0.2);
            color: white;
        }

        .badge-pending {
            background: #fff3e0;
            color: #ef6c00;
        }

        .verification-badge svg {
            width: 14px;
            height: 14px;
        }

        /* Bottom Navigation */
        .bottom-nav {
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            width: 100%;
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

        /* Responsive */
        @media (min-width: 600px) {
            .main-content {
                max-width: 600px;
                margin-left: auto;
                margin-right: auto;
            }

            .header {
                padding: 24px 40px 80px;
            }

            .header-top {
                max-width: 600px;
                margin: 0 auto 20px;
            }

            .earnings-section {
                max-width: 600px;
                margin: 0 auto;
            }
        }

        @media (min-width: 900px) {
            .main-content {
                max-width: 700px;
            }

            .header-top {
                max-width: 700px;
            }

            .earnings-section {
                max-width: 700px;
            }

            .bottom-nav {
                width: 100%;
                left: 0;
                right: 0;
                transform: none;
                border-radius: 0;
            }

            .stat-number {
                font-size: 36px;
            }
        }

        /* Safe area for iOS */
        @supports (padding-bottom: env(safe-area-inset-bottom)) {
            body {
                padding-bottom: calc(80px + env(safe-area-inset-bottom));
            }
            
            .bottom-nav {
                padding-bottom: calc(8px + env(safe-area-inset-bottom));
            }
        }
    </style>
</head>
<body>
    <!-- Header -->
    <header class="header">
        <div class="header-top">
            <a href="{{ route('profile.edit') }}" class="back-btn">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M19 12H5M12 19l-7-7 7-7"/>
                </svg>
            </a>
            <div class="header-actions">
                <a href="{{ route('notifications.index') }}" class="header-btn" title="Notifikasi">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"></path>
                        <path d="M13.73 21a2 2 0 0 1-3.46 0"></path>
                    </svg>
                </a>
                <a href="{{ route('seller.edit-shop') }}" class="header-btn" title="Edit Data Toko">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path>
                        <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path>
                    </svg>
                </a>
            </div>
        </div>

        <!-- Earnings Section -->
        <div class="earnings-section">
            <p class="earnings-label">Saldo Penghasilan Anda</p>
            <h1 class="earnings-amount">Rp{{ number_format($totalEarnings ?? 0, 0, ',', '.') }}</h1>
            <p class="earnings-info">Siap untuk ditarik</p>
            
            @if($user->verified)
                <span class="verification-badge badge-verified">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path>
                        <polyline points="22 4 12 14.01 9 11.01"></polyline>
                    </svg>
                    Terverifikasi
                </span>
            @else
                <span class="verification-badge badge-pending">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <circle cx="12" cy="12" r="10"></circle>
                        <polyline points="12 6 12 12 16 14"></polyline>
                    </svg>
                    Menunggu Verifikasi
                </span>
            @endif
            
            <div class="earnings-buttons">
                <a href="#" class="btn-withdraw">Tarik Dana</a>
                <a href="#" class="btn-history">Lihat Riwayat</a>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main class="main-content">
        @if(session('success'))
            <div class="success-message">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path>
                    <polyline points="22 4 12 14.01 9 11.01"></polyline>
                </svg>
                {{ session('success') }}
            </div>
        @endif

        <!-- Stats Card -->
        <div class="stats-card">
            <h2 class="stats-title">Tampung produk</h2>
            <div class="stats-grid">
                <div class="stat-item">
                    <div class="stat-number">{{ $productCounts['pending'] ?? 0 }}</div>
                    <div class="stat-label">Menunggu</div>
                </div>
                <div class="stat-divider"></div>
                <div class="stat-item">
                    <div class="stat-number">{{ $productCounts['active'] ?? 0 }}</div>
                    <div class="stat-label">Aktif Jual</div>
                </div>
                <div class="stat-divider"></div>
                <div class="stat-item">
                    <div class="stat-number">{{ $productCounts['sold'] ?? 0 }}</div>
                    <div class="stat-label">Terjual</div>
                </div>
            </div>

            <a href="{{ route('products.create') }}" class="btn-add-product">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M12 5v14M5 12h14"/>
                </svg>
                Tambahkan Produk +
            </a>
        </div>

        <!-- Products List -->
        <div class="section">
            <div class="section-header">
                <h2 class="section-title">Kelola produk</h2>
                <a href="{{ route('seller.products') }}" class="section-link">Lihat Semua</a>
            </div>

            @forelse($products->take(5) as $product)
                <div class="product-item">
                    @php
                        $productImage = null;
                        if ($product->images && is_array($product->images) && count($product->images) > 0) {
                            $productImage = asset('storage/' . $product->images[0]);
                        }
                    @endphp
                    
                    @if($productImage)
                        <img src="{{ $productImage }}" alt="{{ $product->name }}" class="product-image">
                    @else
                        <div class="product-no-image">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                                <rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect>
                                <circle cx="8.5" cy="8.5" r="1.5"></circle>
                                <polyline points="21 15 16 10 5 21"></polyline>
                            </svg>
                        </div>
                    @endif
                    
                    <div class="product-details">
                        <h3 class="product-name">{{ $product->name }}</h3>
                        <div class="product-prices">
                            <span class="product-price-original">Harga asli : Rp{{ number_format($product->price * 1.2, 0, ',', '.') }}</span>
                            <span class="product-price-selling">Harga jual : Rp{{ number_format($product->price, 0, ',', '.') }}</span>
                        </div>
                        @if($product->status === 'pending_verif')
                            <span class="product-status status-pending">Menunggu Verifikasi</span>
                        @elseif($product->status === 'verified')
                            <span class="product-status status-active">Dijual</span>
                        @elseif($product->status === 'rejected')
                            <span class="product-status status-rejected" style="background: #fee2e2; color: #dc2626;">Ditolak</span>
                        @elseif($product->status === 'sold_out')
                            <span class="product-status status-sold">Habis</span>
                        @else
                            <span class="product-status status-inactive">Draft</span>
                        @endif
                    </div>
                </div>
            @empty
                <div class="empty-state">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                        <path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"></path>
                    </svg>
                    <p>Belum ada produk. Mulai jual sekarang!</p>
                </div>
            @endforelse
        </div>
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
        <a href="{{ route('orders.index') }}" class="nav-item">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <rect x="1" y="4" width="22" height="16" rx="2" ry="2"></rect>
                <line x1="1" y1="10" x2="23" y2="10"></line>
            </svg>
            <span>Pesanan</span>
        </a>
        <a href="{{ route('profile.edit') }}" class="nav-item active">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                <circle cx="12" cy="7" r="4"></circle>
            </svg>
            <span>Profil</span>
        </a>
    </nav>
</body>
</html>
