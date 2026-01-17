<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1, user-scalable=no">
    <title>Daftar Validator - MAMA Marketplace</title>
    <link rel="icon" type="image/png" href="{{ asset('img/logo-mama.png') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        html, body {
            height: 100%;
            font-family: 'Poppins', -apple-system, BlinkMacSystemFont, sans-serif;
        }

        body {
            background: linear-gradient(180deg, #fef3c7 0%, #fef9e7 100%);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        .logo-section {
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 30px 20px 15px;
        }

        .logo-wrapper {
            width: 90px;
            height: 90px;
            background: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 8px 30px rgba(251, 191, 36, 0.3);
            border: 3px solid #fbbf24;
        }

        .logo-wrapper img {
            width: 60px;
            height: 60px;
        }

        .container {
            flex: 1;
            display: flex;
            justify-content: center;
            align-items: flex-start;
            padding: 20px;
            padding-bottom: 60px;
        }

        .register-card {
            background: white;
            border-radius: 24px;
            padding: 32px 24px;
            width: 100%;
            max-width: 450px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.12);
        }

        .header-section {
            text-align: center;
            margin-bottom: 28px;
        }

        .header-section h1 {
            font-size: 26px;
            font-weight: 700;
            color: #1e293b;
            margin-bottom: 8px;
        }

        .validator-badge {
            display: inline-block;
            background: linear-gradient(135deg, #fbbf24 0%, #f59e0b 100%);
            color: white;
            padding: 6px 16px;
            border-radius: 20px;
            font-size: 13px;
            font-weight: 600;
            margin-bottom: 12px;
        }

        .header-section p {
            font-size: 14px;
            color: #64748b;
            line-height: 1.6;
        }

        .alert {
            background: #fffbeb;
            border: 2px solid #fbbf24;
            border-radius: 12px;
            padding: 14px;
            margin-bottom: 24px;
            font-size: 13px;
            color: #92400e;
            line-height: 1.6;
        }

        .alert strong {
            display: block;
            margin-bottom: 4px;
            color: #b45309;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            font-size: 14px;
            font-weight: 600;
            color: #334155;
            margin-bottom: 8px;
        }

        .form-group label .required {
            color: #ef4444;
        }

        .form-control {
            width: 100%;
            padding: 14px 16px;
            border: 2px solid #e2e8f0;
            border-radius: 12px;
            font-size: 15px;
            transition: all 0.3s;
            background: #f8fafc;
        }

        .form-control:focus {
            outline: none;
            border-color: #fbbf24;
            background: white;
            box-shadow: 0 0 0 3px rgba(251, 191, 36, 0.1);
        }

        .form-control.error {
            border-color: #ef4444;
        }

        .error-message {
            color: #ef4444;
            font-size: 12px;
            margin-top: 6px;
            display: block;
        }

        .helper-text {
            color: #64748b;
            font-size: 12px;
            margin-top: 6px;
            display: block;
        }

        .btn-register {
            width: 100%;
            padding: 16px;
            background: linear-gradient(135deg, #fbbf24 0%, #f59e0b 100%);
            color: white;
            border: none;
            border-radius: 12px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s;
            margin-top: 8px;
        }

        .btn-register:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(251, 191, 36, 0.4);
        }

        .login-link {
            text-align: center;
            margin-top: 24px;
            font-size: 14px;
            color: #64748b;
        }

        .login-link a {
            color: #f59e0b;
            text-decoration: none;
            font-weight: 600;
        }

        .login-link a:hover {
            text-decoration: underline;
        }

        @media (max-width: 480px) {
            .register-card {
                padding: 24px 20px;
            }
            
            .header-section h1 {
                font-size: 22px;
            }
        }
    </style>
</head>
<body>
    <div class="logo-section">
        <div class="logo-wrapper">
            <img src="{{ asset('img/logo-mama.png') }}" alt="MAMA Logo">
        </div>
    </div>

    <div class="container">
        <div class="register-card">
            <div class="header-section">
                <span class="validator-badge">✓ VALIDATOR</span>
                <h1>Daftar sebagai Validator</h1>
                <p>Bergabunglah untuk memverifikasi produk mahasiswa</p>
            </div>

            <div class="alert">
                <strong>📋 Persyaratan Validator:</strong>
                • Email harus menggunakan domain kampus (@student.namakampus.co.id)<br>
                • Memiliki NIM aktif<br>
                • Memiliki rekening bank untuk menerima pembayaran
            </div>

            @if ($errors->any())
                <div style="background: #fef2f2; border: 2px solid #ef4444; border-radius: 12px; padding: 14px; margin-bottom: 20px;">
                    <ul style="margin: 0; padding-left: 20px; color: #dc2626; font-size: 13px;">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('register.validator.post') }}">
                @csrf

                <div class="form-group">
                    <label>Nama Lengkap <span class="required">*</span></label>
                    <input type="text" name="name" class="form-control" value="{{ old('name') }}" required placeholder="Masukkan nama lengkap Anda">
                </div>

                <div class="form-group">
                    <label>Email Kampus <span class="required">*</span></label>
                    <input type="email" name="email" class="form-control" value="{{ old('email') }}" required placeholder="nama@student.kampus.ac.id">
                    <span class="helper-text">Harus menggunakan email kampus (@student.namakampus.co.id atau .ac.id)</span>
                </div>

                <div class="form-group">
                    <label>NIM (Nomor Induk Mahasiswa) <span class="required">*</span></label>
                    <input type="text" name="nim" class="form-control" value="{{ old('nim') }}" required placeholder="Contoh: 1234567890">
                </div>

                <div class="form-group">
                    <label>Program Studi yang Divalidasi <span class="required">*</span></label>
                    <select name="validator_prodi_id" class="form-control" required>
                        <option value="">Pilih Program Studi</option>
                        @foreach($prodis as $prodi)
                            @php
                                $hasValidator = $prodi->validators_count > 0;
                            @endphp
                            <option value="{{ $prodi->id }}" 
                                {{ old('validator_prodi_id') == $prodi->id ? 'selected' : '' }}
                                {{ $hasValidator ? 'disabled' : '' }}>
                                {{ $prodi->name }} ({{ $prodi->code }})
                                {{ $hasValidator ? ' - Sudah ada validator' : '' }}
                            </option>
                        @endforeach
                    </select>
                    <span class="helper-text">⚠️ Hanya 1 validator per prodi yang diperbolehkan. Pilih prodi yang tersedia (tidak disabled).</span>
                </div>

                <div class="form-group">
                    <label>Nomor Telepon <span class="required">*</span></label>
                    <input type="tel" name="phone" class="form-control" value="{{ old('phone') }}" required placeholder="08xxxxxxxxxx">
                </div>

                <div class="form-group">
                    <label>Nama Bank <span class="required">*</span></label>
                    <select name="bank_name" class="form-control" required>
                        <option value="">Pilih Bank</option>
                        <option value="BCA" {{ old('bank_name') == 'BCA' ? 'selected' : '' }}>BCA</option>
                        <option value="BRI" {{ old('bank_name') == 'BRI' ? 'selected' : '' }}>BRI</option>
                        <option value="BNI" {{ old('bank_name') == 'BNI' ? 'selected' : '' }}>BNI</option>
                        <option value="Mandiri" {{ old('bank_name') == 'Mandiri' ? 'selected' : '' }}>Mandiri</option>
                        <option value="BSI" {{ old('bank_name') == 'BSI' ? 'selected' : '' }}>BSI (Bank Syariah Indonesia)</option>
                        <option value="CIMB Niaga" {{ old('bank_name') == 'CIMB Niaga' ? 'selected' : '' }}>CIMB Niaga</option>
                        <option value="Danamon" {{ old('bank_name') == 'Danamon' ? 'selected' : '' }}>Danamon</option>
                        <option value="BTN" {{ old('bank_name') == 'BTN' ? 'selected' : '' }}>BTN</option>
                        <option value="Permata" {{ old('bank_name') == 'Permata' ? 'selected' : '' }}>Permata</option>
                        <option value="Lainnya" {{ old('bank_name') == 'Lainnya' ? 'selected' : '' }}>Lainnya</option>
                    </select>
                    <span class="helper-text">Rekening ini akan digunakan untuk menerima pembayaran dari pembeli</span>
                </div>

                <div class="form-group">
                    <label>Nomor Rekening <span class="required">*</span></label>
                    <input type="text" name="account_number" class="form-control" value="{{ old('account_number') }}" required placeholder="Masukkan nomor rekening">
                </div>

                <div class="form-group">
                    <label>Nama Pemilik Rekening <span class="required">*</span></label>
                    <input type="text" name="account_holder_name" class="form-control" value="{{ old('account_holder_name') }}" required placeholder="Sesuai dengan nama di buku tabungan">
                </div>

                <div class="form-group">
                    <label>Password <span class="required">*</span></label>
                    <input type="password" name="password" class="form-control" required placeholder="Minimal 8 karakter">
                </div>

                <div class="form-group">
                    <label>Konfirmasi Password <span class="required">*</span></label>
                    <input type="password" name="password_confirmation" class="form-control" required placeholder="Ulangi password">
                </div>

                <button type="submit" class="btn-register">Daftar sebagai Validator</button>
            </form>

            <div class="login-link">
                Sudah punya akun? <a href="{{ route('login') }}">Login di sini</a><br>
                <a href="{{ route('register') }}" style="color: #0ea5e9; margin-top: 8px; display: inline-block;">Daftar sebagai User Biasa</a>
            </div>
        </div>
    </div>
</body>
</html>
