<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Validator') - MAMA Marketplace</title>
    <link rel="icon" type="image/png" href="{{ asset('img/logo-mama.png') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
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
            background: #f5f7fa;
            min-height: 100vh;
        }

        /* Sidebar Styles */
        .sidebar {
            position: fixed;
            left: 0;
            top: 0;
            width: 260px;
            height: 100vh;
            background: linear-gradient(180deg, #1e3a5f 0%, #0d2137 100%);
            padding: 20px 0;
            z-index: 100;
            overflow-y: auto;
        }

        .sidebar-logo {
            display: flex;
            align-items: center;
            gap: 12px;
            color: white;
            text-decoration: none;
            padding: 0 20px 20px;
            border-bottom: 1px solid rgba(255,255,255,0.1);
            margin-bottom: 20px;
        }

        .sidebar-logo-icon {
            width: 45px;
            height: 45px;
            background: linear-gradient(135deg, #ff6a00, #ff8533);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .sidebar-logo-text {
            font-size: 18px;
            font-weight: 700;
        }

        .sidebar-section {
            margin-bottom: 24px;
        }

        .sidebar-section-title {
            color: rgba(255,255,255,0.4);
            font-size: 11px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 1px;
            padding: 0 20px 8px;
        }

        .sidebar-nav {
            list-style: none;
            padding: 0 12px;
        }

        .sidebar-nav-item {
            margin-bottom: 4px;
        }

        .sidebar-nav-link {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px 16px;
            color: rgba(255,255,255,0.7);
            text-decoration: none;
            border-radius: 10px;
            transition: all 0.2s;
            font-size: 14px;
        }

        .sidebar-nav-link:hover {
            background: rgba(255,255,255,0.1);
            color: white;
        }

        .sidebar-nav-link.active {
            background: linear-gradient(135deg, #ff6a00, #ff8533);
            color: white;
            font-weight: 500;
        }

        .sidebar-nav-link svg {
            width: 20px;
            height: 20px;
            flex-shrink: 0;
        }

        .sidebar-nav-badge {
            margin-left: auto;
            background: #ff6a00;
            color: white;
            font-size: 11px;
            font-weight: 600;
            padding: 2px 8px;
            border-radius: 10px;
        }

        .sidebar-nav-link.active .sidebar-nav-badge {
            background: white;
            color: #ff6a00;
        }

        .sidebar-footer {
            margin-top: auto;
            padding-top: 20px;
            border-top: 1px solid rgba(255,255,255,0.1);
        }

        /* Main Layout */
        .main-layout {
            margin-left: 260px;
            min-height: 100vh;
            padding: 30px;
        }

        /* Page Header */
        .page-header {
            margin-bottom: 30px;
        }

        .page-title {
            font-size: 28px;
            font-weight: 700;
            color: #111827;
            margin-bottom: 8px;
        }

        .page-subtitle {
            font-size: 15px;
            color: #6b7280;
        }

        /* Card */
        .card {
            background: white;
            border-radius: 12px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
            margin-bottom: 24px;
        }

        /* Buttons */
        .btn {
            padding: 10px 20px;
            border-radius: 8px;
            font-weight: 500;
            text-decoration: none;
            display: inline-block;
            transition: all 0.3s;
            cursor: pointer;
            border: none;
        }

        .btn-primary {
            background: linear-gradient(135deg, #3b82f6, #2563eb);
            color: white;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(59, 130, 246, 0.4);
        }

        .btn-sm {
            padding: 6px 12px;
            font-size: 13px;
        }
    </style>
    @stack('styles')
</head>
<body>
    @include('validator.partials.sidebar', ['active' => $active ?? 'dashboard'])

    <div class="main-layout">
        @yield('content')
    </div>

    @stack('scripts')
</body>
</html>
