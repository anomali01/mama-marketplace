<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1, user-scalable=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Notifikasi - MAMA Marketplace</title>
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
            padding-bottom: 70px;
        }

        /* Header */
        .header {
            background: linear-gradient(135deg, #ff6a00 0%, #ff8533 100%);
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

        .header-title {
            color: white;
            font-size: 18px;
            font-weight: 600;
            flex: 1;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .header-actions {
            display: flex;
            gap: 8px;
        }

        .header-btn {
            background: rgba(255, 255, 255, 0.2);
            border: none;
            color: white;
            padding: 8px 12px;
            border-radius: 20px;
            font-size: 12px;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 4px;
            transition: background 0.2s;
        }

        .header-btn:hover {
            background: rgba(255, 255, 255, 0.3);
        }

        /* Tab Navigation */
        .tab-nav {
            background: white;
            display: flex;
            overflow-x: auto;
            border-bottom: 1px solid #eee;
            position: sticky;
            top: 72px;
            z-index: 99;
            -webkit-overflow-scrolling: touch;
        }

        .tab-nav::-webkit-scrollbar {
            display: none;
        }

        .tab-item {
            flex: 1;
            min-width: max-content;
            padding: 14px 20px;
            text-align: center;
            text-decoration: none;
            color: #666;
            font-size: 13px;
            font-weight: 500;
            border-bottom: 3px solid transparent;
            transition: all 0.2s;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
            white-space: nowrap;
        }

        .tab-item:hover {
            color: #ff6a00;
            background: #fff5f0;
        }

        .tab-item.active {
            color: #ff6a00;
            border-bottom-color: #ff6a00;
        }

        .tab-badge {
            background: #ff3b30;
            color: white;
            font-size: 10px;
            padding: 2px 6px;
            border-radius: 10px;
            font-weight: 600;
        }

        /* Main Content */
        .main-content {
            padding: 12px;
        }

        /* Notification Card */
        .notification-card {
            background: white;
            border-radius: 12px;
            padding: 14px;
            margin-bottom: 10px;
            display: flex;
            gap: 12px;
            text-decoration: none;
            color: inherit;
            transition: all 0.2s;
            position: relative;
            box-shadow: 0 1px 3px rgba(0,0,0,0.06);
        }

        .notification-card:hover {
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
            transform: translateY(-1px);
        }

        .notification-card.unread {
            background: linear-gradient(135deg, #fff5f0 0%, #ffffff 100%);
            border-left: 3px solid #ff6a00;
        }

        .notification-icon {
            width: 48px;
            height: 48px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
            flex-shrink: 0;
        }

        .notification-icon.chat { background: #e3f2fd; }
        .notification-icon.order { background: #fff3e0; }
        .notification-icon.promo { background: #fce4ec; }
        .notification-icon.system { background: #e8f5e9; }
        .notification-icon.product { background: #f3e5f5; }

        .notification-image {
            width: 48px;
            height: 48px;
            border-radius: 8px;
            object-fit: cover;
            flex-shrink: 0;
        }

        .notification-content {
            flex: 1;
            min-width: 0;
        }

        .notification-title {
            font-size: 14px;
            font-weight: 600;
            color: #333;
            margin-bottom: 4px;
            display: -webkit-box;
            -webkit-line-clamp: 1;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        .notification-message {
            font-size: 13px;
            color: #666;
            line-height: 1.4;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        .notification-time {
            font-size: 11px;
            color: #999;
            margin-top: 6px;
            display: flex;
            align-items: center;
            gap: 4px;
        }

        .unread-dot {
            width: 8px;
            height: 8px;
            background: #ff6a00;
            border-radius: 50%;
            position: absolute;
            top: 14px;
            right: 14px;
        }

        .notification-delete {
            position: absolute;
            top: 50%;
            right: 10px;
            transform: translateY(-50%);
            width: 32px;
            height: 32px;
            border: none;
            background: transparent;
            color: #999;
            cursor: pointer;
            border-radius: 50%;
            display: none;
            align-items: center;
            justify-content: center;
            transition: all 0.2s;
        }

        .notification-card:hover .notification-delete {
            display: flex;
        }

        .notification-delete:hover {
            background: #ffebee;
            color: #f44336;
        }

        /* Empty State */
        .empty-state {
            text-align: center;
            padding: 60px 20px;
        }

        .empty-state svg {
            width: 80px;
            height: 80px;
            color: #ddd;
            margin-bottom: 16px;
        }

        .empty-state h3 {
            font-size: 16px;
            font-weight: 600;
            color: #333;
            margin-bottom: 8px;
        }

        .empty-state p {
            font-size: 14px;
            color: #666;
        }

        /* Notification Group */
        .notification-group {
            margin-bottom: 20px;
        }

        .notification-group-header {
            font-size: 12px;
            font-weight: 600;
            color: #999;
            padding: 8px 4px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        /* Pagination */
        .pagination-wrapper {
            display: flex;
            justify-content: center;
            padding: 20px;
        }

        .pagination {
            display: flex;
            gap: 8px;
        }

        .pagination a, .pagination span {
            padding: 8px 14px;
            background: white;
            border-radius: 8px;
            text-decoration: none;
            color: #666;
            font-size: 13px;
            transition: all 0.2s;
        }

        .pagination a:hover {
            background: #ff6a00;
            color: white;
        }

        .pagination .active span {
            background: #ff6a00;
            color: white;
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
            position: relative;
        }

        .nav-item svg {
            width: 24px;
            height: 24px;
            margin-bottom: 4px;
        }

        .nav-item.active {
            color: #ff6a00;
        }

        .nav-badge {
            position: absolute;
            top: 0;
            right: 4px;
            background: #ff3b30;
            color: white;
            font-size: 10px;
            padding: 2px 5px;
            border-radius: 10px;
            font-weight: 600;
            min-width: 16px;
            text-align: center;
        }

        /* Responsive */
        @media (min-width: 600px) {
            .main-content {
                max-width: 600px;
                margin: 0 auto;
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
    </style>
</head>
<body>
    <!-- Header -->
    <header class="header">
        <div class="header-content">
            <a href="{{ route('home') }}" class="back-btn">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M19 12H5M12 19l-7-7 7-7"/>
                </svg>
            </a>
            <h1 class="header-title">
                🔔 Notifikasi
            </h1>
            <div class="header-actions">
                @if($unreadCounts['all'] > 0)
                <form action="{{ route('notifications.mark-all-read') }}" method="POST" style="display: inline;">
                    @csrf
                    <input type="hidden" name="type" value="{{ $type }}">
                    <button type="submit" class="header-btn">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <polyline points="20 6 9 17 4 12"></polyline>
                        </svg>
                        Tandai Dibaca
                    </button>
                </form>
                @endif
            </div>
        </div>
    </header>

    <!-- Tab Navigation -->
    <nav class="tab-nav">
        <a href="{{ route('notifications.index', ['type' => 'all']) }}" class="tab-item {{ $type === 'all' ? 'active' : '' }}">
            🔔 Semua
            @if($unreadCounts['all'] > 0)
                <span class="tab-badge">{{ $unreadCounts['all'] }}</span>
            @endif
        </a>
        <a href="{{ route('notifications.index', ['type' => 'chat']) }}" class="tab-item {{ $type === 'chat' ? 'active' : '' }}">
            💬 Chat
            @if($unreadCounts['chat'] > 0)
                <span class="tab-badge">{{ $unreadCounts['chat'] }}</span>
            @endif
        </a>
        <a href="{{ route('notifications.index', ['type' => 'order']) }}" class="tab-item {{ $type === 'order' ? 'active' : '' }}">
            🛒 Pesanan
            @if($unreadCounts['order'] > 0)
                <span class="tab-badge">{{ $unreadCounts['order'] }}</span>
            @endif
        </a>
        <a href="{{ route('notifications.index', ['type' => 'promo']) }}" class="tab-item {{ $type === 'promo' ? 'active' : '' }}">
            🎉 Promo
            @if($unreadCounts['promo'] > 0)
                <span class="tab-badge">{{ $unreadCounts['promo'] }}</span>
            @endif
        </a>
        <a href="{{ route('notifications.index', ['type' => 'system']) }}" class="tab-item {{ $type === 'system' ? 'active' : '' }}">
            ⚙️ Sistem
            @if($unreadCounts['system'] > 0)
                <span class="tab-badge">{{ $unreadCounts['system'] }}</span>
            @endif
        </a>
    </nav>

    <!-- Main Content -->
    <main class="main-content">
        @if($notifications->count() > 0)
            @php
                $groupedNotifications = $notifications->groupBy(function($item) {
                    if ($item->created_at->isToday()) return 'Hari Ini';
                    if ($item->created_at->isYesterday()) return 'Kemarin';
                    if ($item->created_at->isCurrentWeek()) return 'Minggu Ini';
                    if ($item->created_at->isCurrentMonth()) return 'Bulan Ini';
                    return $item->created_at->format('F Y');
                });
            @endphp

            @foreach($groupedNotifications as $group => $items)
                <div class="notification-group">
                    <div class="notification-group-header">{{ $group }}</div>
                    @foreach($items as $notification)
                        <a href="{{ $notification->action_url ?? '#' }}" 
                           class="notification-card {{ !$notification->is_read ? 'unread' : '' }}"
                           data-id="{{ $notification->id }}"
                           onclick="markAsRead({{ $notification->id }})">
                            
                            @if($notification->image)
                                <img src="{{ asset('storage/' . $notification->image) }}" alt="" class="notification-image">
                            @else
                                <div class="notification-icon {{ $notification->type }}">
                                    {{ $notification->icon }}
                                </div>
                            @endif
                            
                            <div class="notification-content">
                                <div class="notification-title">{{ $notification->title }}</div>
                                <div class="notification-message">{{ $notification->message }}</div>
                                <div class="notification-time">
                                    <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <circle cx="12" cy="12" r="10"></circle>
                                        <polyline points="12 6 12 12 16 14"></polyline>
                                    </svg>
                                    {{ $notification->created_at->diffForHumans() }}
                                </div>
                            </div>
                            
                            @if(!$notification->is_read)
                                <div class="unread-dot"></div>
                            @endif
                            
                            <button type="button" class="notification-delete" onclick="deleteNotification(event, {{ $notification->id }})" title="Hapus">
                                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <polyline points="3 6 5 6 21 6"></polyline>
                                    <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
                                </svg>
                            </button>
                        </a>
                    @endforeach
                </div>
            @endforeach

            <!-- Pagination -->
            @if($notifications->hasPages())
                <div class="pagination-wrapper">
                    {{ $notifications->appends(['type' => $type])->links() }}
                </div>
            @endif
        @else
            <div class="empty-state">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                    <path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"></path>
                    <path d="M13.73 21a2 2 0 0 1-3.46 0"></path>
                </svg>
                <h3>Belum Ada Notifikasi</h3>
                <p>
                    @if($type === 'all')
                        Notifikasi baru akan muncul di sini
                    @elseif($type === 'chat')
                        Belum ada notifikasi chat
                    @elseif($type === 'order')
                        Belum ada notifikasi pesanan
                    @elseif($type === 'promo')
                        Belum ada promo untuk kamu
                    @else
                        Belum ada notifikasi sistem
                    @endif
                </p>
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

    <script>
        function markAsRead(id) {
            fetch(`/notifications/${id}/read`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            });
        }

        function deleteNotification(event, id) {
            event.preventDefault();
            event.stopPropagation();
            
            if (confirm('Hapus notifikasi ini?')) {
                fetch(`/notifications/${id}`, {
                    method: 'DELETE',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    }
                }).then(response => {
                    if (response.ok) {
                        const card = document.querySelector(`.notification-card[data-id="${id}"]`);
                        if (card) {
                            card.style.animation = 'slideOut 0.3s ease forwards';
                            setTimeout(() => card.remove(), 300);
                        }
                    }
                });
            }
        }
    </script>

    <style>
        @keyframes slideOut {
            to {
                opacity: 0;
                transform: translateX(100%);
            }
        }
    </style>
</body>
</html>
