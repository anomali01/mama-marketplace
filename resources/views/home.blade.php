<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1, user-scalable=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>MAMA - Marketplace Mahasiswa</title>
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
            padding: 16px 16px 20px;
            position: sticky;
            top: 0;
            z-index: 100;
        }

        .header-top {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 12px;
        }

        .search-bar {
            flex: 1;
            display: flex;
            align-items: center;
            background: white;
            border-radius: 25px;
            padding: 10px 16px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }

        .search-bar input {
            flex: 1;
            border: none;
            outline: none;
            font-size: 14px;
            color: #333;
            background: transparent;
        }

        .search-bar input::placeholder {
            color: #999;
        }

        .search-icon {
            color: #999;
            margin-right: 8px;
        }

        .header-icons {
            display: flex;
            gap: 8px;
        }

        .icon-btn {
            width: 40px;
            height: 40px;
            background: rgba(255, 255, 255, 0.2);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            text-decoration: none;
            transition: background 0.2s;
            position: relative;
        }

        .icon-btn:hover {
            background: rgba(255, 255, 255, 0.3);
        }

        .icon-btn svg {
            width: 22px;
            height: 22px;
        }

        .badge {
            position: absolute;
            top: -2px;
            right: -2px;
            background: #ff4444;
            color: white;
            font-size: 10px;
            font-weight: 600;
            padding: 2px 6px;
            border-radius: 10px;
            min-width: 18px;
            text-align: center;
        }

        /* Categories */
        .categories {
            display: flex;
            gap: 8px;
            overflow-x: auto;
            padding: 4px 0;
            scrollbar-width: none;
            -ms-overflow-style: none;
        }

        .categories::-webkit-scrollbar {
            display: none;
        }

        .category-btn {
            flex-shrink: 0;
            padding: 8px 16px;
            background: rgba(255, 255, 255, 0.2);
            color: white;
            border: none;
            border-radius: 20px;
            font-size: 13px;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.2s;
            white-space: nowrap;
        }

        .category-btn:hover,
        .category-btn.active {
            background: white;
            color: #1a9fff;
        }

        /* Main Content */
        .main-content {
            padding: 16px;
        }

        /* Trending Section */
        .trending-section {
            margin-bottom: 24px;
        }

        .section-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 16px;
        }

        .section-title {
            font-size: 18px;
            font-weight: 600;
            color: #333;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .trending-icon {
            color: #ff6b35;
            animation: pulse 2s ease-in-out infinite;
        }

        @keyframes pulse {
            0%, 100% { transform: scale(1); }
            50% { transform: scale(1.1); }
        }

        .see-all {
            font-size: 13px;
            color: #1a9fff;
            text-decoration: none;
            font-weight: 500;
        }

        .trending-scroll {
            display: flex;
            gap: 12px;
            overflow-x: auto;
            padding-bottom: 8px;
            scrollbar-width: none;
            -ms-overflow-style: none;
        }

        .trending-scroll::-webkit-scrollbar {
            display: none;
        }

        .trending-card {
            flex-shrink: 0;
            width: 140px;
            background: white;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.06);
            text-decoration: none;
            color: inherit;
            transition: transform 0.2s;
            position: relative;
        }

        .trending-card:hover {
            transform: translateY(-4px);
        }

        .trending-badge {
            position: absolute;
            top: 8px;
            left: 8px;
            background: linear-gradient(135deg, #ff6b35, #f7931e);
            color: white;
            font-size: 10px;
            font-weight: 600;
            padding: 4px 8px;
            border-radius: 12px;
            z-index: 1;
            display: flex;
            align-items: center;
            gap: 4px;
        }

        .trending-card .product-image {
            width: 100%;
            height: 140px;
            object-fit: cover;
        }

        .trending-card .product-info {
            padding: 10px;
        }

        .trending-card .product-title {
            font-size: 12px;
            margin-bottom: 4px;
            -webkit-line-clamp: 2;
        }

        .trending-card .product-price {
            font-size: 13px;
        }

        /* Products Grid */
        .products-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 12px;
        }

        /* Product Card */
        .product-card {
            background: white;
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.06);
            transition: transform 0.2s, box-shadow 0.2s;
            text-decoration: none;
            color: inherit;
            display: block;
        }

        .product-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
        }

        .product-image {
            width: 100%;
            aspect-ratio: 1;
            object-fit: cover;
            background: #f0f0f0;
        }

        .product-info {
            padding: 12px;
        }

        .product-title {
            font-size: 13px;
            font-weight: 500;
            color: #333;
            margin-bottom: 6px;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
            line-height: 1.4;
        }

        .product-meta {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 6px;
        }

        .product-rating {
            display: flex;
            align-items: center;
            gap: 4px;
            font-size: 12px;
            color: #666;
        }

        .star-icon {
            color: #ffc107;
            font-size: 14px;
        }

        .product-sold {
            font-size: 11px;
            color: #999;
        }

        .product-seller {
            font-size: 10px;
            color: #666;
            margin-bottom: 4px;
            display: flex;
            align-items: center;
            gap: 4px;
        }

        .seller-prodi {
            color: #1a9fff;
            font-weight: 500;
        }

        .product-price {
            font-size: 15px;
            font-weight: 700;
            color: #ff6a00;
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

        .nav-item {
            position: relative;
        }

        .nav-badge {
            position: absolute;
            top: 0;
            right: 4px;
            background: #ff3b30;
            color: white;
            font-size: 10px;
            padding: 2px 5px;
            border-radius: 10px;
            font-weight: 600;
            min-width: 16px;
            text-align: center;
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
        }

        /* Loading */
        .loading {
            display: flex;
            justify-content: center;
            padding: 40px;
        }

        .spinner {
            width: 40px;
            height: 40px;
            border: 3px solid #f0f0f0;
            border-top-color: #1a9fff;
            border-radius: 50%;
            animation: spin 0.8s linear infinite;
        }

        @keyframes spin {
            to { transform: rotate(360deg); }
        }

        /* Responsive - Tablet */
        @media (min-width: 600px) {
            .products-grid {
                grid-template-columns: repeat(3, 1fr);
                gap: 16px;
            }

            .main-content {
                padding: 20px;
            }

            .product-title {
                font-size: 14px;
            }

            .product-price {
                font-size: 16px;
            }

            .trending-card {
                width: 160px;
            }

            .trending-card .product-image {
                height: 160px;
            }
        }

        /* Responsive - Desktop */
        @media (min-width: 900px) {
            .header {
                padding: 16px 40px 20px;
            }

            .main-content {
                max-width: 1200px;
                margin: 0 auto;
                padding: 24px 40px;
            }

            .products-grid {
                grid-template-columns: repeat(4, 1fr);
                gap: 20px;
            }

            .trending-scroll {
                gap: 16px;
            }

            .trending-card {
                width: 180px;
            }

            .trending-card .product-image {
                height: 180px;
            }

            .bottom-nav {
                width: 100%;
                left: 0;
                right: 0;
                transform: none;
                border-radius: 0;
            }

            .product-info {
                padding: 14px;
            }
        }

        /* Responsive - Large Desktop */
        @media (min-width: 1200px) {
            .products-grid {
                grid-template-columns: repeat(5, 1fr);
            }

            .trending-card {
                width: 200px;
            }

            .trending-card .product-image {
                height: 200px;
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

        /* Pagination Styling */
        .pagination-wrapper {
            display: flex;
            justify-content: center;
            margin-top: 24px;
        }

        .pagination-wrapper nav {
            display: flex;
            align-items: center;
            gap: 4px;
        }

        .pagination-wrapper nav > div {
            display: flex;
            align-items: center;
            gap: 4px;
        }

        .pagination-wrapper nav > div:first-child {
            display: none;
        }

        .pagination-wrapper nav span,
        .pagination-wrapper nav a {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-width: 36px;
            height: 36px;
            padding: 0 12px;
            border-radius: 8px;
            font-size: 14px;
            font-weight: 500;
            text-decoration: none;
            transition: all 0.2s;
        }

        .pagination-wrapper nav a {
            background: white;
            color: #475569;
            border: 1px solid #e2e8f0;
        }

        .pagination-wrapper nav a:hover {
            background: #f1f5f9;
            border-color: #cbd5e1;
        }

        .pagination-wrapper nav span[aria-current="page"] span,
        .pagination-wrapper nav .active span {
            background: #1a9fff;
            color: white;
            border: 1px solid #1a9fff;
        }

        .pagination-wrapper nav span[aria-disabled="true"],
        .pagination-wrapper nav .disabled span {
            background: #f8fafc;
            color: #cbd5e1;
            border: 1px solid #e2e8f0;
            cursor: not-allowed;
        }

        .pagination-wrapper nav svg {
            width: 16px;
            height: 16px;
        }

        /* Hide default Laravel pagination text */
        .pagination-wrapper p {
            display: none;
        }
    </style>
</head>
<body>
    <!-- Header -->
    <header class="header">
        <div class="header-top">
            <div class="search-bar">
                <svg class="search-icon" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <circle cx="11" cy="11" r="8"></circle>
                    <path d="m21 21-4.35-4.35"></path>
                </svg>
                <input type="text" id="searchInput" placeholder="Search" value="{{ request('search') }}">
            </div>
            <div class="header-icons">
                <a href="{{ route('cart.index') ?? '#' }}" class="icon-btn">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <circle cx="9" cy="21" r="1"></circle>
                        <circle cx="20" cy="21" r="1"></circle>
                        <path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"></path>
                    </svg>
                    <span class="badge">0</span>
                </a>
                <a href="{{ route('notifications.index') }}" class="icon-btn" id="headerNotifIcon">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"></path>
                        <path d="M13.73 21a2 2 0 0 1-3.46 0"></path>
                    </svg>
                    <span class="badge" id="headerNotifBadge" style="display: none;">0</span>
                </a>
            </div>
        </div>

        <!-- Categories -->
        <div class="categories">
            <button class="category-btn {{ !request('category') || request('category') == 'all' ? 'active' : '' }}" data-category="all">
                Semua
            </button>
            @foreach($categories as $category)
                <button class="category-btn {{ request('category') == $category->id ? 'active' : '' }}" data-category="{{ $category->id }}">
                    {{ $category->name }}
                </button>
            @endforeach
        </div>
    </header>

    <!-- Main Content -->
    <main class="main-content">
        <!-- Alert Messages -->
        @if(session('success'))
            <div style="background: #d1fae5; border-left: 4px solid #10b981; padding: 14px 16px; margin-bottom: 20px; border-radius: 8px;">
                <p style="color: #065f46; font-size: 14px; margin: 0;">✅ {{ session('success') }}</p>
            </div>
        @endif

        @if(session('error'))
            <div style="background: #fee2e2; border-left: 4px solid #ef4444; padding: 14px 16px; margin-bottom: 20px; border-radius: 8px;">
                <p style="color: #991b1b; font-size: 14px; margin: 0;">❌ {{ session('error') }}</p>
            </div>
        @endif

        @if(Auth::check() && Auth::user()->role === 'validator' && !Auth::user()->verified)
            <div style="background: #fef3c7; border-left: 4px solid #f59e0b; padding: 14px 16px; margin-bottom: 20px; border-radius: 8px;">
                <p style="color: #92400e; font-size: 14px; margin: 0; font-weight: 600;">⏳ Akun Validator Menunggu Verifikasi</p>
                <p style="color: #92400e; font-size: 13px; margin: 8px 0 0 0;">Akun Anda sedang dalam proses verifikasi oleh admin. Anda akan mendapat notifikasi setelah akun diverifikasi dan dapat mengakses dashboard validator.</p>
            </div>
        @endif

        <!-- Trending Products -->
        @if($trendingProducts->count() > 0)
        <div class="trending-section">
            <div class="section-header">
                <h2 class="section-title">
                    <svg class="trending-icon" width="24" height="24" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M16 6l2.29 2.29-4.88 4.88-4-4L2 16.59 3.41 18l6-6 4 4 6.3-6.29L22 12V6z"/>
                    </svg>
                    Trending Sekarang
                </h2>
                <a href="{{ route('trending') }}" class="see-all">Lihat Semua</a>
            </div>
            <div class="trending-scroll">
                @foreach($trendingProducts as $product)
                    <a href="{{ route('products.show', $product->id) }}" class="trending-card">
                        <div class="trending-badge">
                            🔥 Trending
                        </div>
                        @php
                            $productImage = null;
                            if ($product->images && is_array($product->images) && count($product->images) > 0) {
                                $productImage = asset('storage/' . $product->images[0]);
                            }
                        @endphp
                        
                        @if($productImage)
                            <img src="{{ $productImage }}" alt="{{ $product->name }}" class="product-image">
                        @else
                            <div class="product-image" style="display: flex; align-items: center; justify-content: center; background: #e0e0e0;">
                                <svg width="36" height="36" viewBox="0 0 24 24" fill="none" stroke="#999" stroke-width="1.5">
                                    <rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect>
                                    <circle cx="8.5" cy="8.5" r="1.5"></circle>
                                    <polyline points="21 15 16 10 5 21"></polyline>
                                </svg>
                            </div>
                        @endif
                        
                        <div class="product-info">
                            <h3 class="product-title">{{ $product->name }}</h3>
                            <div class="product-price">Rp{{ number_format($product->price, 0, ',', '.') }}</div>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>
        @endif

        <!-- All Products -->
        <div class="section-header" style="margin-bottom: 16px;">
            <h2 class="section-title" style="font-size: 16px;">Semua Produk</h2>
        </div>
        
        <div class="products-grid" id="productsGrid">
            @forelse($products as $product)
                <a href="{{ route('products.show', $product->id) }}" class="product-card">
                    @php
                        $productImage = null;
                        if ($product->images && is_array($product->images) && count($product->images) > 0) {
                            $productImage = asset('storage/' . $product->images[0]);
                        }
                    @endphp
                    
                    @if($productImage)
                        <img src="{{ $productImage }}" alt="{{ $product->name }}" class="product-image">
                    @else
                        <div class="product-image" style="display: flex; align-items: center; justify-content: center; background: #e0e0e0;">
                            <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="#999" stroke-width="1.5">
                                <rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect>
                                <circle cx="8.5" cy="8.5" r="1.5"></circle>
                                <polyline points="21 15 16 10 5 21"></polyline>
                            </svg>
                        </div>
                    @endif
                    
                    <div class="product-info">
                        <h3 class="product-title">{{ $product->name }}</h3>
                        @if($product->seller)
                        <div class="product-seller">
                            <svg width="12" height="12" viewBox="0 0 24 24" fill="currentColor">
                                <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/>
                            </svg>
                            <span>{{ $product->seller->name }}</span>
                            @if($product->seller->prodi)
                                @php
                                    $sellerProdi = $product->seller->prodi;
                                    if (is_numeric($sellerProdi)) {
                                        $prodiData = \App\Models\StudyProgram::find($sellerProdi);
                                        $sellerProdi = $prodiData ? $prodiData->name : null;
                                    }
                                @endphp
                                @if($sellerProdi)
                                <span class="seller-prodi">• {{ $sellerProdi }}</span>
                                @endif
                            @endif
                        </div>
                        @endif
                        <div class="product-meta">
                            <div class="product-rating">
                                <span class="star-icon">★</span>
                                <span>{{ number_format(rand(40, 50) / 10, 1) }}</span>
                            </div>
                            <span class="product-sold">{{ rand(5, 100) }} terjual</span>
                        </div>
                        <div class="product-price">Rp{{ number_format($product->price, 0, ',', '.') }}</div>
                    </div>
                </a>
            @empty
                <div class="empty-state" style="grid-column: 1 / -1;">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                        <path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"></path>
                        <polyline points="3.27 6.96 12 12.01 20.73 6.96"></polyline>
                        <line x1="12" y1="22.08" x2="12" y2="12"></line>
                    </svg>
                    <p>Belum ada produk tersedia</p>
                </div>
            @endforelse
        </div>

        <!-- Pagination -->
        @if($products->hasPages())
            <div class="pagination-wrapper">
                {{ $products->links() }}
            </div>
        @endif
    </main>

    <!-- Bottom Navigation -->
    <nav class="bottom-nav">
        <a href="{{ route('home') }}" class="nav-item active">
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
        <a href="{{ route('profile.edit') }}" class="nav-item">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                <circle cx="12" cy="7" r="4"></circle>
            </svg>
            <span>Profil</span>
        </a>
    </nav>

    <script>
        // Category filter
        document.querySelectorAll('.category-btn').forEach(btn => {
            btn.addEventListener('click', function() {
                const category = this.dataset.category;
                let url = new URL(window.location.href);
                
                url.searchParams.set('category', category);
                
                // Jika user klik "Semua", hapus search parameter dan kosongkan input
                if (category === 'all') {
                    url.searchParams.delete('search');
                    document.getElementById('searchInput').value = '';
                } else {
                    // Jika kategori spesifik, pertahankan search jika ada
                    const searchValue = document.getElementById('searchInput').value;
                    if (searchValue) {
                        url.searchParams.set('search', searchValue);
                    }
                }
                
                window.location.href = url.toString();
            });
        });

        // Search functionality
        let searchTimeout;
        document.getElementById('searchInput').addEventListener('input', function() {
            clearTimeout(searchTimeout);
            const searchValue = this.value;
            
            searchTimeout = setTimeout(() => {
                let url = new URL(window.location.href);
                if (searchValue) {
                    url.searchParams.set('search', searchValue);
                } else {
                    url.searchParams.delete('search');
                }
                window.location.href = url.toString();
            }, 1200); // Delay 1.2 detik sebelum search otomatis
        });

        // Enter key search
        document.getElementById('searchInput').addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                clearTimeout(searchTimeout);
                let url = new URL(window.location.href);
                if (this.value) {
                    url.searchParams.set('search', this.value);
                } else {
                    url.searchParams.delete('search');
                }
                window.location.href = url.toString();
            }
        });

        // Fetch notification count
        function fetchNotificationCount() {
            fetch('/notifications/unread/count')
                .then(response => response.json())
                .then(data => {
                    const badge = document.getElementById('headerNotifBadge');
                    if (badge) {
                        if (data.count > 0) {
                            badge.textContent = data.count > 99 ? '99+' : data.count;
                            badge.style.display = 'block';
                        } else {
                            badge.style.display = 'none';
                        }
                    }
                })
                .catch(err => console.log('Error fetching notifications'));
        }

        // Fetch on load and every 30 seconds
        @auth
        fetchNotificationCount();
        setInterval(fetchNotificationCount, 30000);
        @endauth
    </script>
</body>
</html>
