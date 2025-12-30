<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Produk Ditolak - Validator MAMA</title>
    <link rel="icon" type="image/png" href="{{ asset('img/logo-mama.png') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    @include('validator.partials.styles')
</head>
<body>
    @include('validator.partials.sidebar', ['active' => 'rejected'])

    <main class="main-content">
        <header class="header">
            <h1 class="header-title">Produk Ditolak</h1>
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
            @if(session('success'))
                <div class="alert alert-success">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M9 12l2 2 4-4"/>
                        <circle cx="12" cy="12" r="10"/>
                    </svg>
                    {{ session('success') }}
                </div>
            @endif

            <div class="section">
                <div class="section-header">
                    <h2 class="section-title">Daftar Produk ({{ $products->total() }} produk)</h2>
                </div>

                @if($products->count() > 0)
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Produk</th>
                                <th>Penjual</th>
                                <th>Harga</th>
                                <th>Alasan Penolakan</th>
                                <th>Tanggal</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($products as $product)
                                <tr>
                                    <td>
                                        <div class="product-cell">
                                            @php
                                                $img = ($product->images && is_array($product->images) && count($product->images) > 0)
                                                    ? asset('storage/' . $product->images[0])
                                                    : null;
                                            @endphp
                                            @if($img)
                                                <img src="{{ $img }}" alt="" class="product-image">
                                            @else
                                                <div class="product-image" style="display:flex;align-items:center;justify-content:center;color:#999;">
                                                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                                                        <rect x="3" y="3" width="18" height="18" rx="2"/>
                                                        <circle cx="8.5" cy="8.5" r="1.5"/>
                                                        <path d="M21 15l-5-5L5 21"/>
                                                    </svg>
                                                </div>
                                            @endif
                                            <div>
                                                <div class="product-name">{{ Str::limit($product->name, 35) }}</div>
                                                <div class="product-category">{{ $product->category->name ?? '-' }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="seller-cell">
                                            <div class="seller-avatar">{{ strtoupper(substr($product->seller->name ?? 'U', 0, 1)) }}</div>
                                            <span>{{ $product->seller->name ?? 'Unknown' }}</span>
                                        </div>
                                    </td>
                                    <td>Rp{{ number_format($product->price, 0, ',', '.') }}</td>
                                    <td>
                                        <span class="rejection-reason">{{ $product->rejection_reason ?? 'Tidak ada keterangan' }}</span>
                                    </td>
                                    <td>{{ $product->updated_at->format('d M Y') }}</td>
                                    <td>
                                        <a href="{{ route('validator.products.show', $product) }}" class="action-btn view" title="Lihat Detail">
                                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                                <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/>
                                                <circle cx="12" cy="12" r="3"/>
                                            </svg>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                    <div class="pagination-wrapper">
                        {{ $products->links() }}
                    </div>
                @else
                    <div class="empty-state">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                            <circle cx="12" cy="12" r="10"/>
                            <line x1="15" y1="9" x2="9" y2="15"/>
                            <line x1="9" y1="9" x2="15" y2="15"/>
                        </svg>
                        <h3>Tidak Ada Produk Ditolak</h3>
                        <p>Belum ada produk yang ditolak.</p>
                    </div>
                @endif
            </div>
        </div>
    </main>
</body>
</html>
