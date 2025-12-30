<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1, user-scalable=no">
    <title>Sign Up - MAMA Marketplace</title>
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
            font-family: 'Poppins', -apple-system, BlinkMacSystemFont, sans-serif;
        }

        body {
            background: linear-gradient(180deg, #e8f4fd 0%, #f0f7fc 100%);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        /* Logo Section */
        .logo-section {
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 40px 20px 20px;
        }

        .logo-wrapper {
            width: 100px;
            height: 100px;
            background: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 8px 30px rgba(0, 0, 0, 0.12);
            animation: float 3s ease-in-out infinite;
        }

        .logo-wrapper img {
            width: 70px;
            height: auto;
        }

        @keyframes float {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-8px); }
        }

        /* Form Section */
        .form-section {
            flex: 1;
            background: linear-gradient(180deg, #ff6a00 0%, #ff8533 100%);
            border-top-left-radius: 32px;
            border-top-right-radius: 32px;
            padding: 20px 24px 40px;
            box-shadow: 0 -8px 30px rgba(255, 106, 0, 0.2);
        }

        .handle {
            width: 40px;
            height: 4px;
            background: rgba(255, 255, 255, 0.5);
            border-radius: 100px;
            margin: 0 auto 24px;
        }

        .form-container {
            max-width: 360px;
            margin: 0 auto;
        }

        .form-title {
            color: white;
            font-size: 24px;
            font-weight: 700;
            text-align: center;
            margin-bottom: 20px;
        }

        .form-group {
            margin-bottom: 14px;
        }

        .form-label {
            display: block;
            color: rgba(255, 255, 255, 0.9);
            font-size: 13px;
            font-weight: 500;
            margin-bottom: 6px;
        }

        .form-input {
            width: 100%;
            padding: 14px 16px;
            font-size: 15px;
            border: none;
            border-radius: 12px;
            background: white;
            color: #333;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
            transition: box-shadow 0.2s ease;
        }

        .form-input:focus {
            outline: none;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        }

        .form-input::placeholder {
            color: #aaa;
        }

        .password-wrapper {
            position: relative;
        }

        .password-toggle {
            position: absolute;
            right: 14px;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            color: #999;
            cursor: pointer;
            font-size: 18px;
        }

        .btn-submit {
            width: 100%;
            padding: 14px;
            background: white;
            color: #ff6a00;
            font-size: 16px;
            font-weight: 700;
            border: none;
            border-radius: 50px;
            cursor: pointer;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.15);
            transition: all 0.2s ease;
            margin-top: 8px;
        }

        .btn-submit:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.2);
        }

        .login-link {
            text-align: center;
            margin-top: 20px;
            color: white;
            font-size: 14px;
        }

        .login-link a {
            color: #ffe066;
            font-weight: 600;
            text-decoration: none;
        }

        .login-link a:hover {
            text-decoration: underline;
        }

        /* Responsive */
        @media (min-width: 768px) {
            .logo-section {
                padding: 60px 20px 30px;
            }

            .logo-wrapper {
                width: 120px;
                height: 120px;
            }

            .logo-wrapper img {
                width: 85px;
            }

            .form-section {
                max-width: 450px;
                margin: 0 auto;
                border-radius: 32px;
                margin-bottom: 40px;
            }

            .form-title {
                font-size: 28px;
            }
        }
    </style>
</head>
<body>
    <!-- Logo Section -->
    <div class="logo-section">
        <div class="logo-wrapper">
            <img src="{{ asset('img/logo-mama.png') }}" alt="MAMA Logo">
        </div>
    </div>

    <!-- Form Section -->
    <div class="form-section">
        <div class="handle"></div>
        
        <div class="form-container">
            <h1 class="form-title">Buat Akun</h1>
            
            <form action="{{ route('register') }}" method="POST">
                @csrf
                
                <div class="form-group">
                    <label class="form-label">Username</label>
                    <input type="text" name="name" class="form-input" placeholder="Masukkan username" required>
                </div>

                <div class="form-group">
                    <label class="form-label">Email</label>
                    <input type="email" name="email" class="form-input" placeholder="Masukkan email" required>
                </div>

                <div class="form-group">
                    <label class="form-label">Password</label>
                    <div class="password-wrapper">
                        <input type="password" name="password" id="password" class="form-input" placeholder="Masukkan password" required>
                        <button type="button" class="password-toggle" onclick="togglePassword('password', this)">👁</button>
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label">Konfirmasi Password</label>
                    <div class="password-wrapper">
                        <input type="password" name="password_confirmation" id="password_confirm" class="form-input" placeholder="Ulangi password" required>
                        <button type="button" class="password-toggle" onclick="togglePassword('password_confirm', this)">👁</button>
                    </div>
                </div>

                <button type="submit" class="btn-submit">Sign up</button>
            </form>

            <p class="login-link">
                Sudah punya akun? <a href="{{ route('login') }}">Login disini</a>
            </p>
        </div>
    </div>

    <script>
        function togglePassword(inputId, btn) {
            const input = document.getElementById(inputId);
            if (input.type === 'password') {
                input.type = 'text';
                btn.textContent = '🙈';
            } else {
                input.type = 'password';
                btn.textContent = '👁';
            }
        }
    </script>
</body>
</html>