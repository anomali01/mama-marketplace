<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Daftar Penjual - Validator MAMA</title>
    <link rel="icon" type="image/png" href="{{ asset('img/logo-mama.png') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    @include('validator.partials.styles')
</head>
<body>
    @include('validator.partials.sidebar', ['active' => 'sellers'])

    <main class="main-content">
        <header class="header">
            <h1 class="header-title">Daftar Penjual</h1>
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
            <div class="section">
                <div class="section-header">
                    <h2 class="section-title">Semua Penjual ({{ $sellers->total() }} orang)</h2>
                </div>

                @if($sellers->count() > 0)
                    <div class="sellers-grid">
                        @foreach($sellers as $seller)
                            <div class="seller-card">
                                <div class="seller-card-header">
                                    <div class="seller-card-avatar">
                                        {{ strtoupper(substr($seller->name, 0, 1)) }}
                                    </div>
                                    <div class="seller-card-info">
                                        <h3 class="seller-card-name">{{ $seller->name }}</h3>
                                        <p class="seller-card-prodi">{{ $seller->studyProgram->name ?? 'Mahasiswa' }}</p>
                                    </div>
                                </div>
                                <div class="seller-card-stats">
                                    <div class="seller-stat">
                                        <span class="stat-value">{{ $seller->products_count ?? 0 }}</span>
                                        <span class="stat-label">Produk</span>
                                    </div>
                                    <div class="seller-stat">
                                        <span class="stat-value">{{ $seller->verified_products_count ?? 0 }}</span>
                                        <span class="stat-label">Terverifikasi</span>
                                    </div>
                                    <div class="seller-stat">
                                        <span class="stat-value">{{ $seller->pending_products_count ?? 0 }}</span>
                                        <span class="stat-label">Pending</span>
                                    </div>
                                </div>
                                <div class="seller-card-footer">
                                    <span class="seller-join-date">
                                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                            <rect x="3" y="4" width="18" height="18" rx="2" ry="2"/>
                                            <line x1="16" y1="2" x2="16" y2="6"/>
                                            <line x1="8" y1="2" x2="8" y2="6"/>
                                            <line x1="3" y1="10" x2="21" y2="10"/>
                                        </svg>
                                        Bergabung {{ $seller->created_at->format('d M Y') }}
                                    </span>
                                    <a href="{{ route('validator.sellers.show', $seller) }}" class="seller-card-link">
                                        Lihat Detail →
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <div class="pagination-wrapper">
                        {{ $sellers->links() }}
                    </div>
                @else
                    <div class="empty-state">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                            <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/>
                            <circle cx="9" cy="7" r="4"/>
                            <path d="M23 21v-2a4 4 0 0 0-3-3.87"/>
                            <path d="M16 3.13a4 4 0 0 1 0 7.75"/>
                        </svg>
                        <h3>Belum Ada Penjual</h3>
                        <p>Belum ada mahasiswa yang menjadi penjual di platform ini.</p>
                    </div>
                @endif
            </div>
        </div>
    </main>

    <style>
        .sellers-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
            gap: 20px;
        }
        .seller-card {
            background: white;
            border-radius: 12px;
            padding: 20px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
            transition: all 0.2s;
        }
        .seller-card:hover {
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        }
        .seller-card-header {
            display: flex;
            align-items: center;
            gap: 14px;
            margin-bottom: 16px;
        }
        .seller-card-avatar {
            width: 52px;
            height: 52px;
            background: linear-gradient(135deg, #1e3a5f 0%, #2d4a6f 100%);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 600;
            font-size: 20px;
        }
        .seller-card-name {
            font-size: 16px;
            font-weight: 600;
            color: #1e293b;
            margin: 0 0 4px;
        }
        .seller-card-prodi {
            font-size: 13px;
            color: #64748b;
            margin: 0;
        }
        .seller-card-stats {
            display: flex;
            gap: 12px;
            padding: 16px 0;
            border-top: 1px solid #f1f5f9;
            border-bottom: 1px solid #f1f5f9;
            margin-bottom: 16px;
        }
        .seller-stat {
            flex: 1;
            text-align: center;
        }
        .stat-value {
            display: block;
            font-size: 20px;
            font-weight: 700;
            color: #1e3a5f;
        }
        .stat-label {
            display: block;
            font-size: 11px;
            color: #64748b;
            text-transform: uppercase;
            margin-top: 2px;
        }
        .seller-card-footer {
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
        .seller-join-date {
            display: flex;
            align-items: center;
            gap: 6px;
            font-size: 12px;
            color: #94a3b8;
        }
        .seller-card-link {
            color: #f97316;
            font-size: 13px;
            font-weight: 500;
            text-decoration: none;
        }
        .seller-card-link:hover {
            text-decoration: underline;
        }
    </style>
</body>
</html>
