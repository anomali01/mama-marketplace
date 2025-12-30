<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <title>MAMA - Marketplace Mahasiswa</title>
    <link rel="icon" type="image/png" href="{{ asset('img/logo-mama.png') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        html, body {
            height: 100%;
            font-family: 'Poppins', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            overflow: hidden;
        }

        body {
            background: linear-gradient(180deg, #e8f4fd 0%, #f0f7fc 50%, #f8fbfe 100%);
            display: flex;
            flex-direction: column;
            min-height: 100vh;
            position: relative;
        }

        /* Main content area */
        .content {
            flex: 1;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        /* Logo container */
        .logo-container {
            text-align: center;
            margin-bottom: 40px;
            transition: transform 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .logo-container.moved-up {
            transform: translateY(-80px);
        }

        .logo-container img {
            width: 180px;
            max-width: 70%;
            height: auto;
            filter: drop-shadow(0 8px 20px rgba(0, 0, 0, 0.12));
        }

        /* Swipe hint */
        .swipe-hint {
            position: absolute;
            bottom: 100px;
            left: 50%;
            transform: translateX(-50%);
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 8px;
            color: #666;
            font-size: 14px;
            animation: pulse 2s ease-in-out infinite;
            transition: opacity 0.3s ease;
        }

        .swipe-hint.hidden {
            opacity: 0;
            pointer-events: none;
        }

        .swipe-arrow {
            width: 24px;
            height: 24px;
            border-left: 3px solid #666;
            border-top: 3px solid #666;
            transform: rotate(45deg);
            animation: bounce 1s ease-in-out infinite;
        }

        @keyframes bounce {
            0%, 100% { transform: rotate(45deg) translateY(0); }
            50% { transform: rotate(45deg) translateY(-8px); }
        }

        @keyframes pulse {
            0%, 100% { opacity: 1; }
            50% { opacity: 0.6; }
        }

        /* Bottom sheet */
        .bottom-sheet {
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            background: #1096ff;
            border-top-left-radius: 24px;
            border-top-right-radius: 24px;
            padding: 16px 24px 32px;
            box-shadow: 0 -4px 20px rgba(0, 0, 0, 0.15);
            transform: translateY(100%);
            transition: transform 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            z-index: 100;
        }

        .bottom-sheet.show {
            transform: translateY(0);
        }

        /* Handle bar */
        .handle {
            width: 48px;
            height: 5px;
            background: rgba(255, 255, 255, 0.9);
            border-radius: 100px;
            margin: 0 auto 20px;
            cursor: grab;
        }

        /* Buttons container */
        .buttons {
            display: flex;
            flex-direction: column;
            gap: 12px;
            align-items: center;
        }

        /* Sign up button */
        .btn-signup {
            display: block;
            width: 85%;
            max-width: 300px;
            padding: 14px 24px;
            background: #e8e8e8;
            color: #ff6a00;
            font-size: 16px;
            font-weight: 600;
            text-align: center;
            text-decoration: none;
            border-radius: 50px;
            border: 1px solid #ddd;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
            transition: all 0.2s ease;
        }

        .btn-signup:hover {
            background: #f0f0f0;
            transform: translateY(-1px);
        }

        /* Login button */
        .btn-login {
            display: block;
            width: 85%;
            max-width: 300px;
            padding: 14px 24px;
            background: #ff6a00;
            color: #fff;
            font-size: 16px;
            font-weight: 600;
            text-align: center;
            text-decoration: none;
            border-radius: 50px;
            border: none;
            box-shadow: 0 4px 12px rgba(255, 106, 0, 0.35);
            transition: all 0.2s ease;
        }

        .btn-login:hover {
            background: #e85f00;
            transform: translateY(-1px);
        }

        /* Desktop adjustments */
        @media (min-width: 768px) {
            .content {
                padding: 60px 20px;
            }

            .logo-container img {
                width: 220px;
            }

            .bottom-sheet {
                max-width: 400px;
                left: 50%;
                transform: translateX(-50%) translateY(100%);
                border-radius: 24px;
                margin-bottom: 40px;
            }

            .bottom-sheet.show {
                transform: translateX(-50%) translateY(0);
            }

            .btn-signup,
            .btn-login {
                max-width: 300px;
            }

            .swipe-hint {
                bottom: 150px;
            }
        }
    </style>
</head>
<body>
    <!-- Main content with logo -->
    <div class="content">
        <div class="logo-container">
            <img src="{{ asset('img/logo-mama.png') }}" alt="Mama">
        </div>
    </div>

    <!-- Swipe hint -->
    <div class="swipe-hint" id="swipeHint">
        <div class="swipe-arrow"></div>
        <span>Geser ke atas untuk mulai</span>
    </div>

    <!-- Bottom sheet with buttons -->
    <div class="bottom-sheet" id="bottomSheet">
        <div class="handle"></div>
        <div class="buttons">
            <a href="{{ route('register') }}" class="btn-signup">Sign up</a>
            <a href="{{ route('login') }}" class="btn-login">Login</a>
        </div>
    </div>

    <script>
        (function() {
            const bottomSheet = document.getElementById('bottomSheet');
            const swipeHint = document.getElementById('swipeHint');
            const logoContainer = document.querySelector('.logo-container');
            let startY = 0;
            let isRevealed = false;

            function showSheet() {
                if (!isRevealed) {
                    bottomSheet.classList.add('show');
                    swipeHint.classList.add('hidden');
                    logoContainer.classList.add('moved-up');
                    isRevealed = true;
                }
            }

            function hideSheet() {
                if (isRevealed) {
                    bottomSheet.classList.remove('show');
                    swipeHint.classList.remove('hidden');
                    logoContainer.classList.remove('moved-up');
                    isRevealed = false;
                }
            }

            // Touch events for swipe
            document.addEventListener('touchstart', function(e) {
                startY = e.touches[0].clientY;
            }, { passive: true });

            document.addEventListener('touchend', function(e) {
                const endY = e.changedTouches[0].clientY;
                const diffY = startY - endY;

                // Swipe up (at least 50px)
                if (diffY > 50 && !isRevealed) {
                    showSheet();
                }
                // Swipe down (at least 50px) - only on the sheet
                else if (diffY < -50 && isRevealed) {
                    hideSheet();
                }
            }, { passive: true });

            // Click/tap on hint to show sheet
            swipeHint.addEventListener('click', showSheet);

            // Click on handle to toggle
            const handle = bottomSheet.querySelector('.handle');
            handle.addEventListener('click', function() {
                if (isRevealed) {
                    hideSheet();
                }
            });

            // Mouse wheel for desktop
            document.addEventListener('wheel', function(e) {
                if (e.deltaY > 30 && !isRevealed) {
                    showSheet();
                } else if (e.deltaY < -30 && isRevealed) {
                    hideSheet();
                }
            }, { passive: true });

            // Keyboard support
            document.addEventListener('keydown', function(e) {
                if (e.key === 'ArrowUp' || e.key === ' ' || e.key === 'Enter') {
                    if (!isRevealed) {
                        e.preventDefault();
                        showSheet();
                    }
                } else if (e.key === 'ArrowDown' || e.key === 'Escape') {
                    if (isRevealed) {
                        e.preventDefault();
                        hideSheet();
                    }
                }
            });
        })();
    </script>
</body>
</html>
