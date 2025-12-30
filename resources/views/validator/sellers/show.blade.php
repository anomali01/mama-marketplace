<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Detail Penjual - Validator MAMA</title>
    <link rel="icon" type="image/png" href="{{ asset('img/logo-mama.png') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    @include('validator.partials.styles')
    <style>
        .seller-profile {
            background: white;
            border-radius: 12px;
            padding: 24px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
            margin-bottom: 24px;
        }
        .profile-header {
            display: flex;
            align-items: center;
            gap: 20px;
            padding-bottom: 20px;
            border-bottom: 1px solid #e5e7eb;
            margin-bottom: 20px;
        }
        .profile-avatar {
            width: 80px;
            height: 80px;
            background: linear-gradient(135deg, #1e3a5f 0%, #2d4a6f 100%);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 600;
            font-size: 32px;
        }
        .profile-info h2 {
            font-size: 24px;
            font-weight: 600;
            color: #1e293b;
            margin: 0 0 8px;
        }
        .profile-info p {
            font-size: 14px;
            color: #64748b;
            margin: 0 0 4px;
        }
        .profile-stats {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 16px;
        }
        .profile-stat-card {
            background: #f8fafc;
            border-radius: 8px;
            padding: 16px;
            text-align: center;
        }
        .profile-stat-value {
            font-size: 28px;
            font-weight: 700;
            color: #1e3a5f;
        }
        .profile-stat-label {
            font-size: 13px;
            color: #64748b;
            margin-top: 4px;
        }
        .profile-stat-card.pending .profile-stat-value { color: #f59e0b; }
        .profile-stat-card.verified .profile-stat-value { color: #10b981; }
        .profile-stat-card.rejected .profile-stat-value { color: #ef4444; }

        .back-link {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            color: #64748b;
            text-decoration: none;
            font-size: 14px;
            margin-bottom: 20px;
            transition: color 0.2s;
        }
        .back-link:hover {
            color: #1e3a5f;
        }
        .back-link svg {
            width: 18px;
            height: 18px;
        }

        .products-section {
            background: white;
            border-radius: 12px;
            padding: 24px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
        }
        .products-tabs {
            display: flex;
            gap: 8px;
            margin-bottom: 20px;
            border-bottom: 1px solid #e5e7eb;
            padding-bottom: 16px;
        }
        .tab-btn {
            padding: 10px 20px;
            background: #f1f5f9;
            border: none;
            border-radius: 8px;
            font-size: 14px;
            font-weight: 500;
            color: #64748b;
            cursor: pointer;
            transition: all 0.2s;
        }
        .tab-btn.active {
            background: #1e3a5f;
            color: white;
        }
        .tab-btn:hover:not(.active) {
            background: #e2e8f0;
        }
        .tab-count {
            display: inline-block;
            padding: 2px 8px;
            background: rgba(255,255,255,0.2);
            border-radius: 10px;
            font-size: 12px;
            margin-left: 6px;
        }
        .tab-btn:not(.active) .tab-count {
            background: #cbd5e1;
            color: #475569;
        }

        .products-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(240px, 1fr));
            gap: 16px;
        }
        .product-card {
            border: 1px solid #e5e7eb;
            border-radius: 10px;
            overflow: hidden;
            transition: all 0.2s;
        }
        .product-card:hover {
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        }
        .product-card-image {
            width: 100%;
            aspect-ratio: 1;
            object-fit: cover;
            background: #f3f4f6;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .product-card-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
        .product-card-body {
            padding: 12px;
        }
        .product-card-name {
            font-size: 14px;
            font-weight: 500;
            color: #1e293b;
            margin-bottom: 4px;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }
        .product-card-price {
            font-size: 16px;
            font-weight: 700;
            color: #f97316;
            margin-bottom: 8px;
        }
        .product-card-status {
            display: inline-flex;
            align-items: center;
            gap: 4px;
            padding: 4px 10px;
            border-radius: 20px;
            font-size: 11px;
            font-weight: 500;
        }
        .product-card-status.pending {
            background: #fef3c7;
            color: #92400e;
        }
        .product-card-status.verified {
            background: #d1fae5;
            color: #065f46;
        }
        .product-card-status.rejected {
            background: #fee2e2;
            color: #991b1b;
        }
        .product-card-footer {
            padding: 12px;
            border-top: 1px solid #f1f5f9;
        }
        .product-card-link {
            display: block;
            text-align: center;
            padding: 8px;
            background: #f8fafc;
            color: #1e3a5f;
            text-decoration: none;
            border-radius: 6px;
            font-size: 13px;
            font-weight: 500;
            transition: all 0.2s;
        }
        .product-card-link:hover {
            background: #1e3a5f;
            color: white;
        }

        .tab-content {
            display: none;
        }
        .tab-content.active {
            display: block;
        }

        .empty-products {
            text-align: center;
            padding: 40px;
            color: #94a3b8;
        }
        .empty-products svg {
            width: 48px;
            height: 48px;
            margin-bottom: 12px;
            opacity: 0.5;
        }
    </style>
</head>
<body>
    @include('validator.partials.sidebar', ['active' => 'sellers'])

    <main class="main-content">
        <header class="header">
            <h1 class="header-title">Detail Penjual</h1>
            <div class="header-user">
                <div class="header-user-info">
                    <div class="header-user-name">{{ Auth::user()->name }}</div>
                    <div class="header-user-role">Validator</div>
                </div>
                <div class="header-user-avatar">
                    {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                </div>
            </div>
        </header>

        <div class="content">
            <a href="{{ route('validator.sellers.index') }}" class="back-link">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M19 12H5M12 19l-7-7 7-7"/>
                </svg>
                Kembali ke Daftar Penjual
            </a>

            <div class="seller-profile">
                <div class="profile-header">
                    <div class="profile-avatar">
                        {{ strtoupper(substr($seller->name, 0, 1)) }}
                    </div>
                    <div class="profile-info">
                        <h2>{{ $seller->name }}</h2>
                        <p>{{ $seller->email }}</p>
                        <p>{{ $seller->studyProgram->name ?? 'Mahasiswa' }} • Bergabung {{ $seller->created_at->format('d M Y') }}</p>
                    </div>
                </div>
                <div class="profile-stats">
                    <div class="profile-stat-card">
                        <div class="profile-stat-value">{{ $seller->products->count() }}</div>
                        <div class="profile-stat-label">Total Produk</div>
                    </div>
                    <div class="profile-stat-card pending">
                        <div class="profile-stat-value">{{ $pendingProducts->count() }}</div>
                        <div class="profile-stat-label">Pending</div>
                    </div>
                    <div class="profile-stat-card verified">
                        <div class="profile-stat-value">{{ $verifiedProducts->count() }}</div>
                        <div class="profile-stat-label">Terverifikasi</div>
                    </div>
                    <div class="profile-stat-card rejected">
                        <div class="profile-stat-value">{{ $rejectedProducts->count() }}</div>
                        <div class="profile-stat-label">Ditolak</div>
                    </div>
                </div>
            </div>

            <div class="products-section">
                <div class="products-tabs">
                    <button class="tab-btn active" onclick="showTab('all')">
                        Semua
                        <span class="tab-count">{{ $seller->products->count() }}</span>
                    </button>
                    <button class="tab-btn" onclick="showTab('pending')">
                        Pending
                        <span class="tab-count">{{ $pendingProducts->count() }}</span>
                    </button>
                    <button class="tab-btn" onclick="showTab('verified')">
                        Terverifikasi
                        <span class="tab-count">{{ $verifiedProducts->count() }}</span>
                    </button>
                    <button class="tab-btn" onclick="showTab('rejected')">
                        Ditolak
                        <span class="tab-count">{{ $rejectedProducts->count() }}</span>
                    </button>
                </div>

                <!-- All Products -->
                <div class="tab-content active" id="tab-all">
                    @if($seller->products->count() > 0)
                        <div class="products-grid">
                            @foreach($seller->products as $product)
                                @include('validator.sellers.partials.product-card', ['product' => $product])
                            @endforeach
                        </div>
                    @else
                        <div class="empty-products">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                                <rect x="3" y="3" width="18" height="18" rx="2"/>
                                <circle cx="8.5" cy="8.5" r="1.5"/>
                                <path d="M21 15l-5-5L5 21"/>
                            </svg>
                            <p>Penjual ini belum memiliki produk</p>
                        </div>
                    @endif
                </div>

                <!-- Pending Products -->
                <div class="tab-content" id="tab-pending">
                    @if($pendingProducts->count() > 0)
                        <div class="products-grid">
                            @foreach($pendingProducts as $product)
                                @include('validator.sellers.partials.product-card', ['product' => $product])
                            @endforeach
                        </div>
                    @else
                        <div class="empty-products">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                                <circle cx="12" cy="12" r="10"/>
                                <path d="M12 6v6l4 2"/>
                            </svg>
                            <p>Tidak ada produk pending</p>
                        </div>
                    @endif
                </div>

                <!-- Verified Products -->
                <div class="tab-content" id="tab-verified">
                    @if($verifiedProducts->count() > 0)
                        <div class="products-grid">
                            @foreach($verifiedProducts as $product)
                                @include('validator.sellers.partials.product-card', ['product' => $product])
                            @endforeach
                        </div>
                    @else
                        <div class="empty-products">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                                <path d="M9 12l2 2 4-4"/>
                                <circle cx="12" cy="12" r="10"/>
                            </svg>
                            <p>Tidak ada produk terverifikasi</p>
                        </div>
                    @endif
                </div>

                <!-- Rejected Products -->
                <div class="tab-content" id="tab-rejected">
                    @if($rejectedProducts->count() > 0)
                        <div class="products-grid">
                            @foreach($rejectedProducts as $product)
                                @include('validator.sellers.partials.product-card', ['product' => $product])
                            @endforeach
                        </div>
                    @else
                        <div class="empty-products">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                                <circle cx="12" cy="12" r="10"/>
                                <line x1="15" y1="9" x2="9" y2="15"/>
                                <line x1="9" y1="9" x2="15" y2="15"/>
                            </svg>
                            <p>Tidak ada produk ditolak</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </main>

    <script>
        function showTab(tab) {
            // Hide all tabs
            document.querySelectorAll('.tab-content').forEach(el => el.classList.remove('active'));
            document.querySelectorAll('.tab-btn').forEach(el => el.classList.remove('active'));
            
            // Show selected tab
            document.getElementById('tab-' + tab).classList.add('active');
            event.target.closest('.tab-btn').classList.add('active');
        }
    </script>
</body>
</html>
