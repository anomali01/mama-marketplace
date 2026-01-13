<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1, user-scalable=no">
    <title>Detail Pesanan #{{ $order->order_code }} - MAMA Marketplace</title>
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
            padding-bottom: 40px;
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
            font-size: 16px;
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
            font-size: 15px;
            font-weight: 700;
            color: #333;
            margin-bottom: 12px;
        }

        /* Alert Messages */
        .alert {
            display: flex;
            align-items: flex-start;
            padding: 12px 16px;
            border-radius: 8px;
            margin-bottom: 16px;
            font-size: 14px;
            line-height: 1.6;
        }

        .alert-success {
            background: linear-gradient(135deg, #d4edda 0%, #c3e6cb 100%);
            color: #155724;
            border-left: 4px solid #28a745;
            box-shadow: 0 2px 8px rgba(40, 167, 69, 0.2);
            font-weight: 500;
        }

        .alert-error {
            background: #ffebee;
            color: #c62828;
            border-left: 4px solid #dc3545;
        }

        /* Status Timeline */
        .timeline {
            position: relative;
            padding-left: 40px;
        }

        .timeline-item {
            position: relative;
            padding-bottom: 24px;
        }

        .timeline-item:last-child {
            padding-bottom: 0;
        }

        .timeline-item::before {
            content: '';
            position: absolute;
            left: -29px;
            top: 8px;
            bottom: -24px;
            width: 2px;
            background: #e0e0e0;
        }

        .timeline-item:last-child::before {
            display: none;
        }

        .timeline-dot {
            position: absolute;
            left: -36px;
            top: 0;
            width: 16px;
            height: 16px;
            border-radius: 50%;
            border: 3px solid #e0e0e0;
            background: white;
        }

        .timeline-item.active .timeline-dot {
            border-color: #0080e0;
            background: #0080e0;
        }

        .timeline-item.completed .timeline-dot {
            border-color: #4caf50;
            background: #4caf50;
        }

        .timeline-content {
            font-size: 14px;
        }

        .timeline-title {
            font-weight: 600;
            color: #333;
            margin-bottom: 4px;
        }

        .timeline-item.active .timeline-title {
            color: #0080e0;
        }

        .timeline-item.completed .timeline-title {
            color: #4caf50;
        }

        .timeline-time {
            font-size: 12px;
            color: #999;
        }

        /* Order Info */
        .info-row {
            display: flex;
            justify-content: space-between;
            padding: 8px 0;
            font-size: 14px;
            border-bottom: 1px solid #f5f5f5;
        }

        .info-row:last-child {
            border-bottom: none;
        }

        .info-label {
            color: #666;
        }

        .info-value {
            font-weight: 600;
            color: #333;
            text-align: right;
        }

        /* Status Badge */
        .status-badge {
            display: inline-block;
            padding: 4px 12px;
            border-radius: 12px;
            font-size: 12px;
            font-weight: 600;
        }

        .status-pending {
            background: #fff3e0;
            color: #ef6c00;
        }

        .status-paid {
            background: #e3f2fd;
            color: #1565c0;
        }

        .status-packed {
            background: #f3e5f5;
            color: #7b1fa2;
        }

        .status-shipped {
            background: #e1f5fe;
            color: #0277bd;
        }

        .status-delivered {
            background: #e8f5e9;
            color: #2e7d32;
        }

        /* Products */
        .product-item {
            display: flex;
            gap: 12px;
            padding: 12px 0;
            border-bottom: 1px solid #f5f5f5;
        }

        .product-item:last-child {
            border-bottom: none;
        }

        .product-image {
            width: 60px;
            height: 60px;
            border-radius: 8px;
            object-fit: cover;
            background: #e0e0e0;
        }

        .product-details {
            flex: 1;
        }

        .product-name {
            font-size: 14px;
            font-weight: 600;
            color: #333;
            margin-bottom: 4px;
        }

        .product-price {
            font-size: 13px;
            color: #ff6a00;
            font-weight: 600;
        }

        .product-qty {
            font-size: 12px;
            color: #999;
        }

        /* Upload Section */
        .upload-section {
            margin-top: 16px;
            padding: 16px;
            background: #f5f5f5;
            border-radius: 8px;
        }

        .upload-title {
            font-size: 14px;
            font-weight: 600;
            color: #333;
            margin-bottom: 12px;
        }

        .file-input {
            display: block;
            width: 100%;
            padding: 12px;
            border: 2px dashed #0080e0;
            border-radius: 8px;
            background: white;
            cursor: pointer;
            text-align: center;
            font-size: 14px;
            color: #666;
            margin-bottom: 12px;
        }

        .file-input:hover {
            background: #f0f8ff;
        }

        .preview-image {
            max-width: 200px;
            max-height: 200px;
            border-radius: 8px;
            margin-top: 12px;
        }

        /* Buttons */
        .btn {
            display: inline-block;
            padding: 12px 24px;
            border-radius: 8px;
            font-size: 14px;
            font-weight: 600;
            text-align: center;
            cursor: pointer;
            border: none;
            transition: all 0.2s;
            text-decoration: none;
        }

        .btn-primary {
            background: linear-gradient(135deg, #0080e0 0%, #1a9fff 100%);
            color: white;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0, 128, 224, 0.3);
        }

        .btn-success {
            background: linear-gradient(135deg, #4caf50 0%, #66bb6a 100%);
            color: white;
        }

        .btn-success:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(76, 175, 80, 0.3);
        }

        .btn-block {
            display: block;
            width: 100%;
        }

        .btn:disabled {
            background: #ccc;
            cursor: not-allowed;
            transform: none;
        }

        /* Seller Actions */
        .seller-actions {
            display: flex;
            gap: 8px;
            margin-top: 12px;
        }

        .seller-actions .btn {
            flex: 1;
        }

        /* Address */
        .address-text {
            font-size: 14px;
            color: #666;
            line-height: 1.6;
            white-space: pre-line;
        }
    </style>
</head>
<body>
    <header class="header">
        <a href="{{ route('orders.index') }}" class="back-btn">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M19 12H5M12 19l-7-7 7-7"/>
            </svg>
        </a>
        <h1 class="header-title">Pesanan #{{ $order->order_code }}</h1>
    </header>

    <main class="main-content">
        @if(session('success'))
            <div class="alert alert-success">
                <svg style="width: 20px; height: 20px; margin-right: 8px; flex-shrink: 0; display: inline-block; vertical-align: middle;" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M9 12l2 2 4-4"/>
                    <circle cx="12" cy="12" r="10"/>
                </svg>
                <span style="flex: 1;">{{ session('success') }}</span>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-error">
                <svg style="width: 20px; height: 20px; margin-right: 8px; flex-shrink: 0; display: inline-block; vertical-align: middle;" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <circle cx="12" cy="12" r="10"/>
                    <line x1="15" y1="9" x2="9" y2="15"/>
                    <line x1="9" y1="9" x2="15" y2="15"/>
                </svg>
                <span style="flex: 1;">{{ session('error') }}</span>
            </div>
        @endif

        <!-- Status Timeline -->
        <div class="section">
            <h2 class="section-title">Status Pesanan</h2>
            <div class="timeline">
                <div class="timeline-item {{ $order->status === 'pending' ? 'active' : 'completed' }}">
                    <div class="timeline-dot"></div>
                    <div class="timeline-content">
                        <div class="timeline-title">Pesanan Dibuat</div>
                        <div class="timeline-time">{{ $order->created_at->format('d M Y, H:i') }}</div>
                    </div>
                </div>

                @if($order->payment_method === 'transfer')
                <div class="timeline-item {{ in_array($order->payment_status, ['pending_confirmation', 'confirmed']) ? ($order->payment_status === 'pending_confirmation' ? 'active' : 'completed') : '' }}">
                    <div class="timeline-dot"></div>
                    <div class="timeline-content">
                        <div class="timeline-title">Menunggu Konfirmasi Pembayaran</div>
                        @if($order->payment_status === 'pending_confirmation')
                            <div class="timeline-time">Menunggu konfirmasi penjual</div>
                        @elseif($order->confirmed_at)
                            <div class="timeline-time">{{ $order->confirmed_at->format('d M Y, H:i') }}</div>
                        @endif
                    </div>
                </div>
                @endif

                <div class="timeline-item {{ $order->status === 'paid' ? 'active' : ($order->confirmed_at ? 'completed' : '') }}">
                    <div class="timeline-dot"></div>
                    <div class="timeline-content">
                        <div class="timeline-title">Pembayaran Dikonfirmasi</div>
                        @if($order->confirmed_at)
                            <div class="timeline-time">{{ $order->confirmed_at->format('d M Y, H:i') }}</div>
                        @endif
                    </div>
                </div>

                <div class="timeline-item {{ $order->status === 'packed' ? 'active' : ($order->packed_at ? 'completed' : '') }}">
                    <div class="timeline-dot"></div>
                    <div class="timeline-content">
                        <div class="timeline-title">Pesanan Dikemas</div>
                        @if($order->packed_at)
                            <div class="timeline-time">{{ $order->packed_at->format('d M Y, H:i') }}</div>
                        @endif
                    </div>
                </div>

                <div class="timeline-item {{ $order->status === 'shipped' ? 'active' : ($order->shipped_at ? 'completed' : '') }}">
                    <div class="timeline-dot"></div>
                    <div class="timeline-content">
                        <div class="timeline-title">
                            @if($order->shipping_method === 'pickup')
                                Siap Diambil
                            @else
                                Pesanan Dikirim
                            @endif
                        </div>
                        @if($order->shipped_at)
                            <div class="timeline-time">{{ $order->shipped_at->format('d M Y, H:i') }}</div>
                        @endif
                    </div>
                </div>

                <div class="timeline-item {{ $order->status === 'delivered' ? 'completed' : '' }}">
                    <div class="timeline-dot"></div>
                    <div class="timeline-content">
                        <div class="timeline-title">Pesanan Diterima</div>
                        @if($order->delivered_at)
                            <div class="timeline-time">{{ $order->delivered_at->format('d M Y, H:i') }}</div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Order Info -->
        <div class="section">
            <h2 class="section-title">Informasi Pesanan</h2>
            <div class="info-row">
                <span class="info-label">Kode Pesanan</span>
                <span class="info-value">{{ $order->order_code }}</span>
            </div>
            <div class="info-row">
                <span class="info-label">Tanggal</span>
                <span class="info-value">{{ $order->created_at->format('d M Y, H:i') }}</span>
            </div>
            <div class="info-row">
                <span class="info-label">Status</span>
                <span class="info-value">
                    <span class="status-badge status-{{ $order->status }}">
                        {{ ucfirst($order->status) }}
                    </span>
                </span>
            </div>
            <div class="info-row">
                <span class="info-label">Metode Pembayaran</span>
                <span class="info-value">Transfer Bank</span>
            </div>
            <div class="info-row">
                <span class="info-label">Total</span>
                <span class="info-value" style="color: #ff6a00;">Rp{{ number_format($order->total_amount, 0, ',', '.') }}</span>
            </div>
        </div>

        <!-- Products -->
        <div class="section">
            <h2 class="section-title">Produk</h2>
            @foreach($order->items as $item)
                <div class="product-item">
                    @php
                        $productImage = null;
                        if ($item->product->images && is_array($item->product->images) && count($item->product->images) > 0) {
                            $productImage = asset('storage/' . $item->product->images[0]);
                        }
                    @endphp
                    @if($productImage)
                        <img src="{{ $productImage }}" alt="{{ $item->product->name }}" class="product-image">
                    @else
                        <div class="product-image"></div>
                    @endif
                    <div class="product-details">
                        <div class="product-name">{{ $item->product->name }}</div>
                        <div class="product-price">Rp{{ number_format($item->price_at_order, 0, ',', '.') }}</div>
                        <div class="product-qty">Jumlah: {{ $item->quantity }}</div>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Shipping Address -->
        <div class="section">
            <h2 class="section-title">Alamat Pengiriman</h2>
            <div class="address-text">{{ $order->shipping_address }}</div>
        </div>

        <!-- Rekening Validator (for Transfer Payment) -->
        @if($order->payment_method === 'transfer')
            @if($order->validator)
                <div class="section" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; border-radius: 12px; padding: 24px; margin-bottom: 24px; box-shadow: 0 4px 20px rgba(102, 126, 234, 0.4);">
                    <h2 style="color: white; font-size: 20px; font-weight: 600; margin-bottom: 20px; display: flex; align-items: center; gap: 10px;">
                        <i class="fas fa-university"></i>
                        Informasi Transfer Pembayaran
                    </h2>
                    
                    <div style="background: rgba(255,255,255,0.2); border-radius: 10px; padding: 18px; margin-bottom: 14px; backdrop-filter: blur(10px); border: 1px solid rgba(255,255,255,0.3);">
                        <div style="font-size: 13px; opacity: 0.9; margin-bottom: 6px; text-transform: uppercase; letter-spacing: 0.5px;">Nama Bank</div>
                        <div style="font-size: 22px; font-weight: 700; letter-spacing: 0.5px;">{{ $order->validator->bank_name ?? 'BCA' }}</div>
                    </div>

                    <div style="background: rgba(255,255,255,0.2); border-radius: 10px; padding: 18px; margin-bottom: 14px; backdrop-filter: blur(10px); border: 1px solid rgba(255,255,255,0.3);">
                        <div style="font-size: 13px; opacity: 0.9; margin-bottom: 6px; text-transform: uppercase; letter-spacing: 0.5px;">Nomor Rekening</div>
                        <div style="font-size: 26px; font-weight: 700; letter-spacing: 2px; font-family: 'Courier New', monospace;">
                        {{ $order->validator->account_number ?? '-' }}
                    </div>
                </div>

                <div style="background: rgba(255,255,255,0.2); border-radius: 10px; padding: 18px; margin-bottom: 14px; backdrop-filter: blur(10px); border: 1px solid rgba(255,255,255,0.3);">
                    <div style="font-size: 13px; opacity: 0.9; margin-bottom: 6px; text-transform: uppercase; letter-spacing: 0.5px;">Atas Nama</div>
                    <div style="font-size: 19px; font-weight: 600;">{{ $order->validator->account_holder_name ?? $order->validator->name }}</div>
                        <div style="font-size: 13px; opacity: 0.9; margin-bottom: 6px; text-transform: uppercase; letter-spacing: 0.5px;">Total yang Harus Ditransfer</div>
                        <div style="font-size: 32px; font-weight: 700; color: #ffd700; text-shadow: 0 2px 4px rgba(0,0,0,0.2);">
                            Rp{{ number_format($order->total_amount, 0, ',', '.') }}
                        </div>
                    </div>

                    <div style="margin-top: 16px; padding: 14px; background: rgba(255,255,255,0.15); border-radius: 8px; font-size: 13px; line-height: 1.7; border-left: 4px solid #ffd700;">
                        <i class="fas fa-info-circle" style="margin-right: 6px;"></i>
                        <strong>PENTING:</strong> Transfer pembayaran dilakukan ke rekening validator prodi untuk verifikasi pembayaran yang lebih aman dan terpercaya. Setelah transfer, silakan upload bukti pembayaran di bawah.
                    </div>
                </div>
            @else
                <div class="section" style="background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%); color: white; border-radius: 12px; padding: 24px; margin-bottom: 24px;">
                    <h2 style="color: white; font-size: 18px; font-weight: 600; margin-bottom: 12px; display: flex; align-items: center; gap: 8px;">
                        <i class="fas fa-exclamation-triangle"></i>
                        Validator Belum Tersedia
                    </h2>
                    <p style="margin: 0; font-size: 14px; line-height: 1.6;">
                        Maaf, saat ini belum ada validator yang tersedia untuk prodi penjual. Silakan hubungi admin untuk informasi lebih lanjut.
                    </p>
                </div>
            @endif
        @endif

        <!-- Upload Payment Proof (Buyer - Transfer only) -->
        @if($order->buyer_id === auth()->id() && $order->payment_method === 'transfer' && !$order->payment_proof)
            <div class="section">
                <h2 class="section-title">Upload Bukti Pembayaran</h2>
                <form action="{{ route('orders.upload-payment', $order) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="upload-section">
                        <div class="upload-title">Silakan upload bukti transfer</div>
                        <input type="file" name="payment_proof" accept="image/*" required class="file-input" id="payment-proof-input">
                        <button type="submit" class="btn btn-primary btn-block">Upload Bukti Pembayaran</button>
                    </div>
                </form>
            </div>
        @endif

        <!-- Show Payment Proof -->
        @if($order->payment_proof)
            <div class="section">
                <h2 class="section-title">Bukti Pembayaran</h2>
                <img src="{{ asset('storage/' . $order->payment_proof) }}" alt="Bukti Pembayaran" class="preview-image">
                @if($order->payment_status === 'pending_confirmation')
                    <p style="margin-top: 12px; font-size: 14px; color: #ef6c00;">
                        <i class="fas fa-clock"></i> Menunggu konfirmasi validator...
                    </p>
                @endif
            </div>
        @endif

        <!-- Seller Actions -->
        @php
            $isSeller = $order->items()->whereHas('product', function($query) {
                $query->where('seller_id', auth()->id());
            })->exists();
        @endphp

        @if($isSeller)
            <div class="section">
                <h2 class="section-title">Aksi Penjual</h2>
                
                @if($order->payment_status === 'pending_confirmation' && $order->payment_proof)
                    <div class="alert" style="background: #fff3cd; border-left: 4px solid #ffc107; padding: 12px 16px; border-radius: 8px; margin-bottom: 16px;">
                        <i class="fas fa-info-circle" style="color: #856404; margin-right: 8px;"></i>
                        <span style="color: #856404; font-size: 14px;">Menunggu validator mengonfirmasi pembayaran</span>
                    </div>
                @endif

                @if($order->status === 'paid')
                    <form action="{{ route('orders.pack', $order) }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-primary btn-block">Kemas Pesanan</button>
                    </form>
                @endif

                @if($order->status === 'packed')
                    <form action="{{ route('orders.ship', $order) }}" method="POST">
                        @csrf
                        @if($order->shipping_method === 'pickup')
                            <button type="submit" class="btn btn-primary btn-block">Pesanan Siap Diambil</button>
                        @else
                            <button type="submit" class="btn btn-primary btn-block">Kirim Pesanan</button>
                        @endif
                    </form>
                @endif
            </div>
        @endif

        <!-- Upload Delivery Proof (Buyer) -->
        @if($order->buyer_id === auth()->id() && $order->status === 'shipped' && !$order->delivery_proof)
            <div class="section">
                <h2 class="section-title">Konfirmasi Penerimaan</h2>
                <form action="{{ route('orders.upload-delivery', $order) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="upload-section">
                        <div class="upload-title">Upload bukti penerimaan barang</div>
                        <input type="file" name="delivery_proof" accept="image/*" required class="file-input">
                        <button type="submit" class="btn btn-success btn-block">Konfirmasi Barang Diterima</button>
                    </div>
                </form>
            </div>
        @endif

        <!-- Show Delivery Proof -->
        @if($order->delivery_proof)
            <div class="section">
                <h2 class="section-title">Bukti Penerimaan</h2>
                <img src="{{ asset('storage/' . $order->delivery_proof) }}" alt="Bukti Penerimaan" class="preview-image">
            </div>
        @endif

        <!-- Chat Seller Button -->
        @if($order->buyer_id === auth()->id())
            @php
                $sellerId = $order->items->first()->product->seller_id;
            @endphp
            <a href="{{ route('messages.show', $sellerId) }}" class="btn btn-primary btn-block" style="margin-top: 12px;">
                Chat Penjual
            </a>
        @endif
    </main>
</body>
</html>
