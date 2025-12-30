<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1, user-scalable=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Pengaturan Akun - MAMA Marketplace</title>
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
            padding-bottom: 100px;
        }

        /* Header */
        .header {
            background: linear-gradient(135deg, #1a9fff 0%, #0080e0 100%);
            padding: 16px 20px;
            display: flex;
            align-items: center;
            gap: 16px;
            position: sticky;
            top: 0;
            z-index: 100;
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
            flex: 1;
            color: white;
            font-size: 18px;
            font-weight: 600;
        }

        /* Main Content */
        .main-content {
            padding: 16px;
            max-width: 600px;
            margin: 0 auto;
        }

        /* Profile Avatar Section */
        .avatar-section {
            text-align: center;
            padding: 24px 16px;
            background: white;
            border-radius: 16px;
            margin-bottom: 16px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.04);
        }

        .avatar {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            background: linear-gradient(135deg, #1a9fff 0%, #0080e0 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 16px;
            font-size: 40px;
            font-weight: 700;
            color: white;
        }

        .user-name {
            font-size: 20px;
            font-weight: 600;
            color: #333;
            margin-bottom: 4px;
        }

        .user-role {
            font-size: 14px;
            color: #666;
        }

        /* Success/Error Messages */
        .alert {
            padding: 12px 16px;
            border-radius: 12px;
            font-size: 13px;
            margin-bottom: 16px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .alert-success {
            background: #d4edda;
            color: #155724;
        }

        .alert-error {
            background: #f8d7da;
            color: #721c24;
        }

        .alert svg {
            width: 20px;
            height: 20px;
            flex-shrink: 0;
        }

        .error-list {
            margin: 8px 0 0 20px;
            font-size: 12px;
        }

        /* Settings Card */
        .settings-card {
            background: white;
            border-radius: 16px;
            padding: 20px;
            margin-bottom: 16px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.04);
        }

        .settings-title {
            font-size: 15px;
            font-weight: 600;
            color: #333;
            margin-bottom: 16px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .settings-title svg {
            width: 20px;
            height: 20px;
            color: #1a9fff;
        }

        /* Form Group */
        .form-group {
            margin-bottom: 16px;
        }

        .form-group:last-child {
            margin-bottom: 0;
        }

        .form-label {
            display: block;
            font-size: 13px;
            font-weight: 500;
            color: #333;
            margin-bottom: 8px;
        }

        .form-label .required {
            color: #dc2626;
        }

        .form-input {
            width: 100%;
            padding: 12px 16px;
            border: 1px solid #e0e0e0;
            border-radius: 12px;
            font-size: 14px;
            font-family: inherit;
            transition: border-color 0.2s, box-shadow 0.2s;
        }

        .form-input:focus {
            outline: none;
            border-color: #1a9fff;
            box-shadow: 0 0 0 3px rgba(26, 159, 255, 0.1);
        }

        .form-input::placeholder {
            color: #999;
        }

        .form-input:disabled {
            background: #f5f5f5;
            color: #666;
        }

        .form-hint {
            font-size: 11px;
            color: #999;
            margin-top: 6px;
        }

        /* Password Toggle */
        .password-wrapper {
            position: relative;
        }

        .password-toggle {
            position: absolute;
            right: 12px;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            color: #999;
            cursor: pointer;
            padding: 4px;
        }

        .password-toggle:hover {
            color: #666;
        }

        .password-toggle svg {
            width: 20px;
            height: 20px;
        }

        /* Submit Button */
        .btn-submit {
            width: 100%;
            padding: 14px;
            background: linear-gradient(135deg, #1a9fff 0%, #0080e0 100%);
            color: white;
            font-size: 14px;
            font-weight: 600;
            border: none;
            border-radius: 12px;
            cursor: pointer;
            transition: all 0.2s;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            margin-top: 20px;
        }

        .btn-submit:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 15px rgba(26, 159, 255, 0.4);
        }

        .btn-submit:active {
            transform: translateY(0);
        }

        .btn-submit svg {
            width: 18px;
            height: 18px;
        }

        .btn-password {
            background: linear-gradient(135deg, #ff6a00 0%, #ff8533 100%);
        }

        .btn-password:hover {
            box-shadow: 0 4px 15px rgba(255, 106, 0, 0.4);
        }

        /* Danger Zone */
        .danger-zone {
            background: #fff5f5;
            border: 1px solid #fed7d7;
        }

        .danger-zone .settings-title {
            color: #c53030;
        }

        .danger-zone .settings-title svg {
            color: #c53030;
        }

        .btn-danger {
            background: #dc2626;
            color: white;
            padding: 12px 20px;
            border: none;
            border-radius: 12px;
            font-size: 13px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.2s;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .btn-danger:hover {
            background: #b91c1c;
        }

        .btn-danger svg {
            width: 16px;
            height: 16px;
        }

        .danger-text {
            font-size: 13px;
            color: #666;
            margin-bottom: 16px;
            line-height: 1.5;
        }

        /* Modal */
        .modal-overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.5);
            z-index: 1000;
            align-items: center;
            justify-content: center;
            padding: 16px;
        }

        .modal-overlay.active {
            display: flex;
        }

        .modal {
            background: white;
            border-radius: 16px;
            padding: 24px;
            max-width: 400px;
            width: 100%;
        }

        .modal-title {
            font-size: 18px;
            font-weight: 600;
            color: #333;
            margin-bottom: 12px;
        }

        .modal-text {
            font-size: 14px;
            color: #666;
            margin-bottom: 20px;
            line-height: 1.5;
        }

        .modal-actions {
            display: flex;
            gap: 12px;
        }

        .modal-btn {
            flex: 1;
            padding: 12px;
            border-radius: 12px;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.2s;
        }

        .modal-btn-cancel {
            background: #f0f0f0;
            color: #333;
            border: none;
        }

        .modal-btn-cancel:hover {
            background: #e0e0e0;
        }

        .modal-btn-confirm {
            background: #dc2626;
            color: white;
            border: none;
        }

        .modal-btn-confirm:hover {
            background: #b91c1c;
        }

        /* Bottom Navigation */
        .bottom-nav {
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            width: 100%;
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

        /* Responsive */
        @media (min-width: 600px) {
            .main-content {
                padding: 24px;
            }
        }

        @media (min-width: 900px) {
            .bottom-nav {
                width: 100%;
                left: 0;
                right: 0;
                transform: none;
                border-radius: 0;
            }
        }

        /* Safe area for iOS */
        @supports (padding-bottom: env(safe-area-inset-bottom)) {
            body {
                padding-bottom: calc(100px + env(safe-area-inset-bottom));
            }
            
            .bottom-nav {
                padding-bottom: calc(8px + env(safe-area-inset-bottom));
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
        <h1 class="header-title">Pengaturan Akun</h1>
    </header>

    <!-- Main Content -->
    <main class="main-content">
        <!-- Avatar Section -->
        <div class="avatar-section">
            <div class="avatar">
                {{ strtoupper(substr($user->name, 0, 1)) }}
            </div>
            <div class="user-name">{{ $user->name }}</div>
            <div class="user-role">
                @if($user->role === 'validator')
                    Validator
                @elseif($user->role === 'admin')
                    Administrator
                @elseif($user->role === 'mahasiswa')
                    Mahasiswa
                @else
                    Pengguna MAMA
                @endif
            </div>
        </div>

        @if(session('success'))
            <div class="alert alert-success">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path>
                    <polyline points="22 4 12 14.01 9 11.01"></polyline>
                </svg>
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-error">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <circle cx="12" cy="12" r="10"></circle>
                    <line x1="12" y1="8" x2="12" y2="12"></line>
                    <line x1="12" y1="16" x2="12.01" y2="16"></line>
                </svg>
                {{ session('error') }}
            </div>
        @endif

        @if($errors->any())
            <div class="alert alert-error">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <circle cx="12" cy="12" r="10"></circle>
                    <line x1="12" y1="8" x2="12" y2="12"></line>
                    <line x1="12" y1="16" x2="12.01" y2="16"></line>
                </svg>
                <div>
                    <strong>Terjadi kesalahan:</strong>
                    <ul class="error-list">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        @endif

        <!-- Edit Profile Form -->
        <form action="{{ route('profile.settings.update') }}" method="POST">
            @csrf
            @method('PATCH')
            
            <div class="settings-card">
                <h3 class="settings-title">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                        <circle cx="12" cy="7" r="4"></circle>
                    </svg>
                    Informasi Profil
                </h3>

                <div class="form-group">
                    <label class="form-label">
                        Nama Lengkap <span class="required">*</span>
                    </label>
                    <input type="text" name="name" class="form-input" value="{{ old('name', $user->name) }}" placeholder="Masukkan nama lengkap" required>
                </div>

                <div class="form-group">
                    <label class="form-label">
                        Email <span class="required">*</span>
                    </label>
                    <input type="email" name="email" class="form-input" value="{{ old('email', $user->email) }}" placeholder="Masukkan email" required>
                    <p class="form-hint">Email digunakan untuk login dan menerima notifikasi</p>
                </div>

                <div class="form-group">
                    <label class="form-label">Nomor Telepon</label>
                    <input type="tel" name="phone" class="form-input" value="{{ old('phone', $user->phone) }}" placeholder="08xxxxxxxxxx">
                    <p class="form-hint">Nomor telepon untuk dihubungi pembeli/penjual</p>
                </div>

                @if($user->role === 'mahasiswa')
                <div class="form-group">
                    <label class="form-label">NIM</label>
                    <input type="text" class="form-input" value="{{ $user->nim }}" disabled>
                    <p class="form-hint">NIM tidak dapat diubah</p>
                </div>

                <div class="form-group">
                    <label class="form-label">Program Studi</label>
                    <input type="text" class="form-input" value="{{ $user->prodi }}" disabled>
                    <p class="form-hint">Program studi tidak dapat diubah</p>
                </div>
                @endif

                <button type="submit" class="btn-submit">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"></path>
                        <polyline points="17 21 17 13 7 13 7 21"></polyline>
                        <polyline points="7 3 7 8 15 8"></polyline>
                    </svg>
                    Simpan Perubahan
                </button>
            </div>
        </form>

        <!-- Change Password Form -->
        <form action="{{ route('profile.settings.password') }}" method="POST">
            @csrf
            @method('PATCH')
            
            <div class="settings-card">
                <h3 class="settings-title">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect>
                        <path d="M7 11V7a5 5 0 0 1 10 0v4"></path>
                    </svg>
                    Ubah Password
                </h3>

                <div class="form-group">
                    <label class="form-label">
                        Password Saat Ini <span class="required">*</span>
                    </label>
                    <div class="password-wrapper">
                        <input type="password" name="current_password" class="form-input" id="currentPassword" placeholder="Masukkan password saat ini" required>
                        <button type="button" class="password-toggle" onclick="togglePassword('currentPassword', this)">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="eye-icon">
                                <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                                <circle cx="12" cy="12" r="3"></circle>
                            </svg>
                        </button>
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label">
                        Password Baru <span class="required">*</span>
                    </label>
                    <div class="password-wrapper">
                        <input type="password" name="password" class="form-input" id="newPassword" placeholder="Masukkan password baru" required minlength="8">
                        <button type="button" class="password-toggle" onclick="togglePassword('newPassword', this)">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="eye-icon">
                                <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                                <circle cx="12" cy="12" r="3"></circle>
                            </svg>
                        </button>
                    </div>
                    <p class="form-hint">Minimal 8 karakter</p>
                </div>

                <div class="form-group">
                    <label class="form-label">
                        Konfirmasi Password Baru <span class="required">*</span>
                    </label>
                    <div class="password-wrapper">
                        <input type="password" name="password_confirmation" class="form-input" id="confirmPassword" placeholder="Ulangi password baru" required>
                        <button type="button" class="password-toggle" onclick="togglePassword('confirmPassword', this)">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="eye-icon">
                                <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                                <circle cx="12" cy="12" r="3"></circle>
                            </svg>
                        </button>
                    </div>
                </div>

                <button type="submit" class="btn-submit btn-password">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect>
                        <path d="M7 11V7a5 5 0 0 1 10 0v4"></path>
                    </svg>
                    Ubah Password
                </button>
            </div>
        </form>

        <!-- Danger Zone -->
        <div class="settings-card danger-zone">
            <h3 class="settings-title">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"></path>
                    <line x1="12" y1="9" x2="12" y2="13"></line>
                    <line x1="12" y1="17" x2="12.01" y2="17"></line>
                </svg>
                Zona Berbahaya
            </h3>
            <p class="danger-text">
                Menghapus akun akan menghapus semua data Anda secara permanen termasuk produk, pesanan, dan riwayat transaksi. Tindakan ini tidak dapat dibatalkan.
            </p>
            <button type="button" class="btn-danger" onclick="showDeleteModal()">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <polyline points="3 6 5 6 21 6"></polyline>
                    <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
                </svg>
                Hapus Akun
            </button>
        </div>
    </main>

    <!-- Delete Account Modal -->
    <div class="modal-overlay" id="deleteModal">
        <div class="modal">
            <h3 class="modal-title">Hapus Akun?</h3>
            <p class="modal-text">
                Apakah Anda yakin ingin menghapus akun? Semua data akan dihapus secara permanen dan tidak dapat dikembalikan.
            </p>
            <form action="{{ route('profile.destroy') }}" method="POST">
                @csrf
                @method('DELETE')
                <div class="form-group" style="margin-bottom: 16px;">
                    <label class="form-label">Masukkan password untuk konfirmasi:</label>
                    <input type="password" name="password" class="form-input" placeholder="Password" required>
                </div>
                <div class="modal-actions">
                    <button type="button" class="modal-btn modal-btn-cancel" onclick="hideDeleteModal()">Batal</button>
                    <button type="submit" class="modal-btn modal-btn-confirm">Ya, Hapus Akun</button>
                </div>
            </form>
        </div>
    </div>

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

    <script>
        function togglePassword(inputId, button) {
            const input = document.getElementById(inputId);
            const icon = button.querySelector('.eye-icon');
            
            if (input.type === 'password') {
                input.type = 'text';
                icon.innerHTML = `
                    <path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24"></path>
                    <line x1="1" y1="1" x2="23" y2="23"></line>
                `;
            } else {
                input.type = 'password';
                icon.innerHTML = `
                    <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                    <circle cx="12" cy="12" r="3"></circle>
                `;
            }
        }

        function showDeleteModal() {
            document.getElementById('deleteModal').classList.add('active');
        }

        function hideDeleteModal() {
            document.getElementById('deleteModal').classList.remove('active');
        }

        // Close modal on overlay click
        document.getElementById('deleteModal').addEventListener('click', function(e) {
            if (e.target === this) {
                hideDeleteModal();
            }
        });
    </script>
</body>
</html>
