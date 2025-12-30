<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1, user-scalable=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Profil - MAMA Marketplace</title>
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
            padding: 16px 16px 24px;
            position: relative;
        }

        .header-top {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }

        .btn-sell {
            display: flex;
            align-items: center;
            gap: 6px;
            background: #ff6a00;
            color: white;
            padding: 10px 16px;
            border-radius: 20px;
            font-size: 13px;
            font-weight: 600;
            text-decoration: none;
            box-shadow: 0 4px 12px rgba(255, 106, 0, 0.3);
            transition: all 0.2s;
        }

        .btn-sell:hover {
            background: #e55f00;
            transform: translateY(-2px);
        }

        .btn-sell svg {
            width: 18px;
            height: 18px;
        }

        .header-actions {
            display: flex;
            align-items: center;
            gap: 10px;
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
            position: relative;
        }

        .header-btn:hover {
            background: rgba(255, 255, 255, 0.3);
        }

        .header-btn svg {
            width: 22px;
            height: 22px;
        }

        .header-btn .badge {
            position: absolute;
            top: -2px;
            right: -2px;
            background: #ff6a00;
            color: white;
            font-size: 10px;
            font-weight: 600;
            min-width: 18px;
            height: 18px;
            border-radius: 9px;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 0 4px;
        }

        .settings-btn {
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

        .settings-btn:hover {
            background: rgba(255, 255, 255, 0.3);
        }

        .settings-btn svg {
            width: 22px;
            height: 22px;
        }

        /* Profile Card */
        .profile-card {
            background: white;
            border-radius: 16px;
            padding: 16px 20px;
            margin: 0 16px;
            display: flex;
            align-items: center;
            gap: 14px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
            position: relative;
            top: -10px;
        }

        .profile-avatar {
            width: 56px;
            height: 56px;
            background: #f0f0f0;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
            font-weight: 700;
            color: #333;
        }

        .profile-info {
            flex: 1;
        }

        .profile-name {
            font-size: 18px;
            font-weight: 600;
            color: #333;
            margin-bottom: 2px;
        }

        .profile-prodi {
            font-size: 13px;
            color: #666;
        }

        .profile-arrow {
            color: #999;
        }

        .profile-arrow svg {
            width: 20px;
            height: 20px;
        }

        /* Main Content */
        .main-content {
            padding: 8px 16px 16px;
        }

        /* Orders Section */
        .section {
            background: white;
            border-radius: 16px;
            padding: 16px;
            margin-bottom: 16px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.04);
        }

        .section-title {
            font-size: 14px;
            font-weight: 600;
            color: #333;
            margin-bottom: 16px;
        }

        .order-stats {
            display: flex;
            justify-content: space-around;
        }

        .order-stat {
            text-align: center;
            flex: 1;
            padding: 8px;
            text-decoration: none;
            color: inherit;
            border-radius: 12px;
            transition: background 0.2s;
        }

        .order-stat:hover {
            background: #f5f5f5;
        }

        .order-stat-number {
            font-size: 28px;
            font-weight: 700;
            color: #333;
            margin-bottom: 4px;
        }

        .order-stat-label {
            font-size: 12px;
            color: #666;
        }

        .order-stat-divider {
            width: 1px;
            background: #e0e0e0;
            margin: 0 4px;
        }

        /* Recommended Products */
        .products-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 12px;
        }

        .product-card {
            background: white;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.06);
            text-decoration: none;
            color: inherit;
            transition: transform 0.2s, box-shadow 0.2s;
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
            padding: 10px 12px;
        }

        .product-title {
            font-size: 12px;
            font-weight: 500;
            color: #333;
            margin-bottom: 4px;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
            line-height: 1.4;
        }

        .product-meta {
            display: flex;
            align-items: center;
            gap: 6px;
            margin-bottom: 4px;
        }

        .product-rating {
            display: flex;
            align-items: center;
            gap: 2px;
            font-size: 11px;
            color: #666;
        }

        .star-icon {
            color: #ffc107;
            font-size: 12px;
        }

        .product-price {
            font-size: 14px;
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

        /* No Image Placeholder */
        .no-image {
            width: 100%;
            aspect-ratio: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            background: #e0e0e0;
        }

        .no-image svg {
            width: 40px;
            height: 40px;
            color: #999;
        }

        /* Empty State */
        .empty-products {
            text-align: center;
            padding: 40px 20px;
            color: #999;
            grid-column: 1 / -1;
        }

        .empty-products svg {
            width: 60px;
            height: 60px;
            margin-bottom: 12px;
            opacity: 0.5;
        }

        /* Responsive - Tablet */
        @media (min-width: 600px) {
            .products-grid {
                grid-template-columns: repeat(3, 1fr);
                gap: 16px;
            }

            .profile-card {
                max-width: 500px;
                margin: 0 auto;
                top: -10px;
            }

            .main-content {
                max-width: 700px;
                margin: 0 auto;
                padding: 8px 20px 16px;
            }

            .header {
                padding: 20px 40px 30px;
            }

            .header-top {
                max-width: 700px;
                margin: 0 auto 20px;
            }
        }

        /* Responsive - Desktop */
        @media (min-width: 900px) {
            .main-content {
                max-width: 900px;
                padding: 16px 40px 24px;
            }

            .products-grid {
                grid-template-columns: repeat(4, 1fr);
            }

            .profile-card {
                max-width: 600px;
            }

            .header-top {
                max-width: 900px;
            }

            .bottom-nav {
                width: 100%;
                left: 0;
                right: 0;
                transform: none;
                border-radius: 0;
            }

            .section {
                padding: 20px;
            }

            .order-stat-number {
                font-size: 32px;
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

        /* Logout Button */
        .logout-section {
            margin-top: 8px;
        }

        .btn-logout {
            width: 100%;
            padding: 14px;
            background: #fee2e2;
            color: #dc2626;
            font-size: 14px;
            font-weight: 600;
            border: none;
            border-radius: 12px;
            cursor: pointer;
            transition: background 0.2s;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
        }

        .btn-logout:hover {
            background: #fecaca;
        }

        .btn-logout svg {
            width: 20px;
            height: 20px;
        }
    </style>
</head>
<body>
    <!-- Header -->
    <header class="header">
        <div class="header-top">
            @if($user->role === 'validator')
                <a href="{{ route('validator.dashboard') }}" class="btn-sell" style="background: #1e3a5f;">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M9 12l2 2 4-4"/>
                        <circle cx="12" cy="12" r="10"/>
                    </svg>
                    Dashboard Validator
                </a>
            @elseif($user->role === 'admin')
                <a href="{{ route('admin.dashboard') }}" class="btn-sell" style="background: #7c3aed;">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <rect x="3" y="3" width="7" height="7"/>
                        <rect x="14" y="3" width="7" height="7"/>
                        <rect x="14" y="14" width="7" height="7"/>
                        <rect x="3" y="14" width="7" height="7"/>
                    </svg>
                    Dashboard Admin
                </a>
            @elseif($user->role === 'mahasiswa')
                <a href="{{ route('seller.dashboard') }}" class="btn-sell">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>
                        <polyline points="9 22 9 12 15 12 15 22"></polyline>
                    </svg>
                    Dashboard Jualan
                </a>
            @else
                <a href="{{ route('seller.register') }}" class="btn-sell">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M12 5v14M5 12h14"/>
                    </svg>
                    Mulai Jualan
                </a>
            @endif
            <div class="header-actions">
                <!-- Keranjang -->
                <a href="{{ route('cart.index') }}" class="header-btn" title="Keranjang Saya">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <circle cx="9" cy="21" r="1"></circle>
                        <circle cx="20" cy="21" r="1"></circle>
                        <path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"></path>
                    </svg>
                    @if(isset($cartCount) && $cartCount > 0)
                        <span class="badge">{{ $cartCount }}</span>
                    @endif
                </a>
                
                <!-- Pesan / Chat -->
                <a href="{{ route('messages.index') }}" class="header-btn" title="Pesan">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"></path>
                    </svg>
                    @if(isset($unreadMessages) && $unreadMessages > 0)
                        <span class="badge">{{ $unreadMessages }}</span>
                    @endif
                </a>
                
                <!-- Settings -->
                <a href="{{ route('profile.settings') }}" class="header-btn" title="Pengaturan">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <circle cx="12" cy="12" r="3"></circle>
                        <path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1 0 2.83 2 2 0 0 1-2.83 0l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-2 2 2 2 0 0 1-2-2v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83 0 2 2 0 0 1 0-2.83l.06-.06a1.65 1.65 0 0 0 .33-1.82 1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1-2-2 2 2 0 0 1 2-2h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 0 1 0-2.83 2 2 0 0 1 2.83 0l.06.06a1.65 1.65 0 0 0 1.82.33H9a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 2-2 2 2 0 0 1 2 2v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 1 2.83 0 2 2 0 0 1 0 2.83l-.06.06a1.65 1.65 0 0 0-.33 1.82V9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 2 2 2 2 0 0 1-2 2h-.09a1.65 1.65 0 0 0-1.51 1z"></path>
                    </svg>
                </a>
            </div>
        </div>
    </header>

    <!-- Profile Card -->
    <div class="profile-card">
        <div class="profile-avatar" @if($user->role === 'validator') style="background: linear-gradient(135deg, #1e3a5f 0%, #2d4a6f 100%); color: white;" @elseif($user->role === 'admin') style="background: linear-gradient(135deg, #7c3aed 0%, #8b5cf6 100%); color: white;" @endif>
            {{ strtoupper(substr($user->name, 0, 1)) }}
        </div>
        <div class="profile-info">
            <div class="profile-name">{{ $user->name }}</div>
            <div class="profile-prodi">
                @if($user->role === 'validator')
                    <span style="color: #1e3a5f; font-weight: 500;">Validator</span>
                @elseif($user->role === 'admin')
                    <span style="color: #7c3aed; font-weight: 500;">Administrator</span>
                @elseif($user->role === 'mahasiswa')
                    Mahasiswa {{ $user->studyProgram->name ?? '' }}
                @else
                    Pengguna MAMA
                @endif
            </div>
        </div>
        <div class="profile-arrow">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M9 18l6-6-6-6"/>
            </svg>
        </div>
    </div>

    <!-- Main Content -->
    <main class="main-content">
        @if($user->role === 'validator')
        <!-- Validator Stats Section -->
        <div class="section" style="background: linear-gradient(135deg, #1e3a5f 0%, #2d4a6f 100%); color: white;">
            <h2 class="section-title" style="color: white;">Statistik Verifikasi</h2>
            <div class="order-stats">
                <a href="{{ route('validator.products.pending') }}" class="order-stat" style="text-decoration: none;">
                    <div class="order-stat-number" style="color: #fbbf24;">{{ $validatorStats['pending'] ?? 0 }}</div>
                    <div class="order-stat-label" style="color: rgba(255,255,255,0.8);">Menunggu</div>
                </a>
                <div class="order-stat-divider" style="background: rgba(255,255,255,0.2);"></div>
                <a href="{{ route('validator.products.verified') }}" class="order-stat" style="text-decoration: none;">
                    <div class="order-stat-number" style="color: #34d399;">{{ $validatorStats['verified'] ?? 0 }}</div>
                    <div class="order-stat-label" style="color: rgba(255,255,255,0.8);">Disetujui</div>
                </a>
                <div class="order-stat-divider" style="background: rgba(255,255,255,0.2);"></div>
                <a href="{{ route('validator.products.rejected') }}" class="order-stat" style="text-decoration: none;">
                    <div class="order-stat-number" style="color: #f87171;">{{ $validatorStats['rejected'] ?? 0 }}</div>
                    <div class="order-stat-label" style="color: rgba(255,255,255,0.8);">Ditolak</div>
                </a>
            </div>
            <a href="{{ route('validator.dashboard') }}" style="display: block; text-align: center; margin-top: 16px; padding: 12px; background: rgba(255,255,255,0.15); border-radius: 10px; color: white; text-decoration: none; font-weight: 500; font-size: 14px;">
                Buka Dashboard Validator →
            </a>
        </div>
        @endif

        <!-- Orders Section -->
        <div class="section">
            <h2 class="section-title">Pesanan saya</h2>
            <div class="order-stats">
                <a href="{{ route('orders.index') }}?status=processing" class="order-stat">
                    <div class="order-stat-number">{{ $orderCounts['dikemas'] ?? 0 }}</div>
                    <div class="order-stat-label">Dikemas</div>
                </a>
                <div class="order-stat-divider"></div>
                <a href="{{ route('orders.index') }}?status=shipped" class="order-stat">
                    <div class="order-stat-number">{{ $orderCounts['pengiriman'] ?? 0 }}</div>
                    <div class="order-stat-label">Pengiriman</div>
                </a>
                <div class="order-stat-divider"></div>
                <a href="{{ route('orders.index') }}?status=completed" class="order-stat">
                    <div class="order-stat-number">{{ $orderCounts['selesai'] ?? 0 }}</div>
                    <div class="order-stat-label">Selesai</div>
                </a>
            </div>
        </div>

        <!-- Recommended Products -->
        <div class="section">
            <h2 class="section-title">Kamu mungkin suka</h2>
            <div class="products-grid">
                @forelse($recommendedProducts as $product)
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
                            <div class="no-image">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                                    <rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect>
                                    <circle cx="8.5" cy="8.5" r="1.5"></circle>
                                    <polyline points="21 15 16 10 5 21"></polyline>
                                </svg>
                            </div>
                        @endif
                        
                        <div class="product-info">
                            <h3 class="product-title">{{ $product->name }}</h3>
                            <div class="product-meta">
                                <div class="product-rating">
                                    <span class="star-icon">★</span>
                                    <span>{{ number_format(rand(40, 50) / 10, 1) }}</span>
                                </div>
                            </div>
                            <div class="product-price">Rp{{ number_format($product->price, 0, ',', '.') }}</div>
                        </div>
                    </a>
                @empty
                    <div class="empty-products">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                            <path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"></path>
                        </svg>
                        <p>Belum ada rekomendasi produk</p>
                    </div>
                @endforelse
            </div>
        </div>

        <!-- Logout Section -->
        <div class="section logout-section">
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="btn-logout">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path>
                        <polyline points="16 17 21 12 16 7"></polyline>
                        <line x1="21" y1="12" x2="9" y2="12"></line>
                    </svg>
                    Keluar
                </button>
            </form>
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
