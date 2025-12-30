<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1, user-scalable=no">
    <title>{{ $product->name }} - MAMA Marketplace</title>
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
            background: white;
            padding: 12px 16px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            position: sticky;
            top: 0;
            z-index: 100;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.06);
        }

        .back-btn {
            width: 40px;
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #333;
            text-decoration: none;
            border-radius: 50%;
            transition: background 0.2s;
        }

        .back-btn:hover {
            background: #f0f0f0;
        }

        .back-btn svg {
            width: 24px;
            height: 24px;
        }

        .header-actions {
            display: flex;
            gap: 8px;
        }

        .action-btn {
            width: 40px;
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #333;
            text-decoration: none;
            border-radius: 50%;
            background: none;
            border: none;
            cursor: pointer;
            transition: background 0.2s;
        }

        .action-btn:hover {
            background: #f0f0f0;
        }

        .action-btn svg {
            width: 22px;
            height: 22px;
        }

        /* Product Image */
        .product-image-container {
            background: white;
            width: 100%;
            aspect-ratio: 1;
            max-height: 400px;
            overflow: hidden;
        }

        .product-image {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .no-image {
            width: 100%;
            height: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            background: #e0e0e0;
        }

        .no-image svg {
            width: 80px;
            height: 80px;
            color: #999;
        }

        /* Product Info */
        .product-info {
            background: white;
            padding: 20px;
            margin-top: 8px;
        }

        .product-price {
            font-size: 24px;
            font-weight: 700;
            color: #ff6a00;
            margin-bottom: 8px;
        }

        .product-title {
            font-size: 16px;
            font-weight: 500;
            color: #333;
            line-height: 1.5;
            margin-bottom: 12px;
        }

        .product-meta {
            display: flex;
            align-items: center;
            gap: 16px;
            font-size: 13px;
            color: #666;
        }

        .product-rating {
            display: flex;
            align-items: center;
            gap: 4px;
        }

        .star-icon {
            color: #ffc107;
        }

        /* Seller Info */
        .seller-section {
            background: white;
            padding: 16px 20px;
            margin-top: 8px;
            display: flex;
            align-items: center;
            gap: 12px;
            border-radius: 12px;
        }

        .seller-avatar {
            width: 48px;
            height: 48px;
            border-radius: 50%;
            background: linear-gradient(135deg, #ff6a00 0%, #e55f00 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 600;
            font-size: 18px;
        }

        .seller-info {
            flex: 1;
        }

        .seller-name {
            font-size: 14px;
            font-weight: 600;
            color: #333;
        }

        .seller-badge {
            font-size: 12px;
            color: #666;
            display: flex;
            align-items: center;
            gap: 6px;
            flex-wrap: wrap;
        }

        .prodi-badge {
            display: inline-block;
            background: linear-gradient(135deg, #1a9fff, #0080e0);
            color: white;
            padding: 3px 10px;
            border-radius: 12px;
            font-size: 11px;
            font-weight: 600;
        }

        .chat-seller-btn {
            padding: 8px 16px;
            background: linear-gradient(135deg, #0080e0 0%, #1a9fff 100%);
            color: white;
            border: none;
            border-radius: 20px;
            font-size: 13px;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.2s;
        }

        .chat-seller-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0, 128, 224, 0.3);
        }

        .chat-seller-btn:active {
            transform: translateY(0);
        }

        /* Description */
        .description-section {
            background: white;
            padding: 20px;
            margin-top: 8px;
        }

        .section-title {
            font-size: 15px;
            font-weight: 600;
            color: #333;
            margin-bottom: 12px;
        }

        .description-text {
            font-size: 14px;
            color: #666;
            line-height: 1.6;
        }

        /* Bottom Action Bar */
        .bottom-action {
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            background: white;
            padding: 12px 16px;
            display: flex;
            gap: 12px;
            box-shadow: 0 -2px 10px rgba(0, 0, 0, 0.1);
            z-index: 100;
        }

        .btn-cart {
            flex: 1;
            padding: 14px 20px;
            background: white;
            color: #ff6a00;
            font-size: 15px;
            font-weight: 600;
            border: 2px solid #ff6a00;
            border-radius: 12px;
            cursor: pointer;
            transition: all 0.2s;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
        }

        .btn-cart:hover {
            background: #fff5f0;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(255, 106, 0, 0.2);
        }

        .btn-cart:active {
            transform: translateY(0);
        }

        .btn-cart svg {
            width: 20px;
            height: 20px;
        }

        .btn-buy {
            flex: 1;
            padding: 14px 20px;
            background: linear-gradient(135deg, #ff6a00 0%, #e55f00 100%);
            color: white;
            font-size: 15px;
            font-weight: 600;
            border: none;
            border-radius: 12px;
            cursor: pointer;
            transition: all 0.2s;
        }

        .btn-buy:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(255, 106, 0, 0.3);
        }

        .btn-buy:active {
            transform: translateY(0);
        }

        /* Stock Badge */
        .stock-badge {
            display: inline-block;
            padding: 4px 10px;
            border-radius: 12px;
            font-size: 12px;
            font-weight: 500;
        }

        .stock-badge.in-stock {
            background: #e8f5e9;
            color: #2e7d32;
        }

        .stock-badge.low-stock {
            background: #fff3e0;
            color: #ef6c00;
        }

        .stock-badge.out-stock {
            background: #ffebee;
            color: #c62828;
        }

        /* Quantity Selector */
        .quantity-selector {
            background: white;
            padding: 16px 20px;
            margin-top: 8px;
            display: flex;
            align-items: center;
            gap: 16px;
            border-radius: 12px;
        }

        .quantity-label {
            font-size: 14px;
            font-weight: 600;
            color: #333;
            min-width: 80px;
        }

        .quantity-control {
            display: flex;
            align-items: center;
            background: linear-gradient(135deg, #f5f5f5 0%, #efefef 100%);
            border-radius: 12px;
            padding: 0;
            border: 2px solid #e0e0e0;
            transition: border-color 0.2s;
        }

        .quantity-control:hover {
            border-color: #0080e0;
        }

        .qty-btn {
            width: 40px;
            height: 40px;
            border: none;
            background: transparent;
            color: #0080e0;
            font-size: 20px;
            font-weight: 600;
            cursor: pointer;
            transition: background 0.2s, color 0.2s;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .qty-btn:hover {
            background: rgba(0, 128, 224, 0.1);
            color: #0080e0;
        }

        .qty-btn:active {
            background: rgba(0, 128, 224, 0.2);
        }

        .qty-input {
            width: 50px;
            border: none;
            background: transparent;
            text-align: center;
            font-size: 16px;
            font-weight: 700;
            color: #333;
            border-left: 2px solid #e0e0e0;
            border-right: 2px solid #e0e0e0;
            padding: 0;
        }

        .qty-input:focus {
            outline: none;
            background: rgba(0, 128, 224, 0.05);
        }

        /* Responsive */
        @media (min-width: 768px) {
            body {
                padding-bottom: 0;
            }

            .product-container {
                max-width: 1000px;
                margin: 0 auto;
                display: grid;
                grid-template-columns: 1fr 1fr;
                gap: 20px;
                padding: 20px;
            }

            .product-image-container {
                border-radius: 16px;
                position: sticky;
                top: 80px;
            }

            .product-details {
                display: flex;
                flex-direction: column;
                gap: 12px;
            }

            .product-info,
            .seller-section,
            .description-section {
                border-radius: 16px;
                margin-top: 0;
            }

            .bottom-action {
                position: relative;
                box-shadow: none;
                padding: 0;
                background: transparent;
                margin-top: 12px;
            }
        }

        @supports (padding-bottom: env(safe-area-inset-bottom)) {
            .bottom-action {
                padding-bottom: calc(12px + env(safe-area-inset-bottom));
            }
        }
    </style>
</head>
<body>
    <!-- Header -->
    <header class="header">
        <a href="{{ route('home') }}" class="back-btn">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M19 12H5M12 19l-7-7 7-7"/>
            </svg>
        </a>
        <div class="header-actions">
            <button class="action-btn">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <circle cx="11" cy="11" r="8"></circle>
                    <path d="m21 21-4.35-4.35"></path>
                </svg>
            </button>
            <a href="{{ route('cart.index') }}" class="action-btn">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <circle cx="9" cy="21" r="1"></circle>
                    <circle cx="20" cy="21" r="1"></circle>
                    <path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"></path>
                </svg>
            </a>
            <button class="action-btn">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <circle cx="12" cy="12" r="1"></circle>
                    <circle cx="19" cy="12" r="1"></circle>
                    <circle cx="5" cy="12" r="1"></circle>
                </svg>
            </button>
        </div>
    </header>

    <div class="product-container">
        <!-- Product Image -->
        <div class="product-image-container">
            @php
                $productImage = null;
                if ($product->images && is_array($product->images) && count($product->images) > 0) {
                    $productImage = asset('storage/' . $product->images[0]);
                }
            @endphp
            
            @if($productImage)
                <img src="{{ $productImage }}" alt="{{ $product->name }}" class="product-image">
            @else
                <div class="no-image">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                        <rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect>
                        <circle cx="8.5" cy="8.5" r="1.5"></circle>
                        <polyline points="21 15 16 10 5 21"></polyline>
                    </svg>
                </div>
            @endif
        </div>

        <div class="product-details">
            <!-- Product Info -->
            <div class="product-info">
                <div class="product-price">Rp{{ number_format($product->price, 0, ',', '.') }}</div>
                <h1 class="product-title">{{ $product->name }}</h1>
                <div class="product-meta">
                    <div class="product-rating">
                        <span class="star-icon">★</span>
                        <span>{{ number_format(rand(40, 50) / 10, 1) }}</span>
                        <span style="color: #999;">({{ rand(10, 200) }} ulasan)</span>
                    </div>
                    <span>{{ rand(20, 500) }} terjual</span>
                    @if($product->stock > 10)
                        <span class="stock-badge in-stock">Stok: {{ $product->stock }}</span>
                    @elseif($product->stock > 0)
                        <span class="stock-badge low-stock">Stok: {{ $product->stock }}</span>
                    @else
                        <span class="stock-badge out-stock">Habis</span>
                    @endif
                </div>
            </div>

            <!-- Seller Info -->
            <div class="seller-section">
                <div class="seller-avatar">
                    {{ strtoupper(substr($product->seller->name ?? 'U', 0, 1)) }}
                </div>
                <div class="seller-info">
                    <div class="seller-name">{{ $product->seller->name ?? 'Unknown Seller' }}</div>
                    <div class="seller-badge">
                        <span>Mahasiswa Verified ✓</span>
                        @if($product->seller->prodi)
                            @php
                                $prodiDisplay = $product->seller->prodi;
                                // Jika prodi berupa angka, ambil nama dari tabel prodis
                                if (is_numeric($prodiDisplay)) {
                                    $prodiData = \App\Models\StudyProgram::find($prodiDisplay);
                                    $prodiDisplay = $prodiData ? $prodiData->name : null;
                                }
                            @endphp
                            @if($prodiDisplay)
                                <span class="prodi-badge">{{ $prodiDisplay }}</span>
                            @endif
                        @endif
                    </div>
                </div>
                @auth
                    @if(auth()->user()->id !== $product->seller->id)
                        <button class="chat-seller-btn" id="chat-btn" onclick="initiateChat({{ $product->seller->id }}, '{{ $product->seller->name }}', event)">Chat</button>
                    @endif
                @else
                    <a href="{{ route('login') }}" class="chat-seller-btn">Chat</a>
                @endauth
            </div>

            <!-- Lokasi Pengambilan -->
            @if($product->location)
            <div class="pickup-location-section" style="background: #fff8e1; border-radius: 12px; padding: 16px; margin: 16px 0;">
                <div style="display: flex; align-items: flex-start; gap: 12px;">
                    <div style="background: #ff9800; color: white; width: 36px; height: 36px; border-radius: 50%; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path>
                            <circle cx="12" cy="10" r="3"></circle>
                        </svg>
                    </div>
                    <div>
                        <div style="font-weight: 600; color: #5d4037; margin-bottom: 4px;">📍 Lokasi Pengambilan Barang</div>
                        <div style="color: #795548; font-size: 14px;">{{ $product->location }}</div>
                        <div style="color: #999; font-size: 12px; margin-top: 4px;">Ambil barang langsung di lokasi ini atau pilih diantar penjual saat checkout</div>
                    </div>
                </div>
            </div>
            @endif

            <!-- Description -->
            <div class="description-section">
                <h2 class="section-title">Deskripsi Produk</h2>
                <p class="description-text">
                    {{ $product->description ?? 'Tidak ada deskripsi untuk produk ini.' }}
                </p>
            </div>

            <!-- Quantity Selector -->
            <div class="quantity-selector">
                <label class="quantity-label">Jumlah:</label>
                <div class="quantity-control">
                    <button class="qty-btn" id="qty-minus" type="button">−</button>
                    <input type="number" class="qty-input" id="qty-input" value="1" min="1" max="{{ $product->stock }}">
                    <button class="qty-btn" id="qty-plus" type="button">+</button>
                </div>
                <span style="font-size: 12px; color: #999; font-weight: 500;">Max: {{ $product->stock }}</span>
            </div>

            <!-- Desktop Bottom Action -->
            <div class="bottom-action desktop-action">
                <button class="btn-cart" id="btn-cart-desktop">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <circle cx="9" cy="21" r="1"></circle>
                        <circle cx="20" cy="21" r="1"></circle>
                        <path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"></path>
                    </svg>
                    Keranjang
                </button>
                <button type="button" class="btn-buy" id="btn-buy-desktop">Beli Sekarang</button>
            </div>
        </div>
    </div>

    <!-- Mobile Bottom Action -->
    <div class="bottom-action mobile-action">
        <button class="btn-cart" id="btn-cart-mobile">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <circle cx="9" cy="21" r="1"></circle>
                <circle cx="20" cy="21" r="1"></circle>
                <path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"></path>
            </svg>
            Keranjang
        </button>
        <button type="button" class="btn-buy" id="btn-buy-mobile">Beli Sekarang</button>
    </div>

    <style>
        @media (min-width: 768px) {
            .mobile-action {
                display: none;
            }
        }
        @media (max-width: 767px) {
            .desktop-action {
                display: none;
            }
        }
    </style>

    <script>
        // Check if user can chat with seller
        function initiateChat(sellerId, sellerName, event) {
            event.preventDefault();
            
            // Try to open messages page, if not purchased yet show option to continue anyway
            const xhr = new XMLHttpRequest();
            xhr.open('GET', '/messages/' + sellerId, true);
            xhr.onload = function() {
                if (xhr.status === 200) {
                    window.location.href = '/messages/' + sellerId;
                } else if (xhr.status === 302 || xhr.status === 301) {
                    // Redirected, likely error
                    const continueAnyway = confirm(
                        'Anda belum pernah membeli dari penjual ini.\n\n' + 
                        'Ingin mengirim pesan secara umum ke ' + sellerName + '?\n\n' +
                        'Anda akan dialihkan ke halaman pesan.'
                    );
                    if (continueAnyway) {
                        window.location.href = '/messages/' + sellerId;
                    }
                }
            };
            xhr.onerror = function() {
                // Network error, try direct redirect
                window.location.href = '/messages/' + sellerId;
            };
            xhr.send();
        }

        // Quantity Control
        const qtyInput = document.getElementById('qty-input');
        const qtyMinus = document.getElementById('qty-minus');
        const qtyPlus = document.getElementById('qty-plus');
        const maxQty = parseInt(qtyInput.max);

        qtyMinus.addEventListener('click', function() {
            let qty = parseInt(qtyInput.value);
            if (qty > 1) {
                qtyInput.value = qty - 1;
                updateQuantityInputs();
            }
        });

        qtyPlus.addEventListener('click', function() {
            let qty = parseInt(qtyInput.value);
            if (qty < maxQty) {
                qtyInput.value = qty + 1;
                updateQuantityInputs();
            }
        });

        qtyInput.addEventListener('change', function() {
            let qty = parseInt(this.value);
            if (isNaN(qty) || qty < 1) {
                this.value = 1;
            } else if (qty > maxQty) {
                this.value = maxQty;
            }
        });

        // Cart functionality
        function addToCart(e) {
            e.preventDefault();
            const quantity = document.getElementById('qty-input').value;
            const productId = {{ $product->id }};
            
            // Store in localStorage or session
            let cart = JSON.parse(localStorage.getItem('mama-cart') || '[]');
            const existingItem = cart.find(item => item.product_id === productId);
            
            if (existingItem) {
                existingItem.quantity = parseInt(existingItem.quantity) + parseInt(quantity);
            } else {
                cart.push({
                    product_id: productId,
                    quantity: parseInt(quantity)
                });
            }
            
            localStorage.setItem('mama-cart', JSON.stringify(cart));
            
            // Show success message
            const message = document.createElement('div');
            message.style.cssText = `
                position: fixed;
                top: 20px;
                right: 20px;
                background: #4caf50;
                color: white;
                padding: 12px 20px;
                border-radius: 8px;
                font-size: 14px;
                font-weight: 600;
                z-index: 999;
                animation: slideIn 0.3s ease;
            `;
            message.textContent = 'Ditambahkan ke keranjang!';
            document.body.appendChild(message);
            
            setTimeout(() => message.remove(), 2000);
        }

        // Attach cart button listeners
        document.getElementById('btn-cart-desktop').addEventListener('click', addToCart);
        document.getElementById('btn-cart-mobile').addEventListener('click', addToCart);

        // Buy Now functionality - redirect to checkout
        function buyNow(e) {
            e.preventDefault();
            
            @auth
            const quantity = parseInt(document.getElementById('qty-input').value);
            const productId = {{ $product->id }};
            
            // Save to direct buy storage (different from cart)
            const directBuyData = [{
                product_id: productId,
                quantity: quantity
            }];
            
            // Store in mama-direct-buy for checkout
            localStorage.setItem('mama-direct-buy', JSON.stringify(directBuyData));
            
            // Redirect to checkout with direct buy flag
            window.location.href = '{{ route("checkout.index") }}?direct=1';
            @else
            window.location.href = '{{ route("login") }}';
            @endauth
        }

        // Attach buy button listeners
        document.getElementById('btn-buy-desktop').addEventListener('click', buyNow);
        document.getElementById('btn-buy-mobile').addEventListener('click', buyNow);

        // Initialize quantity inputs on page load
        // (removed updateQuantityInputs since forms are removed)

        // Prevent stock out message
        @if($product->stock <= 0)
            document.getElementById('btn-buy-desktop').disabled = true;
            document.getElementById('btn-buy-mobile').disabled = true;
            document.getElementById('btn-cart-desktop').disabled = true;
            document.getElementById('btn-cart-mobile').disabled = true;
            document.getElementById('qty-plus').disabled = true;
        @endif
    </script>
</body>
</html>