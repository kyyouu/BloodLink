<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Masuk — BloodLink</title>
    <meta name="description" content="Masuk ke platform BloodLink — Sistem Informasi Donor Darah Digital.">
    
    {{-- Google Fonts --}}
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;700;900&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet">
    
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
        :root {
            /* Professional Light Mode */
            --bg-base:        #F3F4F6; 
            --bg-surface:     #FFFFFF; 
            --bg-surface-2:   #F9FAFB; 
            --primary:        #E11D48;
            --primary-hover:  #BE123C;
            --primary-glow:   rgba(225, 29, 72, 0.15);
            --text-1:         #111827;
            --text-2:         #374151;
            --text-3:         #6B7280;
            --border:         #E5E7EB;
            --border-light:   #F3F4F6;
            
            --font-display:   'Outfit', sans-serif;
            --font-body:      'Plus Jakarta Sans', sans-serif;
            
            --shadow-sm:      0 1px 2px 0 rgba(0, 0, 0, 0.05);
            --shadow-lg:      0 10px 15px -3px rgba(0, 0, 0, 0.05), 0 4px 6px -2px rgba(0, 0, 0, 0.03);
            --shadow-red:     0 8px 20px -6px var(--primary-glow);
        }

        body {
            font-family: var(--font-body);
            background-color: var(--bg-base);
            color: var(--text-2);
            min-height: 100vh;
            display: flex;
            overflow: hidden;
        }

        /* ── LEFT PANEL ── */
        .login-left {
            width: 50%;
            min-height: 100vh;
            background: linear-gradient(135deg, var(--bg-surface) 0%, var(--bg-surface-2) 100%);
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            padding: 50px 60px;
            position: relative;
            border-right: 1px solid var(--border);
            z-index: 2;
            box-shadow: 10px 0 30px rgba(0,0,0,0.02);
        }

        /* Subtle background pattern */
        .login-left::before {
            content: '';
            position: absolute;
            inset: 0;
            background-image: radial-gradient(var(--border) 1px, transparent 1px);
            background-size: 32px 32px;
            opacity: 0.5;
            z-index: -1;
        }

        .left-content {
            position: relative;
            z-index: 1;
            text-align: center;
            max-width: 420px;
            animation: fadeInUp .8s ease both;
        }

        .brand-logo {
            width: 80px; height: 80px;
            background: linear-gradient(135deg, var(--primary), var(--primary-hover));
            border-radius: 20px;
            display: flex; align-items: center; justify-content: center;
            font-size: 36px; color: white;
            margin: 0 auto 24px;
            box-shadow: var(--shadow-red);
            border: 1px solid rgba(255,255,255,0.5);
        }

        .left-brand {
            font-family: var(--font-display);
            font-size: 42px;
            font-weight: 900;
            color: var(--text-1);
            letter-spacing: -1px;
            margin-bottom: 12px;
        }
        .left-brand span { color: var(--primary); }

        .left-tagline {
            font-size: 15px;
            color: var(--text-3);
            line-height: 1.6;
            margin-bottom: 40px;
            font-weight: 500;
        }

        .stat-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 16px;
            text-align: left;
        }
        
        .stat-box {
            background: var(--bg-surface);
            border: 1px solid var(--border);
            border-radius: 16px;
            padding: 20px;
            display: flex;
            align-items: center;
            gap: 16px;
            transition: all .3s ease;
            box-shadow: var(--shadow-sm);
        }
        .stat-box:hover {
            transform: translateY(-5px);
            box-shadow: var(--shadow-lg);
            border-color: var(--primary);
        }
        .stat-icon {
            width: 40px; height: 40px;
            border-radius: 12px;
            background: rgba(225, 29, 72, 0.1);
            color: var(--primary);
            display: flex; align-items: center; justify-content: center;
            font-size: 18px;
        }
        .stat-val { font-family: var(--font-display); font-size: 20px; font-weight: 800; color: var(--text-1); line-height: 1.2; }
        .stat-lbl { font-size: 11px; color: var(--text-3); text-transform: uppercase; letter-spacing: 0.5px; font-weight: 600; }

        /* ── RIGHT PANEL ── */
        .login-right {
            width: 50%;
            min-height: 100vh;
            background: var(--bg-base);
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            padding: 40px;
            position: relative;
        }

        .login-card {
            width: 100%;
            max-width: 440px;
            background: var(--bg-surface);
            border: 1px solid var(--border);
            border-radius: 24px;
            padding: 48px;
            box-shadow: var(--shadow-lg);
            animation: fadeInRight .8s ease both .2s;
        }

        .auth-title {
            font-family: var(--font-display);
            font-size: 28px;
            font-weight: 800;
            color: var(--text-1);
            margin-bottom: 8px;
            letter-spacing: -0.5px;
        }
        .auth-subtitle {
            font-size: 14px;
            color: var(--text-3);
            margin-bottom: 32px;
            font-weight: 500;
        }

        .form-label {
            font-size: 13px;
            font-weight: 600;
            color: var(--text-2);
            margin-bottom: 8px;
            display: flex; justify-content: space-between;
        }
        
        .input-group-custom {
            position: relative;
            margin-bottom: 24px;
        }
        .input-icon {
            position: absolute;
            left: 16px; top: 50%;
            transform: translateY(-50%);
            color: var(--text-3);
            font-size: 14px;
            transition: color .3s;
            pointer-events: none;
        }
        .form-control {
            background: var(--bg-surface);
            border: 1px solid var(--border);
            color: var(--text-1);
            border-radius: 12px;
            padding: 14px 16px 14px 44px;
            font-size: 14px;
            font-weight: 500;
            width: 100%;
            transition: all .3s;
            box-shadow: var(--shadow-sm);
        }
        .form-control:focus {
            background: var(--bg-surface);
            border-color: var(--primary);
            color: var(--text-1);
            box-shadow: 0 0 0 4px var(--primary-glow);
            outline: none;
        }
        .form-control:focus + .input-icon { color: var(--primary); }
        .form-control::placeholder { color: #9CA3AF; }

        .btn-toggle-pwd {
            position: absolute;
            right: 16px; top: 50%;
            transform: translateY(-50%);
            background: none; border: none;
            color: var(--text-3);
            cursor: pointer;
            padding: 0;
            transition: color .2s;
        }
        .btn-toggle-pwd:hover { color: var(--text-1); }

        .btn-submit {
            width: 100%;
            background: linear-gradient(135deg, var(--primary), var(--primary-hover));
            color: white;
            border: none;
            border-radius: 12px;
            padding: 16px;
            font-size: 15px;
            font-weight: 700;
            box-shadow: var(--shadow-red);
            transition: all .3s;
            display: flex; align-items: center; justify-content: center; gap: 10px;
            cursor: pointer;
        }
        .btn-submit:hover {
            transform: translateY(-2px);
            box-shadow: 0 12px 28px -6px rgba(225, 29, 72, 0.4);
            opacity: 0.95;
        }

        .auth-footer {
            margin-top: 32px;
            text-align: center;
            font-size: 13px;
            color: var(--text-3);
            font-weight: 500;
        }
        .auth-footer a {
            color: var(--primary);
            text-decoration: none;
            font-weight: 700;
            transition: color .2s;
        }
        .auth-footer a:hover {
            color: var(--primary-hover);
        }

        /* ── ALERTS ── */
        .alert-custom {
            background: rgba(225, 29, 72, 0.05);
            border: 1px solid rgba(225, 29, 72, 0.2);
            color: var(--primary);
            border-radius: 12px;
            padding: 14px 16px;
            font-size: 13px;
            font-weight: 600;
            margin-bottom: 24px;
            display: flex; align-items: flex-start; gap: 12px;
            animation: shake 0.5s cubic-bezier(.36,.07,.19,.97) both;
        }

        /* ── RESPONSIVE ── */
        @media (max-width: 991px) {
            body { flex-direction: column; overflow-y: auto; }
            .login-left { width: 100%; min-height: 60vh; padding: 40px 20px; }
            .login-right { width: 100%; min-height: auto; padding: 40px 20px; }
            .login-card { padding: 32px; }
        }

        /* ── ANIMATIONS ── */
        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        @keyframes fadeInRight {
            from { opacity: 0; transform: translateX(30px); }
            to { opacity: 1; transform: translateX(0); }
        }
        @keyframes shake {
            10%, 90% { transform: translate3d(-1px, 0, 0); }
            20%, 80% { transform: translate3d(2px, 0, 0); }
            30%, 50%, 70% { transform: translate3d(-4px, 0, 0); }
            40%, 60% { transform: translate3d(4px, 0, 0); }
        }
    </style>
</head>
<body>

    <!-- LEFT PANEL: BRAND & STATS -->
    <div class="login-left">
        <div class="left-content">
            <div class="brand-logo">
                <i class="fas fa-tint"></i>
            </div>
            <h1 class="left-brand"><span>blood</span>link</h1>
            <p class="left-tagline">
                Sistem Informasi Donor Darah Digital yang menghubungkan pahlawan kemanusiaan, rumah sakit, dan PMI secara real-time.
            </p>
            
            <div class="stat-grid">
                @php
                    $pendonor = \App\Models\Pendonor::count();
                    $kantong = \App\Models\Donor::count();
                    $rs = \App\Models\RumahSakit::count();
                @endphp
                <div class="stat-box">
                    <div class="stat-icon"><i class="fas fa-users"></i></div>
                    <div>
                        <div class="stat-val">{{ number_format($pendonor) }}</div>
                        <div class="stat-lbl">Pahlawan Donor</div>
                    </div>
                </div>
                <div class="stat-box">
                    <div class="stat-icon"><i class="fas fa-cubes"></i></div>
                    <div>
                        <div class="stat-val">{{ number_format($kantong) }}</div>
                        <div class="stat-lbl">Kantong Darah</div>
                    </div>
                </div>
                <div class="stat-box">
                    <div class="stat-icon"><i class="fas fa-hospital"></i></div>
                    <div>
                        <div class="stat-val">{{ number_format($rs) }}</div>
                        <div class="stat-lbl">Rumah Sakit Mitra</div>
                    </div>
                </div>
                <div class="stat-box">
                    <div class="stat-icon"><i class="fas fa-shield-heart"></i></div>
                    <div>
                        <div class="stat-val">24/7</div>
                        <div class="stat-lbl">Layanan Aktif</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- RIGHT PANEL: AUTH FORM -->
    <div class="login-right">
        <div class="login-card">
            
            <h2 class="auth-title">Selamat Datang</h2>
            <p class="auth-subtitle">Silakan masukkan kredensial akun Anda untuk mengakses dashboard BloodLink.</p>

            @if(session('success'))
                <div class="alert-custom" style="background: rgba(16, 185, 129, 0.1); border-color: rgba(16, 185, 129, 0.3); color: #065F46;">
                    <i class="fas fa-check-circle mt-1"></i>
                    <div>{{ session('success') }}</div>
                </div>
            @endif

            @if($errors->any())
                <div class="alert-custom">
                    <i class="fas fa-exclamation-triangle mt-1"></i>
                    <div>
                        <strong style="display:block;margin-bottom:4px;">Gagal Masuk:</strong>
                        <ul style="margin:0;padding-left:16px;">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            @endif

            <form action="{{ route('login') }}" method="POST">
                @csrf
                
                <div class="input-group-custom">
                    <label class="form-label">Email Instansi / Pribadi</label>
                    <div style="position:relative;">
                        <input type="email" name="email" class="form-control" placeholder="admin@bloodlink.com" value="{{ old('email') }}" required autofocus autocomplete="email">
                        <i class="fas fa-envelope input-icon"></i>
                    </div>
                </div>

                <div class="input-group-custom">
                    <label class="form-label">
                        Password
                        <a href="#" style="color:var(--primary);text-decoration:none;font-weight:700;">Lupa Sandi?</a>
                    </label>
                    <div style="position:relative;">
                        <input type="password" name="password" id="password" class="form-control" placeholder="••••••••" required autocomplete="current-password">
                        <i class="fas fa-lock input-icon"></i>
                        <button type="button" class="btn-toggle-pwd" id="togglePwd" tabindex="-1">
                            <i class="fas fa-eye"></i>
                        </button>
                    </div>
                </div>

                <button type="submit" class="btn-submit">
                    Masuk ke Sistem <i class="fas fa-arrow-right ms-2"></i>
                </button>
            </form>
        </div>
    </div>

    <script>
        document.getElementById('togglePwd').addEventListener('click', function() {
            const pwdInput = document.getElementById('password');
            const icon = this.querySelector('i');
            if (pwdInput.type === 'password') {
                pwdInput.type = 'text';
                icon.classList.replace('fa-eye', 'fa-eye-slash');
            } else {
                pwdInput.type = 'password';
                icon.classList.replace('fa-eye-slash', 'fa-eye');
            }
        });
    </script>
</body>
</html>
