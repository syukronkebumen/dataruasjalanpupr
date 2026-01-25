<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SIJJ - Sistem Informasi Jalan & Jembatan</title>
    <link rel="icon" type="image/x-icon" href="{{ asset('img/logo/logo.png') }}">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            color: #333;
            line-height: 1.6;
        }

        header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 1rem 0;
            position: sticky;
            top: 0;
            z-index: 100;
        }

        nav {
            max-width: 1200px;
            margin: 0 auto;
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0 2rem;
        }

        .logo {
            font-size: 1.8rem;
            font-weight: bold;
        }

        .nav-links {
            display: flex;
            gap: 2rem;
            list-style: none;
        }

        .nav-links a {
            color: white;
            text-decoration: none;
            transition: opacity 0.3s;
        }

        .nav-links a:hover {
            opacity: 0.8;
        }

        .hero {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 6rem 2rem;
            text-align: center;
        }

        .hero-content {
            max-width: 800px;
            margin: 0 auto;
        }

        .hero h1 {
            font-size: 3rem;
            margin-bottom: 1rem;
        }

        .hero p {
            font-size: 1.2rem;
            margin-bottom: 2rem;
            opacity: 0.9;
        }

        .cta-button {
            display: inline-block;
            background: white;
            color: #667eea;
            padding: 0.8rem 2rem;
            border-radius: 5px;
            text-decoration: none;
            font-weight: bold;
            transition: transform 0.3s, box-shadow 0.3s;
        }

        .cta-button:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
        }

        .features {
            max-width: 1200px;
            margin: 4rem auto;
            padding: 0 2rem;
        }

        .features h2 {
            text-align: center;
            font-size: 2.5rem;
            margin-bottom: 3rem;
            color: #333;
        }

        .features-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 2rem;
        }

        .feature-card {
            background: #f8f9fa;
            padding: 2rem;
            border-radius: 10px;
            text-align: center;
            transition: transform 0.3s, box-shadow 0.3s;
            border: 1px solid #e0e0e0;
        }

        .feature-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        }

        .feature-icon {
            font-size: 3rem;
            margin-bottom: 1rem;
        }

        .feature-card h3 {
            color: #667eea;
            margin-bottom: 1rem;
        }

        .feature-card p {
            color: #666;
        }

        .stats {
            background: #f0f4ff;
            padding: 3rem 2rem;
            margin: 3rem 0;
        }

        .stats-container {
            max-width: 1200px;
            margin: 0 auto;
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 2rem;
            text-align: center;
        }

        .stat {
            padding: 2rem;
        }

        .stat-number {
            font-size: 2.5rem;
            color: #667eea;
            font-weight: bold;
        }

        .stat-label {
            color: #666;
            margin-top: 0.5rem;
        }

        footer {
            background: #2c3e50;
            color: white;
            text-align: center;
            padding: 2rem;
            margin-top: 4rem;
        }

        @media (max-width: 768px) {
            .hero h1 {
                font-size: 2rem;
            }

            .nav-links {
                gap: 1rem;
                font-size: 0.9rem;
            }

            .features h2 {
                font-size: 1.8rem;
            }
        }
    </style>
</head>
<body>
    <!-- Header -->
    <header>
        <nav>
            <div class="logo">
                <a href="/" style="text-decoration: none; display: flex; align-items: center; gap: 0.5rem; color: white;">
                    <img src="{{ asset('img/logo/logo.png') }}" alt="SIJJ Logo" style="height: 2rem;">
                    SIJJ
                </a>
            </div>
            <ul class="nav-links">
                <li><a href="#fitur">Fitur</a></li>
                <li><a href="#statistik">Statistik</a></li>
                <li><a href="#kontak">Kontak</a></li>
            </ul>
        </nav>
    </header>

    <!-- Hero Section -->
    <section class="hero" id="hero">
        <div class="hero-content">
            <h1>Sistem Informasi Jalan & Jembatan</h1>
            <p>Kelola dan pantau semua data infrastruktur jalan dan jembatan dengan sistem terpadu yang efisien dan akurat</p>
            <a href="/ruasjalan" class="cta-button">Mulai Sekarang</a>
        </div>
    </section>

    <!-- Statistics -->
    <section class="stats" id="statistik">
        <div class="stats-container">
            <div class="stat">
                <div class="stat-number">200+</div>
                <div class="stat-label">Jalan Terpantau</div>
            </div>
            <div class="stat">
                <div class="stat-number">200+</div>
                <div class="stat-label">Jembatan Terpantau</div>
            </div>
            <div class="stat">
                <div class="stat-number">24/7</div>
                <div class="stat-label">Monitoring Aktif</div>
            </div>
            <div class="stat">
                <div class="stat-number">100+</div>
                <div class="stat-label">Pengguna Terdaftar</div>
            </div>
        </div>
    </section>

    <!-- Features -->
    <section class="features" id="fitur">
        <h2>Fitur Unggulan</h2>
        <div class="features-grid">
            <div class="feature-card">
                <div class="feature-icon">📍</div>
                <h3>Pemetaan Real-time</h3>
                <p>Lihat lokasi jalan dan jembatan dengan informasi kondisi terkini di peta interaktif</p>
            </div>
            <div class="feature-card">
                <div class="feature-icon">⚠️</div>
                <h3>Peringatan Kondisi</h3>
                <p>Notifikasi otomatis untuk kerusakan atau kondisi berbahaya di jalan dan jembatan</p>
            </div>
            <div class="feature-card">
                <div class="feature-icon">📊</div>
                <h3>Analitik & Laporan</h3>
                <p>Data statistik lengkap dan laporan detail untuk pemeliharaan infrastruktur</p>
            </div>
            <div class="feature-card">
                <div class="feature-icon">👥</div>
                <h3>Manajemen Pengguna</h3>
                <p>Kontrol akses multi-role untuk pejabat, teknisi, dan masyarakat umum</p>
            </div>
            <div class="feature-card">
                <div class="feature-icon">📱</div>
                <h3>Aplikasi Mobile</h3>
                <p>Akses informasi kapan saja, dimana saja melalui aplikasi mobile yang responsif</p>
            </div>
            <div class="feature-card">
                <div class="feature-icon">🔐</div>
                <h3>Keamanan Data</h3>
                <p>Sistem keamanan berlapis untuk melindungi data infrastruktur kritis</p>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer id="kontak">
        <p>&copy; 2024 SIJJ - Sistem Informasi Jalan & Jembatan</p>
        <p>Kontak: info@pupr@lampungtimurkab.go.id | Telepon: (021) 1234-5678</p>
    </footer>
</body>
</html>