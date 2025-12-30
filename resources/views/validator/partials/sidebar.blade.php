@php
    use App\Models\Product;
    $pendingCount = Product::where('status', 'pending_verif')->count();
@endphp

<aside class="sidebar">
    <div class="sidebar-logo">
        <div class="sidebar-logo-icon">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M9 12l2 2 4-4"/>
                <path d="M12 22c5.523 0 10-4.477 10-10S17.523 2 12 2 2 6.477 2 12s4.477 10 10 10z"/>
            </svg>
        </div>
        <span class="sidebar-logo-text">MAMA<span>Validator</span></span>
    </div>

    <div class="sidebar-section">
        <div class="sidebar-section-title">Menu Utama</div>
        <ul class="sidebar-nav">
            <li class="sidebar-nav-item">
                <a href="{{ route('validator.dashboard') }}" class="sidebar-nav-link {{ $active === 'dashboard' ? 'active' : '' }}">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <rect x="3" y="3" width="7" height="7"/>
                        <rect x="14" y="3" width="7" height="7"/>
                        <rect x="14" y="14" width="7" height="7"/>
                        <rect x="3" y="14" width="7" height="7"/>
                    </svg>
                    Dashboard
                </a>
            </li>
        </ul>
    </div>

    <div class="sidebar-section">
        <div class="sidebar-section-title">Verifikasi Produk</div>
        <ul class="sidebar-nav">
            <li class="sidebar-nav-item">
                <a href="{{ route('validator.products.pending') }}" class="sidebar-nav-link {{ $active === 'pending' ? 'active' : '' }}">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <circle cx="12" cy="12" r="10"/>
                        <path d="M12 6v6l4 2"/>
                    </svg>
                    Menunggu Review
                    @if($pendingCount > 0)
                        <span class="sidebar-nav-badge">{{ $pendingCount }}</span>
                    @endif
                </a>
            </li>
            <li class="sidebar-nav-item">
                <a href="{{ route('validator.products.verified') }}" class="sidebar-nav-link {{ $active === 'verified' ? 'active' : '' }}">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M9 12l2 2 4-4"/>
                        <circle cx="12" cy="12" r="10"/>
                    </svg>
                    Terverifikasi
                </a>
            </li>
            <li class="sidebar-nav-item">
                <a href="{{ route('validator.products.rejected') }}" class="sidebar-nav-link {{ $active === 'rejected' ? 'active' : '' }}">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <circle cx="12" cy="12" r="10"/>
                        <line x1="15" y1="9" x2="9" y2="15"/>
                        <line x1="9" y1="9" x2="15" y2="15"/>
                    </svg>
                    Ditolak
                </a>
            </li>
        </ul>
    </div>

    <div class="sidebar-section">
        <div class="sidebar-section-title">Penjual</div>
        <ul class="sidebar-nav">
            <li class="sidebar-nav-item">
                <a href="{{ route('validator.sellers.index') }}" class="sidebar-nav-link {{ $active === 'sellers' ? 'active' : '' }}">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/>
                        <circle cx="9" cy="7" r="4"/>
                        <path d="M23 21v-2a4 4 0 0 0-3-3.87"/>
                        <path d="M16 3.13a4 4 0 0 1 0 7.75"/>
                    </svg>
                    Daftar Penjual
                </a>
            </li>
        </ul>
    </div>

    <div class="sidebar-footer">
        <ul class="sidebar-nav">
            <li class="sidebar-nav-item">
                <a href="{{ route('home') }}" class="sidebar-nav-link">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/>
                        <polyline points="9 22 9 12 15 12 15 22"/>
                    </svg>
                    Kembali ke Website
                </a>
            </li>
            <li class="sidebar-nav-item">
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="sidebar-nav-link" style="width: 100%; border: none; background: none; cursor: pointer; text-align: left;">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/>
                            <polyline points="16 17 21 12 16 7"/>
                            <line x1="21" y1="12" x2="9" y2="12"/>
                        </svg>
                        Logout
                    </button>
                </form>
            </li>
        </ul>
    </div>
</aside>
