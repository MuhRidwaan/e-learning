<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Learnova | Platform Pembelajaran Intensif</title>
    
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('plugins/fontawesome-free/css/all.min.css') }}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('dist/css/adminlte.min.css') }}">
    <!-- Landing Page CSS -->
    <link rel="stylesheet" href="{{ asset('css/landing.css') }}">
</head>
<body>

<!-- ===== FLOATING NAVBAR ===== -->
<nav class="floating-navbar" id="floatingNav">
    <a href="#" class="nav-logo">
        <img src="{{ asset('img/logo_learnova.png') }}" alt="Learnova">
    </a>

    <div class="nav-links">
        <a href="#features">Fitur</a>
        <a href="#catalog">Katalog</a>
        <a href="#instructors">Instruktur</a>
        <a href="#about">Tentang Kami</a>
    </div>

    <div class="nav-actions">
        <a href="{{ route('login') }}" class="nav-signin">Masuk</a>
        <a href="{{ route('register') }}" class="nav-cta">Daftar Sekarang</a>
    </div>

    <button class="nav-mobile-toggle" id="mobileToggle" aria-label="Toggle menu">
        <i class="fas fa-bars" id="toggleIcon"></i>
    </button>

    <!-- Mobile Dropdown -->
    <div class="mobile-menu" id="mobileMenu">
        <a href="#features">Fitur</a>
        <a href="#catalog">Katalog</a>
        <a href="#instructors">Instruktur</a>
        <a href="#about">Tentang Kami</a>
        <hr class="mobile-menu-divider">
        <a href="{{ route('login') }}">Masuk</a>
        <a href="{{ route('register') }}" class="nav-cta">Daftar Sekarang</a>
    </div>
</nav>

<!-- ===== HERO SECTION ===== -->
<div class="hero-wrapper" id="home">
    <div class="hero-slide slide-1 active"></div>
    <div class="hero-slide slide-2"></div>
    <div class="hero-slide slide-3"></div>

    <div class="hero-content">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 col-xl-7">
                    <div class="hero-badge hero-animate delay-1">
                        <span class="dot"></span>
                        Learning Management System
                    </div>
                    <h1 class="hero-title hero-animate delay-2">
                        Belajar Lebih Cerdas,<br>
                        <span class="accent">Tumbuh Lebih Jauh</span>
                    </h1>
                    <p class="hero-desc hero-animate delay-3">
                        Platform pembelajaran terpadu yang menyatukan manajemen kelas, jadwal, absensi, dan interaksi akademik dalam satu ekosistem digital.
                    </p>
                    <div class="hero-btns hero-animate delay-4">
                        <a href="#catalog" class="btn-hero-primary">
                            Jelajahi Kursus <i class="fas fa-arrow-right"></i>
                        </a>
                        <a href="{{ route('register') }}" class="btn-hero-secondary">
                            Daftar Gratis
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="hero-dots">
        <button class="hero-dot active" data-slide="0"></button>
        <button class="hero-dot" data-slide="1"></button>
        <button class="hero-dot" data-slide="2"></button>
    </div>

    <div class="hero-scroll-arrow d-none d-md-flex">
        <span>Scroll</span>
        <i class="fas fa-chevron-down"></i>
    </div>
</div>

<!-- ===== STATS ===== -->
<div class="stats-section py-5">
    <div class="container py-3">
        <div class="row text-center">
            <div class="col-md-3 col-6 mb-4 mb-md-0">
                <div class="stat-number">12k+</div>
                <div class="stat-label">Pelajar Aktif</div>
            </div>
            <div class="col-md-3 col-6 mb-4 mb-md-0">
                <div class="stat-number">1.4k+</div>
                <div class="stat-label">Total Kursus</div>
            </div>
            <div class="col-md-3 col-6">
                <div class="stat-number">400+</div>
                <div class="stat-label">Kelas Master</div>
            </div>
            <div class="col-md-3 col-6">
                <div class="stat-number">95%</div>
                <div class="stat-label">Tingkat Penyelesaian</div>
            </div>
        </div>
    </div>
</div>

<!-- ===== FEATURES ===== -->
<div id="features" class="py-5 bg-white">
    <div class="container py-5">
        <div class="text-center mb-5">
            <span class="section-label">Fitur Unggulan</span>
            <h2 class="section-title mt-1">Mendefinisikan Ulang Standar Pendidikan</h2>
            <p class="text-muted mt-3 mx-auto" style="max-width: 580px; line-height: 1.75;">Kami menyediakan struktur dan konten yang Anda butuhkan untuk memimpin karir Anda melalui metode pedagogis berbasis data.</p>
        </div>
        <div class="row">
            <div class="col-md-4 mb-4">
                <div class="feature-card">
                    <div class="feature-icon icon-blue"><i class="fas fa-graduation-cap"></i></div>
                    <h5 class="font-weight-bold mb-2">Konten dari Para Ahli</h5>
                    <p class="text-muted mb-0" style="line-height: 1.75;">Kursus yang dirancang dan diajarkan oleh pemimpin industri, dari akademisi papan atas hingga praktisi teknologi terkemuka.</p>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <div class="feature-card">
                    <div class="feature-icon icon-amber"><i class="fas fa-clock"></i></div>
                    <h5 class="font-weight-bold mb-2">Pembelajaran Fleksibel</h5>
                    <p class="text-muted mb-0" style="line-height: 1.75;">Belajar dengan jadwal Anda sendiri dengan akses seumur hidup ke semua materi di berbagai perangkat.</p>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <div class="feature-card">
                    <div class="feature-icon icon-teal"><i class="fas fa-medal"></i></div>
                    <h5 class="font-weight-bold mb-2">Sertifikasi Industri</h5>
                    <p class="text-muted mb-0" style="line-height: 1.75;">Dapatkan kredensial yang diakui dan diverifikasi oleh perusahaan global untuk meningkatkan otoritas profesional Anda.</p>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- ===== CATALOG ===== -->
<div id="catalog" class="py-5 bg-light-custom">
    <div class="container py-5">
        <div class="d-flex justify-content-between align-items-end mb-5">
            <div>
                <span class="section-label">Daftar Sekarang</span>
                <h2 class="section-title mt-1">Katalog Kursus Pilihan</h2>
            </div>
            <a href="{{ route('catalog') }}" class="font-weight-bold text-primary d-none d-sm-flex align-items-center" style="text-decoration: none; gap: 6px;">
                Lihat Semua <i class="fas fa-chevron-right" style="font-size: 0.8rem;"></i>
            </a>
        </div>
        <div class="row">
            @forelse($courses as $course)
            <div class="col-lg-4 col-md-6 mb-4">
                <div class="card course-card h-100 border-0">
                    <img src="{{ $course->thumbnail ? asset('storage/'.$course->thumbnail) : 'https://placehold.co/600x400?text='.urlencode($course->title) }}" class="card-img-top" alt="Gambar Kursus">
                    <div class="card-body d-flex flex-column p-4">
                        <div class="d-flex justify-content-between mb-2">
                            <span class="badge badge-primary px-2 py-1" style="border-radius: 6px;">Kursus</span>
                            <span class="text-primary font-weight-bold">Gratis</span>
                        </div>
                        <h5 class="card-title font-weight-bold mb-2">{{ $course->title }}</h5>
                        <p class="card-text text-muted mb-4" style="font-size: 0.9rem; line-height: 1.65;">{{ Str::limit(strip_tags($course->description), 100) }}</p>
                        <div class="mt-auto border-top pt-3 d-flex justify-content-between align-items-center">
                            <div class="text-muted" style="font-size: 0.88rem;">
                                <i class="fas fa-clock mr-1"></i> {{ $course->duration_weeks ?? 0 }} Minggu
                            </div>
                            <a href="{{ route('course.preview', $course->id) }}" class="btn btn-outline-primary btn-sm font-weight-bold" style="border-radius: 20px; padding: 5px 16px;">Pratinjau</a>
                        </div>
                    </div>
                </div>
            </div>
            @empty
            <div class="col-12 text-center py-5">
                <i class="fas fa-book-open fa-3x text-muted mb-3 d-block"></i>
                <p class="text-muted">Belum ada kursus yang tersedia saat ini.</p>
            </div>
            @endforelse
        </div>
        <div class="text-center d-block d-sm-none mt-3">
            <a href="{{ route('catalog') }}" class="btn btn-outline-primary" style="border-radius: 30px; padding: 10px 28px;">Lihat Semua Katalog</a>
        </div>
    </div>
</div>

<!-- ===== INSTRUCTOR ===== -->
<div id="instructors" class="py-5 bg-white">
    <div class="container py-5">
        <div class="row align-items-center">
            <div class="col-lg-5 mb-5 mb-lg-0">
                <img src="https://images.unsplash.com/photo-1571260899304-425eee4c7efc?w=600&q=80" class="img-fluid shadow-lg" alt="Instruktur" style="border-radius: 20px;">
            </div>
            <div class="col-lg-6 offset-lg-1">
                <span class="section-label">Sorotan Instruktur</span>
                <h2 class="section-title mt-2 mb-4">Belajar dari Ahli Global</h2>
                <div class="p-4 bg-light shadow-sm mb-4" style="border-radius: 16px; border-left: 4px solid #00628c;">
                    <p class="font-italic text-muted mb-3" style="line-height: 1.8;">"Di Learnova, kami tidak hanya mengajarkan teknologi; kami mengajarkan fondasi masa depan. Tujuan kami adalah memberikan setiap siswa alat bantu yang presisi untuk memimpin masa depan mereka sendiri."</p>
                    <h6 class="font-weight-bold mb-0">Dr. Julian Thorne</h6>
                    <small class="text-muted">Arsitek Cloud Utama &amp; Instruktur Kepala</small>
                </div>
                <div class="row mt-4">
                    <div class="col-md-6 mb-3">
                        <div class="d-flex">
                            <div class="text-primary mr-3 mt-1"><i class="fas fa-check-circle fa-lg"></i></div>
                            <div>
                                <h6 class="font-weight-bold mb-1">Kredensial Terverifikasi</h6>
                                <small class="text-muted">Semua instruktur disaring oleh Dewan Akademik kami.</small>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <div class="d-flex">
                            <div class="text-primary mr-3 mt-1"><i class="fas fa-users fa-lg"></i></div>
                            <div>
                                <h6 class="font-weight-bold mb-1">Mentoring Aktif</h6>
                                <small class="text-muted">Umpan balik langsung dari setiap instruktur kursus.</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- ===== ABOUT ===== -->
<div id="about" class="py-5 bg-light-custom">
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-lg-9 text-center">
                <span class="section-label">Tentang Kami</span>
                <h2 class="section-title mt-2 mb-4">Mengenal Learnova</h2>
                <p class="text-muted mb-4" style="font-size: 1.05rem; line-height: 1.85; text-align: justify;">
                    Learnova merupakan sebuah Learning Management System (LMS) yang dikembangkan untuk mengatasi permasalahan dalam pengelolaan aktivitas pembelajaran yang masih tersebar dan kurang terintegrasi. Proses pengelolaan kelas, jadwal pembelajaran, absensi, serta interaksi antara siswa dan pengajar membutuhkan sebuah platform yang dapat menyatukan seluruh aktivitas tersebut dalam satu sistem.
                </p>
                <p class="text-muted" style="font-size: 1.05rem; line-height: 1.85; text-align: justify;">
                    Melalui Learnova, siswa, pengajar, dan pihak akademik dapat mengelola kegiatan pembelajaran secara lebih efektif melalui fitur seperti dashboard berbasis role, manajemen kelas, jadwal pembelajaran, sistem absensi, dan forum diskusi. Produk ini diharapkan dapat membantu meningkatkan efisiensi pengelolaan pembelajaran, mempermudah akses informasi akademik, serta menciptakan proses belajar yang lebih terstruktur dan interaktif.
                </p>
            </div>
        </div>
    </div>
</div>

<!-- ===== CTA ===== -->
<div class="py-5 bg-white">
    <div class="container">
        <div class="cta-section text-center">
            <h2 class="display-4 font-weight-bold mb-3" style="color: #fff; position: relative; z-index: 1;">Siap untuk Memimpin Masa Depanmu?</h2>
            <p class="lead mb-5 mx-auto" style="max-width: 560px; color: rgba(255,255,255,0.82); line-height: 1.75; position: relative; z-index: 1;">Bergabunglah dengan ribuan profesional yang telah menguasai keterampilan baru di platform kami. Masa depan Anda dimulai dari sekarang.</p>
            <div class="d-flex justify-content-center flex-wrap" style="gap: 14px; position: relative; z-index: 1;">
                <a href="{{ route('register') }}" class="btn-hero-primary">Mulai Hari Ini</a>
                <a href="#catalog" class="btn-hero-secondary">Lihat Katalog</a>
            </div>
        </div>
    </div>
</div>

<!-- ===== FOOTER ===== -->
<footer class="site-footer">
    <div class="container">
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-center" style="gap: 16px;">
            <div>
                <div class="footer-brand mb-1">Learnova</div>
                <small>&copy; 2024 Learnova. Hak Cipta Dilindungi.</small>
            </div>
            <div class="d-flex flex-wrap justify-content-center" style="gap: 20px;">
                <a href="#">Kebijakan Privasi</a>
                <a href="#">Syarat &amp; Ketentuan</a>
                <a href="#">Pusat Bantuan</a>
                <a href="#">Hubungi Kami</a>
            </div>
            <div class="d-flex" style="gap: 10px;">
                <a href="#" class="social-icon"><i class="fab fa-twitter"></i></a>
                <a href="#" class="social-icon"><i class="fab fa-linkedin-in"></i></a>
                <a href="#" class="social-icon"><i class="fab fa-github"></i></a>
            </div>
        </div>
    </div>
</footer>

<!-- jQuery -->
<script src="{{ asset('plugins/jquery/jquery.min.js') }}"></script>
<!-- Bootstrap 4 -->
<script src="{{ asset('plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>

<script>
    // ===== HERO SLIDER =====
    var slides = document.querySelectorAll('.hero-slide');
    var dots = document.querySelectorAll('.hero-dot');
    var currentSlide = 0;
    var slideInterval;

    function goToSlide(n) {
        slides[currentSlide].classList.remove('active');
        dots[currentSlide].classList.remove('active');
        currentSlide = (n + slides.length) % slides.length;
        slides[currentSlide].classList.add('active');
        dots[currentSlide].classList.add('active');
    }
    function startAutoplay() { slideInterval = setInterval(function(){ goToSlide(currentSlide + 1); }, 5000); }
    function resetAutoplay() { clearInterval(slideInterval); startAutoplay(); }

    dots.forEach(function(dot) {
        dot.addEventListener('click', function() {
            goToSlide(parseInt(this.dataset.slide));
            resetAutoplay();
        });
    });
    startAutoplay();

    // ===== NAVBAR SCROLL =====
    window.addEventListener('scroll', function() {
        var nav = document.getElementById('floatingNav');
        if (window.scrollY > 60) nav.classList.add('scrolled');
        else nav.classList.remove('scrolled');
    });

    // ===== MOBILE MENU =====
    var toggle = document.getElementById('mobileToggle');
    var menu = document.getElementById('mobileMenu');
    var icon = document.getElementById('toggleIcon');
    toggle.addEventListener('click', function(e) {
        e.stopPropagation();
        menu.classList.toggle('open');
        icon.classList.toggle('fa-bars');
        icon.classList.toggle('fa-times');
    });
    document.addEventListener('click', function(e) {
        if (!document.getElementById('floatingNav').contains(e.target)) {
            menu.classList.remove('open');
            icon.classList.add('fa-bars');
            icon.classList.remove('fa-times');
        }
    });
    menu.querySelectorAll('a').forEach(function(link) {
        link.addEventListener('click', function() {
            menu.classList.remove('open');
            icon.classList.add('fa-bars');
            icon.classList.remove('fa-times');
        });
    });

    // ===== SMOOTH SCROLL =====
    document.querySelectorAll('a[href^="#"]').forEach(function(anchor) {
        anchor.addEventListener('click', function(e) {
            var target = document.querySelector(this.getAttribute('href'));
            if (target) {
                e.preventDefault();
                window.scrollTo({ top: target.getBoundingClientRect().top + window.pageYOffset - 80, behavior: 'smooth' });
            }
        });
    </script>
</body>
</html>
