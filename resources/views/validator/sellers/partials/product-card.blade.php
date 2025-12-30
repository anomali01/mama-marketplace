<div class="product-card">
    <div class="product-card-image">
        @php
            $img = ($product->images && is_array($product->images) && count($product->images) > 0)
                ? asset('storage/' . $product->images[0])
                : null;
        @endphp
        @if($img)
            <img src="{{ $img }}" alt="{{ $product->name }}">
        @else
            <svg width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="#ccc" stroke-width="1">
                <rect x="3" y="3" width="18" height="18" rx="2"/>
                <circle cx="8.5" cy="8.5" r="1.5"/>
                <path d="M21 15l-5-5L5 21"/>
            </svg>
        @endif
    </div>
    <div class="product-card-body">
        <div class="product-card-name">{{ $product->name }}</div>
        <div class="product-card-price">Rp{{ number_format($product->price, 0, ',', '.') }}</div>
        @if($product->status === 'pending_verif')
            <span class="product-card-status pending">
                <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <circle cx="12" cy="12" r="10"/>
                    <path d="M12 6v6l4 2"/>
                </svg>
                Pending
            </span>
        @elseif($product->status === 'verified')
            <span class="product-card-status verified">
                <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M9 12l2 2 4-4"/>
                    <circle cx="12" cy="12" r="10"/>
                </svg>
                Terverifikasi
            </span>
        @elseif($product->status === 'rejected')
            <span class="product-card-status rejected">
                <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <circle cx="12" cy="12" r="10"/>
                    <line x1="15" y1="9" x2="9" y2="15"/>
                    <line x1="9" y1="9" x2="15" y2="15"/>
                </svg>
                Ditolak
            </span>
        @endif
    </div>
    <div class="product-card-footer">
        <a href="{{ route('validator.products.show', $product) }}" class="product-card-link">Lihat Detail</a>
    </div>
</div>
