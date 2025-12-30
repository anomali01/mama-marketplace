<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1, user-scalable=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Produk Saya - MAMA Marketplace</title>
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
            padding: 16px 20px;
            display: flex;
            align-items: center;
            gap: 16px;
            position: sticky;
            top: 0;
            z-index: 100;
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

        .header-title {
            flex: 1;
            color: white;
            font-size: 18px;
            font-weight: 600;
        }

        .add-btn {
            width: 40px;
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            background: #ff6a00;
            border-radius: 50%;
            text-decoration: none;
            transition: all 0.2s;
        }

        .add-btn:hover {
            background: #e55f00;
            transform: scale(1.05);
        }

        .add-btn svg {
            width: 22px;
            height: 22px;
        }

        /* Main Content */
        .main-content {
            padding: 16px;
        }

        /* Product Item */
        .product-item {
            background: white;
            border-radius: 12px;
            padding: 12px;
            margin-bottom: 12px;
            display: flex;
            gap: 12px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.04);
        }

        .product-image {
            width: 80px;
            height: 80px;
            border-radius: 10px;
            object-fit: cover;
            background: #f0f0f0;
            flex-shrink: 0;
        }

        .product-no-image {
            width: 80px;
            height: 80px;
            border-radius: 10px;
            background: #e0e0e0;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .product-no-image svg {
            width: 32px;
            height: 32px;
            color: #999;
        }

        .product-details {
            flex: 1;
            min-width: 0;
        }

        .product-name {
            font-size: 14px;
            font-weight: 500;
            color: #333;
            margin-bottom: 4px;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        .product-price {
            font-size: 15px;
            font-weight: 700;
            color: #ff6a00;
            margin-bottom: 6px;
        }

        .product-meta {
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .product-status {
            display: inline-block;
            padding: 4px 10px;
            border-radius: 12px;
            font-size: 11px;
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

        .product-stock {
            font-size: 11px;
            color: #666;
        }

        .product-actions {
            display: flex;
            flex-direction: column;
            justify-content: center;
            gap: 8px;
        }

        .action-btn {
            width: 36px;
            height: 36px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 8px;
            text-decoration: none;
            transition: all 0.2s;
            border: none;
            cursor: pointer;
        }

        .action-btn svg {
            width: 18px;
            height: 18px;
        }

        .btn-edit {
            background: #e3f2fd;
            color: #1565c0;
        }

        .btn-edit:hover {
            background: #bbdefb;
        }

        .btn-delete {
            background: #ffebee;
            color: #c62828;
        }

        .btn-delete:hover {
            background: #ffcdd2;
        }

        /* Empty State */
        .empty-state {
            text-align: center;
            padding: 60px 20px;
            color: #999;
        }

        .empty-state svg {
            width: 80px;
            height: 80px;
            margin-bottom: 16px;
            opacity: 0.5;
        }

        .empty-state p {
            font-size: 14px;
            margin-bottom: 20px;
        }

        .btn-add {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 12px 24px;
            background: #ff6a00;
            color: white;
            font-size: 14px;
            font-weight: 600;
            border-radius: 25px;
            text-decoration: none;
            transition: all 0.2s;
        }

        .btn-add:hover {
            background: #e55f00;
        }

        .btn-add svg {
            width: 18px;
            height: 18px;
        }

        /* Pagination */
        .pagination {
            display: flex;
            justify-content: center;
            gap: 8px;
            margin-top: 20px;
        }

        .pagination a, .pagination span {
            padding: 8px 14px;
            border-radius: 8px;
            font-size: 13px;
            text-decoration: none;
            transition: all 0.2s;
        }

        .pagination a {
            background: white;
            color: #333;
        }

        .pagination a:hover {
            background: #ff6a00;
            color: white;
        }

        .pagination .active {
            background: #ff6a00;
            color: white;
        }

        .pagination .disabled {
            background: #f0f0f0;
            color: #999;
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
                margin: 0 auto;
            }

            .product-item {
                padding: 16px;
            }

            .product-image, .product-no-image {
                width: 100px;
                height: 100px;
            }
        }

        @media (min-width: 900px) {
            .main-content {
                max-width: 700px;
            }

            .bottom-nav {
                width: 100%;
                left: 0;
                right: 0;
                transform: none;
                border-radius: 0;
            }
        }

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
        <a href="{{ route('seller.dashboard') }}" class="back-btn">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M19 12H5M12 19l-7-7 7-7"/>
            </svg>
        </a>
        <h1 class="header-title">Produk Saya</h1>
        <a href="{{ route('products.create') }}" class="add-btn">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M12 5v14M5 12h14"/>
            </svg>
        </a>
    </header>

    <!-- Main Content -->
    <main class="main-content">
        @forelse($products as $product)
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
                    <div class="product-price">Rp{{ number_format($product->price, 0, ',', '.') }}</div>
                    <div class="product-meta">
                        @if($product->status === 'pending_verif')
                            <span class="product-status status-pending">Menunggu Verifikasi</span>
                        @elseif($product->status === 'verified')
                            <span class="product-status status-active">Aktif</span>
                        @elseif($product->status === 'rejected')
                            <span class="product-status" style="background: #fee2e2; color: #dc2626; padding: 4px 10px; border-radius: 20px; font-size: 11px;">Ditolak</span>
                        @elseif($product->status === 'sold_out')
                            <span class="product-status status-inactive">Habis</span>
                        @else
                            <span class="product-status status-inactive">Draft</span>
                        @endif
                        <span class="product-stock">Stok: {{ $product->stock }}</span>
                    </div>
                </div>
                
                <div class="product-actions">
                    <a href="{{ route('products.edit', $product->id) }}" class="action-btn btn-edit">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path>
                            <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path>
                        </svg>
                    </a>
                    <form action="{{ route('products.destroy', $product->id) }}" method="POST" onsubmit="return confirm('Hapus produk ini?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="action-btn btn-delete">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <polyline points="3 6 5 6 21 6"></polyline>
                                <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
                            </svg>
                        </button>
                    </form>
                </div>
            </div>
        @empty
            <div class="empty-state">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                    <path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"></path>
                    <polyline points="3.27 6.96 12 12.01 20.73 6.96"></polyline>
                    <line x1="12" y1="22.08" x2="12" y2="12"></line>
                </svg>
                <p>Belum ada produk yang dijual</p>
                <a href="{{ route('products.create') }}" class="btn-add">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M12 5v14M5 12h14"/>
                    </svg>
                    Tambah Produk
                </a>
            </div>
        @endforelse

        @if($products->hasPages())
            <div class="pagination">
                {{ $products->links() }}
            </div>
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
