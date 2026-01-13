<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1, user-scalable=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Checkout - MAMA Marketplace</title>
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

        .header {
            background: linear-gradient(135deg, #1a9fff 0%, #0080e0 100%);
            padding: 16px 20px;
            display: flex;
            align-items: center;
            gap: 16px;
            position: sticky;
            top: 0;
            z-index: 100;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }

        .back-btn {
            color: white;
            text-decoration: none;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .back-btn svg {
            width: 24px;
            height: 24px;
        }

        .header-title {
            color: white;
            font-size: 18px;
            font-weight: 600;
            flex: 1;
        }

        .main-content {
            max-width: 800px;
            margin: 0 auto;
            padding: 16px;
        }

        .section {
            background: white;
            border-radius: 12px;
            padding: 16px;
            margin-bottom: 12px;
        }

        .section-title {
            font-size: 16px;
            font-weight: 700;
            color: #333;
            margin-bottom: 16px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .section-title svg {
            width: 20px;
            height: 20px;
            color: #0080e0;
        }

        /* Form */
        .form-group {
            margin-bottom: 16px;
        }

        .form-label {
            display: block;
            font-size: 14px;
            font-weight: 600;
            color: #333;
            margin-bottom: 8px;
        }

        .form-input,
        .form-textarea {
            width: 100%;
            padding: 12px 16px;
            border: 2px solid #e0e0e0;
            border-radius: 8px;
            font-family: inherit;
            font-size: 14px;
            color: #333;
            transition: border-color 0.2s;
        }

        .form-input:focus,
        .form-textarea:focus {
            outline: none;
            border-color: #0080e0;
        }

        .form-textarea {
            resize: vertical;
            min-height: 100px;
        }

        /* Order Items */
        .order-item {
            display: flex;
            gap: 12px;
            padding: 12px 0;
            border-bottom: 1px solid #f0f0f0;
        }

        .order-item:last-child {
            border-bottom: none;
        }

        .item-image {
            width: 60px;
            height: 60px;
            border-radius: 8px;
            object-fit: cover;
            background: #e0e0e0;
            flex-shrink: 0;
        }

        .item-details {
            flex: 1;
        }

        .item-name {
            font-size: 14px;
            font-weight: 600;
            color: #333;
            margin-bottom: 4px;
        }

        .item-price {
            font-size: 13px;
            color: #666;
        }

        .item-qty {
            font-size: 13px;
            color: #999;
        }

        /* Payment Method */
        .payment-options {
            display: flex;
            flex-direction: column;
            gap: 12px;
        }

        .payment-option {
            border: 2px solid #e0e0e0;
            border-radius: 12px;
            padding: 16px;
            cursor: pointer;
            transition: all 0.2s;
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .payment-option:hover {
            border-color: #0080e0;
            background: #f0f8ff;
        }

        .payment-option.selected {
            border-color: #0080e0;
            background: linear-gradient(135deg, #f0f8ff 0%, #e3f2fd 100%);
        }

        .payment-radio {
            width: 20px;
            height: 20px;
            border: 2px solid #e0e0e0;
            border-radius: 50%;
            position: relative;
            flex-shrink: 0;
        }

        .payment-option.selected .payment-radio {
            border-color: #0080e0;
        }

        .payment-option.selected .payment-radio::after {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 10px;
            height: 10px;
            background: #0080e0;
            border-radius: 50%;
        }

        .payment-info {
            flex: 1;
        }

        .payment-name {
            font-size: 14px;
            font-weight: 600;
            color: #333;
            margin-bottom: 4px;
        }

        .payment-desc {
            font-size: 12px;
            color: #666;
        }

        .payment-icon {
            width: 40px;
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: #f5f5f5;
            border-radius: 8px;
            flex-shrink: 0;
        }

        .payment-icon svg {
            width: 24px;
            height: 24px;
            color: #0080e0;
        }

        /* Shipping Method */
        .shipping-options {
            display: flex;
            flex-direction: column;
            gap: 12px;
        }

        .shipping-option {
            border: 2px solid #e0e0e0;
            border-radius: 12px;
            padding: 16px;
            cursor: pointer;
            transition: all 0.2s;
        }

        .shipping-option:hover {
            border-color: #0080e0;
            background: #f0f8ff;
        }

        .shipping-option.selected {
            border-color: #0080e0;
            background: linear-gradient(135deg, #f0f8ff 0%, #e3f2fd 100%);
        }

        .shipping-option-header {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .shipping-radio {
            width: 20px;
            height: 20px;
            border: 2px solid #e0e0e0;
            border-radius: 50%;
            position: relative;
            flex-shrink: 0;
        }

        .shipping-option.selected .shipping-radio {
            border-color: #0080e0;
        }

        .shipping-option.selected .shipping-radio::after {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 10px;
            height: 10px;
            background: #0080e0;
            border-radius: 50%;
        }

        .shipping-info {
            flex: 1;
        }

        .shipping-name {
            font-size: 14px;
            font-weight: 600;
            color: #333;
            margin-bottom: 4px;
        }

        .shipping-desc {
            font-size: 12px;
            color: #666;
        }

        .shipping-icon {
            width: 40px;
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: #f5f5f5;
            border-radius: 8px;
            flex-shrink: 0;
        }

        .shipping-icon svg {
            width: 24px;
            height: 24px;
            color: #0080e0;
        }

        .pickup-location {
            margin-top: 12px;
            padding: 12px;
            background: #fff8e1;
            border-radius: 8px;
            font-size: 13px;
            color: #795548;
        }

        .pickup-location strong {
            display: block;
            margin-bottom: 4px;
            color: #5d4037;
        }

        .delivery-details {
            margin-top: 12px;
            padding-top: 12px;
            border-top: 1px dashed #e0e0e0;
            display: none;
        }

        .shipping-option.selected .delivery-details {
            display: block;
        }

        .delivery-fee-input {
            display: flex;
            align-items: center;
            gap: 8px;
            margin-top: 8px;
        }

        .delivery-fee-input span {
            font-size: 14px;
            color: #666;
        }

        .delivery-fee-display {
            font-weight: 600;
            color: #ff6a00;
        }

        .delivery-note {
            font-size: 12px;
            color: #999;
            margin-top: 8px;
            font-style: italic;
        }

        .address-section {
            display: none;
        }

        .address-section.show {
            display: block;
        }

        /* Summary */
        .summary-row {
            display: flex;
            justify-content: space-between;
            padding: 10px 0;
            font-size: 14px;
            color: #666;
        }

        .summary-row.total {
            border-top: 2px solid #f0f0f0;
            padding-top: 16px;
            margin-top: 8px;
            font-size: 16px;
            font-weight: 700;
            color: #333;
        }

        .summary-value {
            color: #ff6a00;
            font-weight: 600;
        }

        .summary-value.total {
            font-size: 18px;
        }

        /* Bottom Action */
        .bottom-action {
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            background: white;
            padding: 16px;
            box-shadow: 0 -2px 10px rgba(0, 0, 0, 0.1);
            z-index: 100;
        }

        .btn-checkout {
            width: 100%;
            max-width: 800px;
            margin: 0 auto;
            display: block;
            padding: 16px;
            background: linear-gradient(135deg, #ff6a00 0%, #e55f00 100%);
            color: white;
            font-size: 16px;
            font-weight: 700;
            border: none;
            border-radius: 12px;
            cursor: pointer;
            transition: all 0.2s;
        }

        .btn-checkout:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(255, 106, 0, 0.3);
        }

        .btn-checkout:disabled {
            background: #ccc;
            cursor: not-allowed;
            transform: none;
        }

        .error-message {
            background: #ffebee;
            color: #c62828;
            padding: 12px 16px;
            border-radius: 8px;
            font-size: 14px;
            margin-bottom: 16px;
        }

        @media (min-width: 768px) {
            .bottom-action {
                padding: 16px 20px;
            }
        }
    </style>
</head>
<body>
    <header class="header">
        <a href="javascript:history.back()" class="back-btn" id="back-btn">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M19 12H5M12 19l-7-7 7-7"/>
            </svg>
        </a>
        <h1 class="header-title">Checkout</h1>
    </header>

    <main class="main-content">
        @if ($errors->any())
            <div class="error-message">
                <ul style="margin: 0; padding-left: 20px;">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form id="checkout-form" action="{{ route('checkout.process') }}" method="POST">
            @csrf
            <input type="hidden" name="cart_data" id="cart-data">
            <input type="hidden" name="shipping_method" id="shipping-method">
            <input type="hidden" name="shipping_fee" id="shipping-fee-input" value="0">

            <!-- Data Pembeli -->
            <div class="section">
                <h2 class="section-title">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                        <circle cx="12" cy="7" r="4"></circle>
                    </svg>
                    Data Pembeli
                </h2>
                <div class="form-group">
                    <label class="form-label" for="name">Nama Lengkap</label>
                    <input type="text" id="name" name="recipient_name" class="form-input" value="{{ auth()->user()->name }}" required>
                </div>
                <div class="form-group">
                    <label class="form-label" for="phone">No. Telepon</label>
                    <input type="tel" id="phone" name="recipient_phone" class="form-input" value="{{ auth()->user()->phone }}" placeholder="08xxxxxxxxxx" required>
                </div>
            </div>

            <!-- Metode Pengambilan/Pengiriman -->
            <div class="section">
                <h2 class="section-title">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <rect x="1" y="3" width="15" height="13"></rect>
                        <polygon points="16 8 20 8 23 11 23 16 16 16 16 8"></polygon>
                        <circle cx="5.5" cy="18.5" r="2.5"></circle>
                        <circle cx="18.5" cy="18.5" r="2.5"></circle>
                    </svg>
                    Metode Pengambilan
                </h2>
                <div class="shipping-options">
                    <!-- Opsi 1: Ambil Sendiri -->
                    <div class="shipping-option" data-method="pickup">
                        <div class="shipping-option-header">
                            <div class="shipping-radio"></div>
                            <div class="shipping-info">
                                <div class="shipping-name">🏪 Ambil Sendiri</div>
                                <div class="shipping-desc">Ambil barang langsung di lokasi penjual - Gratis</div>
                            </div>
                            <div class="shipping-icon">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path>
                                    <circle cx="12" cy="10" r="3"></circle>
                                </svg>
                            </div>
                        </div>
                        <div class="pickup-location" id="pickup-location-info">
                            <strong>📍 Lokasi Pengambilan:</strong>
                            <span id="pickup-address">Akan ditampilkan setelah memilih produk</span>
                        </div>
                    </div>

                    <!-- Opsi 2: Diantar Penjual -->
                    <div class="shipping-option" data-method="delivery">
                        <div class="shipping-option-header">
                            <div class="shipping-radio"></div>
                            <div class="shipping-info">
                                <div class="shipping-name">🚚 Diantar oleh Penjual</div>
                                <div class="shipping-desc">Penjual mengirim langsung ke alamat Anda</div>
                            </div>
                            <div class="shipping-icon">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <rect x="1" y="3" width="15" height="13"></rect>
                                    <polygon points="16 8 20 8 23 11 23 16 16 16 16 8"></polygon>
                                    <circle cx="5.5" cy="18.5" r="2.5"></circle>
                                    <circle cx="18.5" cy="18.5" r="2.5"></circle>
                                </svg>
                            </div>
                        </div>
                        <div class="delivery-details">
                            <div class="delivery-fee-input">
                                <span>💰 Biaya Pengiriman:</span>
                                <span class="delivery-fee-display" id="delivery-fee-display">Rp0</span>
                                <span style="font-size: 12px; color: #666;">(ditentukan penjual)</span>
                            </div>
                            <div class="delivery-note">
                                ⚠️ Biaya pengiriman akan dikonfirmasi oleh penjual setelah pesanan dibuat. Anda dapat membatalkan jika tidak setuju dengan biaya.
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Alamat Pengiriman (hanya untuk delivery) -->
            <div class="section address-section" id="address-section">
                <h2 class="section-title">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>
                        <polyline points="9 22 9 12 15 12 15 22"></polyline>
                    </svg>
                    Alamat Pengiriman
                </h2>
                <div class="form-group">
                    <label class="form-label" for="address">Alamat Lengkap</label>
                    <textarea id="address" name="shipping_address" class="form-textarea" placeholder="Jalan, Nomor Rumah, RT/RW, Kelurahan, Kecamatan"></textarea>
                </div>
                <div class="form-group">
                    <label class="form-label" for="notes">Catatan untuk Pengantar (Opsional)</label>
                    <textarea id="notes" name="notes" class="form-textarea" placeholder="Contoh: Rumah cat hijau, depan minimarket, hubungi saat sampai" rows="3"></textarea>
                </div>
            </div>

            <!-- Ringkasan Pesanan -->
            <div class="section">
                <h2 class="section-title">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <circle cx="9" cy="21" r="1"></circle>
                        <circle cx="20" cy="21" r="1"></circle>
                        <path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"></path>
                    </svg>
                    Ringkasan Pesanan
                </h2>
                <div id="order-items"></div>
                <div style="margin-top: 16px;">
                    <div class="summary-row">
                        <span>Subtotal Produk</span>
                        <span class="summary-value" id="subtotal">Rp0</span>
                    </div>
                    <div class="summary-row" id="shipping-fee-row">
                        <span>Biaya Pengiriman</span>
                        <span class="summary-value" id="shipping-fee-summary">Gratis</span>
                    </div>
                    <div class="summary-row total">
                        <span>Total Pembayaran</span>
                        <span class="summary-value total" id="total">Rp0</span>
                    </div>
                </div>
            </div>

            <!-- Metode Pembayaran -->
            <div class="section">
                <h2 class="section-title">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <rect x="1" y="4" width="22" height="16" rx="2" ry="2"></rect>
                        <line x1="1" y1="10" x2="23" y2="10"></line>
                    </svg>
                    Metode Pembayaran
                </h2>
                <div class="payment-options">
                    <div class="payment-option active" data-method="transfer">
                        <div class="payment-radio"></div>
                        <div class="payment-info">
                            <div class="payment-name">Transfer Bank</div>
                            <div class="payment-desc">Transfer ke rekening validator & upload bukti pembayaran</div>
                        </div>
                        <div class="payment-icon">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <rect x="1" y="4" width="22" height="16" rx="2" ry="2"></rect>
                                <line x1="1" y1="10" x2="23" y2="10"></line>
                            </svg>
                        </div>
                    </div>
                    <div style="background: #fffbeb; border: 2px solid #fbbf24; border-radius: 8px; padding: 12px; margin-top: 12px;">
                        <div style="color: #92400e; font-size: 13px; display: flex; align-items: start; gap: 8px;">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#f59e0b" stroke-width="2">
                                <circle cx="12" cy="12" r="10"/>
                                <line x1="12" y1="8" x2="12" y2="12"/>
                                <line x1="12" y1="16" x2="12.01" y2="16"/>
                            </svg>
                            <div>
                                <strong>Catatan Penting:</strong> Pembayaran dilakukan melalui transfer ke rekening validator untuk memastikan keamanan transaksi. Validator akan meneruskan pembayaran ke penjual setelah barang diterima.
                            </div>
                        </div>
                    </div>
                </div>
                <input type="hidden" name="payment_method" id="payment-method" required>
            </div>
        </form>
    </main>

    <div class="bottom-action">
        <button type="submit" form="checkout-form" class="btn-checkout" id="btn-checkout">
            Buat Pesanan
        </button>
    </div>

    <script>
        // Check if this is direct buy or from cart
        const urlParams = new URLSearchParams(window.location.search);
        const isDirect = urlParams.get('direct') === '1';
        
        // Load cart data based on type
        let cart;
        if (isDirect) {
            cart = JSON.parse(localStorage.getItem('mama-direct-buy') || '[]');
        } else {
            cart = JSON.parse(localStorage.getItem('mama-cart') || '[]');
        }
        
        if (cart.length === 0) {
            window.location.href = '{{ route("cart.index") }}';
        }

        // Product data from server (including location)
        const productData = {
            @foreach(App\Models\Product::with('seller')->get() as $product)
                {{ $product->id }}: {
                    id: {{ $product->id }},
                    name: "{{ addslashes($product->name) }}",
                    price: {{ $product->price }},
                    seller_id: {{ $product->seller_id }},
                    seller_name: "{{ addslashes($product->seller->name ?? 'Penjual') }}",
                    location: "{{ addslashes($product->location ?? 'Lokasi tidak tersedia') }}",
                    image: @if($product->images && is_array($product->images) && count($product->images) > 0) "{{ asset('storage/' . $product->images[0]) }}" @else null @endif
                },
            @endforeach
        };

        let subtotal = 0;
        let shippingFee = 0;

        // Render order items
        function renderOrderItems() {
            const container = document.getElementById('order-items');
            let html = '';
            subtotal = 0;
            let pickupLocations = [];

            cart.forEach(item => {
                const product = productData[item.product_id];
                if (product) {
                    const itemTotal = product.price * item.quantity;
                    subtotal += itemTotal;
                    
                    // Collect pickup locations
                    if (product.location && !pickupLocations.includes(product.location)) {
                        pickupLocations.push(`${product.seller_name}: ${product.location}`);
                    }

                    const imageHtml = product.image ?
                        `<img src="${product.image}" alt="${product.name}" class="item-image">` :
                        `<div class="item-image"></div>`;

                    html += `
                        <div class="order-item">
                            ${imageHtml}
                            <div class="item-details">
                                <div class="item-name">${product.name}</div>
                                <div class="item-price">Rp${parseInt(product.price).toLocaleString('id-ID')}</div>
                                <div class="item-qty">Jumlah: ${item.quantity}</div>
                                <div style="font-size: 11px; color: #888; margin-top: 4px;">📍 ${product.location}</div>
                            </div>
                        </div>
                    `;
                }
            });

            container.innerHTML = html;
            
            // Update pickup location info
            document.getElementById('pickup-address').innerHTML = pickupLocations.length > 0 
                ? pickupLocations.join('<br>') 
                : 'Lokasi tidak tersedia';
            
            updateTotals();
        }

        // Update totals
        function updateTotals() {
            document.getElementById('subtotal').textContent = 'Rp' + subtotal.toLocaleString('id-ID');
            
            const shippingMethodInput = document.getElementById('shipping-method');
            if (shippingMethodInput.value === 'pickup') {
                shippingFee = 0;
                document.getElementById('shipping-fee-summary').textContent = 'Gratis (Ambil Sendiri)';
            } else if (shippingMethodInput.value === 'delivery') {
                // Shipping fee akan dikonfirmasi penjual
                shippingFee = 0; // Sementara 0, akan dikonfirmasi
                document.getElementById('shipping-fee-summary').textContent = 'Dikonfirmasi penjual';
            } else {
                document.getElementById('shipping-fee-summary').textContent = '-';
            }
            
            document.getElementById('shipping-fee-input').value = shippingFee;
            document.getElementById('total').textContent = 'Rp' + (subtotal + shippingFee).toLocaleString('id-ID');
        }

        // Shipping method selection
        const shippingOptions = document.querySelectorAll('.shipping-option');
        const shippingMethodInput = document.getElementById('shipping-method');
        const addressSection = document.getElementById('address-section');
        const addressInput = document.getElementById('address');

        shippingOptions.forEach(option => {
            option.addEventListener('click', function() {
                shippingOptions.forEach(opt => opt.classList.remove('selected'));
                this.classList.add('selected');
                shippingMethodInput.value = this.dataset.method;
                
                // Show/hide address section
                if (this.dataset.method === 'delivery') {
                    addressSection.classList.add('show');
                    addressInput.setAttribute('required', 'required');
                } else {
                    addressSection.classList.remove('show');
                    addressInput.removeAttribute('required');
                }
                
                updateTotals();
            });
        });

        // Payment method selection
        const paymentOptions = document.querySelectorAll('.payment-option');
        const paymentMethodInput = document.getElementById('payment-method');

        paymentOptions.forEach(option => {
            option.addEventListener('click', function() {
                paymentOptions.forEach(opt => opt.classList.remove('selected'));
                this.classList.add('selected');
                paymentMethodInput.value = this.dataset.method;
            });
        });

        // Form submission
        document.getElementById('checkout-form').addEventListener('submit', function(e) {
            if (!shippingMethodInput.value) {
                e.preventDefault();
                alert('Silakan pilih metode pengambilan barang');
                return;
            }
            
            if (!paymentMethodInput.value) {
                e.preventDefault();
                alert('Silakan pilih metode pembayaran');
                return;
            }
            
            // Validate address for delivery
            if (shippingMethodInput.value === 'delivery' && !addressInput.value.trim()) {
                e.preventDefault();
                alert('Silakan isi alamat pengiriman');
                return;
            }

            // Set cart data
            document.getElementById('cart-data').value = JSON.stringify(cart);
            
            // Clear the appropriate storage after successful submission
            if (isDirect) {
                localStorage.removeItem('mama-direct-buy');
            } else {
                localStorage.removeItem('mama-cart');
            }
        });

        // Initial render
        renderOrderItems();
    </script>
</body>
</html>
