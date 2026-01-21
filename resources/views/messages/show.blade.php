<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1, user-scalable=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Chat dengan {{ $seller->name }} - MAMA Marketplace</title>
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
            display: flex;
            flex-direction: column;
        }

        /* Header */
        .header {
            background: linear-gradient(135deg, #1a9fff 0%, #0080e0 100%);
            padding: 12px 16px;
            position: sticky;
            top: 0;
            z-index: 100;
        }

        .header-content {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .back-btn {
            width: 40px;
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            background: rgba(255, 255, 255, 0.2);
            border-radius: 50%;
            text-decoration: none;
            transition: background 0.2s;
        }

        .back-btn:hover {
            background: rgba(255, 255, 255, 0.3);
        }

        .back-btn svg {
            width: 24px;
            height: 24px;
        }

        .seller-info {
            display: flex;
            align-items: center;
            gap: 12px;
            flex: 1;
        }

        .seller-avatar {
            width: 44px;
            height: 44px;
            background: rgba(255, 255, 255, 0.3);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 18px;
            font-weight: 700;
            color: white;
        }

        .seller-details {
            flex: 1;
        }

        .seller-name {
            color: white;
            font-size: 16px;
            font-weight: 600;
        }

        .seller-status {
            color: rgba(255, 255, 255, 0.8);
            font-size: 12px;
            display: flex;
            align-items: center;
            gap: 4px;
        }

        .online-dot {
            width: 8px;
            height: 8px;
            background: #4caf50;
            border-radius: 50%;
        }

        .header-actions {
            display: flex;
            gap: 8px;
        }

        .header-btn {
            width: 40px;
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            background: rgba(255, 255, 255, 0.2);
            border-radius: 50%;
            text-decoration: none;
            border: none;
            cursor: pointer;
            transition: background 0.2s;
        }

        .header-btn:hover {
            background: rgba(255, 255, 255, 0.3);
        }

        .header-btn svg {
            width: 22px;
            height: 22px;
        }

        .whatsapp-btn {
            background: #25d366;
        }

        .whatsapp-btn:hover {
            background: #128c7e;
        }

        /* Chat Container */
        .chat-container {
            flex: 1;
            display: flex;
            flex-direction: column;
            max-width: 700px;
            margin: 0 auto;
            width: 100%;
            background: #e5ddd5;
        }

        /* Products Strip */
        .products-strip {
            background: white;
            padding: 10px 16px;
            border-bottom: 1px solid #eee;
        }

        .products-strip-title {
            font-size: 11px;
            font-weight: 600;
            color: #666;
            margin-bottom: 8px;
        }

        .products-scroll {
            display: flex;
            gap: 10px;
            overflow-x: auto;
            padding-bottom: 6px;
            -webkit-overflow-scrolling: touch;
        }

        .products-scroll::-webkit-scrollbar {
            height: 3px;
        }

        .products-scroll::-webkit-scrollbar-thumb {
            background: #ddd;
            border-radius: 2px;
        }

        .product-mini {
            flex-shrink: 0;
            width: 80px;
            text-decoration: none;
            color: inherit;
        }

        .product-mini-img {
            width: 80px;
            height: 80px;
            border-radius: 8px;
            object-fit: cover;
            background: #f0f0f0;
        }

        .product-mini-name {
            font-size: 10px;
            color: #333;
            margin-top: 4px;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
            line-height: 1.3;
        }

        .product-mini-price {
            font-size: 10px;
            font-weight: 600;
            color: #ff6a00;
        }

        /* Messages Area */
        .messages-area {
            flex: 1;
            padding: 16px;
            overflow-y: auto;
            display: flex;
            flex-direction: column;
            gap: 8px;
            background: url('data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAADIAAAAyBAMAAADsEZWCAAAAElBMVEXd3d3e3t7f39/g4ODh4eHi4uK3USJLAAAABnRSTlMBAgMEBQZVJp3xAAAATklEQVQ4y2NgGAWjYBQMZWAoLS1FwQUFBcglJSUlKLiwsBByCRQgtyBwEYqLsQORywtJl5ejoIIClAQ1ChYUoCRoYWEhSoIeBaNgFAwEAACIThpJK8F1fAAAAABJRU5ErkJggg==');
        }

        /* Date Divider */
        .date-divider {
            text-align: center;
            margin: 16px 0;
        }

        .date-divider span {
            background: rgba(255, 255, 255, 0.9);
            padding: 6px 14px;
            border-radius: 8px;
            font-size: 12px;
            color: #666;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
        }

        /* Message */
        .message {
            max-width: 75%;
            padding: 8px 12px;
            border-radius: 8px;
            font-size: 14px;
            line-height: 1.4;
            position: relative;
            animation: messageSlideIn 0.2s ease;
        }

        @keyframes messageSlideIn {
            from {
                opacity: 0;
                transform: translateY(10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .message.sent {
            align-self: flex-end;
            background: #dcf8c6;
            color: #303030;
            border-bottom-right-radius: 2px;
        }

        .message.received {
            align-self: flex-start;
            background: white;
            color: #303030;
            border-bottom-left-radius: 2px;
        }

        .message-content {
            word-wrap: break-word;
        }

        .message-time {
            font-size: 11px;
            color: rgba(0,0,0,0.45);
            margin-top: 4px;
            text-align: right;
            display: flex;
            align-items: center;
            justify-content: flex-end;
            gap: 4px;
        }

        .message-time svg {
            width: 16px;
            height: 16px;
        }

        .read-check {
            color: #53bdeb;
        }

        /* Attachment */
        .message-attachment {
            margin-bottom: 6px;
        }

        .message-attachment img {
            max-width: 250px;
            max-height: 300px;
            border-radius: 6px;
            cursor: pointer;
        }

        .file-attachment {
            display: flex;
            align-items: center;
            gap: 10px;
            background: rgba(0,0,0,0.05);
            padding: 10px 12px;
            border-radius: 6px;
            text-decoration: none;
            color: inherit;
        }

        .file-icon {
            width: 40px;
            height: 40px;
            background: #ff6a00;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
        }

        .file-icon svg {
            width: 24px;
            height: 24px;
        }

        .file-info {
            flex: 1;
        }

        .file-name {
            font-size: 13px;
            font-weight: 500;
            color: #333;
        }

        .file-size {
            font-size: 11px;
            color: #666;
        }

        /* Input Area */
        .input-area {
            background: #f0f0f0;
            padding: 10px 12px;
            display: flex;
            gap: 8px;
            align-items: flex-end;
        }

        .attach-btn {
            width: 44px;
            height: 44px;
            background: transparent;
            border: none;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #666;
            cursor: pointer;
            transition: background 0.2s;
            flex-shrink: 0;
        }

        .attach-btn:hover {
            background: #e0e0e0;
        }

        .attach-btn svg {
            width: 24px;
            height: 24px;
        }

        .input-wrapper {
            flex: 1;
            background: white;
            border-radius: 24px;
            padding: 8px 16px;
            display: flex;
            align-items: center;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
        }

        .chat-input {
            flex: 1;
            border: none;
            background: transparent;
            font-family: inherit;
            font-size: 15px;
            resize: none;
            max-height: 100px;
            outline: none;
        }

        .chat-input::placeholder {
            color: #999;
        }

        .send-btn {
            width: 48px;
            height: 48px;
            background: #00a884;
            border: none;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            cursor: pointer;
            transition: transform 0.2s, background 0.2s;
            flex-shrink: 0;
        }

        .send-btn:hover {
            background: #008f72;
            transform: scale(1.05);
        }

        .send-btn:disabled {
            background: #ccc;
            cursor: not-allowed;
            transform: none;
        }

        .send-btn svg {
            width: 24px;
            height: 24px;
        }

        /* File Preview */
        .file-preview {
            display: none;
            background: white;
            padding: 12px 16px;
            border-bottom: 1px solid #eee;
            align-items: center;
            gap: 12px;
        }

        .file-preview.show {
            display: flex;
        }

        .preview-image {
            width: 60px;
            height: 60px;
            border-radius: 8px;
            object-fit: cover;
        }

        .preview-file-icon {
            width: 60px;
            height: 60px;
            background: #ff6a00;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
        }

        .preview-info {
            flex: 1;
        }

        .preview-name {
            font-size: 14px;
            font-weight: 500;
            color: #333;
        }

        .preview-size {
            font-size: 12px;
            color: #666;
        }

        .preview-remove {
            width: 32px;
            height: 32px;
            background: #ff5252;
            border: none;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            cursor: pointer;
        }

        /* Empty Chat */
        .empty-chat {
            flex: 1;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            text-align: center;
            padding: 40px 20px;
        }

        .empty-chat-icon {
            width: 80px;
            height: 80px;
            background: rgba(0,0,0,0.05);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 16px;
        }

        .empty-chat-icon svg {
            width: 40px;
            height: 40px;
            color: #666;
        }

        .empty-chat h3 {
            font-size: 16px;
            font-weight: 600;
            color: #333;
            margin-bottom: 8px;
        }

        .empty-chat p {
            font-size: 14px;
            color: #666;
            line-height: 1.5;
        }

        /* No Image */
        .no-image {
            width: 80px;
            height: 80px;
            border-radius: 8px;
            background: #e0e0e0;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .no-image svg {
            width: 30px;
            height: 30px;
            color: #999;
        }

        /* Hidden file input */
        .hidden-input {
            display: none;
        }

        /* Image Modal */
        .image-modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0,0,0,0.9);
            z-index: 1000;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .image-modal.show {
            display: flex;
        }

        .image-modal img {
            max-width: 100%;
            max-height: 100%;
            border-radius: 8px;
        }

        .image-modal-close {
            position: absolute;
            top: 20px;
            right: 20px;
            width: 40px;
            height: 40px;
            background: rgba(255,255,255,0.2);
            border: none;
            border-radius: 50%;
            color: white;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        /* Responsive */
        @media (min-width: 600px) {
            .chat-container {
                border-left: 1px solid #ddd;
                border-right: 1px solid #ddd;
            }
        }

        @supports (padding-bottom: env(safe-area-inset-bottom)) {
            .input-area {
                padding-bottom: calc(10px + env(safe-area-inset-bottom));
            }
        }

        /* Loading spinner animation */
        @keyframes spin {
            from {
                transform: rotate(0deg);
            }
            to {
                transform: rotate(360deg);
            }
        }
    </style>
</head>
<body>
    <!-- Header -->
    <header class="header">
        <div class="header-content">
            <a href="{{ route('messages.index') }}" class="back-btn">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M19 12H5M12 19l-7-7 7-7"/>
                </svg>
            </a>
            <div class="seller-info">
                <div class="seller-avatar">
                    {{ strtoupper(substr($seller->name, 0, 1)) }}
                </div>
                <div class="seller-details">
                    <div class="seller-name">{{ $seller->name }}</div>
                    <div class="seller-status">
                        <span class="online-dot"></span>
                        {{ $seller->role == 'mahasiswa' ? 'Penjual' : ucfirst($seller->role) }}
                    </div>
                </div>
            </div>
            <div class="header-actions">
                @if($seller->phone)
                <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $seller->phone) }}?text={{ urlencode('Halo, saya dari MAMA Marketplace...') }}" target="_blank" class="header-btn whatsapp-btn" title="Chat WhatsApp">
                    <svg viewBox="0 0 24 24" fill="currentColor">
                        <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/>
                    </svg>
                </a>
                @endif
            </div>
        </div>
    </header>

    <div class="chat-container">
        <!-- Products Strip -->
        @if($purchasedProducts && $purchasedProducts->count() > 0)
            <div class="products-strip">
                <div class="products-strip-title">Produk yang dibeli:</div>
                <div class="products-scroll">
                    @foreach($purchasedProducts as $product)
                        <a href="{{ route('products.show', $product->id) }}" class="product-mini">
                            @php
                                $productImage = null;
                                if ($product->images && is_array($product->images) && count($product->images) > 0) {
                                    $productImage = asset('storage/' . $product->images[0]);
                                }
                            @endphp
                            
                            @if($productImage)
                                <img src="{{ $productImage }}" alt="{{ $product->name }}" class="product-mini-img">
                            @else
                                <div class="no-image">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                                        <rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect>
                                        <circle cx="8.5" cy="8.5" r="1.5"></circle>
                                        <polyline points="21 15 16 10 5 21"></polyline>
                                    </svg>
                                </div>
                            @endif
                            <div class="product-mini-name">{{ $product->name }}</div>
                            <div class="product-mini-price">Rp{{ number_format($product->price, 0, ',', '.') }}</div>
                        </a>
                    @endforeach
                </div>
            </div>
        @endif

        <!-- File Preview -->
        <div class="file-preview" id="filePreview">
            <img src="" alt="" class="preview-image" id="previewImage" style="display: none;">
            <div class="preview-file-icon" id="previewFileIcon" style="display: none;">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                    <polyline points="14 2 14 8 20 8"></polyline>
                </svg>
            </div>
            <div class="preview-info">
                <div class="preview-name" id="previewName"></div>
                <div class="preview-size" id="previewSize"></div>
            </div>
            <button type="button" class="preview-remove" onclick="removeFile()">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <line x1="18" y1="6" x2="6" y2="18"></line>
                    <line x1="6" y1="6" x2="18" y2="18"></line>
                </svg>
            </button>
        </div>

        <!-- Messages Area -->
        <div class="messages-area" id="messagesArea">
            @if($messages->count() > 0)
                @php $lastDate = null; @endphp
                @foreach($messages as $message)
                    @php
                        $messageDate = $message->created_at->format('Y-m-d');
                        $showDateDivider = $lastDate !== $messageDate;
                        $lastDate = $messageDate;
                    @endphp
                    
                    @if($showDateDivider)
                        <div class="date-divider">
                            <span>
                                @if($message->created_at->isToday())
                                    Hari Ini
                                @elseif($message->created_at->isYesterday())
                                    Kemarin
                                @else
                                    {{ $message->created_at->format('d M Y') }}
                                @endif
                            </span>
                        </div>
                    @endif
                    
                    <div class="message {{ $message->sender_id == auth()->id() ? 'sent' : 'received' }}" data-id="{{ $message->id }}">
                        @if($message->attachment)
                            <div class="message-attachment">
                                @if($message->attachment_type == 'image')
                                    <img src="{{ asset('storage/' . $message->attachment) }}" alt="Gambar" onclick="openImageModal(this.src)">
                                @else
                                    <a href="{{ asset('storage/' . $message->attachment) }}" target="_blank" class="file-attachment" download>
                                        <div class="file-icon">
                                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                                <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                                                <polyline points="14 2 14 8 20 8"></polyline>
                                            </svg>
                                        </div>
                                        <div class="file-info">
                                            <div class="file-name">{{ $message->attachment_name ?? 'File' }}</div>
                                            <div class="file-size">Ketuk untuk download</div>
                                        </div>
                                    </a>
                                @endif
                            </div>
                        @endif
                        @if($message->message)
                            <div class="message-content">{!! nl2br(e($message->message)) !!}</div>
                        @endif
                        <div class="message-time">
                            {{ $message->created_at->format('H:i') }}
                            @if($message->sender_id == auth()->id())
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="{{ $message->is_read ? 'read-check' : '' }}">
                                    <polyline points="20 6 9 17 4 12"></polyline>
                                </svg>
                            @endif
                        </div>
                    </div>
                @endforeach
            @else
                <div class="empty-chat">
                    <div class="empty-chat-icon">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"></path>
                        </svg>
                    </div>
                    <h3>Mulai Percakapan</h3>
                    <p>Kirim pesan untuk bertanya tentang produk atau jasa.<br>Penjual dapat mengirim file, gambar, atau link.</p>
                </div>
            @endif
        </div>

        <!-- Input Area -->
        <form id="chatForm" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="receiver_id" value="{{ $seller->id }}">
            <input type="file" name="attachment" id="attachmentInput" class="hidden-input" accept="image/*,.pdf,.doc,.docx,.zip,.rar">
            
            <div class="input-area">
                <button type="button" class="attach-btn" onclick="document.getElementById('attachmentInput').click()">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M21.44 11.05l-9.19 9.19a6 6 0 0 1-8.49-8.49l9.19-9.19a4 4 0 0 1 5.66 5.66l-9.2 9.19a2 2 0 0 1-2.83-2.83l8.49-8.48"></path>
                    </svg>
                </button>
                <div class="input-wrapper">
                    <textarea name="message" class="chat-input" id="chatInput" placeholder="Ketik pesan..." rows="1"></textarea>
                </div>
                <button type="submit" class="send-btn" id="sendBtn">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <line x1="22" y1="2" x2="11" y2="13"></line>
                        <polygon points="22 2 15 22 11 13 2 9 22 2"></polygon>
                    </svg>
                </button>
            </div>
        </form>
    </div>

    <!-- Image Modal -->
    <div class="image-modal" id="imageModal" onclick="closeImageModal()">
        <button class="image-modal-close">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <line x1="18" y1="6" x2="6" y2="18"></line>
                <line x1="6" y1="6" x2="18" y2="18"></line>
            </svg>
        </button>
        <img src="" alt="" id="modalImage">
    </div>

    <script>
        const messagesArea = document.getElementById('messagesArea');
        const chatForm = document.getElementById('chatForm');
        const chatInput = document.getElementById('chatInput');
        const attachmentInput = document.getElementById('attachmentInput');
        const filePreview = document.getElementById('filePreview');
        const previewImage = document.getElementById('previewImage');
        const previewFileIcon = document.getElementById('previewFileIcon');
        const previewName = document.getElementById('previewName');
        const previewSize = document.getElementById('previewSize');
        const sendBtn = document.getElementById('sendBtn');
        
        let lastMessageId = {{ $messages->last() ? $messages->last()->id : 0 }};
        let selectedFile = null;

        // Scroll to bottom
        function scrollToBottom() {
            messagesArea.scrollTop = messagesArea.scrollHeight;
        }
        scrollToBottom();

        // Auto-resize textarea
        chatInput.addEventListener('input', function() {
            this.style.height = 'auto';
            this.style.height = Math.min(this.scrollHeight, 100) + 'px';
        });

        // File selection
        attachmentInput.addEventListener('change', function() {
            if (this.files && this.files[0]) {
                selectedFile = this.files[0];
                previewName.textContent = selectedFile.name;
                previewSize.textContent = formatFileSize(selectedFile.size);
                
                if (selectedFile.type.startsWith('image/')) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        previewImage.src = e.target.result;
                        previewImage.style.display = 'block';
                        previewFileIcon.style.display = 'none';
                    };
                    reader.readAsDataURL(selectedFile);
                } else {
                    previewImage.style.display = 'none';
                    previewFileIcon.style.display = 'flex';
                }
                
                filePreview.classList.add('show');
            }
        });

        function removeFile() {
            selectedFile = null;
            attachmentInput.value = '';
            filePreview.classList.remove('show');
        }

        function formatFileSize(bytes) {
            if (bytes === 0) return '0 Bytes';
            const k = 1024;
            const sizes = ['Bytes', 'KB', 'MB', 'GB'];
            const i = Math.floor(Math.log(bytes) / Math.log(k));
            return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + ' ' + sizes[i];
        }

        // Send message
        chatForm.addEventListener('submit', async function(e) {
            e.preventDefault();
            
            const message = chatInput.value.trim();
            if (!message && !selectedFile) {
                alert('Silakan ketik pesan atau pilih file.');
                return;
            }
            
            // Disable send button and show loading state
            sendBtn.disabled = true;
            const originalBtnHTML = sendBtn.innerHTML;
            sendBtn.innerHTML = '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="animation: spin 1s linear infinite;"><circle cx="12" cy="12" r="10"></circle></svg>';
            
            const formData = new FormData();
            formData.append('_token', '{{ csrf_token() }}');
            formData.append('receiver_id', '{{ $seller->id }}');
            
            if (message) {
                formData.append('message', message);
            }
            
            if (selectedFile) {
                formData.append('attachment', selectedFile);
            }
            
            try {
                const response = await fetch('{{ route("messages.store") }}', {
                    method: 'POST',
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: formData
                });
                
                // Check if response is ok
                if (!response.ok) {
                    // Try to parse error response
                    let errorMessage = 'Gagal mengirim pesan. Silakan coba lagi.';
                    try {
                        const errorData = await response.json();
                        if (errorData.message) {
                            errorMessage = errorData.message;
                        } else if (errorData.errors) {
                            // Format validation errors
                            const errors = Object.values(errorData.errors).flat();
                            errorMessage = errors.join('\n');
                        }
                    } catch (parseError) {
                        console.error('Error parsing error response:', parseError);
                    }
                    throw new Error(errorMessage);
                }
                
                const data = await response.json();
                
                if (data.success) {
                    // Add message to UI
                    addMessageToUI(data.message, true);
                    lastMessageId = data.message.id;
                    
                    // Clear input
                    chatInput.value = '';
                    chatInput.style.height = 'auto';
                    removeFile();
                    
                    // Remove empty chat if exists
                    const emptyChat = messagesArea.querySelector('.empty-chat');
                    if (emptyChat) emptyChat.remove();
                } else {
                    // Handle unsuccessful response
                    throw new Error(data.message || 'Gagal mengirim pesan.');
                }
            } catch (error) {
                console.error('Error sending message:', error);
                alert(error.message || 'Gagal mengirim pesan. Silakan coba lagi.');
            } finally {
                // Re-enable send button and restore original state
                sendBtn.disabled = false;
                sendBtn.innerHTML = originalBtnHTML;
            }
        });

        // Add message to UI
        function addMessageToUI(message, isSent) {
            const div = document.createElement('div');
            div.className = `message ${isSent ? 'sent' : 'received'}`;
            div.dataset.id = message.id;
            
            let html = '';
            
            if (message.attachment) {
                html += '<div class="message-attachment">';
                if (message.attachment_type === 'image') {
                    html += `<img src="/storage/${message.attachment}" alt="Gambar" onclick="openImageModal(this.src)">`;
                } else {
                    html += `
                        <a href="/storage/${message.attachment}" target="_blank" class="file-attachment" download>
                            <div class="file-icon">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                                    <polyline points="14 2 14 8 20 8"></polyline>
                                </svg>
                            </div>
                            <div class="file-info">
                                <div class="file-name">${message.attachment_name || 'File'}</div>
                                <div class="file-size">Ketuk untuk download</div>
                            </div>
                        </a>
                    `;
                }
                html += '</div>';
            }
            
            if (message.message) {
                html += `<div class="message-content">${message.message.replace(/\n/g, '<br>')}</div>`;
            }
            
            const time = new Date(message.created_at);
            html += `<div class="message-time">${time.getHours().toString().padStart(2, '0')}:${time.getMinutes().toString().padStart(2, '0')}`;
            if (isSent) {
                html += `<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="20 6 9 17 4 12"></polyline></svg>`;
            }
            html += '</div>';
            
            div.innerHTML = html;
            messagesArea.appendChild(div);
            scrollToBottom();
        }

        // Poll for new messages
        async function fetchNewMessages() {
            try {
                const response = await fetch(`/messages/{{ $seller->id }}/fetch?last_id=${lastMessageId}`);
                const data = await response.json();
                
                if (data.messages && data.messages.length > 0) {
                    data.messages.forEach(message => {
                        if (!document.querySelector(`.message[data-id="${message.id}"]`)) {
                            addMessageToUI(message, message.sender_id == {{ auth()->id() }});
                            lastMessageId = Math.max(lastMessageId, message.id);
                        }
                    });
                }
            } catch (error) {
                console.error('Error fetching messages:', error);
            }
        }

        // Poll every 3 seconds
        setInterval(fetchNewMessages, 3000);

        // Image modal
        function openImageModal(src) {
            document.getElementById('modalImage').src = src;
            document.getElementById('imageModal').classList.add('show');
        }

        function closeImageModal() {
            document.getElementById('imageModal').classList.remove('show');
        }
    </script>
</body>
</html>
