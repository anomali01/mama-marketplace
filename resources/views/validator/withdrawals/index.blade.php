<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Permintaan Penarikan Dana - MAMA Marketplace</title>
    <link rel="icon" type="image/png" href="{{ asset('img/logo-mama.png') }}">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background: #f8fafc;
            padding-bottom: 80px;
        }

        .header {
            background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
            color: white;
            padding: 20px;
            position: sticky;
            top: 0;
            z-index: 100;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }

        .header-content {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .back-btn {
            background: rgba(255,255,255,0.2);
            border: none;
            width: 36px;
            height: 36px;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
        }

        .header-title {
            font-size: 20px;
            font-weight: 700;
        }

        .container {
            padding: 20px;
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 12px;
            margin-bottom: 24px;
        }

        .stat-card {
            background: white;
            border-radius: 12px;
            padding: 16px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
        }

        .stat-number {
            font-size: 24px;
            font-weight: 700;
            margin-bottom: 4px;
        }

        .stat-label {
            font-size: 12px;
            color: #64748b;
        }

        .stat-pending {
            color: #f59e0b;
        }

        .stat-processing {
            color: #3b82f6;
        }

        .stat-transferred {
            color: #ef4444;
        }

        .tabs {
            display: flex;
            gap: 8px;
            margin-bottom: 20px;
            background: white;
            padding: 4px;
            border-radius: 12px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
        }

        .tab {
            flex: 1;
            padding: 10px;
            text-align: center;
            border-radius: 8px;
            cursor: pointer;
            font-weight: 600;
            font-size: 14px;
            color: #64748b;
            text-decoration: none;
        }

        .tab.active {
            background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
            color: white;
        }

        .section-title {
            font-size: 18px;
            font-weight: 700;
            color: #1e293b;
            margin-bottom: 16px;
        }

        .withdrawal-card {
            background: white;
            border-radius: 12px;
            padding: 16px;
            margin-bottom: 12px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
            cursor: pointer;
            transition: all 0.2s;
        }

        .withdrawal-card:hover {
            box-shadow: 0 4px 12px rgba(0,0,0,0.15);
            transform: translateY(-2px);
        }

        .card-header {
            display: flex;
            justify-content: space-between;
            align-items: start;
            margin-bottom: 12px;
        }

        .seller-info {
            flex: 1;
        }

        .seller-name {
            font-size: 16px;
            font-weight: 700;
            color: #1e293b;
            margin-bottom: 4px;
        }

        .seller-nim {
            font-size: 13px;
            color: #64748b;
        }

        .amount {
            font-size: 20px;
            font-weight: 700;
            color: #f59e0b;
            text-align: right;
        }

        .bank-info {
            background: #f8fafc;
            padding: 12px;
            border-radius: 8px;
            margin-bottom: 12px;
        }

        .bank-row {
            display: flex;
            justify-content: space-between;
            font-size: 13px;
            margin-bottom: 6px;
        }

        .bank-row:last-child {
            margin-bottom: 0;
        }

        .bank-label {
            color: #64748b;
        }

        .bank-value {
            font-weight: 600;
            color: #1e293b;
        }

        .card-footer {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding-top: 12px;
            border-top: 1px solid #e2e8f0;
        }

        .timestamp {
            font-size: 12px;
            color: #94a3b8;
        }

        .status-badge {
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
        }

        .status-pending {
            background: #fef3c7;
            color: #92400e;
        }

        .status-processing {
            background: #dbeafe;
            color: #1e40af;
        }

        .status-transferred {
            background: #fee2e2;
            color: #991b1b;
        }

        .btn-action {
            width: 100%;
            padding: 12px;
            border: none;
            border-radius: 8px;
            font-weight: 600;
            font-size: 14px;
            cursor: pointer;
            margin-top: 12px;
        }

        .btn-process {
            background: #f59e0b;
            color: white;
        }

        .btn-view {
            background: #3b82f6;
            color: white;
        }

        .empty-state {
            text-align: center;
            padding: 60px 20px;
            color: #94a3b8;
        }

        .empty-state svg {
            margin-bottom: 16px;
        }

        .alert {
            padding: 14px;
            border-radius: 12px;
            margin-bottom: 20px;
            font-size: 14px;
        }

        .alert-success {
            background: #d1fae5;
            color: #065f46;
            border: 1px solid #86efac;
        }

        .alert-error {
            background: #fee2e2;
            color: #991b1b;
            border: 1px solid #fca5a5;
        }

        .nav-bottom {
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            background: white;
            border-top: 1px solid #e2e8f0;
            display: flex;
            justify-content: space-around;
            padding: 12px 0;
            z-index: 100;
        }

        .nav-item {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 4px;
            color: #94a3b8;
            text-decoration: none;
            font-size: 12px;
        }

        .nav-item.active {
            color: #f59e0b;
        }

        .badge {
            position: absolute;
            top: -4px;
            right: -8px;
            background: #ef4444;
            color: white;
            font-size: 10px;
            font-weight: 700;
            padding: 2px 6px;
            border-radius: 10px;
            min-width: 18px;
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="header">
        <div class="header-content">
            <button class="back-btn" onclick="window.location.href='{{ route('validator.dashboard') }}'">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2">
                    <path d="M19 12H5M12 19l-7-7 7-7"/>
                </svg>
            </button>
            <h1 class="header-title">Permintaan Penarikan Dana</h1>
        </div>
    </div>

    <div class="container">
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        @if(session('error'))
            <div class="alert alert-error">{{ session('error') }}</div>
        @endif

        <!-- Stats Grid -->
        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-number stat-pending">{{ $pendingCount }}</div>
                <div class="stat-label">Menunggu</div>
            </div>
            <div class="stat-card">
                <div class="stat-number stat-processing">{{ $processingCount }}</div>
                <div class="stat-label">Diproses</div>
            </div>
            <div class="stat-card">
                <div class="stat-number stat-transferred">{{ $transferredCount }}</div>
                <div class="stat-label">Ditransfer</div>
            </div>
        </div>

        <!-- Tabs -->
        <div class="tabs">
            <a href="{{ route('validator.withdrawals', ['status' => 'pending']) }}" 
               class="tab {{ $currentStatus === 'pending' ? 'active' : '' }}">
                Baru ({{ $pendingCount }})
            </a>
            <a href="{{ route('validator.withdrawals', ['status' => 'processing']) }}" 
               class="tab {{ $currentStatus === 'processing' ? 'active' : '' }}">
                Proses ({{ $processingCount }})
            </a>
            <a href="{{ route('validator.withdrawals', ['status' => 'transferred']) }}" 
               class="tab {{ $currentStatus === 'transferred' ? 'active' : '' }}">
                Transfer ({{ $transferredCount }})
            </a>
        </div>

        <!-- Withdrawal List -->
        @if($withdrawals->count() > 0)
            @foreach($withdrawals as $withdrawal)
                <div class="withdrawal-card" onclick="window.location.href='{{ route('validator.withdrawals.show', $withdrawal) }}'">
                    <div class="card-header">
                        <div class="seller-info">
                            <div class="seller-name">{{ $withdrawal->seller->name }}</div>
                            <div class="seller-nim">{{ $withdrawal->seller->nim }}</div>
                        </div>
                        <div class="amount">Rp{{ number_format($withdrawal->amount, 0, ',', '.') }}</div>
                    </div>

                    <div class="bank-info">
                        <div class="bank-row">
                            <span class="bank-label">Bank</span>
                            <span class="bank-value">{{ $withdrawal->seller_bank_name }}</span>
                        </div>
                        <div class="bank-row">
                            <span class="bank-label">No. Rekening</span>
                            <span class="bank-value">{{ $withdrawal->seller_account_number }}</span>
                        </div>
                        <div class="bank-row">
                            <span class="bank-label">Atas Nama</span>
                            <span class="bank-value">{{ $withdrawal->seller_account_holder_name }}</span>
                        </div>
                    </div>

                    @if($withdrawal->note)
                        <div style="font-size: 13px; color: #64748b; margin-bottom: 12px;">
                            <strong>Catatan:</strong> {{ $withdrawal->note }}
                        </div>
                    @endif

                    <div class="card-footer">
                        <span class="timestamp">{{ $withdrawal->created_at->diffForHumans() }}</span>
                        <span class="status-badge status-{{ $withdrawal->status }}">
                            @if($withdrawal->status === 'pending') ⏳ Menunggu
                            @elseif($withdrawal->status === 'processing') 🔄 Diproses
                            @else ✅ Ditransfer
                            @endif
                        </span>
                    </div>

                    @if($withdrawal->status === 'pending')
                        <form action="{{ route('validator.withdrawals.process', $withdrawal) }}" method="POST" onclick="event.stopPropagation()">
                            @csrf
                            <button type="submit" class="btn-action btn-process" onclick="return confirm('Proses permintaan penarikan ini?')">
                                Proses Sekarang
                            </button>
                        </form>
                    @else
                        <button class="btn-action btn-view" onclick="window.location.href='{{ route('validator.withdrawals.show', $withdrawal) }}'">
                            Lihat Detail
                        </button>
                    @endif
                </div>
            @endforeach

            <div style="margin-top: 20px;">
                {{ $withdrawals->links() }}
            </div>
        @else
            <div class="empty-state">
                <svg width="64" height="64" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                    <rect x="1" y="4" width="22" height="16" rx="2" ry="2"></rect>
                    <line x1="1" y1="10" x2="23" y2="10"></line>
                </svg>
                <p>Tidak ada permintaan penarikan</p>
            </div>
        @endif
    </div>

    <nav class="nav-bottom">
        <a href="{{ route('home') }}" class="nav-item">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>
            </svg>
            <span>Home</span>
        </a>
        <a href="{{ route('validator.dashboard') }}" class="nav-item">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <rect x="3" y="3" width="7" height="7"></rect>
                <rect x="14" y="3" width="7" height="7"></rect>
                <rect x="14" y="14" width="7" height="7"></rect>
                <rect x="3" y="14" width="7" height="7"></rect>
            </svg>
            <span>Dashboard</span>
        </a>
        <a href="{{ route('validator.withdrawals') }}" class="nav-item active" style="position: relative;">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <rect x="1" y="4" width="22" height="16" rx="2" ry="2"></rect>
                <line x1="1" y1="10" x2="23" y2="10"></line>
            </svg>
            <span>Penarikan</span>
            @if($pendingCount > 0)
                <span class="badge">{{ $pendingCount }}</span>
            @endif
        </a>
        <a href="{{ route('profile.edit') }}" class="nav-item">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                <circle cx="12" cy="7" r="4"></circle>
            </svg>
            <span>Profil</span>
        </a>
    </nav>
</body>
</html>
