<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1, user-scalable=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Edit Data Toko - MAMA Marketplace</title>
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

        /* Success Message */
        .success-message {
            background: #d4edda;
            color: #155724;
            padding: 12px 16px;
            border-radius: 12px;
            font-size: 13px;
            margin-bottom: 16px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .success-message svg {
            width: 20px;
            height: 20px;
            flex-shrink: 0;
        }

        /* Error Message */
        .error-message {
            background: #f8d7da;
            color: #721c24;
            padding: 12px 16px;
            border-radius: 12px;
            font-size: 13px;
            margin-bottom: 16px;
        }

        .error-list {
            margin: 8px 0 0 16px;
            font-size: 12px;
        }

        /* Form Card */
        .form-card {
            background: white;
            border-radius: 16px;
            padding: 20px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.04);
        }

        .form-section {
            margin-bottom: 24px;
        }

        .form-section:last-child {
            margin-bottom: 0;
        }

        .form-section-title {
            font-size: 14px;
            font-weight: 600;
            color: #333;
            margin-bottom: 16px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .form-section-title svg {
            width: 18px;
            height: 18px;
            color: #1a9fff;
        }

        /* Shop Image Preview */
        .shop-image-section {
            text-align: center;
            margin-bottom: 24px;
        }

        .shop-image-preview {
            width: 120px;
            height: 120px;
            border-radius: 50%;
            background: linear-gradient(135deg, #1a9fff 0%, #0080e0 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 16px;
            overflow: hidden;
            border: 4px solid #e0e0e0;
        }

        .shop-image-preview img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .shop-image-preview .placeholder {
            color: white;
            font-size: 48px;
            font-weight: 700;
        }

        .shop-image-label {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 10px 20px;
            background: #f0f0f0;
            color: #333;
            border-radius: 20px;
            font-size: 13px;
            font-weight: 500;
            cursor: pointer;
            transition: background 0.2s;
        }

        .shop-image-label:hover {
            background: #e0e0e0;
        }

        .shop-image-label svg {
            width: 18px;
            height: 18px;
        }

        .shop-image-input {
            display: none;
        }

        .image-hint {
            font-size: 11px;
            color: #999;
            margin-top: 8px;
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

        .form-textarea {
            min-height: 100px;
            resize: vertical;
        }

        .form-hint {
            font-size: 11px;
            color: #999;
            margin-top: 6px;
        }

        .char-count {
            text-align: right;
            font-size: 11px;
            color: #999;
            margin-top: 4px;
        }

        /* Submit Button */
        .btn-submit {
            width: 100%;
            padding: 14px;
            background: linear-gradient(135deg, #ff6a00 0%, #ff8533 100%);
            color: white;
            font-size: 15px;
            font-weight: 600;
            border: none;
            border-radius: 12px;
            cursor: pointer;
            transition: all 0.2s;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            margin-top: 24px;
        }

        .btn-submit:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 15px rgba(255, 106, 0, 0.4);
        }

        .btn-submit:active {
            transform: translateY(0);
        }

        .btn-submit svg {
            width: 20px;
            height: 20px;
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

            .form-card {
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
        <a href="{{ route('seller.dashboard') }}" class="back-btn">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M19 12H5M12 19l-7-7 7-7"/>
            </svg>
        </a>
        <h1 class="header-title">Edit Data Toko</h1>
    </header>

    <!-- Main Content -->
    <main class="main-content">
        @if(session('success'))
            <div class="success-message">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path>
                    <polyline points="22 4 12 14.01 9 11.01"></polyline>
                </svg>
                {{ session('success') }}
            </div>
        @endif

        @if($errors->any())
            <div class="error-message">
                <strong>Terjadi kesalahan:</strong>
                <ul class="error-list">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('seller.update-shop') }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PATCH')

            <div class="form-card">
                <!-- Shop Image -->
                <div class="shop-image-section">
                    <div class="shop-image-preview" id="imagePreview">
                        @if($user->shop_image)
                            <img src="{{ asset('storage/' . $user->shop_image) }}" alt="Logo Toko" id="previewImg">
                        @else
                            <span class="placeholder" id="placeholderText">{{ strtoupper(substr($user->shop_name ?? $user->name, 0, 1)) }}</span>
                        @endif
                    </div>
                    <label class="shop-image-label">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M23 19a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h4l2-3h6l2 3h4a2 2 0 0 1 2 2z"></path>
                            <circle cx="12" cy="13" r="4"></circle>
                        </svg>
                        Ganti Logo Toko
                        <input type="file" name="shop_image" class="shop-image-input" id="shopImageInput" accept="image/*">
                    </label>
                    <p class="image-hint">Format: JPG, PNG, WEBP. Maks: 2MB</p>
                </div>

                <!-- Shop Info -->
                <div class="form-section">
                    <h3 class="form-section-title">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>
                            <polyline points="9 22 9 12 15 12 15 22"></polyline>
                        </svg>
                        Informasi Toko
                    </h3>

                    <div class="form-group">
                        <label class="form-label">
                            Nama Toko <span class="required">*</span>
                        </label>
                        <input type="text" name="shop_name" class="form-input" value="{{ old('shop_name', $user->shop_name ?? $user->name . ' Shop') }}" placeholder="Masukkan nama toko" maxlength="100" required>
                        <p class="form-hint">Nama toko akan ditampilkan di halaman produk Anda</p>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Deskripsi Toko</label>
                        <textarea name="shop_description" class="form-input form-textarea" placeholder="Ceritakan tentang toko Anda..." maxlength="1000" id="shopDescription">{{ old('shop_description', $user->shop_description) }}</textarea>
                        <div class="char-count"><span id="descCount">{{ strlen(old('shop_description', $user->shop_description ?? '')) }}</span>/1000</div>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Alamat Toko / Lokasi Pickup</label>
                        <textarea name="shop_address" class="form-input form-textarea" placeholder="Alamat lengkap untuk pengambilan barang..." maxlength="500" style="min-height: 80px;">{{ old('shop_address', $user->shop_address) }}</textarea>
                        <p class="form-hint">Alamat ini akan ditampilkan ke pembeli untuk pengambilan barang</p>
                    </div>
                </div>

                <!-- Contact Info -->
                <div class="form-section">
                    <h3 class="form-section-title">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"></path>
                        </svg>
                        Kontak
                    </h3>

                    <div class="form-group">
                        <label class="form-label">
                            Nomor WhatsApp <span class="required">*</span>
                        </label>
                        <input type="tel" name="phone" class="form-input" value="{{ old('phone', $user->phone) }}" placeholder="08xxxxxxxxxx" maxlength="15" required>
                        <p class="form-hint">Nomor ini akan digunakan pembeli untuk menghubungi Anda</p>
                    </div>
                </div>

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
    </main>

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
        // Image preview
        document.getElementById('shopImageInput').addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(event) {
                    const preview = document.getElementById('imagePreview');
                    preview.innerHTML = `<img src="${event.target.result}" alt="Logo Toko" id="previewImg">`;
                };
                reader.readAsDataURL(file);
            }
        });

        // Character count for description
        const descTextarea = document.getElementById('shopDescription');
        const descCount = document.getElementById('descCount');
        
        descTextarea.addEventListener('input', function() {
            descCount.textContent = this.value.length;
        });
    </script>
</body>
</html>
