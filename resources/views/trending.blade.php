<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1, user-scalable=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Trending - MAMA Marketplace</title>
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
            background: linear-gradient(135deg, #ff6b35 0%, #f7931e 100%);
            padding: 16px;
            position: sticky;
            top: 0;
            z-index: 100;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        .header-content {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .back-btn {
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
        }

        .back-btn:hover {
            background: rgba(255, 255, 255, 0.3);
        }

        .header-title {
            flex: 1;
            color: white;
            font-size: 20px;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .trending-icon {
            animation: pulse 2s ease-in-out infinite;
        }

        @keyframes pulse {
            0%, 100% { transform: scale(1); }
            50% { transform: scale(1.1); }
        }

        /* Main Content */
        .main-content {
            padding: 16px;
        }

        /* Section */
        .section {
            margin-bottom: 32px;
        }

        .section-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 16px;
            padding-bottom: 12px;
            border-bottom: 2px solid #e0e0e0;
        }

        .section-title {
            font-size: 18px;
            font-weight: 600;
            color: #333;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .section-badge {
            background: linear-gradient(135deg, #ff6b35, #f7931e);
            color: white;
            font-size: 11px;
            font-weight: 600;
            padding: 4px 10px;
            border-radius: 12px;
        }

        .prodi-badge {
            background: linear-gradient(135deg, #1a9fff, #0080e0);
        }

        /* Filter Pills */
        .filter-section {
            margin-bottom: 24px;
            padding-bottom: 16px;
            border-bottom: 2px solid #e0e0e0;
        }

        .filter-label {
            font-size: 14px;
            font-weight: 600;
            color: #333;
            margin-bottom: 12px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .filter-pills {
            display: flex;
            gap: 8px;
            overflow-x: auto;
            padding: 4px 0;
            scrollbar-width: none;
            -ms-overflow-style: none;
        }

        .filter-pills::-webkit-scrollbar {
            display: none;
        }

        .filter-pill {
            flex-shrink: 0;
            padding: 8px 16px;
            background: white;
            color: #666;
            border: 2px solid #e0e0e0;
            border-radius: 20px;
            font-size: 13px;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.2s;
            text-decoration: none;
            white-space: nowrap;
        }

        .filter-pill:hover {
            border-color: #ff6b35;
            color: #ff6b35;
        }

        .filter-pill.active {
            background: linear-gradient(135deg, #ff6b35, #f7931e);
            color: white;
            border-color: transparent;
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
            position: relative;
        }

        .product-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
        }

        .rank-badge {
            position: absolute;
            top: 8px;
            left: 8px;
            background: linear-gradient(135deg, #ff6b35, #f7931e);
            color: white;
            font-size: 11px;
            font-weight: 700;
            padding: 6px 10px;
            border-radius: 12px;
            z-index: 1;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.2);
        }

        .rank-badge.top-1 {
            background: linear-gradient(135deg, #ffd700, #ffed4e);
            color: #333;
        }

        .rank-badge.top-2 {
            background: linear-gradient(135deg, #c0c0c0, #e8e8e8);
            color: #333;
        }

        .rank-badge.top-3 {
            background: linear-gradient(135deg, #cd7f32, #e69a5a);
            color: white;
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
            margin-bottom: 8px;
            font-size: 11px;
            color: #666;
        }

        .product-sold {
            display: flex;
            align-items: center;
            gap: 4px;
            color: #ff6b35;
            font-weight: 600;
        }

        .product-prodi {
            display: inline-block;
            background: #e3f2fd;
            color: #1976d2;
            font-size: 10px;
            font-weight: 600;
            padding: 3px 8px;
            border-radius: 8px;
            margin-bottom: 6px;
        }

        .product-price {
            font-size: 15px;
            font-weight: 700;
            color: #1a9fff;
        }

        .empty-state {
            text-align: center;
            padding: 40px 20px;
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

        /* Empty Prodi State */
        .empty-prodi-state {
            text-align: center;
            padding: 40px 20px;
            background: white;
            border-radius: 16px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.06);
        }

        .empty-prodi-state svg {
            margin-bottom: 16px;
        }

        .empty-prodi-state h3 {
            font-size: 16px;
            font-weight: 600;
            color: #333;
            margin-bottom: 8px;
        }

        .empty-prodi-state p {
            font-size: 14px;
            color: #666;
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
            color: #1a9fff;
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
        }

        /* Responsive - Desktop */
        @media (min-width: 900px) {
            .header {
                padding: 16px 40px;
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

            .bottom-nav {
                width: 100%;
                left: 0;
                right: 0;
                transform: none;
                border-radius: 0;
            }
        }

        /* Responsive - Large Desktop */
        @media (min-width: 1200px) {
            .products-grid {
                grid-template-columns: repeat(5, 1fr);
            }
        }
    </style>
</head>
<body>
    <!-- Header -->
    <header class="header">
        <div class="header-content">
            <a href="{{ route('home') }}" class="back-btn">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M19 12H5M12 19l-7-7 7-7"/>
                </svg>
            </a>
            <h1 class="header-title">
                <svg class="trending-icon" width="24" height="24" viewBox="0 0 24 24" fill="currentColor">
                    <path d="M16 6l2.29 2.29-4.88 4.88-4-4L2 16.59 3.41 18l6-6 4 4 6.3-6.29L22 12V6z"/>
                </svg>
                Trending
            </h1>
        </div>
    </header>

    <!-- Main Content -->
    <main class="main-content">
        <!-- Filter Prodi -->
        <div class="filter-section">
            <div class="filter-label">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor">
                    <path d="M3 18h6v-2H3v2zM3 6v2h18V6H3zm0 7h12v-2H3v2z"/>
                </svg>
                Filter Berdasarkan Prodi:
            </div>
            <div class="filter-pills">
                <a href="{{ route('trending', ['prodi' => 'all']) }}" class="filter-pill {{ $selectedProdi === 'all' ? 'active' : '' }}">
                    🌟 Semua Prodi
                </a>
                @foreach($studyPrograms as $prodi)
                    <a href="{{ route('trending', ['prodi' => $prodi->id]) }}" class="filter-pill {{ $selectedProdi == $prodi->id ? 'active' : '' }}">
                        {{ $prodi->name }}
                    </a>
                @endforeach
            </div>
        </div>

        <!-- Baris 1: Trending Umum (Terpopuler) -->
        @if($trendingGeneral->count() > 0)
        <div class="section">
            <div class="section-header">
                <h2 class="section-title">
                    🔥 Trending Umum
                    <span class="section-badge">Terpopuler</span>
                </h2>
            </div>
            <div class="products-grid">
                @foreach($trendingGeneral as $index => $product)
                    <a href="{{ route('products.show', $product->id) }}" class="product-card">
                        <div class="rank-badge {{ $index === 0 ? 'top-1' : ($index === 1 ? 'top-2' : ($index === 2 ? 'top-3' : '')) }}">
                            #{{ $index + 1 }}
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
                                <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="#999" stroke-width="1.5">
                                    <rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect>
                                    <circle cx="8.5" cy="8.5" r="1.5"></circle>
                                    <polyline points="21 15 16 10 5 21"></polyline>
                                </svg>
                            </div>
                        @endif
                        
                        <div class="product-info">
                            @php
                                $trendingProdi = null;
                                if($product->seller && $product->seller->prodi) {
                                    $trendingProdi = $product->seller->prodi;
                                    if (is_numeric($trendingProdi)) {
                                        $prodiData = \App\Models\StudyProgram::find($trendingProdi);
                                        $trendingProdi = $prodiData ? $prodiData->name : null;
                                    }
                                } elseif($product->studyProgram) {
                                    $trendingProdi = $product->studyProgram->name;
                                }
                            @endphp
                            @if($trendingProdi)
                                <span class="product-prodi">{{ $trendingProdi }}</span>
                            @endif
                            <h3 class="product-title">{{ $product->name }}</h3>
                            <div class="product-meta">
                                <span class="product-sold">
                                    <svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor">
                                        <path d="M7 18c-1.1 0-1.99.9-1.99 2S5.9 22 7 22s2-.9 2-2-.9-2-2-2zM1 2v2h2l3.6 7.59-1.35 2.45c-.16.28-.25.61-.25.96 0 1.1.9 2 2 2h12v-2H7.42c-.14 0-.25-.11-.25-.25l.03-.12.9-1.63h7.45c.75 0 1.41-.41 1.75-1.03l3.58-6.49c.08-.14.12-.31.12-.48 0-.55-.45-1-1-1H5.21l-.94-2H1zm16 16c-1.1 0-1.99.9-1.99 2s.89 2 1.99 2 2-.9 2-2-.9-2-2-2z"/>
                                    </svg>
                                    {{ $product->order_items_count }} terjual
                                </span>
                            </div>
                            <div class="product-price">Rp{{ number_format($product->price, 0, ',', '.') }}</div>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>
        @endif

        <!-- Baris 2: Trending Per Prodi -->
        @if($selectedProdi === 'all')
            <!-- Tampilkan semua prodi dengan grouping -->
            @if(is_object($trendingByProdi) && $trendingByProdi->count() > 0)
                @foreach($trendingByProdi as $prodiId => $products)
                    @if($products->count() > 0)
                    <div class="section">
                        <div class="section-header">
                            <h2 class="section-title">
                                🎓 Trending di {{ $products->first()->studyProgram->name ?? 'Prodi' }}
                            </h2>
                        </div>
                        <div class="products-grid">
                            @foreach($products as $index => $product)
                                <a href="{{ route('products.show', $product->id) }}" class="product-card">
                                    @if($index < 3)
                                    <div class="rank-badge {{ $index === 0 ? 'top-1' : ($index === 1 ? 'top-2' : 'top-3') }}">
                                        #{{ $index + 1 }}
                                    </div>
                                    @endif
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
                                        <div class="product-meta">
                                            <span class="product-sold">
                                                <svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor">
                                                    <path d="M7 18c-1.1 0-1.99.9-1.99 2S5.9 22 7 22s2-.9 2-2-.9-2-2-2zM1 2v2h2l3.6 7.59-1.35 2.45c-.16.28-.25.61-.25.96 0 1.1.9 2 2 2h12v-2H7.42c-.14 0-.25-.11-.25-.25l.03-.12.9-1.63h7.45c.75 0 1.41-.41 1.75-1.03l3.58-6.49c.08-.14.12-.31.12-.48 0-.55-.45-1-1-1H5.21l-.94-2H1zm16 16c-1.1 0-1.99.9-1.99 2s.89 2 1.99 2 2-.9 2-2-.9-2-2-2z"/>
                                                </svg>
                                                {{ $product->order_items_count ?? 0 }} terjual
                                            </span>
                                        </div>
                                        <div class="product-price">Rp{{ number_format($product->price, 0, ',', '.') }}</div>
                                    </div>
                                </a>
                            @endforeach
                        </div>
                    </div>
                    @endif
                @endforeach
            @endif
        @else
            <!-- Tampilkan prodi yang dipilih -->
            @php
                $selectedProdiName = $studyPrograms->where('id', $selectedProdi)->first()?->name ?? 'Prodi';
            @endphp
            @if($trendingByProdi->count() > 0)
            <div class="section">
                <div class="section-header">
                    <h2 class="section-title">
                        🎓 Produk dari {{ $selectedProdiName }}
                        <span class="section-badge prodi-badge">{{ $trendingByProdi->count() }} Produk</span>
                    </h2>
                </div>
                <div class="products-grid">
                    @foreach($trendingByProdi as $index => $product)
                        <a href="{{ route('products.show', $product->id) }}" class="product-card">
                            @if($product->order_items_count > 0 && $index < 3)
                            <div class="rank-badge {{ $index === 0 ? 'top-1' : ($index === 1 ? 'top-2' : 'top-3') }}">
                                #{{ $index + 1 }}
                            </div>
                            @endif
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
                                <div class="product-meta">
                                    <span class="product-sold">
                                        <svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor">
                                            <path d="M7 18c-1.1 0-1.99.9-1.99 2S5.9 22 7 22s2-.9 2-2-.9-2-2-2zM1 2v2h2l3.6 7.59-1.35 2.45c-.16.28-.25.61-.25.96 0 1.1.9 2 2 2h12v-2H7.42c-.14 0-.25-.11-.25-.25l.03-.12.9-1.63h7.45c.75 0 1.41-.41 1.75-1.03l3.58-6.49c.08-.14.12-.31.12-.48 0-.55-.45-1-1-1H5.21l-.94-2H1zm16 16c-1.1 0-1.99.9-1.99 2s.89 2 1.99 2 2-.9 2-2-.9-2-2-2z"/>
                                        </svg>
                                        {{ $product->order_items_count }} terjual
                                    </span>
                                </div>
                                <div class="product-price">Rp{{ number_format($product->price, 0, ',', '.') }}</div>
                            </div>
                        </a>
                    @endforeach
                </div>
            </div>
            @else
            <div class="section">
                <div class="empty-prodi-state">
                    <svg width="64" height="64" viewBox="0 0 24 24" fill="none" stroke="#ccc" stroke-width="1.5">
                        <path d="M22 10v6M2 10l10-5 10 5-10 5z"/>
                        <path d="M6 12v5c3 3 9 3 12 0v-5"/>
                    </svg>
                    <h3>Belum Ada Produk di {{ $selectedProdiName }}</h3>
                    <p>Prodi ini belum memiliki produk yang tersedia. Cek prodi lainnya!</p>
                </div>
            </div>
            @endif
        @endif

        <!-- Empty State jika tidak ada trending -->
        @if($trendingGeneral->count() === 0 && (($selectedProdi === 'all' && (!is_object($trendingByProdi) || $trendingByProdi->count() === 0)) || ($selectedProdi !== 'all' && $trendingByProdi->count() === 0)))
        <div class="empty-state">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                <path d="M16 6l2.29 2.29-4.88 4.88-4-4L2 16.59 3.41 18l6-6 4 4 6.3-6.29L22 12V6z"/>
            </svg>
            <p>Belum ada produk trending {{ $selectedProdi !== 'all' ? 'di prodi ini' : 'saat ini' }}</p>
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
        <a href="{{ route('trending') }}" class="nav-item active">
            <svg viewBox="0 0 24 24" fill="currentColor">
                <path d="M16 6l2.29 2.29-4.88 4.88-4-4L2 16.59 3.41 18l6-6 4 4 6.3-6.29L22 12V6z"/>
            </svg>
            <span>Trending</span>
        </a>
        <a href="{{ route('orders.index') ?? '#' }}" class="nav-item">
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
