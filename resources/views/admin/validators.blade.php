<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verifikasi Validator - Admin MAMA</title>
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
        }

        .header {
            background: linear-gradient(135deg, #6366f1 0%, #4f46e5 100%);
            color: white;
            padding: 20px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }

        .header-content {
            max-width: 1200px;
            margin: 0 auto;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .back-btn {
            background: rgba(255,255,255,0.2);
            border: none;
            padding: 10px 20px;
            border-radius: 8px;
            color: white;
            font-weight: 600;
            cursor: pointer;
            text-decoration: none;
        }

        .header-title {
            font-size: 24px;
            font-weight: 700;
        }

        .container {
            max-width: 1200px;
            margin: 30px auto;
            padding: 0 20px;
        }

        .section-title {
            font-size: 20px;
            font-weight: 700;
            color: #1e293b;
            margin-bottom: 16px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .validator-card {
            background: white;
            border-radius: 12px;
            padding: 20px;
            margin-bottom: 16px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
        }

        .validator-header {
            display: flex;
            justify-content: space-between;
            align-items: start;
            margin-bottom: 16px;
        }

        .validator-name {
            font-size: 18px;
            font-weight: 700;
            color: #1e293b;
            margin-bottom: 4px;
        }

        .validator-prodi {
            font-size: 14px;
            color: #64748b;
            background: #f1f5f9;
            padding: 4px 12px;
            border-radius: 12px;
            display: inline-block;
        }

        .validator-info {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 12px;
            margin-bottom: 16px;
        }

        .info-item {
            font-size: 14px;
        }

        .info-label {
            color: #64748b;
            margin-bottom: 4px;
        }

        .info-value {
            color: #1e293b;
            font-weight: 600;
        }

        .action-buttons {
            display: flex;
            gap: 12px;
        }

        .btn {
            padding: 10px 20px;
            border: none;
            border-radius: 8px;
            font-weight: 600;
            cursor: pointer;
            font-size: 14px;
        }

        .btn-approve {
            background: #10b981;
            color: white;
        }

        .btn-reject {
            background: #ef4444;
            color: white;
        }

        .btn:hover {
            opacity: 0.9;
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
            padding: 60px 20px;
            color: #94a3b8;
        }

        .verified-badge {
            background: #d1fae5;
            color: #065f46;
            padding: 6px 12px;
            border-radius: 12px;
            font-size: 12px;
            font-weight: 600;
        }

        .tabs {
            display: flex;
            gap: 12px;
            margin-bottom: 24px;
            border-bottom: 2px solid #e2e8f0;
        }

        .tab {
            padding: 12px 24px;
            background: none;
            border: none;
            color: #64748b;
            font-weight: 600;
            cursor: pointer;
            border-bottom: 3px solid transparent;
            margin-bottom: -2px;
        }

        .tab.active {
            color: #6366f1;
            border-bottom-color: #6366f1;
        }

        .tab-content {
            display: none;
        }

        .tab-content.active {
            display: block;
        }
    </style>
</head>
<body>
    <div class="header">
        <div class="header-content">
            <h1 class="header-title">✅ Verifikasi Validator</h1>
            <a href="{{ route('admin.dashboard') }}" class="back-btn">← Kembali</a>
        </div>
    </div>

    <div class="container">
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        @if(session('error'))
            <div class="alert alert-error">{{ session('error') }}</div>
        @endif

        <!-- Tabs -->
        <div class="tabs">
            <button class="tab active" onclick="switchTab('pending')">
                Menunggu Verifikasi ({{ $pendingValidators->count() }})
            </button>
            <button class="tab" onclick="switchTab('verified')">
                Sudah Diverifikasi ({{ $verifiedValidators->count() }})
            </button>
        </div>

        <!-- Pending Validators -->
        <div class="tab-content active" id="pending-tab">
            <h2 class="section-title">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <circle cx="12" cy="12" r="10"></circle>
                    <path d="M12 6v6l4 2"></path>
                </svg>
                Menunggu Verifikasi
            </h2>

            @if($pendingValidators->count() > 0)
                @foreach($pendingValidators as $validator)
                    <div class="validator-card">
                        <div class="validator-header">
                            <div>
                                <div class="validator-name">{{ $validator->name }}</div>
                                <span class="validator-prodi">
                                    {{ $validator->validatorStudyProgram->name ?? 'Prodi tidak ditemukan' }}
                                    ({{ $validator->validatorStudyProgram->code ?? '-' }})
                                </span>
                            </div>
                        </div>

                        <div class="validator-info">
                            <div class="info-item">
                                <div class="info-label">Email</div>
                                <div class="info-value">{{ $validator->email }}</div>
                            </div>
                            <div class="info-item">
                                <div class="info-label">NIM</div>
                                <div class="info-value">{{ $validator->nim }}</div>
                            </div>
                            <div class="info-item">
                                <div class="info-label">Telepon</div>
                                <div class="info-value">{{ $validator->phone ?? '-' }}</div>
                            </div>
                            <div class="info-item">
                                <div class="info-label">Bank</div>
                                <div class="info-value">{{ $validator->bank_name }} - {{ $validator->account_number }}</div>
                            </div>
                            <div class="info-item">
                                <div class="info-label">Atas Nama</div>
                                <div class="info-value">{{ $validator->account_holder_name }}</div>
                            </div>
                            <div class="info-item">
                                <div class="info-label">Tanggal Daftar</div>
                                <div class="info-value">{{ $validator->created_at->format('d M Y, H:i') }}</div>
                            </div>
                        </div>

                        <div class="action-buttons">
                            <form action="{{ route('admin.validators.approve', $validator) }}" method="POST" style="display: inline;">
                                @csrf
                                <button type="submit" class="btn btn-approve" onclick="return confirm('Verifikasi validator ini?')">
                                    ✓ Verifikasi
                                </button>
                            </form>

                            <form action="{{ route('admin.validators.reject', $validator) }}" method="POST" style="display: inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-reject" onclick="return confirm('Tolak dan hapus validator ini?')">
                                    ✗ Tolak
                                </button>
                            </form>
                        </div>
                    </div>
                @endforeach
            @else
                <div class="empty-state">
                    <svg width="64" height="64" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                        <path d="M9 12l2 2 4-4"></path>
                        <circle cx="12" cy="12" r="10"></circle>
                    </svg>
                    <p>Tidak ada validator yang menunggu verifikasi</p>
                </div>
            @endif
        </div>

        <!-- Verified Validators -->
        <div class="tab-content" id="verified-tab">
            <h2 class="section-title">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M9 12l2 2 4-4"></path>
                    <circle cx="12" cy="12" r="10"></circle>
                </svg>
                Validator Terverifikasi
            </h2>

            @if($verifiedValidators->count() > 0)
                @foreach($verifiedValidators as $validator)
                    <div class="validator-card">
                        <div class="validator-header">
                            <div>
                                <div class="validator-name">{{ $validator->name }}</div>
                                <span class="validator-prodi">
                                    {{ $validator->validatorStudyProgram->name ?? 'Prodi tidak ditemukan' }}
                                    ({{ $validator->validatorStudyProgram->code ?? '-' }})
                                </span>
                            </div>
                            <span class="verified-badge">✓ Terverifikasi</span>
                        </div>

                        <div class="validator-info">
                            <div class="info-item">
                                <div class="info-label">Email</div>
                                <div class="info-value">{{ $validator->email }}</div>
                            </div>
                            <div class="info-item">
                                <div class="info-label">NIM</div>
                                <div class="info-value">{{ $validator->nim }}</div>
                            </div>
                            <div class="info-item">
                                <div class="info-label">Telepon</div>
                                <div class="info-value">{{ $validator->phone ?? '-' }}</div>
                            </div>
                            <div class="info-item">
                                <div class="info-label">Bank</div>
                                <div class="info-value">{{ $validator->bank_name }} - {{ $validator->account_number }}</div>
                            </div>
                        </div>
                    </div>
                @endforeach
            @else
                <div class="empty-state">
                    <svg width="64" height="64" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                        <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                        <circle cx="9" cy="7" r="4"></circle>
                        <path d="M23 21v-2a4 4 0 0 0-3-3.87"></path>
                        <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
                    </svg>
                    <p>Belum ada validator yang terverifikasi</p>
                </div>
            @endif
        </div>
    </div>

    <script>
        function switchTab(tabName) {
            // Update tab buttons
            document.querySelectorAll('.tab').forEach(tab => {
                tab.classList.remove('active');
            });
            event.target.classList.add('active');

            // Update tab content
            document.querySelectorAll('.tab-content').forEach(content => {
                content.classList.remove('active');
            });
            document.getElementById(tabName + '-tab').classList.add('active');
        }
    </script>
</body>
</html>
