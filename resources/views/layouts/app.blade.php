<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Favicon -->
        <link rel="icon" type="image/png" href="{{ asset('img/logo-mama.png') }}">

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen bg-gray-100">
            @include('layouts.navigation')

            <!-- Page Heading -->
            @isset($header)
                <header class="bg-white shadow">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endisset

            <!-- Page Content -->
            <main>
                {{ $slot }}
            </main>
        </div>
        
        @auth
        <script>
            // Notification polling for desktop
            function updateDesktopNotificationBadge() {
                fetch('{{ route("notifications.unread-count") }}')
                    .then(response => response.json())
                    .then(data => {
                        const badge = document.getElementById('desktop-notification-badge');
                        if (badge) {
                            if (data.count > 0) {
                                badge.textContent = data.count > 99 ? '99+' : data.count;
                                badge.classList.remove('hidden');
                                badge.classList.add('flex');
                            } else {
                                badge.classList.add('hidden');
                                badge.classList.remove('flex');
                            }
                        }
                    })
                    .catch(error => console.error('Error fetching notifications:', error));
            }

            // Initial load
            document.addEventListener('DOMContentLoaded', function() {
                updateDesktopNotificationBadge();
                // Poll every 30 seconds
                setInterval(updateDesktopNotificationBadge, 30000);
            });
        </script>
        @endauth
    </body>
</html>
