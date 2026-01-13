<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Penarikan Dana - MAMA Marketplace</title>
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
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
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

        .balance-card {
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
            border-radius: 16px;
            padding: 24px;
            color: white;
            margin-bottom: 24px;
            box-shadow: 0 4px 20px rgba(16, 185, 129, 0.3);
        }

        .balance-label {
            font-size: 14px;
            opacity: 0.9;
            margin-bottom: 8px;
        }

        .balance-amount {
            font-size: 32px;
            font-weight: 700;
            margin-bottom: 16px;
        }

        .balance-stats {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 12px;
            margin-top: 16px;
            padding-top: 16px;
            border-top: 1px solid rgba(255,255,255,0.2);
        }

        .stat-item {
            background: rgba(255,255,255,0.15);
            padding: 12px;
            border-radius: 8px;
        }

        .stat-label {
            font-size: 12px;
            opacity: 0.8;
            margin-bottom: 4px;
        }

        .stat-value {
            font-size: 18px;
            font-weight: 600;
        }

        .btn-withdraw {
            width: 100%;
            padding: 14px;
            background: white;
            color: #059669;
            border: none;
            border-radius: 12px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            margin-top: 16px;
        }

        .section-title {
            font-size: 18px;
            font-weight: 700;
            color: #1e293b;
            margin-bottom: 16px;
        }

        .withdrawal-item {
            background: white;
            border-radius: 12px;
            padding: 16px;
            margin-bottom: 12px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
        }

        .withdrawal-header {
            display: flex;
            justify-content: space-between;
            align-items: start;
            margin-bottom: 12px;
        }

        .withdrawal-amount {
            font-size: 20px;
            font-weight: 700;
            color: #10b981;
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

        .status-completed {
            background: #d1fae5;
            color: #065f46;
        }

        .withdrawal-info {
            font-size: 13px;
            color: #64748b;
            margin-bottom: 8px;
        }

        .withdrawal-date {
            font-size: 12px;
            color: #94a3b8;
        }

        .btn-confirm {
            width: 100%;
            padding: 10px;
            background: #10b981;
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 14px;
            font-weight: 600;
            margin-top: 12px;
            cursor: pointer;
        }

        .proof-image {
            width: 100%;
            max-width: 300px;
            border-radius: 8px;
            margin-top: 12px;
            cursor: pointer;
        }

        .modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0,0,0,0.5);
            z-index: 1000;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .modal-content {
            background: white;
            border-radius: 20px;
            padding: 24px;
            max-width: 500px;
            width: 100%;
            max-height: 90vh;
            overflow-y: auto;
        }

        .modal-header {
            font-size: 20px;
            font-weight: 700;
            margin-bottom: 20px;
            color: #1e293b;
        }

        .form-group {
            margin-bottom: 16px;
        }

        .form-label {
            display: block;
            font-size: 14px;
            font-weight: 600;
            color: #334155;
            margin-bottom: 8px;
        }

        .form-control {
            width: 100%;
            padding: 12px;
            border: 2px solid #e2e8f0;
            border-radius: 8px;
            font-size: 15px;
        }

        .form-control:focus {
            outline: none;
            border-color: #10b981;
        }

        .btn-submit {
            width: 100%;
            padding: 14px;
            background: #10b981;
            color: white;
            border: none;
            border-radius: 12px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
        }

        .btn-cancel {
            width: 100%;
            padding: 14px;
            background: #f1f5f9;
            color: #64748b;
            border: none;
            border-radius: 12px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            margin-top: 8px;
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

        .empty-state {
            text-align: center;
            padding: 40px 20px;
            color: #94a3b8;
        }

        .empty-state svg {
            margin-bottom: 16px;
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
            color: #667eea;
        }
    </style>
</head>
<body>
    <div class="header">
        <div class="header-content">
            <button class="back-btn" onclick="window.location.href='{{ route('seller.dashboard') }}'">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2">
                    <path d="M19 12H5M12 19l-7-7 7-7"/>
                </svg>
            </button>
            <h1 class="header-title">Penarikan Dana</h1>
        </div>
    </div>

    <div class="container">
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        @if(session('error'))
            <div class="alert alert-error">{{ session('error') }}</div>
        @endif

        <!-- Balance Card -->
        <div class="balance-card">
            <div class="balance-label">Saldo Tersedia</div>
            <div class="balance-amount">Rp{{ number_format($balance->available ?? 0, 0, ',', '.') }}</div>
            
            <div class="balance-stats">
                <div class="stat-item">
                    <div class="stat-label">Total Saldo</div>
                    <div class="stat-value">Rp{{ number_format($balance->amount ?? 0, 0, ',', '.') }}</div>
                </div>
                <div class="stat-item">
                    <div class="stat-label">Pending Withdrawal</div>
                    <div class="stat-value">Rp{{ number_format($balance->pending ?? 0, 0, ',', '.') }}</div>
                </div>
                <div class="stat-item">
                    <div class="stat-label">Sudah Ditarik</div>
                    <div class="stat-value">Rp{{ number_format($totalWithdrawn, 0, ',', '.') }}</div>
                </div>
            </div>

            @if(($balance->available ?? 0) >= 10000)
                <button class="btn-withdraw" onclick="openWithdrawModal()">Tarik Dana Sekarang</button>
            @else
                <button class="btn-withdraw" style="opacity: 0.5; cursor: not-allowed;" disabled>
                    Minimal penarikan Rp10.000
                </button>
            @endif
        </div>

        <!-- Withdrawal History -->
        <h2 class="section-title">Riwayat Penarikan</h2>

        @if($withdrawals->count() > 0)
            @foreach($withdrawals as $withdrawal)
                <div class="withdrawal-item">
                    <div class="withdrawal-header">
                        <div class="withdrawal-amount">Rp{{ number_format($withdrawal->amount, 0, ',', '.') }}</div>
                        <span class="status-badge status-{{ $withdrawal->status }}">
                            @if($withdrawal->status === 'pending') ⏳ Menunggu
                            @elseif($withdrawal->status === 'processing') 🔄 Diproses
                            @elseif($withdrawal->status === 'transferred') ✅ Ditransfer
                            @elseif($withdrawal->status === 'completed') ✓ Selesai
                            @else ✗ Ditolak
                            @endif
                        </span>
                    </div>

                    <div class="withdrawal-info">
                        <strong>Bank:</strong> {{ $withdrawal->seller_bank_name }}<br>
                        <strong>Rekening:</strong> {{ $withdrawal->seller_account_number }}<br>
                        <strong>Atas Nama:</strong> {{ $withdrawal->seller_account_holder_name }}
                    </div>

                    @if($withdrawal->note)
                        <div class="withdrawal-info" style="margin-top: 8px;">
                            <strong>Catatan:</strong> {{ $withdrawal->note }}
                        </div>
                    @endif

                    @if($withdrawal->validator)
                        <div class="withdrawal-info" style="margin-top: 8px;">
                            <strong>Validator:</strong> {{ $withdrawal->validator->name }}
                        </div>
                    @endif

                    <div class="withdrawal-date">
                        {{ $withdrawal->created_at->format('d M Y, H:i') }}
                    </div>

                    @if($withdrawal->status === 'transferred' && $withdrawal->transfer_proof)
                        <img src="{{ asset('storage/' . $withdrawal->transfer_proof) }}" 
                             class="proof-image" 
                             alt="Bukti Transfer"
                             onclick="window.open('{{ asset('storage/' . $withdrawal->transfer_proof) }}', '_blank')">
                        
                        <form action="{{ route('seller.withdrawals.confirm', $withdrawal) }}" method="POST">
                            @csrf
                            <button type="submit" class="btn-confirm" onclick="return confirm('Konfirmasi bahwa dana sudah diterima?')">
                                Konfirmasi Dana Diterima
                            </button>
                        </form>
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
                <p>Belum ada penarikan dana</p>
            </div>
        @endif
    </div>

    <!-- Withdrawal Modal -->
    <div class="modal" id="withdrawModal">
        <div class="modal-content">
            <h2 class="modal-header">Request Penarikan Dana</h2>
            
            <form action="{{ route('seller.withdrawals.store') }}" method="POST">
                @csrf

                <div class="form-group">
                    <label class="form-label">Jumlah Penarikan</label>
                    <input type="number" name="amount" class="form-control" 
                           min="10000" max="{{ $balance->available ?? 0 }}" 
                           placeholder="Minimal Rp10.000" required>
                    <small style="color: #64748b; font-size: 12px; margin-top: 4px; display: block;">
                        Maksimal: Rp{{ number_format($balance->available ?? 0, 0, ',', '.') }}
                    </small>
                </div>

                <div class="form-group">
                    <label class="form-label">Nama Bank</label>
                    <select name="seller_bank_name" class="form-control" required>
                        <option value="">Pilih Bank</option>
                        <option value="BCA" {{ Auth::user()->seller_bank_name == 'BCA' ? 'selected' : '' }}>BCA</option>
                        <option value="BRI" {{ Auth::user()->seller_bank_name == 'BRI' ? 'selected' : '' }}>BRI</option>
                        <option value="BNI" {{ Auth::user()->seller_bank_name == 'BNI' ? 'selected' : '' }}>BNI</option>
                        <option value="Mandiri" {{ Auth::user()->seller_bank_name == 'Mandiri' ? 'selected' : '' }}>Mandiri</option>
                        <option value="BSI" {{ Auth::user()->seller_bank_name == 'BSI' ? 'selected' : '' }}>BSI</option>
                        <option value="CIMB Niaga" {{ Auth::user()->seller_bank_name == 'CIMB Niaga' ? 'selected' : '' }}>CIMB Niaga</option>
                        <option value="Danamon" {{ Auth::user()->seller_bank_name == 'Danamon' ? 'selected' : '' }}>Danamon</option>
                        <option value="GoPay" {{ Auth::user()->seller_bank_name == 'GoPay' ? 'selected' : '' }}>GoPay</option>
                        <option value="OVO" {{ Auth::user()->seller_bank_name == 'OVO' ? 'selected' : '' }}>OVO</option>
                        <option value="DANA" {{ Auth::user()->seller_bank_name == 'DANA' ? 'selected' : '' }}>DANA</option>
                    </select>
                </div>

                <div class="form-group">
                    <label class="form-label">Nomor Rekening / E-Wallet</label>
                    <input type="text" name="seller_account_number" class="form-control" 
                           value="{{ Auth::user()->seller_account_number }}" 
                           placeholder="Masukkan nomor rekening" required>
                </div>

                <div class="form-group">
                    <label class="form-label">Nama Pemilik Rekening</label>
                    <input type="text" name="seller_account_holder_name" class="form-control" 
                           value="{{ Auth::user()->seller_account_holder_name }}" 
                           placeholder="Sesuai rekening" required>
                </div>

                <div class="form-group">
                    <label class="form-label">Catatan (Opsional)</label>
                    <textarea name="note" class="form-control" rows="3" placeholder="Tambahkan catatan jika perlu"></textarea>
                </div>

                <button type="submit" class="btn-submit">Kirim Permintaan</button>
                <button type="button" class="btn-cancel" onclick="closeWithdrawModal()">Batal</button>
            </form>
        </div>
    </div>

    <nav class="nav-bottom">
        <a href="{{ route('home') }}" class="nav-item">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>
            </svg>
            <span>Home</span>
        </a>
        <a href="{{ route('seller.products') }}" class="nav-item">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <rect x="2" y="7" width="20" height="14" rx="2" ry="2"></rect>
                <path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"></path>
            </svg>
            <span>Produk</span>
        </a>
        <a href="{{ route('seller.withdrawals') }}" class="nav-item active">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <rect x="1" y="4" width="22" height="16" rx="2" ry="2"></rect>
                <line x1="1" y1="10" x2="23" y2="10"></line>
            </svg>
            <span>Tarik Dana</span>
        </a>
        <a href="{{ route('profile.edit') }}" class="nav-item">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                <circle cx="12" cy="7" r="4"></circle>
            </svg>
            <span>Profil</span>
        </a>
    </nav>

    <script>
        function openWithdrawModal() {
            document.getElementById('withdrawModal').style.display = 'flex';
        }

        function closeWithdrawModal() {
            document.getElementById('withdrawModal').style.display = 'none';
        }

        // Close modal when clicking outside
        document.getElementById('withdrawModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeWithdrawModal();
            }
        });
    </script>
</body>
</html>
