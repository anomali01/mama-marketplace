<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Detail Produk - Validator MAMA</title>
    <link rel="icon" type="image/png" href="{{ asset('img/logo-mama.png') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    @include('validator.partials.styles')
    <style>
        .product-detail {
            display: grid;
            grid-template-columns: 400px 1fr;
            gap: 32px;
        }
        .product-gallery {
            background: white;
            border-radius: 12px;
            padding: 16px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
        }
        .main-image {
            width: 100%;
            aspect-ratio: 1;
            object-fit: cover;
            border-radius: 8px;
            background: #f3f4f6;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .main-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            border-radius: 8px;
        }
        .thumbnail-list {
            display: flex;
            gap: 8px;
            margin-top: 12px;
            overflow-x: auto;
        }
        .thumbnail {
            width: 70px;
            height: 70px;
            border-radius: 6px;
            object-fit: cover;
            cursor: pointer;
            border: 2px solid transparent;
            transition: all 0.2s;
        }
        .thumbnail:hover,
        .thumbnail.active {
            border-color: #f97316;
        }
        .product-info {
            background: white;
            border-radius: 12px;
            padding: 24px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
        }
        .product-title {
            font-size: 24px;
            font-weight: 600;
            color: #1e293b;
            margin-bottom: 8px;
        }
        .product-price {
            font-size: 28px;
            font-weight: 700;
            color: #f97316;
            margin-bottom: 16px;
        }
        .product-meta {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 16px;
            padding: 16px 0;
            border-top: 1px solid #e5e7eb;
            border-bottom: 1px solid #e5e7eb;
            margin-bottom: 16px;
        }
        .meta-item {
            display: flex;
            flex-direction: column;
            gap: 4px;
        }
        .meta-label {
            font-size: 12px;
            color: #64748b;
            text-transform: uppercase;
        }
        .meta-value {
            font-size: 15px;
            font-weight: 500;
            color: #1e293b;
        }
        .product-description {
            margin-bottom: 24px;
        }
        .product-description h4 {
            font-size: 14px;
            font-weight: 600;
            color: #475569;
            margin-bottom: 8px;
        }
        .product-description p {
            font-size: 14px;
            color: #64748b;
            line-height: 1.6;
            white-space: pre-wrap;
        }
        .seller-info {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 16px;
            background: #f8fafc;
            border-radius: 8px;
            margin-bottom: 24px;
        }
        .seller-avatar-lg {
            width: 48px;
            height: 48px;
            background: linear-gradient(135deg, #1e3a5f 0%, #2d4a6f 100%);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 600;
            font-size: 18px;
        }
        .seller-details {
            flex: 1;
        }
        .seller-name {
            font-weight: 600;
            color: #1e293b;
            margin-bottom: 2px;
        }
        .seller-prodi {
            font-size: 13px;
            color: #64748b;
        }
        .action-buttons {
            display: flex;
            gap: 12px;
        }
        .btn-approve {
            flex: 1;
            padding: 14px 24px;
            background: #10b981;
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 15px;
            font-weight: 600;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            transition: all 0.2s;
        }
        .btn-approve:hover {
            background: #059669;
        }
        .btn-reject {
            flex: 1;
            padding: 14px 24px;
            background: #ef4444;
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 15px;
            font-weight: 600;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            transition: all 0.2s;
        }
        .btn-reject:hover {
            background: #dc2626;
        }
        .btn-approve svg,
        .btn-reject svg {
            width: 20px;
            height: 20px;
        }
        .status-badge {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 13px;
            font-weight: 500;
        }
        .status-pending_verif {
            background: #fef3c7;
            color: #92400e;
        }
        .status-verified {
            background: #d1fae5;
            color: #065f46;
        }
        .status-rejected {
            background: #fee2e2;
            color: #991b1b;
        }
        .back-link {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            color: #64748b;
            text-decoration: none;
            font-size: 14px;
            margin-bottom: 20px;
            transition: color 0.2s;
        }
        .back-link:hover {
            color: #1e3a5f;
        }
        .back-link svg {
            width: 18px;
            height: 18px;
        }
        
        /* Modal */
        .modal-overlay {
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
        }
        .modal-overlay.active {
            display: flex;
        }
        .modal {
            background: white;
            border-radius: 12px;
            padding: 24px;
            width: 100%;
            max-width: 450px;
            margin: 20px;
        }
        .modal-title {
            font-size: 18px;
            font-weight: 600;
            color: #1e293b;
            margin-bottom: 16px;
        }
        .modal-body textarea {
            width: 100%;
            padding: 12px;
            border: 1px solid #e5e7eb;
            border-radius: 8px;
            font-size: 14px;
            font-family: inherit;
            resize: vertical;
            min-height: 100px;
        }
        .modal-body textarea:focus {
            outline: none;
            border-color: #f97316;
        }
        .modal-actions {
            display: flex;
            gap: 12px;
            margin-top: 16px;
        }
        .modal-actions button {
            flex: 1;
            padding: 10px 16px;
            border-radius: 8px;
            font-size: 14px;
            font-weight: 500;
            cursor: pointer;
        }
        .btn-cancel {
            background: #f1f5f9;
            border: none;
            color: #64748b;
        }
        .btn-cancel:hover {
            background: #e2e8f0;
        }
        .btn-submit-reject {
            background: #ef4444;
            border: none;
            color: white;
        }
        .btn-submit-reject:hover {
            background: #dc2626;
        }

        @media (max-width: 900px) {
            .product-detail {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>
    @include('validator.partials.sidebar', ['active' => 'products'])

    <main class="main-content">
        <header class="header">
            <h1 class="header-title">Detail Produk</h1>
            <div class="header-user">
                <div class="header-user-info">
                    <div class="header-user-name">{{ Auth::user()->name }}</div>
                    <div class="header-user-role">Validator</div>
                </div>
                <div class="header-user-avatar">
                    {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                </div>
            </div>
        </header>

        <div class="content">
            <a href="{{ url()->previous() }}" class="back-link">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M19 12H5M12 19l-7-7 7-7"/>
                </svg>
                Kembali
            </a>

            @if(session('success'))
                <div class="alert alert-success">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M9 12l2 2 4-4"/>
                        <circle cx="12" cy="12" r="10"/>
                    </svg>
                    {{ session('success') }}
                </div>
            @endif

            <div class="product-detail">
                <div class="product-gallery">
                    <div class="main-image" id="mainImage">
                        @php
                            $images = $product->images ?? [];
                            $hasImages = is_array($images) && count($images) > 0;
                        @endphp
                        @if($hasImages)
                            <img src="{{ asset('storage/' . $images[0]) }}" alt="{{ $product->name }}" id="mainImg">
                        @else
                            <svg width="80" height="80" viewBox="0 0 24 24" fill="none" stroke="#ccc" stroke-width="1">
                                <rect x="3" y="3" width="18" height="18" rx="2"/>
                                <circle cx="8.5" cy="8.5" r="1.5"/>
                                <path d="M21 15l-5-5L5 21"/>
                            </svg>
                        @endif
                    </div>
                    @if($hasImages && count($images) > 1)
                        <div class="thumbnail-list">
                            @foreach($images as $index => $img)
                                <img 
                                    src="{{ asset('storage/' . $img) }}" 
                                    alt="" 
                                    class="thumbnail {{ $index === 0 ? 'active' : '' }}"
                                    onclick="changeImage(this, '{{ asset('storage/' . $img) }}')"
                                >
                            @endforeach
                        </div>
                    @endif
                </div>

                <div class="product-info">
                    <div style="display: flex; align-items: center; gap: 12px; margin-bottom: 8px;">
                        <span class="status-badge status-{{ $product->status }}">
                            @if($product->status === 'pending_verif')
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <circle cx="12" cy="12" r="10"/>
                                    <path d="M12 6v6l4 2"/>
                                </svg>
                                Menunggu Verifikasi
                            @elseif($product->status === 'verified')
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M9 12l2 2 4-4"/>
                                    <circle cx="12" cy="12" r="10"/>
                                </svg>
                                Terverifikasi
                            @elseif($product->status === 'rejected')
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <circle cx="12" cy="12" r="10"/>
                                    <line x1="15" y1="9" x2="9" y2="15"/>
                                    <line x1="9" y1="9" x2="15" y2="15"/>
                                </svg>
                                Ditolak
                            @else
                                {{ ucfirst($product->status) }}
                            @endif
                        </span>
                    </div>

                    <h1 class="product-title">{{ $product->name }}</h1>
                    <div class="product-price">Rp{{ number_format($product->price, 0, ',', '.') }}</div>

                    <div class="product-meta">
                        <div class="meta-item">
                            <span class="meta-label">Kategori</span>
                            <span class="meta-value">{{ $product->category->name ?? '-' }}</span>
                        </div>
                        <div class="meta-item">
                            <span class="meta-label">Kondisi</span>
                            <span class="meta-value">{{ $product->condition === 'new' ? 'Baru' : 'Bekas' }}</span>
                        </div>
                        <div class="meta-item">
                            <span class="meta-label">Stok</span>
                            <span class="meta-value">{{ $product->stock }} unit</span>
                        </div>
                        <div class="meta-item">
                            <span class="meta-label">Tanggal Upload</span>
                            <span class="meta-value">{{ $product->created_at->format('d M Y, H:i') }}</span>
                        </div>
                    </div>

                    <div class="product-description">
                        <h4>Deskripsi</h4>
                        <p>{{ $product->description ?? 'Tidak ada deskripsi' }}</p>
                    </div>

                    <div class="seller-info">
                        <div class="seller-avatar-lg">
                            {{ strtoupper(substr($product->seller->name ?? 'U', 0, 1)) }}
                        </div>
                        <div class="seller-details">
                            <div class="seller-name">{{ $product->seller->name ?? 'Unknown' }}</div>
                            <div class="seller-prodi">{{ $product->seller->studyProgram->name ?? 'Mahasiswa' }}</div>
                        </div>
                        <a href="{{ route('validator.sellers.show', $product->seller_id) }}" style="color: #f97316; font-size: 14px; text-decoration: none;">
                            Lihat Profil →
                        </a>
                    </div>

                    @if($product->status === 'pending_verif')
                        <div class="action-buttons">
                            <form action="{{ route('validator.products.approve', $product) }}" method="POST" style="flex: 1;">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="btn-approve" style="width: 100%;">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <path d="M9 12l2 2 4-4"/>
                                        <circle cx="12" cy="12" r="10"/>
                                    </svg>
                                    Setujui Produk
                                </button>
                            </form>
                            <button type="button" class="btn-reject" onclick="openRejectModal()">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <circle cx="12" cy="12" r="10"/>
                                    <line x1="15" y1="9" x2="9" y2="15"/>
                                    <line x1="9" y1="9" x2="15" y2="15"/>
                                </svg>
                                Tolak Produk
                            </button>
                        </div>
                    @endif

                    @if($product->status === 'rejected' && $product->rejection_reason)
                        <div style="background: #fef2f2; border: 1px solid #fecaca; border-radius: 8px; padding: 16px; margin-top: 16px;">
                            <h4 style="color: #991b1b; font-size: 14px; font-weight: 600; margin-bottom: 8px;">Alasan Penolakan:</h4>
                            <p style="color: #dc2626; font-size: 14px; margin: 0;">{{ $product->rejection_reason }}</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </main>

    <!-- Reject Modal -->
    <div class="modal-overlay" id="rejectModal">
        <div class="modal">
            <h3 class="modal-title">Tolak Produk</h3>
            <form action="{{ route('validator.products.reject', $product) }}" method="POST">
                @csrf
                @method('PATCH')
                <div class="modal-body">
                    <label style="display: block; font-size: 14px; color: #475569; margin-bottom: 8px;">
                        Alasan Penolakan <span style="color: #ef4444;">*</span>
                    </label>
                    <textarea name="rejection_reason" placeholder="Masukkan alasan mengapa produk ini ditolak..." required></textarea>
                </div>
                <div class="modal-actions">
                    <button type="button" class="btn-cancel" onclick="closeRejectModal()">Batal</button>
                    <button type="submit" class="btn-submit-reject">Tolak Produk</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function changeImage(thumbnail, src) {
            document.getElementById('mainImg').src = src;
            document.querySelectorAll('.thumbnail').forEach(t => t.classList.remove('active'));
            thumbnail.classList.add('active');
        }

        function openRejectModal() {
            document.getElementById('rejectModal').classList.add('active');
        }

        function closeRejectModal() {
            document.getElementById('rejectModal').classList.remove('active');
        }

        // Close modal on overlay click
        document.getElementById('rejectModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeRejectModal();
            }
        });
    </script>
</body>
</html>
