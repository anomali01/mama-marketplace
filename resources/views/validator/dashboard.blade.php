<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Dashboard Validator - MAMA Marketplace</title>
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
            background: #f5f7fa;
            min-height: 100vh;
        }

        /* Sidebar */
        .sidebar {
            position: fixed;
            left: 0;
            top: 0;
            width: 260px;
            height: 100vh;
            background: linear-gradient(180deg, #1e3a5f 0%, #0d2137 100%);
            padding: 20px 0;
            z-index: 100;
            overflow-y: auto;
        }

        .sidebar-header {
            padding: 0 20px 20px;
            border-bottom: 1px solid rgba(255,255,255,0.1);
            margin-bottom: 20px;
        }

        .sidebar-logo {
            display: flex;
            align-items: center;
            gap: 12px;
            color: white;
            text-decoration: none;
        }

        .sidebar-logo-icon {
            width: 45px;
            height: 45px;
            background: linear-gradient(135deg, #ff6a00, #ff8533);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .sidebar-logo-icon svg {
            width: 28px;
            height: 28px;
            color: white;
        }

        .sidebar-logo-text {
            font-size: 18px;
            font-weight: 700;
        }

        .sidebar-logo-sub {
            font-size: 11px;
            color: rgba(255,255,255,0.6);
        }

        .sidebar-menu {
            list-style: none;
            padding: 0 12px;
        }

        .sidebar-menu-title {
            color: rgba(255,255,255,0.4);
            font-size: 11px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 1px;
            padding: 16px 12px 8px;
        }

        .sidebar-menu-item {
            margin-bottom: 4px;
        }

        .sidebar-menu-link {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px 16px;
            color: rgba(255,255,255,0.7);
            text-decoration: none;
            border-radius: 10px;
            transition: all 0.2s;
            font-size: 14px;
        }

        .sidebar-menu-link:hover {
            background: rgba(255,255,255,0.1);
            color: white;
        }

        .sidebar-menu-link.active {
            background: linear-gradient(135deg, #ff6a00, #ff8533);
            color: white;
            font-weight: 500;
        }

        .sidebar-menu-link svg {
            width: 20px;
            height: 20px;
            flex-shrink: 0;
        }

        .sidebar-menu-badge {
            margin-left: auto;
            background: #ff6a00;
            color: white;
            font-size: 11px;
            font-weight: 600;
            padding: 2px 8px;
            border-radius: 10px;
        }

        .sidebar-menu-link.active .sidebar-menu-badge {
            background: white;
            color: #ff6a00;
        }

        /* Main Content */
        .main-content {
            margin-left: 260px;
            min-height: 100vh;
        }

        /* Header */
        .header {
            background: white;
            padding: 16px 30px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
            position: sticky;
            top: 0;
            z-index: 50;
        }

        .header-title {
            font-size: 20px;
            font-weight: 600;
            color: #1e3a5f;
        }

        .header-user {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .header-user-avatar {
            width: 40px;
            height: 40px;
            background: linear-gradient(135deg, #1e3a5f, #0d2137);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 600;
            font-size: 16px;
        }

        .header-user-info {
            text-align: right;
        }

        .header-user-name {
            font-size: 14px;
            font-weight: 600;
            color: #333;
        }

        .header-user-role {
            font-size: 12px;
            color: #666;
        }

        /* Content Area */
        .content {
            padding: 30px;
        }

        /* Stats Cards */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 20px;
            margin-bottom: 30px;
        }

        .stat-card {
            background: white;
            border-radius: 16px;
            padding: 24px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
        }

        .stat-card-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 16px;
        }

        .stat-card-icon {
            width: 48px;
            height: 48px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .stat-card-icon svg {
            width: 24px;
            height: 24px;
        }

        .stat-card-icon.pending {
            background: #fff3cd;
            color: #ff9800;
        }

        .stat-card-icon.approved {
            background: #d4edda;
            color: #28a745;
        }

        .stat-card-icon.rejected {
            background: #f8d7da;
            color: #dc3545;
        }

        .stat-card-icon.sellers {
            background: #e3f2fd;
            color: #2196f3;
        }

        .stat-card-value {
            font-size: 32px;
            font-weight: 700;
            color: #1e3a5f;
            margin-bottom: 4px;
        }

        .stat-card-label {
            font-size: 13px;
            color: #666;
        }

        /* Table Section */
        .section {
            background: white;
            border-radius: 16px;
            padding: 24px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
        }

        .section-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 20px;
        }

        .section-title {
            font-size: 16px;
            font-weight: 600;
            color: #1e3a5f;
        }

        .section-link {
            color: #ff6a00;
            text-decoration: none;
            font-size: 13px;
            font-weight: 500;
        }

        .section-link:hover {
            text-decoration: underline;
        }

        /* Table */
        .table {
            width: 100%;
            border-collapse: collapse;
        }

        .table th {
            text-align: left;
            padding: 12px 16px;
            font-size: 12px;
            font-weight: 600;
            color: #666;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            border-bottom: 2px solid #f0f0f0;
        }

        .table td {
            padding: 16px;
            border-bottom: 1px solid #f0f0f0;
            font-size: 14px;
            color: #333;
        }

        .table tr:last-child td {
            border-bottom: none;
        }

        .table tr:hover {
            background: #f9f9f9;
        }

        .product-cell {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .product-image {
            width: 50px;
            height: 50px;
            border-radius: 8px;
            object-fit: cover;
            background: #f0f0f0;
        }

        .product-name {
            font-weight: 500;
        }

        .product-category {
            font-size: 12px;
            color: #666;
        }

        .seller-cell {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .seller-avatar {
            width: 32px;
            height: 32px;
            background: #1e3a5f;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 12px;
            font-weight: 600;
        }

        .status-badge {
            display: inline-flex;
            align-items: center;
            gap: 4px;
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 500;
        }

        .status-badge.pending {
            background: #fff3cd;
            color: #856404;
        }

        .status-badge.verified {
            background: #d4edda;
            color: #155724;
        }

        .status-badge.rejected {
            background: #f8d7da;
            color: #721c24;
        }

        .action-btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 32px;
            height: 32px;
            border-radius: 8px;
            text-decoration: none;
            transition: all 0.2s;
        }

        .action-btn svg {
            width: 18px;
            height: 18px;
        }

        .action-btn.view {
            background: #e3f2fd;
            color: #1976d2;
        }

        .action-btn.view:hover {
            background: #bbdefb;
        }

        /* Empty State */
        .empty-state {
            text-align: center;
            padding: 40px;
            color: #666;
        }

        .empty-state svg {
            width: 60px;
            height: 60px;
            margin-bottom: 16px;
            opacity: 0.5;
        }

        /* Logout Form */
        .logout-form {
            padding: 12px;
            border-top: 1px solid rgba(255,255,255,0.1);
            margin-top: auto;
        }

        .logout-btn {
            display: flex;
            align-items: center;
            gap: 12px;
            width: 100%;
            padding: 12px 16px;
            background: rgba(220, 53, 69, 0.2);
            color: #ff6b6b;
            border: none;
            border-radius: 10px;
            font-size: 14px;
            font-family: inherit;
            cursor: pointer;
            transition: all 0.2s;
        }

        .logout-btn:hover {
            background: rgba(220, 53, 69, 0.3);
        }

        .logout-btn svg {
            width: 20px;
            height: 20px;
        }

        /* Responsive */
        @media (max-width: 1200px) {
            .stats-grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        @media (max-width: 768px) {
            .sidebar {
                transform: translateX(-100%);
            }

            .main-content {
                margin-left: 0;
            }

            .stats-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>
    <!-- Sidebar -->
    <aside class="sidebar">
        <div class="sidebar-header">
            <a href="{{ route('validator.dashboard') }}" class="sidebar-logo">
                <div class="sidebar-logo-icon">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M9 12l2 2 4-4"/>
                        <path d="M12 22c5.523 0 10-4.477 10-10S17.523 2 12 2 2 6.477 2 12s4.477 10 10 10z"/>
                    </svg>
                </div>
                <div>
                    <div class="sidebar-logo-text">MAMA</div>
                    <div class="sidebar-logo-sub">Validator Panel</div>
                </div>
            </a>
        </div>

        <ul class="sidebar-menu">
            <li class="sidebar-menu-title">Menu Utama</li>
            <li class="sidebar-menu-item">
                <a href="{{ route('validator.dashboard') }}" class="sidebar-menu-link active">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <rect x="3" y="3" width="7" height="9" rx="1"/>
                        <rect x="14" y="3" width="7" height="5" rx="1"/>
                        <rect x="14" y="12" width="7" height="9" rx="1"/>
                        <rect x="3" y="16" width="7" height="5" rx="1"/>
                    </svg>
                    Dashboard
                </a>
            </li>

            <li class="sidebar-menu-title">Verifikasi Produk</li>
            <li class="sidebar-menu-item">
                <a href="{{ route('validator.products.pending') }}" class="sidebar-menu-link">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <circle cx="12" cy="12" r="10"/>
                        <path d="M12 6v6l4 2"/>
                    </svg>
                    Menunggu Verifikasi
                    @if($stats['pending'] > 0)
                        <span class="sidebar-menu-badge">{{ $stats['pending'] }}</span>
                    @endif
                </a>
            </li>
            <li class="sidebar-menu-item">
                <a href="{{ route('validator.products.verified') }}" class="sidebar-menu-link">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M9 12l2 2 4-4"/>
                        <circle cx="12" cy="12" r="10"/>
                    </svg>
                    Terverifikasi
                </a>
            </li>
            <li class="sidebar-menu-item">
                <a href="{{ route('validator.products.rejected') }}" class="sidebar-menu-link">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <circle cx="12" cy="12" r="10"/>
                        <path d="M15 9l-6 6M9 9l6 6"/>
                    </svg>
                    Ditolak
                </a>
            </li>

            <li class="sidebar-menu-title">Penjual</li>
            <li class="sidebar-menu-item">
                <a href="{{ route('validator.sellers.index') }}" class="sidebar-menu-link">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/>
                        <circle cx="9" cy="7" r="4"/>
                        <path d="M23 21v-2a4 4 0 0 0-3-3.87"/>
                        <path d="M16 3.13a4 4 0 0 1 0 7.75"/>
                    </svg>
                    Daftar Penjual
                </a>
            </li>

            <li class="sidebar-menu-title">Penarikan Dana</li>
            <li class="sidebar-menu-item">
                <a href="{{ route('validator.withdrawals') }}" class="sidebar-menu-link">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <rect x="1" y="4" width="22" height="16" rx="2" ry="2"/>
                        <line x1="1" y1="10" x2="23" y2="10"/>
                    </svg>
                    Permintaan Penarikan
                </a>
            </li>
        </ul>

        <form action="{{ route('logout') }}" method="POST" class="logout-form">
            @csrf
            <button type="submit" class="logout-btn">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/>
                    <polyline points="16 17 21 12 16 7"/>
                    <line x1="21" y1="12" x2="9" y2="12"/>
                </svg>
                Logout
            </button>
        </form>
    </aside>

    <!-- Main Content -->
    <main class="main-content">
        <!-- Header -->
        <header class="header">
            <h1 class="header-title">Dashboard</h1>
            <div class="header-user">
                <div class="header-user-info">
                    <div class="header-user-name">{{ $user->name }}</div>
                    <div class="header-user-role">Validator</div>
                </div>
                <div class="header-user-avatar">
                    {{ strtoupper(substr($user->name, 0, 1)) }}
                </div>
            </div>
        </header>

        <!-- Content -->
        <div class="content">
            <!-- Stats -->
            <div class="stats-grid">
                <div class="stat-card">
                    <div class="stat-card-header">
                        <div class="stat-card-icon pending">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <circle cx="12" cy="12" r="10"/>
                                <path d="M12 6v6l4 2"/>
                            </svg>
                        </div>
                    </div>
                    <div class="stat-card-value">{{ $stats['pending'] }}</div>
                    <div class="stat-card-label">Menunggu Verifikasi</div>
                </div>

                <div class="stat-card">
                    <div class="stat-card-header">
                        <div class="stat-card-icon approved">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M9 12l2 2 4-4"/>
                                <circle cx="12" cy="12" r="10"/>
                            </svg>
                        </div>
                    </div>
                    <div class="stat-card-value">{{ $stats['approved'] }}</div>
                    <div class="stat-card-label">Terverifikasi</div>
                </div>

                <div class="stat-card">
                    <div class="stat-card-header">
                        <div class="stat-card-icon rejected">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <circle cx="12" cy="12" r="10"/>
                                <path d="M15 9l-6 6M9 9l6 6"/>
                            </svg>
                        </div>
                    </div>
                    <div class="stat-card-value">{{ $stats['rejected'] }}</div>
                    <div class="stat-card-label">Ditolak</div>
                </div>

                <div class="stat-card">
                    <div class="stat-card-header">
                        <div class="stat-card-icon sellers">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/>
                                <circle cx="9" cy="7" r="4"/>
                            </svg>
                        </div>
                    </div>
                    <div class="stat-card-value">{{ $stats['total_sellers'] }}</div>
                    <div class="stat-card-label">Total Penjual</div>
                </div>
            </div>

            <!-- Rekening Bank Info -->
            <div class="section">
                <div style="background: linear-gradient(135deg, #fef3c7 0%, #fde68a 100%); border: 2px solid #fbbf24; border-radius: 16px; padding: 24px; margin-bottom: 24px;">
                    <div style="display: flex; align-items: center; gap: 12px; margin-bottom: 16px;">
                        <div style="background: white; width: 48px; height: 48px; border-radius: 12px; display: flex; align-items: center; justify-content: center;">
                            <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="#f59e0b" stroke-width="2">
                                <rect x="1" y="4" width="22" height="16" rx="2" ry="2"></rect>
                                <line x1="1" y1="10" x2="23" y2="10"></line>
                            </svg>
                        </div>
                        <div>
                            <h3 style="font-size: 18px; font-weight: 700; color: #92400e; margin: 0;">Rekening Validator</h3>
                            <p style="font-size: 13px; color: #b45309; margin: 4px 0 0 0;">Rekening untuk menerima pembayaran dari pembeli</p>
                        </div>
                    </div>
                    <div style="background: white; border-radius: 12px; padding: 16px; display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 16px;">
                        <div>
                            <div style="color: #64748b; font-size: 12px; margin-bottom: 4px;">Nama Bank</div>
                            <div style="color: #1e293b; font-size: 16px; font-weight: 600;">{{ $user->bank_name ?? '-' }}</div>
                        </div>
                        <div>
                            <div style="color: #64748b; font-size: 12px; margin-bottom: 4px;">Nomor Rekening</div>
                            <div style="color: #1e293b; font-size: 16px; font-weight: 600;">{{ $user->account_number ?? '-' }}</div>
                        </div>
                        <div>
                            <div style="color: #64748b; font-size: 12px; margin-bottom: 4px;">Atas Nama</div>
                            <div style="color: #1e293b; font-size: 16px; font-weight: 600;">{{ $user->account_holder_name ?? '-' }}</div>
                        </div>
                    </div>
                </div>

                <!-- Tracking Dana -->
                <div style="background: white; border-radius: 16px; padding: 24px; box-shadow: 0 1px 3px rgba(0,0,0,0.1); margin-bottom: 24px;">
                    <h3 style="font-size: 18px; font-weight: 700; color: #1e293b; margin-bottom: 20px; display: flex; align-items: center; gap: 8px;">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#0ea5e9" stroke-width="2">
                            <line x1="12" y1="1" x2="12" y2="23"></line>
                            <path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"></path>
                        </svg>
                        Tracking Dana
                    </h3>
                    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 16px; margin-bottom: 20px;">
                        <div style="background: #fefce8; border: 2px solid #fde047; border-radius: 12px; padding: 16px;">
                            <div style="color: #713f12; font-size: 13px; margin-bottom: 8px; font-weight: 500;">⭐ Saldo Validator</div>
                            <div style="color: #b45309; font-size: 24px; font-weight: 700;">Rp{{ number_format($transactionStats['validator_balance'] ?? 0, 0, ',', '.') }}</div>
                            <div style="color: #ca8a04; font-size: 11px; margin-top: 4px;">Fee 3% dari transaksi</div>
                        </div>
                        <div style="background: #fff7ed; border: 2px solid #fdba74; border-radius: 12px; padding: 16px;">
                            <div style="color: #9a3412; font-size: 13px; margin-bottom: 8px; font-weight: 500;">⏳ Pending Transfer</div>
                            <div style="color: #ea580c; font-size: 24px; font-weight: 700;">Rp{{ number_format($transactionStats['pending_withdrawals'] ?? 0, 0, ',', '.') }}</div>
                            <div style="color: #f97316; font-size: 11px; margin-top: 4px;">Harus transfer ke penjual</div>
                        </div>
                        <div style="background: #f0fdf4; border: 2px solid #86efac; border-radius: 12px; padding: 16px;">
                            <div style="color: #166534; font-size: 13px; margin-bottom: 8px; font-weight: 500;">✅ Sudah Transfer</div>
                            <div style="color: #15803d; font-size: 24px; font-weight: 700;">Rp{{ number_format($transactionStats['total_transferred'] ?? 0, 0, ',', '.') }}</div>
                            <div style="color: #16a34a; font-size: 11px; margin-top: 4px;">Total terkirim</div>
                        </div>
                    </div>

                    <!-- Recent Transactions -->
                    @if(isset($recentTransactions) && $recentTransactions->count() > 0)
                    <div style="border-top: 2px solid #f1f5f9; padding-top: 20px;">
                        <h4 style="font-size: 15px; font-weight: 600; color: #475569; margin-bottom: 12px;">Transaksi Terbaru</h4>
                        <div style="overflow-x: auto;">
                            <table style="width: 100%; font-size: 13px;">
                                <thead>
                                    <tr style="border-bottom: 2px solid #e2e8f0;">
                                        <th style="text-align: left; padding: 8px; color: #64748b; font-weight: 600;">Tanggal</th>
                                        <th style="text-align: left; padding: 8px; color: #64748b; font-weight: 600;">Tipe</th>
                                        <th style="text-align: left; padding: 8px; color: #64748b; font-weight: 600;">Penjual</th>
                                        <th style="text-align: right; padding: 8px; color: #64748b; font-weight: 600;">Jumlah</th>
                                        <th style="text-align: center; padding: 8px; color: #64748b; font-weight: 600;">Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($recentTransactions as $transaction)
                                    <tr style="border-bottom: 1px solid #f1f5f9;">
                                        <td style="padding: 10px; color: #475569;">{{ $transaction->created_at->format('d M Y, H:i') }}</td>
                                        <td style="padding: 10px;">
                                            @if($transaction->type === 'validator_commission')
                                                <span style="background: #d1fae5; color: #065f46; padding: 4px 10px; border-radius: 12px; font-size: 11px; font-weight: 600;">💰 Komisi</span>
                                            @elseif($transaction->type === 'order_income')
                                                <span style="background: #dbeafe; color: #1e40af; padding: 4px 10px; border-radius: 12px; font-size: 11px; font-weight: 600;">📦 Pesanan</span>
                                            @else
                                                <span style="background: #fee2e2; color: #991b1b; padding: 4px 10px; border-radius: 12px; font-size: 11px; font-weight: 600;">📤 {{ ucfirst($transaction->type) }}</span>
                                            @endif
                                        </td>
                                        <td style="padding: 10px; color: #475569;">{{ $transaction->order->items->first()?->product?->seller?->name ?? $transaction->description ?? '-' }}</td>
                                        <td style="padding: 10px; text-align: right; font-weight: 600; color: #16a34a;">
                                            +Rp{{ number_format($transaction->amount, 0, ',', '.') }}
                                        </td>
                                        <td style="padding: 10px; text-align: center;">
                                            @if($transaction->status === 'completed')
                                                <span style="color: #16a34a; font-weight: 600;">✓</span>
                                            @elseif($transaction->status === 'pending')
                                                <span style="color: #f59e0b; font-weight: 600;">⏳</span>
                                            @else
                                                <span style="color: #dc2626; font-weight: 600;">✗</span>
                                            @endif
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    @else
                    <div style="text-align: center; padding: 32px; color: #94a3b8;">
                        <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" style="margin: 0 auto 12px;">
                            <rect x="1" y="4" width="22" height="16" rx="2" ry="2"></rect>
                            <line x1="1" y1="10" x2="23" y2="10"></line>
                        </svg>
                        <p style="font-size: 14px; margin: 0;">Belum ada transaksi</p>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Saldo Penjual yang Harus Dibayar -->
            @if(isset($sellerBalances) && $sellerBalances->count() > 0)
            <div class="section">
                <div class="section-header">
                    <h2 class="section-title">Saldo Penjual (Prodi {{ $user->validatorProdi->name ?? '-' }})</h2>
                    <a href="{{ route('validator.withdrawals') }}" class="section-link">Lihat Penarikan →</a>
                </div>

                <div style="background: white; border-radius: 16px; padding: 24px; box-shadow: 0 1px 3px rgba(0,0,0,0.1);">
                    <div style="overflow-x: auto;">
                        <table style="width: 100%; font-size: 14px;">
                            <thead>
                                <tr style="border-bottom: 2px solid #e2e8f0;">
                                    <th style="text-align: left; padding: 12px; color: #64748b; font-weight: 600;">Penjual</th>
                                    <th style="text-align: right; padding: 12px; color: #64748b; font-weight: 600;">Total Saldo</th>
                                    <th style="text-align: right; padding: 12px; color: #64748b; font-weight: 600;">Pending</th>
                                    <th style="text-align: right; padding: 12px; color: #64748b; font-weight: 600;">Tersedia Ditarik</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($sellerBalances as $balance)
                                <tr style="border-bottom: 1px solid #f1f5f9;">
                                    <td style="padding: 12px;">
                                        <div style="display: flex; align-items: center; gap: 10px;">
                                            <div style="width: 36px; height: 36px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border-radius: 50%; display: flex; align-items: center; justify-content: center; color: white; font-weight: 600; font-size: 14px;">
                                                {{ strtoupper(substr($balance->user->name ?? '?', 0, 1)) }}
                                            </div>
                                            <div>
                                                <div style="font-weight: 600; color: #1e293b;">{{ $balance->user->name ?? '-' }}</div>
                                                <div style="font-size: 12px; color: #64748b;">{{ $balance->user->nim ?? '-' }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td style="padding: 12px; text-align: right; font-weight: 600; color: #1e293b;">
                                        Rp{{ number_format($balance->amount, 0, ',', '.') }}
                                    </td>
                                    <td style="padding: 12px; text-align: right; color: #f59e0b;">
                                        Rp{{ number_format($balance->pending, 0, ',', '.') }}
                                    </td>
                                    <td style="padding: 12px; text-align: right;">
                                        <span style="background: #dcfce7; color: #166534; padding: 6px 12px; border-radius: 8px; font-weight: 600;">
                                            Rp{{ number_format($balance->available, 0, ',', '.') }}
                                        </span>
                                    </td>
                                </tr>
                                @endforeach
                                <tr style="background: #f8fafc; font-weight: 700;">
                                    <td style="padding: 12px; color: #1e293b;">TOTAL</td>
                                    <td style="padding: 12px; text-align: right; color: #1e293b;">
                                        Rp{{ number_format($sellerBalances->sum('amount'), 0, ',', '.') }}
                                    </td>
                                    <td style="padding: 12px; text-align: right; color: #f59e0b;">
                                        Rp{{ number_format($sellerBalances->sum('pending'), 0, ',', '.') }}
                                    </td>
                                    <td style="padding: 12px; text-align: right; color: #16a34a;">
                                        Rp{{ number_format($sellerBalances->sum('available'), 0, ',', '.') }}
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div style="margin-top: 16px; padding: 12px; background: #fef3c7; border-left: 4px solid #f59e0b; border-radius: 8px;">
                        <p style="margin: 0; font-size: 13px; color: #92400e;">
                            <strong>💡 Info:</strong> Kolom "Pending" menunjukkan saldo yang sedang dalam proses penarikan. Silakan cek menu Penarikan untuk memproses permintaan transfer.
                        </p>
                    </div>
                </div>
            </div>
            @endif

            <!-- Pending Sellers - Penjual Menunggu Verifikasi -->
            @if(isset($pendingSellers) && $pendingSellers->count() > 0)
            <div class="section">
                <div class="section-header">
                    <h2 class="section-title">Penjual Menunggu Verifikasi ({{ $pendingSellers->count() }})</h2>
                </div>

                <div style="background: white; border-radius: 16px; padding: 24px; box-shadow: 0 1px 3px rgba(0,0,0,0.1);">
                    <div style="overflow-x: auto;">
                        <table style="width: 100%; font-size: 14px;">
                            <thead>
                                <tr style="border-bottom: 2px solid #e2e8f0;">
                                    <th style="text-align: left; padding: 12px; color: #64748b; font-weight: 600;">Penjual</th>
                                    <th style="text-align: left; padding: 12px; color: #64748b; font-weight: 600;">NIM</th>
                                    <th style="text-align: left; padding: 12px; color: #64748b; font-weight: 600;">Program Studi</th>
                                    <th style="text-align: left; padding: 12px; color: #64748b; font-weight: 600;">Telepon</th>
                                    <th style="text-align: left; padding: 12px; color: #64748b; font-weight: 600;">Terdaftar</th>
                                    <th style="text-align: center; padding: 12px; color: #64748b; font-weight: 600;">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($pendingSellers as $seller)
                                <tr style="border-bottom: 1px solid #f1f5f9;">
                                    <td style="padding: 12px;">
                                        <div style="display: flex; align-items: center; gap: 10px;">
                                            <div style="width: 40px; height: 40px; background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%); border-radius: 50%; display: flex; align-items: center; justify-content: center; color: white; font-weight: 700; font-size: 16px;">
                                                {{ strtoupper(substr($seller->name, 0, 1)) }}
                                            </div>
                                            <div>
                                                <div style="font-weight: 600; color: #1e293b;">{{ $seller->name }}</div>
                                                <div style="font-size: 12px; color: #64748b;">{{ $seller->email }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td style="padding: 12px; color: #475569; font-weight: 500;">{{ $seller->nim }}</td>
                                    <td style="padding: 12px; color: #475569;">{{ $seller->prodi }}</td>
                                    <td style="padding: 12px; color: #475569;">{{ $seller->phone }}</td>
                                    <td style="padding: 12px; color: #64748b; font-size: 13px;">{{ $seller->created_at->diffForHumans() }}</td>
                                    <td style="padding: 12px; text-align: center;">
                                        <form action="{{ route('validator.sellers.verify', $seller->id) }}" method="POST" style="display: inline;">
                                            @csrf
                                            <button type="submit" style="background: linear-gradient(135deg, #10b981 0%, #059669 100%); color: white; border: none; padding: 8px 16px; border-radius: 8px; font-weight: 600; font-size: 13px; cursor: pointer; transition: all 0.2s;">
                                                ✓ Verifikasi
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            @endif

            <!-- Pending Products -->
            <div class="section">
                <div class="section-header">
                    <h2 class="section-title">Produk Menunggu Verifikasi</h2>
                    <a href="{{ route('validator.products.pending') }}" class="section-link">Lihat Semua →</a>
                </div>

                @if($pendingProducts->count() > 0)
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Produk</th>
                                <th>Penjual</th>
                                <th>Harga</th>
                                <th>Tanggal</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($pendingProducts as $product)
                                <tr>
                                    <td>
                                        <div class="product-cell">
                                            @php
                                                $img = ($product->images && is_array($product->images) && count($product->images) > 0)
                                                    ? asset('storage/' . $product->images[0])
                                                    : null;
                                            @endphp
                                            @if($img)
                                                <img src="{{ $img }}" alt="" class="product-image">
                                            @else
                                                <div class="product-image" style="display:flex;align-items:center;justify-content:center;color:#999;">
                                                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                                                        <rect x="3" y="3" width="18" height="18" rx="2"/>
                                                        <circle cx="8.5" cy="8.5" r="1.5"/>
                                                        <path d="M21 15l-5-5L5 21"/>
                                                    </svg>
                                                </div>
                                            @endif
                                            <div>
                                                <div class="product-name">{{ Str::limit($product->name, 30) }}</div>
                                                <div class="product-category">{{ $product->category->name ?? '-' }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="seller-cell">
                                            <div class="seller-avatar">{{ strtoupper(substr($product->seller->name ?? 'U', 0, 1)) }}</div>
                                            <span>{{ $product->seller->name ?? 'Unknown' }}</span>
                                        </div>
                                    </td>
                                    <td>Rp{{ number_format($product->price, 0, ',', '.') }}</td>
                                    <td>{{ $product->created_at->format('d M Y') }}</td>
                                    <td>
                                        <a href="{{ route('validator.products.show', $product) }}" class="action-btn view" title="Lihat Detail">
                                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                                <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/>
                                                <circle cx="12" cy="12" r="3"/>
                                            </svg>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @else
                    <div class="empty-state">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                            <path d="M9 12l2 2 4-4"/>
                            <circle cx="12" cy="12" r="10"/>
                        </svg>
                        <p>Tidak ada produk yang menunggu verifikasi.</p>
                    </div>
                @endif
            </div>
        </div>
    </main>
</body>
</html>
