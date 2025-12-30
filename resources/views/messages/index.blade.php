<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1, user-scalable=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Pesan - MAMA Marketplace</title>
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

        /* Header */
        .header {
            background: linear-gradient(135deg, #1a9fff 0%, #0080e0 100%);
            padding: 16px;
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

        .header-title {
            color: white;
            font-size: 18px;
            font-weight: 600;
        }

        /* Main Content */
        .main-content {
            padding: 16px;
        }

        /* Chat List */
        .chat-list {
            display: flex;
            flex-direction: column;
            gap: 12px;
        }

        .chat-item {
            background: white;
            border-radius: 16px;
            padding: 16px;
            display: flex;
            align-items: center;
            gap: 14px;
            text-decoration: none;
            color: inherit;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.06);
            transition: transform 0.2s, box-shadow 0.2s;
        }

        .chat-item:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }

        .chat-avatar {
            width: 56px;
            height: 56px;
            background: linear-gradient(135deg, #1a9fff 0%, #0080e0 100%);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
            font-weight: 700;
            color: white;
            flex-shrink: 0;
        }

        .chat-info {
            flex: 1;
            min-width: 0;
        }

        .chat-name {
            font-size: 15px;
            font-weight: 600;
            color: #333;
            margin-bottom: 4px;
        }

        .chat-preview {
            font-size: 13px;
            color: #666;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .chat-meta {
            display: flex;
            flex-direction: column;
            align-items: flex-end;
            gap: 6px;
        }

        .chat-time {
            font-size: 11px;
            color: #999;
        }

        .chat-badge {
            background: #ff6a00;
            color: white;
            font-size: 11px;
            font-weight: 600;
            min-width: 20px;
            height: 20px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 0 6px;
        }

        .chat-arrow {
            color: #ccc;
        }

        .chat-arrow svg {
            width: 20px;
            height: 20px;
        }

        /* Empty State */
        .empty-state {
            text-align: center;
            padding: 60px 20px;
            color: #999;
        }

        .empty-state svg {
            width: 80px;
            height: 80px;
            margin-bottom: 16px;
            opacity: 0.5;
        }

        .empty-state h3 {
            font-size: 16px;
            font-weight: 600;
            color: #666;
            margin-bottom: 8px;
        }

        .empty-state p {
            font-size: 14px;
            line-height: 1.5;
        }

        .btn-explore {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: linear-gradient(135deg, #1a9fff 0%, #0080e0 100%);
            color: white;
            padding: 12px 24px;
            border-radius: 25px;
            font-size: 14px;
            font-weight: 600;
            text-decoration: none;
            margin-top: 20px;
            transition: transform 0.2s, box-shadow 0.2s;
        }

        .btn-explore:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 15px rgba(26, 159, 255, 0.4);
        }

        /* Seller Badge */
        .seller-badge {
            display: inline-flex;
            align-items: center;
            gap: 4px;
            background: #e8f5e9;
            color: #2e7d32;
            font-size: 11px;
            padding: 4px 8px;
            border-radius: 12px;
            margin-top: 4px;
        }

        .seller-badge svg {
            width: 12px;
            height: 12px;
        }

        /* Bottom Navigation */
        .bottom-nav {
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
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
                max-width: 600px;
                margin: 0 auto;
            }
        }

        @media (min-width: 900px) {
            .main-content {
                max-width: 700px;
            }
            
            .bottom-nav {
                width: 100%;
                left: 0;
                right: 0;
                transform: none;
                border-radius: 0;
            }
        }

        @supports (padding-bottom: env(safe-area-inset-bottom)) {
            body {
                padding-bottom: calc(80px + env(safe-area-inset-bottom));
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
        <div class="header-content">
            <a href="{{ route('home') }}" class="back-btn">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M19 12H5M12 19l-7-7 7-7"/>
                </svg>
            </a>
            <h1 class="header-title">Pesan</h1>
        </div>
    </header>

    <!-- Main Content -->
    <main class="main-content">
        @if(Auth::user()->role === 'validator' && isset($availableSellers) && $availableSellers->count() > 0)
            <div class="section-title" style="font-size: 14px; font-weight: 600; color: #666; margin-bottom: 12px; display: flex; align-items: center; gap: 8px;">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#ff6a00" stroke-width="2">
                    <path d="M12 2L2 7l10 5 10-5-10-5z"></path>
                    <path d="M2 17l10 5 10-5"></path>
                    <path d="M2 12l10 5 10-5"></path>
                </svg>
                Penjual yang Belum Di-chat (Validator)
            </div>
            <div class="chat-list" style="margin-bottom: 24px;">
                @foreach($availableSellers as $seller)
                    <a href="{{ route('messages.show', $seller->id) }}" class="chat-item" style="border-left: 3px solid #ff6a00;">
                        <div class="chat-avatar" style="background: linear-gradient(135deg, #ff6a00 0%, #ff9500 100%);">
                            {{ strtoupper(substr($seller->name, 0, 1)) }}
                        </div>
                        <div class="chat-info">
                            <div class="chat-name">{{ $seller->name }}</div>
                            <div class="chat-preview">Ketuk untuk memulai chat</div>
                            <div class="seller-badge">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>
                                    <polyline points="9 22 9 12 15 12 15 22"></polyline>
                                </svg>
                                Penjual - {{ $seller->products_count ?? $seller->products->count() }} Produk
                            </div>
                        </div>
                        <div class="chat-arrow">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M9 18l6-6-6-6"/>
                            </svg>
                        </div>
                    </a>
                @endforeach
            </div>
        @endif

        @if($chatUsers->count() > 0)
            @if(Auth::user()->role === 'validator' && isset($availableSellers) && $availableSellers->count() > 0)
                <div class="section-title" style="font-size: 14px; font-weight: 600; color: #666; margin-bottom: 12px;">
                    Chat Terbaru
                </div>
            @endif
            <div class="chat-list">
                @foreach($chatUsers as $chatUser)
                    <a href="{{ route('messages.show', $chatUser->id) }}" class="chat-item">
                        <div class="chat-avatar">
                            {{ strtoupper(substr($chatUser->name, 0, 1)) }}
                        </div>
                        <div class="chat-info">
                            <div class="chat-name">{{ $chatUser->name }}</div>
                            <div class="chat-preview">
                                @if($chatUser->last_message)
                                    @if($chatUser->last_message->attachment)
                                        📎 {{ $chatUser->last_message->attachment_type == 'image' ? 'Foto' : 'File' }}
                                    @else
                                        {{ Str::limit($chatUser->last_message->message, 40) }}
                                    @endif
                                @else
                                    Ketuk untuk memulai chat
                                @endif
                            </div>
                            <div class="seller-badge">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>
                                    <polyline points="9 22 9 12 15 12 15 22"></polyline>
                                </svg>
                                {{ $chatUser->role == 'mahasiswa' ? 'Penjual' : ucfirst($chatUser->role) }}
                            </div>
                        </div>
                        <div class="chat-meta">
                            @if($chatUser->last_message)
                                <div class="chat-time">{{ $chatUser->last_message->created_at->diffForHumans() }}</div>
                            @endif
                            @if($chatUser->unread_count > 0)
                                <div class="chat-badge">{{ $chatUser->unread_count }}</div>
                            @endif
                        </div>
                        <div class="chat-arrow">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M9 18l6-6-6-6"/>
                            </svg>
                        </div>
                    </a>
                @endforeach
            </div>
        @else
            <div class="empty-state">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                    <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"></path>
                </svg>
                <h3>Belum Ada Pesan</h3>
                <p>Anda belum pernah berbelanja.<br>Mulai belanja untuk chat dengan penjual!</p>
                <a href="{{ route('home') }}" class="btn-explore">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <circle cx="11" cy="11" r="8"></circle>
                        <path d="m21 21-4.35-4.35"></path>
                    </svg>
                    Jelajahi Produk
                </a>
            </div>
        @endif
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
        <a href="{{ route('profile.edit') }}" class="nav-item">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                <circle cx="12" cy="7" r="4"></circle>
            </svg>
            <span>Profil</span>
        </a>
    </nav>
</body>
</html>
