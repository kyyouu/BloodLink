<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>BloodLink — Sistem Informasi Donor Darah Digital</title>
    <meta name="description" content="BloodLink adalah platform digital yang menghubungkan pendonor darah, PMI, dan rumah sakit secara real-time untuk menyelamatkan lebih banyak jiwa.">

    {{-- Fonts --}}
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
            
            --font-display:   'Outfit', sans-serif;
            --font-body:      'Plus Jakarta Sans', sans-serif;
            
            --shadow-sm:      0 1px 2px 0 rgba(0, 0, 0, 0.05);
            --shadow-md:      0 4px 6px -1px rgba(0, 0, 0, 0.05), 0 2px 4px -1px rgba(0, 0, 0, 0.03);
            --shadow-lg:      0 10px 15px -3px rgba(0, 0, 0, 0.05), 0 4px 6px -2px rgba(0, 0, 0, 0.03);
            --shadow-red:     0 8px 20px -6px var(--primary-glow);
        }

        html { scroll-behavior: smooth; }

        body {
            font-family: var(--font-body);
            background: var(--bg-base);
            color: var(--text-2);
            overflow-x: hidden;
            background-image: 
                radial-gradient(circle at 0% 0%, rgba(225, 29, 72, 0.03) 0%, transparent 40%),
                radial-gradient(circle at 100% 100%, rgba(225, 29, 72, 0.03) 0%, transparent 40%);
        }

        /* ═══════════════════════════════════════
           NAVBAR
        ═══════════════════════════════════════ */
        .navbar {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 5%;
            height: 80px;
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            position: fixed;
            width: 100%;
            top: 0;
            z-index: 1000;
            border-bottom: 1px solid var(--border);
            transition: all 0.3s;
        }

        .brand {
            display: flex;
            align-items: center;
            gap: 12px;
            text-decoration: none;
            color: var(--text-1);
        }
        .brand-icon {
            width: 40px; height: 40px;
            background: linear-gradient(135deg, var(--primary), var(--primary-hover));
            border-radius: 12px;
            display: flex; align-items: center; justify-content: center;
            color: white;
            font-size: 20px;
            box-shadow: var(--shadow-red);
        }
        .brand-text {
            font-family: var(--font-display);
            font-size: 24px;
            font-weight: 800;
            letter-spacing: -0.5px;
        }
        .brand-text span { color: var(--primary); }

        .nav-links {
            display: flex;
            gap: 32px;
        }
        .nav-links a {
            text-decoration: none;
            font-size: 14px;
            font-weight: 600;
            color: var(--text-2);
            transition: color .3s;
        }
        .nav-links a:hover { color: var(--primary); }

        .nav-actions {
            display: flex;
            gap: 12px;
        }

        .btn-outline {
            text-decoration: none;
            padding: 10px 24px;
            border-radius: 12px;
            border: 1px solid var(--border);
            color: var(--text-2);
            font-size: 14px;
            font-weight: 600;
            transition: all .3s;
        }
        .btn-outline:hover {
            background: var(--bg-surface-2);
            border-color: var(--text-3);
            color: var(--text-1);
        }
        
        .btn-primary {
            text-decoration: none;
            padding: 10px 24px;
            border-radius: 12px;
            background: var(--primary);
            color: white;
            font-size: 14px;
            font-weight: 600;
            box-shadow: var(--shadow-red);
            transition: all .3s;
            border: none;
        }
        .btn-primary:hover {
            background: var(--primary-hover);
            transform: translateY(-2px);
            box-shadow: 0 12px 28px -6px rgba(225, 29, 72, 0.3);
            color: white;
        }

        /* ═══════════════════════════════════════
           HERO SECTION
        ═══════════════════════════════════════ */
        .hero {
            padding: 160px 5% 80px;
            position: relative;
        }
        .hero-inner {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 60px;
            align-items: center;
        }

        .hero-title {
            font-family: var(--font-display);
            font-size: 64px;
            font-weight: 900;
            color: var(--text-1);
            line-height: 1.1;
            letter-spacing: -2px;
            margin-bottom: 24px;
            animation: fadeUp 1s ease both;
        }
        .hero-title span {
            color: var(--primary);
            position: relative;
        }

        .hero-desc {
            font-size: 18px;
            color: var(--text-2);
            line-height: 1.6;
            margin-bottom: 40px;
            max-width: 500px;
            animation: fadeUp 1s ease both .2s;
        }

        .hero-actions {
            display: flex;
            gap: 16px;
            animation: fadeUp 1s ease both .4s;
        }

        /* ═══════════════════════════════════════
           STATS BAND
        ═══════════════════════════════════════ */
        .stats-band {
            padding: 60px 5%;
            background: var(--bg-surface);
            border-top: 1px solid var(--border);
            border-bottom: 1px solid var(--border);
        }
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 30px;
        }
        .stat-item {
            text-align: center;
            padding: 30px;
            border-radius: 20px;
            background: var(--bg-surface-2);
            border: 1px solid var(--border);
            transition: all .3s;
        }
        .stat-item:hover {
            transform: translateY(-5px);
            border-color: var(--primary);
            box-shadow: var(--shadow-md);
        }
        .stat-icon {
            font-size: 32px;
            color: var(--primary);
            margin-bottom: 16px;
            filter: drop-shadow(0 4px 12px var(--primary-glow));
        }
        .stat-number {
            font-family: var(--font-display);
            font-size: 40px;
            font-weight: 900;
            color: var(--text-1);
            line-height: 1;
            margin-bottom: 8px;
        }
        .stat-label {
            font-size: 13px;
            color: var(--text-3);
            text-transform: uppercase;
            font-weight: 700;
            letter-spacing: 1px;
        }

        /* ═══════════════════════════════════════
           FEATURES SECTION
        ═══════════════════════════════════════ */
        .section-title {
            text-align: center;
            margin-bottom: 60px;
        }
        .section-title h2 {
            font-family: var(--font-display);
            font-size: 42px;
            font-weight: 800;
            color: var(--text-1);
            letter-spacing: -1px;
        }
        .section-title p {
            color: var(--text-3);
            font-size: 16px;
            margin-top: 12px;
        }

        .features {
            padding: 100px 5%;
            background: var(--bg-base);
        }
        .feature-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 32px;
        }
        .feature-card {
            background: var(--bg-surface);
            border: 1px solid var(--border);
            border-radius: 24px;
            padding: 40px;
            transition: all .3s;
            position: relative;
            overflow: hidden;
        }
        .feature-card:hover {
            transform: translateY(-10px);
            border-color: var(--primary);
            box-shadow: var(--shadow-lg);
        }
        .feature-icon {
            width: 64px; height: 64px;
            background: rgba(225, 29, 72, 0.1);
            border-radius: 16px;
            display: flex; align-items: center; justify-content: center;
            font-size: 24px; color: var(--primary);
            margin-bottom: 24px;
            border: 1px solid rgba(225, 29, 72, 0.2);
        }
        .feature-title {
            font-family: var(--font-display);
            font-size: 22px;
            font-weight: 800;
            color: var(--text-1);
            margin-bottom: 12px;
        }
        .feature-desc {
            font-size: 15px;
            color: var(--text-2);
            line-height: 1.6;
        }

        /* ═══════════════════════════════════════
           BLOOD TYPES
        ═══════════════════════════════════════ */
        .blood-types {
            padding: 100px 5%;
            background: var(--bg-surface);
            border-top: 1px solid var(--border);
        }
        .blood-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 24px;
        }
        .blood-card {
            background: var(--bg-surface-2);
            border: 1px solid var(--border);
            border-radius: 20px;
            padding: 32px;
            text-align: center;
            transition: all .3s;
        }
        .blood-card:hover {
            background: var(--bg-surface);
            border-color: var(--primary);
            box-shadow: var(--shadow-md);
            transform: scale(1.03);
        }
        .blood-type {
            font-family: var(--font-display);
            font-size: 48px;
            font-weight: 900;
            color: var(--primary);
            line-height: 1;
            margin-bottom: 16px;
        }
        .blood-can-give {
            font-size: 13px;
            color: var(--text-2);
            font-weight: 600;
        }
        .blood-can-give span { color: var(--text-1); font-weight: 800; }

        /* ═══════════════════════════════════════
           FOOTER
        ═══════════════════════════════════════ */
        footer {
            padding: 60px 5%;
            background: var(--bg-base);
            border-top: 1px solid var(--border);
            text-align: center;
        }
        .footer-brand {
            font-family: var(--font-display);
            font-size: 28px;
            font-weight: 900;
            color: var(--text-1);
            margin-bottom: 16px;
        }
        .footer-brand span { color: var(--primary); }
        .footer-text {
            color: var(--text-3);
            font-size: 14px;
        }

        /* ── RESPONSIVE ── */
        @media (max-width: 991px) {
            .hero-inner { grid-template-columns: 1fr; text-align: center; }
            .hero-desc { margin: 0 auto 40px; }
            .hero-actions { justify-content: center; }
            .hero-image { display: none !important; }
            
            .stats-grid { grid-template-columns: 1fr 1fr; }
            .feature-grid { grid-template-columns: 1fr; }
            .blood-grid { grid-template-columns: 1fr 1fr; }
            .nav-links { display: none; }
        }
        @media (max-width: 576px) {
            .stats-grid { grid-template-columns: 1fr; }
            .blood-grid { grid-template-columns: 1fr; }
            .hero-title { font-size: 48px; }
        }

        /* ── ANIMATIONS ── */
        @keyframes fadeUp {
            from { opacity: 0; transform: translateY(30px); }
            to { opacity: 1; transform: translateY(0); }
        }
        @keyframes float {
            0% { transform: translateY(0); }
            50% { transform: translateY(-20px); }
            100% { transform: translateY(0); }
        }
    </style>
</head>
<body>

    {{-- NAVBAR --}}
    <nav class="navbar">
        <a href="/" class="brand">
            <div class="brand-icon"><i class="fas fa-tint"></i></div>
            <div class="brand-text"><span>blood</span>link</div>
        </a>
        
        <div class="nav-links">
            <a href="#about">Tentang</a>
            <a href="#features">Fitur</a>
            <a href="#blood-types">Golongan Darah</a>
        </div>

        <div class="nav-actions">
            @auth
                @php
                    $role = auth()->user()->role;
                    $route = match($role) {
                        'admin' => 'admin.dashboard',
                        'petugas_pmi' => 'petugas.dashboard',
                        'pendonor' => 'pendonor.dashboard',
                        'rumah_sakit' => 'rs.dashboard',
                        'pimpinan_pmi' => 'pimpinan.dashboard',
                        default => 'login'
                    };
                @endphp
                <a href="{{ route($route) }}" class="btn-primary">Dashboard Saya</a>
            @else
                <a href="{{ route('login') }}" class="btn-primary">Login</a>
            @endauth
        </div>
    </nav>

    {{-- HERO SECTION --}}
    <div class="hero">
        <div class="hero-inner">
            <div>
                <h1 class="hero-title">Setetes Darah<br><span>Menyambung Nyawa</span></h1>
                <p class="hero-desc">Platform digital cerdas yang menghubungkan pahlawan kemanusiaan, PMI, dan Rumah Sakit secara real-time.</p>
                <div class="hero-actions">
                    <a href="{{ route('login') }}" class="btn-primary" style="padding: 14px 32px; font-size: 16px;">Mulai Donor Sekarang</a>
                </div>
            </div>
            <div class="hero-image" style="display: flex; justify-content: center; align-items: center;">
                <img src="{{ asset('logo.png') }}" alt="BloodLink Logo" style="width: 80%; max-width: 400px; animation: float 6s ease-in-out infinite; filter: drop-shadow(0 20px 40px rgba(225, 29, 72, 0.2)); border: none; box-shadow: none; border-radius: 0;">
            </div>
        </div>
    </div>

    {{-- STATS --}}
    <div class="stats-band" id="about">
        @php
            $statPendonor = \App\Models\Pendonor::count();
            $statDonor = \App\Models\Donor::count();
            $statRS = \App\Models\RumahSakit::count();
            $statJiwa = $statDonor * 3;
        @endphp
        <div class="stats-grid">
            <div class="stat-item">
                <i class="fas fa-users stat-icon"></i>
                <div class="stat-number">{{ number_format($statPendonor) }}</div>
                <div class="stat-label">Pendonor Aktif</div>
            </div>
            <div class="stat-item">
                <i class="fas fa-cubes stat-icon"></i>
                <div class="stat-number">{{ number_format($statDonor) }}</div>
                <div class="stat-label">Kantong Darah</div>
            </div>
            <div class="stat-item">
                <i class="fas fa-hospital stat-icon"></i>
                <div class="stat-number">{{ number_format($statRS) }}</div>
                <div class="stat-label">Rumah Sakit</div>
            </div>
            <div class="stat-item">
                <i class="fas fa-heartbeat stat-icon"></i>
                <div class="stat-number">{{ number_format($statJiwa) }}</div>
                <div class="stat-label">Jiwa Terselamatkan</div>
            </div>
        </div>
    </div>

    {{-- FEATURES --}}
    <div class="features" id="features">
        <div class="section-title">
            <h2>Layanan Digital Terpadu</h2>
            <p>Berbagai fitur unggulan yang memudahkan proses donor dan distribusi darah.</p>
        </div>
        <div class="feature-grid">
            <div class="feature-card">
                <div class="feature-icon"><i class="fas fa-calendar-check"></i></div>
                <h3 class="feature-title">Booking Jadwal Mudah</h3>
                <p class="feature-desc">Pendonor dapat memilih lokasi dan jadwal donor terdekat tanpa perlu mengantre panjang di lokasi PMI.</p>
            </div>
            <div class="feature-card">
                <div class="feature-icon"><i class="fas fa-truck-medical"></i></div>
                <h3 class="feature-title">Permintaan Real-time</h3>
                <p class="feature-desc">Rumah Sakit mitra dapat mengajukan permintaan stok darah secara instan ke PMI dengan sistem tracking yang akurat.</p>
            </div>
            <div class="feature-card">
                <div class="feature-icon"><i class="fas fa-chart-pie"></i></div>
                <h3 class="feature-title">Monitoring Stok Cerdas</h3>
                <p class="feature-desc">Dashboard informatif yang menyajikan ketersediaan setiap golongan darah secara transparan untuk pengambil kebijakan.</p>
            </div>
        </div>
    </div>

    {{-- BLOOD TYPES --}}
    <div class="blood-types" id="blood-types">
        <div class="section-title">
            <h2>Kecocokan Golongan Darah</h2>
            <p>Pastikan Anda memahami siapa saja yang bisa menerima donasi darah Anda.</p>
        </div>
        <div class="blood-grid">
            <div class="blood-card">
                <div class="blood-type">A+</div>
                <div class="blood-can-give">Dapat mendonor ke: <br><span>A+, AB+</span></div>
            </div>
            <div class="blood-card">
                <div class="blood-type">B+</div>
                <div class="blood-can-give">Dapat mendonor ke: <br><span>B+, AB+</span></div>
            </div>
            <div class="blood-card">
                <div class="blood-type">O+</div>
                <div class="blood-can-give">Dapat mendonor ke: <br><span>O+, A+, B+, AB+</span></div>
            </div>
            <div class="blood-card">
                <div class="blood-type">AB+</div>
                <div class="blood-can-give">Dapat mendonor ke: <br><span>AB+ (Penerima Universal)</span></div>
            </div>
            <div class="blood-card">
                <div class="blood-type">A-</div>
                <div class="blood-can-give">Dapat mendonor ke: <br><span>A+, A-, AB+, AB-</span></div>
            </div>
            <div class="blood-card">
                <div class="blood-type">B-</div>
                <div class="blood-can-give">Dapat mendonor ke: <br><span>B+, B-, AB+, AB-</span></div>
            </div>
            <div class="blood-card">
                <div class="blood-type">O-</div>
                <div class="blood-can-give">Dapat mendonor ke: <br><span>Semua Golongan (Donor Universal)</span></div>
            </div>
            <div class="blood-card">
                <div class="blood-type">AB-</div>
                <div class="blood-can-give">Dapat mendonor ke: <br><span>AB+, AB-</span></div>
            </div>
        </div>
    </div>

    {{-- FOOTER --}}
    <footer>
        <div class="footer-brand"><span>blood</span>link</div>
        <p class="footer-text">&copy; {{ now()->year }} BloodLink. Menghubungkan kepedulian, menyelamatkan kehidupan.</p>
    </footer>

    <script>
        // Simple scroll effect for navbar
        window.addEventListener('scroll', function() {
            const nav = document.querySelector('.navbar');
            if(window.scrollY > 50) {
                nav.style.boxShadow = 'var(--shadow-sm)';
            } else {
                nav.style.boxShadow = 'none';
            }
        });
    </script>
</body>
</html>
