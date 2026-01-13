<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Detail Penarikan Dana - MAMA Marketplace</title>
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
            padding-bottom: 100px;
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

        .status-header {
            background: white;
            border-radius: 16px;
            padding: 24px;
            margin-bottom: 20px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
            text-align: center;
        }

        .status-badge-large {
            display: inline-block;
            padding: 12px 24px;
            border-radius: 30px;
            font-size: 16px;
            font-weight: 700;
            margin-bottom: 16px;
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

        .amount-large {
            font-size: 36px;
            font-weight: 700;
            color: #f59e0b;
            margin-bottom: 8px;
        }

        .amount-label {
            font-size: 14px;
            color: #64748b;
        }

        .info-card {
            background: white;
            border-radius: 12px;
            padding: 20px;
            margin-bottom: 16px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
        }

        .card-title {
            font-size: 16px;
            font-weight: 700;
            color: #1e293b;
            margin-bottom: 16px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .info-row {
            display: flex;
            justify-content: space-between;
            padding: 12px 0;
            border-bottom: 1px solid #f1f5f9;
        }

        .info-row:last-child {
            border-bottom: none;
        }

        .info-label {
            font-size: 14px;
            color: #64748b;
        }

        .info-value {
            font-size: 14px;
            font-weight: 600;
            color: #1e293b;
            text-align: right;
        }

        .bank-card {
            background: linear-gradient(135deg, #1e293b 0%, #334155 100%);
            border-radius: 16px;
            padding: 24px;
            color: white;
            margin-bottom: 16px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.2);
        }

        .bank-name {
            font-size: 18px;
            font-weight: 700;
            margin-bottom: 20px;
            opacity: 0.9;
        }

        .account-number {
            font-size: 24px;
            font-weight: 700;
            letter-spacing: 2px;
            margin-bottom: 12px;
        }

        .account-holder {
            font-size: 14px;
            opacity: 0.8;
        }

        .btn-copy {
            background: rgba(255,255,255,0.2);
            border: none;
            padding: 8px 16px;
            border-radius: 8px;
            color: white;
            font-size: 13px;
            font-weight: 600;
            cursor: pointer;
            margin-top: 12px;
        }

        .upload-section {
            background: #fef3c7;
            border: 2px dashed #f59e0b;
            border-radius: 12px;
            padding: 24px;
            text-align: center;
            margin-bottom: 16px;
        }

        .upload-icon {
            width: 64px;
            height: 64px;
            background: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 16px;
        }

        .upload-title {
            font-size: 16px;
            font-weight: 700;
            color: #92400e;
            margin-bottom: 8px;
        }

        .upload-desc {
            font-size: 13px;
            color: #92400e;
            opacity: 0.8;
            margin-bottom: 16px;
        }

        .file-input-wrapper {
            position: relative;
            overflow: hidden;
            display: inline-block;
        }

        .file-input-wrapper input[type=file] {
            position: absolute;
            left: -9999px;
        }

        .btn-upload {
            padding: 12px 24px;
            background: #f59e0b;
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
        }

        .preview-image {
            width: 100%;
            max-width: 400px;
            border-radius: 12px;
            margin-top: 16px;
            cursor: pointer;
        }

        .btn-submit {
            width: 100%;
            padding: 16px;
            background: #10b981;
            color: white;
            border: none;
            border-radius: 12px;
            font-size: 16px;
            font-weight: 700;
            cursor: pointer;
            margin-top: 16px;
        }

        .btn-submit:disabled {
            background: #94a3b8;
            cursor: not-allowed;
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

        .alert-warning {
            background: #fef3c7;
            color: #92400e;
            border: 1px solid #fde68a;
        }

        .timeline {
            position: relative;
            padding-left: 30px;
        }

        .timeline-item {
            position: relative;
            padding-bottom: 24px;
        }

        .timeline-item:last-child {
            padding-bottom: 0;
        }

        .timeline-item::before {
            content: '';
            position: absolute;
            left: -30px;
            top: 0;
            width: 2px;
            height: 100%;
            background: #e2e8f0;
        }

        .timeline-item:last-child::before {
            display: none;
        }

        .timeline-dot {
            position: absolute;
            left: -36px;
            top: 0;
            width: 14px;
            height: 14px;
            border-radius: 50%;
            background: #10b981;
            border: 3px solid white;
            box-shadow: 0 0 0 2px #10b981;
        }

        .timeline-dot.pending {
            background: #f59e0b;
            box-shadow: 0 0 0 2px #f59e0b;
        }

        .timeline-content {
            font-size: 14px;
        }

        .timeline-title {
            font-weight: 600;
            color: #1e293b;
            margin-bottom: 4px;
        }

        .timeline-time {
            font-size: 12px;
            color: #94a3b8;
        }

        .proof-uploaded {
            background: #d1fae5;
            border: 2px solid #10b981;
            border-radius: 12px;
            padding: 20px;
            text-align: center;
        }

        .proof-title {
            font-size: 16px;
            font-weight: 700;
            color: #065f46;
            margin-bottom: 16px;
        }
    </style>
</head>
<body>
    <div class="header">
        <div class="header-content">
            <button class="back-btn" onclick="window.location.href='{{ route('validator.withdrawals') }}'">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2">
                    <path d="M19 12H5M12 19l-7-7 7-7"/>
                </svg>
            </button>
            <h1 class="header-title">Detail Penarikan</h1>
        </div>
    </div>

    <div class="container">
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        @if(session('error'))
            <div class="alert alert-error">{{ session('error') }}</div>
        @endif

        <!-- Status Header -->
        <div class="status-header">
            <div class="status-badge-large status-{{ $withdrawal->status }}">
                @if($withdrawal->status === 'pending') ⏳ Menunggu Diproses
                @elseif($withdrawal->status === 'processing') 🔄 Sedang Diproses
                @else ✅ Sudah Ditransfer
                @endif
            </div>
            <div class="amount-large">Rp{{ number_format($withdrawal->amount, 0, ',', '.') }}</div>
            <div class="amount-label">Jumlah yang harus ditransfer (97% dari penjualan)</div>
        </div>

        <!-- Seller Info -->
        <div class="info-card">
            <div class="card-title">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                    <circle cx="12" cy="7" r="4"></circle>
                </svg>
                Informasi Penjual
            </div>
            <div class="info-row">
                <span class="info-label">Nama</span>
                <span class="info-value">{{ $withdrawal->seller->name }}</span>
            </div>
            <div class="info-row">
                <span class="info-label">NIM</span>
                <span class="info-value">{{ $withdrawal->seller->nim }}</span>
            </div>
            <div class="info-row">
                <span class="info-label">Email</span>
                <span class="info-value">{{ $withdrawal->seller->email }}</span>
            </div>
            @if($withdrawal->note)
                <div class="info-row">
                    <span class="info-label">Catatan</span>
                    <span class="info-value">{{ $withdrawal->note }}</span>
                </div>
            @endif
        </div>

        <!-- Bank Account Card -->
        <div class="bank-card">
            <div class="bank-name">{{ $withdrawal->seller_bank_name }}</div>
            <div class="account-number" id="accountNumber">{{ $withdrawal->seller_account_number }}</div>
            <div class="account-holder">{{ $withdrawal->seller_account_holder_name }}</div>
            <button class="btn-copy" onclick="copyAccountNumber()">
                📋 Salin Nomor Rekening
            </button>
        </div>

        <!-- Transaction Details -->
        <div class="info-card">
            <div class="card-title">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <line x1="12" y1="1" x2="12" y2="23"></line>
                    <path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"></path>
                </svg>
                Detail Transaksi
            </div>
            <div class="info-row">
                <span class="info-label">Total Penjualan</span>
                <span class="info-value">Rp{{ number_format($withdrawal->total_sales, 0, ',', '.') }}</span>
            </div>
            <div class="info-row">
                <span class="info-label">Fee Validator (3%)</span>
                <span class="info-value">Rp{{ number_format($withdrawal->validator_fee, 0, ',', '.') }}</span>
            </div>
            <div class="info-row">
                <span class="info-label">Jumlah Transfer (97%)</span>
                <span class="info-value" style="color: #f59e0b; font-size: 16px;">Rp{{ number_format($withdrawal->amount, 0, ',', '.') }}</span>
            </div>
            <div class="info-row">
                <span class="info-label">Tanggal Request</span>
                <span class="info-value">{{ $withdrawal->created_at->format('d M Y, H:i') }}</span>
            </div>
        </div>

        <!-- Upload Section or Proof -->
        @if($withdrawal->status === 'processing' && !$withdrawal->transfer_proof)
            <div class="alert alert-warning">
                ⚠️ Silakan transfer dana sebesar <strong>Rp{{ number_format($withdrawal->amount, 0, ',', '.') }}</strong> ke rekening di atas, lalu upload bukti transfer.
            </div>

            <div class="upload-section">
                <div class="upload-icon">
                    <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="#f59e0b" stroke-width="2">
                        <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path>
                        <polyline points="17 8 12 3 7 8"></polyline>
                        <line x1="12" y1="3" x2="12" y2="15"></line>
                    </svg>
                </div>
                <div class="upload-title">Upload Bukti Transfer</div>
                <div class="upload-desc">Upload foto/screenshot bukti transfer (JPG, PNG, max 2MB)</div>
                
                <form id="uploadForm" action="{{ route('validator.withdrawals.upload-proof', $withdrawal) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="file-input-wrapper">
                        <label for="transfer_proof" class="btn-upload">
                            📸 Pilih File
                        </label>
                        <input type="file" id="transfer_proof" name="transfer_proof" accept="image/*" required onchange="previewImage(this)">
                    </div>
                    <div id="preview"></div>
                    <button type="submit" class="btn-submit" id="submitBtn" disabled>
                        Konfirmasi Transfer
                    </button>
                </form>
            </div>

        @elseif($withdrawal->transfer_proof)
            <div class="proof-uploaded">
                <div class="proof-title">✅ Bukti Transfer Telah Diupload</div>
                <img src="{{ asset('storage/' . $withdrawal->transfer_proof) }}" 
                     class="preview-image" 
                     alt="Bukti Transfer"
                     onclick="window.open('{{ asset('storage/' . $withdrawal->transfer_proof) }}', '_blank')">
                <div style="margin-top: 12px; font-size: 13px; color: #065f46;">
                    Klik gambar untuk memperbesar
                </div>
            </div>

            @if($withdrawal->status === 'transferred')
                <div class="alert alert-warning">
                    ⏳ Menunggu konfirmasi dari penjual bahwa dana sudah diterima
                </div>
            @endif
        @endif

        <!-- Timeline -->
        <div class="info-card">
            <div class="card-title">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <circle cx="12" cy="12" r="10"></circle>
                    <polyline points="12 6 12 12 16 14"></polyline>
                </svg>
                Timeline
            </div>
            <div class="timeline">
                <div class="timeline-item">
                    <div class="timeline-dot"></div>
                    <div class="timeline-content">
                        <div class="timeline-title">Request Dibuat</div>
                        <div class="timeline-time">{{ $withdrawal->created_at->format('d M Y, H:i') }}</div>
                    </div>
                </div>

                @if($withdrawal->status !== 'pending')
                    <div class="timeline-item">
                        <div class="timeline-dot"></div>
                        <div class="timeline-content">
                            <div class="timeline-title">Diproses oleh Validator</div>
                            <div class="timeline-time">{{ $withdrawal->updated_at->format('d M Y, H:i') }}</div>
                        </div>
                    </div>
                @endif

                @if($withdrawal->transfer_proof)
                    <div class="timeline-item">
                        <div class="timeline-dot"></div>
                        <div class="timeline-content">
                            <div class="timeline-title">Bukti Transfer Diupload</div>
                            <div class="timeline-time">{{ $withdrawal->updated_at->format('d M Y, H:i') }}</div>
                        </div>
                    </div>
                @endif

                @if($withdrawal->status === 'completed')
                    <div class="timeline-item">
                        <div class="timeline-dot"></div>
                        <div class="timeline-content">
                            <div class="timeline-title">Dikonfirmasi oleh Penjual</div>
                            <div class="timeline-time">{{ $withdrawal->updated_at->format('d M Y, H:i') }}</div>
                        </div>
                    </div>
                @else
                    <div class="timeline-item">
                        <div class="timeline-dot pending"></div>
                        <div class="timeline-content">
                            <div class="timeline-title" style="color: #94a3b8;">Menunggu Konfirmasi Penjual</div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <script>
        function copyAccountNumber() {
            const accountNumber = document.getElementById('accountNumber').textContent;
            navigator.clipboard.writeText(accountNumber).then(() => {
                alert('✅ Nomor rekening berhasil disalin!');
            });
        }

        function previewImage(input) {
            const preview = document.getElementById('preview');
            const submitBtn = document.getElementById('submitBtn');
            
            if (input.files && input.files[0]) {
                const reader = new FileReader();
                
                reader.onload = function(e) {
                    preview.innerHTML = `<img src="${e.target.result}" class="preview-image" alt="Preview">`;
                    submitBtn.disabled = false;
                }
                
                reader.readAsDataURL(input.files[0]);
            }
        }
    </script>
</body>
</html>
