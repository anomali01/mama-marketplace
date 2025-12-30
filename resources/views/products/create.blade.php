<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Produk - MAMA Marketplace</title>
    <link rel="icon" type="image/png" href="{{ asset('img/logo-mama.png') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f5f5f5;
            min-height: 100vh;
        }
        
        .header {
            background: linear-gradient(135deg, #1e40af 0%, #3b82f6 100%);
            padding: 16px 20px;
            display: flex;
            align-items: center;
            gap: 16px;
            position: sticky;
            top: 0;
            z-index: 100;
        }
        
        .back-btn {
            color: white;
            text-decoration: none;
            display: flex;
            align-items: center;
            font-size: 24px;
        }
        
        .header h1 {
            color: white;
            font-size: 18px;
            font-weight: 600;
        }
        
        .container {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
        }
        
        .form-card {
            background: white;
            border-radius: 16px;
            padding: 24px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.08);
        }
        
        .image-upload {
            border: 2px dashed #ddd;
            border-radius: 12px;
            padding: 40px 20px;
            text-align: center;
            cursor: pointer;
            margin-bottom: 24px;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }
        
        .image-upload:hover {
            border-color: #f97316;
            background: #fff7ed;
        }
        
        .image-upload input[type="file"] {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            opacity: 0;
            cursor: pointer;
        }
        
        .upload-icon {
            font-size: 48px;
            color: #ccc;
            margin-bottom: 12px;
        }
        
        .upload-text {
            color: #666;
            font-size: 14px;
        }
        
        .upload-hint {
            color: #999;
            font-size: 12px;
            margin-top: 8px;
        }
        
        .image-preview {
            display: none;
            width: 100%;
            max-height: 200px;
            object-fit: cover;
            border-radius: 8px;
        }
        
        .form-group {
            margin-bottom: 20px;
        }
        
        .form-group label {
            display: block;
            font-weight: 600;
            color: #333;
            margin-bottom: 8px;
            font-size: 14px;
        }
        
        .form-group label span {
            color: #e53935;
        }
        
        .form-control {
            width: 100%;
            padding: 14px 16px;
            border: 1px solid #e0e0e0;
            border-radius: 12px;
            font-size: 15px;
            font-family: inherit;
            transition: all 0.3s ease;
            background: #fafafa;
        }
        
        .form-control:focus {
            outline: none;
            border-color: #f97316;
            background: white;
            box-shadow: 0 0 0 3px rgba(249, 115, 22, 0.1);
        }
        
        textarea.form-control {
            min-height: 120px;
            resize: vertical;
        }
        
        .price-input {
            position: relative;
        }
        
        .price-input .prefix {
            position: absolute;
            left: 16px;
            top: 50%;
            transform: translateY(-50%);
            color: #666;
            font-weight: 500;
        }
        
        .price-input input {
            padding-left: 45px;
        }
        
        .form-row {
            display: flex;
            gap: 16px;
        }
        
        .form-row .form-group {
            flex: 1;
        }
        
        select.form-control {
            cursor: pointer;
            appearance: none;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='24' height='24' viewBox='0 0 24 24' fill='none' stroke='%23666' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3E%3Cpolyline points='6 9 12 15 18 9'%3E%3C/polyline%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: right 12px center;
            background-size: 18px;
            padding-right: 40px;
        }
        
        .condition-options {
            display: flex;
            gap: 12px;
        }
        
        .condition-option {
            flex: 1;
        }
        
        .condition-option input {
            display: none;
        }
        
        .condition-option label {
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 14px;
            border: 2px solid #e0e0e0;
            border-radius: 12px;
            cursor: pointer;
            font-weight: 500;
            color: #666;
            transition: all 0.3s ease;
        }
        
        .condition-option input:checked + label {
            border-color: #f97316;
            background: #fff7ed;
            color: #f97316;
        }
        
        .submit-btn {
            width: 100%;
            padding: 16px;
            background: linear-gradient(135deg, #f97316 0%, #ea580c 100%);
            color: white;
            border: none;
            border-radius: 12px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            margin-top: 24px;
        }
        
        .submit-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(249, 115, 22, 0.4);
        }
        
        .error-message {
            background: #fee2e2;
            border: 1px solid #fecaca;
            color: #dc2626;
            padding: 12px 16px;
            border-radius: 12px;
            margin-bottom: 20px;
            font-size: 14px;
        }
        
        @media (max-width: 480px) {
            .container {
                padding: 16px;
            }
            
            .form-card {
                padding: 20px;
            }
            
            .form-row {
                flex-direction: column;
                gap: 0;
            }
        }
    </style>
</head>
<body>
    <header class="header">
        <a href="{{ route('seller.dashboard') }}" class="back-btn">←</a>
        <h1>Tambah Produk</h1>
    </header>
    
    <div class="container">
        @if ($errors->any())
            <div class="error-message">
                <ul style="margin: 0; padding-left: 20px;">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        
        <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data" class="form-card">
            @csrf
            
            <div class="image-upload" id="imageUpload">
                <div class="upload-icon">📷</div>
                <div class="upload-text">Tap untuk upload foto produk</div>
                <div class="upload-hint">Format: JPG, PNG (Maks. 2MB)</div>
                <input type="file" name="image" id="imageInput" accept="image/*">
                <img class="image-preview" id="imagePreview" alt="Preview">
            </div>
            
            <div class="form-group">
                <label>Nama Produk <span>*</span></label>
                <input type="text" name="name" class="form-control" placeholder="Contoh: Laptop Asus ROG" value="{{ old('name') }}" required>
            </div>
            
            <div class="form-group">
                <label>Deskripsi <span>*</span></label>
                <textarea name="description" class="form-control" placeholder="Jelaskan kondisi, kelengkapan, dan detail produk..." required>{{ old('description') }}</textarea>
            </div>
            
            <div class="form-group">
                <label>Kategori <span>*</span></label>
                <select name="category_id" class="form-control" required>
                    <option value="">Pilih Kategori</option>
                    @foreach(\App\Models\Category::all() as $category)
                        <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            
            <div class="form-row">
                <div class="form-group">
                    <label>Harga <span>*</span></label>
                    <div class="price-input">
                        <span class="prefix">Rp</span>
                        <input type="number" name="price" class="form-control" placeholder="0" value="{{ old('price') }}" required min="1000">
                    </div>
                </div>
                
                <div class="form-group">
                    <label>Stok <span>*</span></label>
                    <input type="number" name="stock" class="form-control" placeholder="1" value="{{ old('stock', 1) }}" required min="1">
                </div>
            </div>
            
            <div class="form-group">
                <label>Kondisi Produk <span>*</span></label>
                <div class="condition-options">
                    <div class="condition-option">
                        <input type="radio" name="condition" id="condNew" value="new" {{ old('condition', 'new') == 'new' ? 'checked' : '' }}>
                        <label for="condNew">✨ Baru</label>
                    </div>
                    <div class="condition-option">
                        <input type="radio" name="condition" id="condUsed" value="used" {{ old('condition') == 'used' ? 'checked' : '' }}>
                        <label for="condUsed">📦 Bekas</label>
                    </div>
                </div>
            </div>
            
            <div class="form-group">
                <label>📍 Lokasi Pengambilan Barang <span style="color: #e74c3c;">*</span></label>
                <input type="text" name="location" class="form-control" placeholder="Contoh: Gedung FTI Lt.2 Ruang 201, Kampus A" value="{{ old('location') }}" required>
                <small style="color: #666; font-size: 12px; margin-top: 4px; display: block;">
                    Lokasi dimana pembeli bisa mengambil barang (wajib diisi). Tulis selengkap mungkin agar pembeli mudah menemukan.
                </small>
            </div>
            
            <button type="submit" class="submit-btn">
                Tambahkan Produk
            </button>
        </form>
    </div>
    
    <script>
        const imageInput = document.getElementById('imageInput');
        const imageUpload = document.getElementById('imageUpload');
        const imagePreview = document.getElementById('imagePreview');
        const uploadIcon = imageUpload.querySelector('.upload-icon');
        const uploadText = imageUpload.querySelector('.upload-text');
        const uploadHint = imageUpload.querySelector('.upload-hint');
        
        imageInput.addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    imagePreview.src = e.target.result;
                    imagePreview.style.display = 'block';
                    uploadIcon.style.display = 'none';
                    uploadText.style.display = 'none';
                    uploadHint.style.display = 'none';
                }
                reader.readAsDataURL(file);
            }
        });
    </script>
</body>
</html>
