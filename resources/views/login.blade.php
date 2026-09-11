<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Jobnation.id</title>
    <link rel="stylesheet" href="{{ asset('style.css') }}?v={{ time() }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/remixicon@3.5.0/fonts/remixicon.css">
</head>
<body>
    <div class="background-shapes">
        <div class="shape shape-1"></div>
        <div class="shape shape-2"></div>
        <div class="shape shape-3"></div>
    </div>

    <div class="login-container">
        <div class="login-card">
            <div class="logo-section">
                <div class="logo" style="margin-bottom: -10px; margin-top: -20px;">
                    <img src="{{ asset('logo.png') }}" alt="Jobnation IT Outsource" style="max-width: 280px; height: auto; margin-bottom: -15px;">
                </div>
                <p class="subtitle">Kelola keuangan, rencanakan masa depan.</p>
            </div>

            <div class="welcome-section">
                <h2>Selamat datang kembali!</h2>
                <p>Silakan masuk untuk melanjutkan</p>
            </div>

            @if($errors->any())
                <div style="background-color: #fee2e2; color: #991b1b; padding: 12px 15px; border-radius: 6px; margin-bottom: 20px; font-size: 14px; border: 1px solid #f87171;">
                    {{ $errors->first() }}
                </div>
            @endif

            <form class="login-form" method="POST" action="{{ route('login') }}">
                @csrf
                <div class="form-group">
                    <label for="email">Email</label>
                    <div class="input-wrapper">
                        <i class="ri-mail-line icon"></i>
                        <input type="email" id="email" name="email" placeholder="admin@gmail.com" value="{{ old('email') }}" required>
                    </div>
                </div>

                <div class="form-group">
                    <label for="password">Password</label>
                    <div class="input-wrapper">
                        <i class="ri-lock-2-line icon lock-icon" style="color: #F5A623;"></i>
                        <input type="password" id="password" name="password" placeholder="Masukkan password" required>
                        <i class="ri-eye-off-line icon-right toggle-password"></i>
                    </div>
                </div>

                <div class="form-options">
                    <label class="remember-me">
                        <input type="checkbox" name="remember">
                        <span class="checkmark"></span>
                        Ingat saya
                    </label>
                    <a href="#" class="forgot-password">Lupa password?</a>
                </div>

                <button type="submit" class="btn-login">Masuk</button>
            </form>

            <div class="footer">
                &copy; 2026 Jobnation.id. Semua hak dilindungi.
            </div>
        </div>
    </div>

    <script>
        const togglePassword = document.querySelector('.toggle-password');
        const passwordInput = document.querySelector('#password');

        togglePassword.addEventListener('click', function () {
            const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordInput.setAttribute('type', type);
            
            if (type === 'password') {
                this.classList.remove('ri-eye-line');
                this.classList.add('ri-eye-off-line');
            } else {
                this.classList.remove('ri-eye-off-line');
                this.classList.add('ri-eye-line');
            }
        });
    </script>
</body>
</html>
