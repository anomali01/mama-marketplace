<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1, user-scalable=no">
    <title>Keranjang - MAMA Marketplace</title>
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
            padding-bottom: 80px;
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
            padding: 16px;
        }

        /* Cart Items */
        .cart-items {
            display: flex;
            flex-direction: column;
            gap: 12px;
        }

        .cart-item {
            background: white;
            border-radius: 12px;
            padding: 12px;
            display: flex;
            gap: 12px;
        }

        .cart-item-image {
            width: 80px;
            height: 80px;
            border-radius: 8px;
            object-fit: cover;
            background: #e0e0e0;
            flex-shrink: 0;
        }

        .cart-item-details {
            flex: 1;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        .cart-item-name {
            font-size: 14px;
            font-weight: 600;
            color: #333;
            line-height: 1.4;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        .cart-item-meta {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-top: 8px;
        }

        .cart-item-price {
            font-size: 14px;
            font-weight: 700;
            color: #ff6a00;
        }

        .cart-item-remove {
            background: none;
            border: none;
            color: #999;
            cursor: pointer;
            font-size: 20px;
            padding: 0;
            width: 24px;
            height: 24px;
        }

        .cart-item-qty {
            display: flex;
            align-items: center;
            background: #f5f5f5;
            border-radius: 6px;
            padding: 2px;
            gap: 4px;
        }

        .qty-btn-small {
            width: 24px;
            height: 24px;
            border: none;
            background: transparent;
            color: #333;
            font-size: 14px;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .qty-input-small {
            width: 30px;
            border: none;
            background: transparent;
            text-align: center;
            font-size: 12px;
            font-weight: 600;
            color: #333;
            padding: 0;
        }

        .qty-input-small:focus {
            outline: none;
        }

        .empty-state {
            text-align: center;
            padding: 80px 20px;
            color: #999;
        }

        .empty-state svg {
            width: 100px;
            height: 100px;
            margin-bottom: 20px;
            opacity: 0.5;
        }

        .empty-state h2 {
            font-size: 18px;
            color: #666;
            margin-bottom: 8px;
        }

        .empty-state p {
            font-size: 14px;
            margin-bottom: 24px;
        }

        .btn-shop {
            display: inline-block;
            padding: 12px 32px;
            background: #ff6a00;
            color: white;
            font-weight: 600;
            text-decoration: none;
            border-radius: 25px;
            transition: background 0.2s;
        }

        .btn-shop:hover {
            background: #e55f00;
        }

        /* Summary */
        .cart-summary {
            background: white;
            border-radius: 12px;
            padding: 16px;
            margin-top: 12px;
        }

        .summary-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 8px 0;
            font-size: 14px;
            color: #666;
        }

        .summary-row.total {
            border-top: 1px solid #eee;
            padding-top: 12px;
            margin-top: 12px;
            font-size: 16px;
            font-weight: 700;
            color: #333;
        }

        .summary-value {
            color: #ff6a00;
            font-weight: 600;
        }

        .summary-value.total {
            color: #ff6a00;
        }

        /* Bottom Action */
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

        .btn-checkout {
            flex: 1;
            padding: 14px 20px;
            background: linear-gradient(135deg, #1a9fff 0%, #0080e0 100%);
            color: white;
            font-size: 15px;
            font-weight: 600;
            border: none;
            border-radius: 12px;
            cursor: pointer;
            transition: all 0.2s;
        }

        .btn-checkout:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0, 128, 224, 0.3);
        }

        .btn-checkout:disabled {
            background: #ccc;
            cursor: not-allowed;
            transform: none;
        }

        /* Bottom Navigation */
        .bottom-nav {
            display: none;
        }

        @media (max-width: 600px) {
            .bottom-action {
                padding: 12px 16px;
            }

            .btn-checkout {
                padding: 12px 16px;
                font-size: 14px;
            }
        }

        @media (min-width: 900px) {
            .main-content {
                max-width: 800px;
                margin: 0 auto;
            }

            .bottom-action {
                max-width: 800px;
                left: 50%;
                transform: translateX(-50%);
            }
        }
    </style>
</head>
<body>
    <header class="header">
        <a href="{{ route('home') }}" class="back-btn">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M19 12H5M12 19l-7-7 7-7"/>
            </svg>
        </a>
        <h1 class="header-title">Keranjang</h1>
        <span style="color: white; font-size: 14px; background: rgba(255,255,255,0.2); padding: 4px 12px; border-radius: 20px;" id="cart-count">0</span>
    </header>

    <main class="main-content" id="cart-container">
        <div class="empty-state">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                <circle cx="9" cy="21" r="1"></circle>
                <circle cx="20" cy="21" r="1"></circle>
                <path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"></path>
            </svg>
            <h2>Keranjang Kosong</h2>
            <p>Belum ada produk di keranjang kamu</p>
            <a href="{{ route('home') }}" class="btn-shop">Mulai Belanja</a>
        </div>
    </main>

    <!-- Bottom Action -->
    <div class="bottom-action" id="bottom-action" style="display: none;">
        <button class="btn-checkout" id="btn-checkout">Checkout</button>
    </div>

    <script>
        // Store product data in window (we'll populate this via server)
        window.productData = {
            @forelse(App\Models\Product::all() as $product)
                {{ $product->id }}: {
                    id: {{ $product->id }},
                    name: "{{ addslashes($product->name) }}",
                    price: {{ $product->price }},
                    image: @if($product->images && is_array($product->images) && count($product->images) > 0) "{{ asset('storage/' . $product->images[0]) }}" @else null @endif,
                    stock: {{ $product->stock }}
                },
            @empty
            @endforelse
        };

        function renderCart() {
            const cart = JSON.parse(localStorage.getItem('mama-cart') || '[]');
            const container = document.getElementById('cart-container');
            const bottomAction = document.getElementById('bottom-action');
            const cartCount = document.getElementById('cart-count');
            
            if (cartCount) cartCount.textContent = cart.length;
            
            if (cart.length === 0) {
                container.innerHTML = `
                    <div class="empty-state">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                            <circle cx="9" cy="21" r="1"></circle>
                            <circle cx="20" cy="21" r="1"></circle>
                            <path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"></path>
                        </svg>
                        <h2>Keranjang Kosong</h2>
                        <p>Belum ada produk di keranjang kamu</p>
                        <a href="{{ route('home') }}" class="btn-shop">Mulai Belanja</a>
                    </div>
                `;
                bottomAction.style.display = 'none';
                return;
            }

            let html = '<div class="cart-items">';
            let total = 0;

            cart.forEach((item, index) => {
                const product = window.productData[item.product_id];
                if (product) {
                    const itemTotal = product.price * item.quantity;
                    total += itemTotal;
                    
                    const imageHtml = product.image ? 
                        `<img src="${product.image}" alt="${product.name}" class="cart-item-image">` :
                        `<div class="cart-item-image" style="background: #e0e0e0;"></div>`;
                    
                    html += `
                        <div class="cart-item" data-index="${index}" data-product-id="${item.product_id}">
                            ${imageHtml}
                            <div class="cart-item-details">
                                <div class="cart-item-name">${product.name}</div>
                                <div class="cart-item-meta">
                                    <div class="cart-item-price">Rp${parseInt(product.price).toLocaleString('id-ID')}</div>
                                    <div class="cart-item-qty">
                                        <button class="qty-btn-small" onclick="updateQty(${index}, -1)">−</button>
                                        <input type="number" class="qty-input-small" value="${item.quantity}" min="1" max="${product.stock}" onchange="updateQtyDirect(${index}, this.value)">
                                        <button class="qty-btn-small" onclick="updateQty(${index}, 1)">+</button>
                                        <button class="cart-item-remove" onclick="removeFromCart(${index})">✕</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    `;
                }
            });

            html += '</div>';
            html += `
                <div class="cart-summary">
                    <div class="summary-row">
                        <span>Subtotal</span>
                        <span class="summary-value">Rp${total.toLocaleString('id-ID')}</span>
                    </div>
                    <div class="summary-row">
                        <span>Ongkir</span>
                        <span class="summary-value">Gratis</span>
                    </div>
                    <div class="summary-row total">
                        <span>Total</span>
                        <span class="summary-value total">Rp${total.toLocaleString('id-ID')}</span>
                    </div>
                </div>
            `;

            container.innerHTML = html;
            bottomAction.style.display = 'flex';
        }

        function updateQty(index, change) {
            const cart = JSON.parse(localStorage.getItem('mama-cart') || '[]');
            if (cart[index]) {
                const newQty = parseInt(cart[index].quantity) + change;
                const product = window.productData[cart[index].product_id];
                if (newQty >= 1 && newQty <= product.stock) {
                    cart[index].quantity = newQty;
                    localStorage.setItem('mama-cart', JSON.stringify(cart));
                    renderCart();
                }
            }
        }

        function updateQtyDirect(index, qty) {
            const cart = JSON.parse(localStorage.getItem('mama-cart') || '[]');
            if (cart[index]) {
                const product = window.productData[cart[index].product_id];
                const newQty = parseInt(qty);
                if (newQty >= 1 && newQty <= product.stock) {
                    cart[index].quantity = newQty;
                    localStorage.setItem('mama-cart', JSON.stringify(cart));
                    renderCart();
                } else {
                    renderCart(); // Reset to previous value
                }
            }
        }

        function removeFromCart(index) {
            const cart = JSON.parse(localStorage.getItem('mama-cart') || '[]');
            cart.splice(index, 1);
            localStorage.setItem('mama-cart', JSON.stringify(cart));
            renderCart();
        }

        document.getElementById('btn-checkout').addEventListener('click', function() {
            const cart = JSON.parse(localStorage.getItem('mama-cart') || '[]');
            if (cart.length === 0) {
                alert('Keranjang kosong!');
                return;
            }

            // Redirect to checkout page
            window.location.href = '{{ route("checkout.index") }}';
        });

        // Initial render
        document.addEventListener('DOMContentLoaded', renderCart);
    </script>
</body>
</html>
