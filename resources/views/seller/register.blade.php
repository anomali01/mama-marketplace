<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1, user-scalable=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Mulai Jualan - MAMA Marketplace</title>
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
            background: linear-gradient(180deg, #e8f4fd 0%, #f0f7fc 100%);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        /* Header */
        .header {
            background: linear-gradient(135deg, #1a9fff 0%, #0080e0 100%);
            padding: 16px 20px;
            display: flex;
            align-items: center;
            gap: 16px;
        }

        .back-btn {
            width: 40px;
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            text-decoration: none;
            border-radius: 50%;
            transition: background 0.2s;
        }

        .back-btn:hover {
            background: rgba(255, 255, 255, 0.2);
        }

        .back-btn svg {
            width: 24px;
            height: 24px;
        }

        .header-title {
            color: white;
            font-size: 18px;
            font-weight: 600;
        }

        /* Form Section */
        .form-section {
            flex: 1;
            background: linear-gradient(180deg, #ff6a00 0%, #ff8533 100%);
            border-top-left-radius: 32px;
            border-top-right-radius: 32px;
            padding: 24px 24px 40px;
            margin-top: 20px;
            box-shadow: 0 -8px 30px rgba(255, 106, 0, 0.2);
        }

        .handle {
            width: 40px;
            height: 4px;
            background: rgba(255, 255, 255, 0.5);
            border-radius: 100px;
            margin: 0 auto 24px;
        }

        .form-container {
            max-width: 400px;
            margin: 0 auto;
        }

        .form-title {
            color: white;
            font-size: 22px;
            font-weight: 700;
            text-align: center;
            margin-bottom: 8px;
        }

        .form-subtitle {
            color: rgba(255, 255, 255, 0.85);
            font-size: 13px;
            text-align: center;
            margin-bottom: 24px;
            line-height: 1.5;
        }

        .form-group {
            margin-bottom: 16px;
        }

        .form-label {
            display: block;
            color: rgba(255, 255, 255, 0.9);
            font-size: 13px;
            font-weight: 500;
            margin-bottom: 6px;
        }

        .form-input {
            width: 100%;
            padding: 14px 16px;
            font-size: 15px;
            border: none;
            border-radius: 12px;
            background: white;
            color: #333;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
            transition: box-shadow 0.2s;
        }

        .form-input:focus {
            outline: none;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        }

        .form-input::placeholder {
            color: #aaa;
        }

        .form-select {
            width: 100%;
            padding: 14px 16px;
            font-size: 15px;
            border: none;
            border-radius: 12px;
            background: white;
            color: #333;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
            cursor: pointer;
            appearance: none;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='24' height='24' viewBox='0 0 24 24' fill='none' stroke='%23666' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3E%3Cpolyline points='6 9 12 15 18 9'%3E%3C/polyline%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: right 12px center;
            background-size: 20px;
        }

        .form-select:focus {
            outline: none;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        }

        .form-hint {
            color: rgba(255, 255, 255, 0.7);
            font-size: 11px;
            margin-top: 4px;
        }

        .btn-submit {
            width: 100%;
            padding: 14px;
            background: white;
            color: #ff6a00;
            font-size: 16px;
            font-weight: 700;
            border: none;
            border-radius: 50px;
            cursor: pointer;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.15);
            transition: all 0.2s ease;
            margin-top: 8px;
        }

        .btn-submit:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.2);
        }

        /* Info Box */
        .info-box {
            background: rgba(255, 255, 255, 0.15);
            border-radius: 12px;
            padding: 16px;
            margin-bottom: 20px;
        }

        .info-box-title {
            color: white;
            font-size: 14px;
            font-weight: 600;
            margin-bottom: 8px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .info-box-title svg {
            width: 18px;
            height: 18px;
        }

        .info-box ul {
            color: rgba(255, 255, 255, 0.9);
            font-size: 12px;
            padding-left: 20px;
            line-height: 1.6;
        }

        /* Error Messages */
        .error-message {
            background: #fee2e2;
            color: #dc2626;
            padding: 12px 16px;
            border-radius: 12px;
            font-size: 13px;
            margin-bottom: 16px;
        }

        .error-message ul {
            margin: 0;
            padding-left: 20px;
        }

        /* Responsive */
        @media (min-width: 768px) {
            .form-section {
                max-width: 500px;
                margin: 20px auto 0;
                border-radius: 32px;
                margin-bottom: 40px;
            }

            .header {
                justify-content: center;
            }

            .back-btn {
                position: absolute;
                left: 20px;
            }
        }
    </style>
</head>
<body>
    <!-- Header -->
    <header class="header">
        <a href="{{ route('profile.edit') }}" class="back-btn">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M19 12H5M12 19l-7-7 7-7"/>
            </svg>
        </a>
        <h1 class="header-title">Mulai Jualan</h1>
    </header>

    <!-- Form Section -->
    <div class="form-section">
        <div class="handle"></div>
        
        <div class="form-container">
            <h2 class="form-title">Daftar Sebagai Penjual</h2>
            <p class="form-subtitle">
                Untuk bisa menjual di MAMA, kamu harus terdaftar sebagai mahasiswa. 
                Lengkapi data berikut untuk verifikasi.
            </p>

            <!-- Info Box -->
            <div class="info-box">
                <div class="info-box-title">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <circle cx="12" cy="12" r="10"></circle>
                        <line x1="12" y1="16" x2="12" y2="12"></line>
                        <line x1="12" y1="8" x2="12.01" y2="8"></line>
                    </svg>
                    Persyaratan
                </div>
                <ul>
                    <li>Menggunakan email kampus (.ac.id)</li>
                    <li>Memiliki NIM yang valid</li>
                    <li>Data akan diverifikasi oleh validator prodi</li>
                </ul>
            </div>

            @if ($errors->any())
                <div class="error-message">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            
            <form action="{{ route('seller.store') }}" method="POST">
                @csrf
                
                <div class="form-group">
                    <label class="form-label">NIM (Nomor Induk Mahasiswa)</label>
                    <input type="text" name="nim" class="form-input" placeholder="Contoh: 2021001234" value="{{ old('nim') }}" required>
                </div>

                <div class="form-group">
                    <label class="form-label">Email Kampus</label>
                    <input type="email" name="student_email" class="form-input" placeholder="nama@kampus.ac.id" value="{{ old('student_email') }}" required>
                    <p class="form-hint">Gunakan email dengan domain .ac.id</p>
                </div>

                <div class="form-group">
                    <label class="form-label">Program Studi</label>
                    <select name="prodi" class="form-select" required>
                        <option value="">-- Pilih Program Studi --</option>
                        @foreach($studyPrograms as $prodi)
                            <option value="{{ $prodi->name }}" {{ old('prodi') == $prodi->name ? 'selected' : '' }}>
                                {{ $prodi->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label class="form-label">Nomor WhatsApp</label>
                    <input type="tel" name="phone" class="form-input" placeholder="08xxxxxxxxxx" value="{{ old('phone', auth()->user()->phone) }}" required>
                    <p class="form-hint">Untuk komunikasi dengan pembeli</p>
                </div>

                <button type="submit" class="btn-submit">Daftar Sebagai Penjual</button>
            </form>
        </div>
    </div>
</body>
</html>
