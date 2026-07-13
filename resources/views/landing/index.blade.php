<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>EduCommand | Platform Pembelajaran Intensif</title>
    
    <!-- Google Font -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('plugins/fontawesome-free/css/all.min.css') }}">
    <!-- Theme style (AdminLTE includes Bootstrap 4) -->
    <link rel="stylesheet" href="{{ asset('dist/css/adminlte.min.css') }}">
    
    <style>
        .hero-section {
            background: linear-gradient(135deg, #00628c 0%, #247caa 100%);
            color: white;
            padding: 100px 0;
            min-height: 80vh;
            display: flex;
            align-items: center;
        }
        .hero-section h1 {
            font-size: 4rem;
            font-weight: 900;
        }
        .text-primary-custom {
            color: #87ceff !important;
        }
        .bg-light-custom {
            background-color: #f8f9fa;
        }
        .course-card img {
            height: 200px;
            object-fit: cover;
        }
        .stats-section {
            background-color: #343a40;
            color: white;
        }
        .cta-section {
            background: linear-gradient(135deg, #00628c 0%, #247caa 100%);
            color: white;
            border-radius: 15px;
            padding: 60px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.2);
        }
        .tracking-wide {
            letter-spacing: 0.1em;
        }
        .navbar-nav .nav-link.active {
            color: #00628c !important;
            font-weight: bold;
            border-bottom: 2px solid #00628c;
        }
    </style>
</head>
<body class="hold-transition layout-top-nav" data-spy="scroll" data-target="#navbarCollapse" data-offset="70">
<div class="wrapper">

  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand-md navbar-light navbar-white fixed-top shadow-sm">
    <div class="container">
      <a href="#" class="navbar-brand">
        <span class="brand-text font-weight-bold text-primary">EduCommand</span>
      </a>

      <button class="navbar-toggler order-1" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="collapse navbar-collapse order-3" id="navbarCollapse">
        <ul class="navbar-nav mx-auto">
          <li class="nav-item">
            <a href="#catalog" class="nav-link">Katalog</a>
          </li>
          <li class="nav-item">
            <a href="#features" class="nav-link">Fitur</a>
          </li>
          <li class="nav-item">
            <a href="#instructors" class="nav-link">Instruktur</a>
          </li>
          <li class="nav-item">
            <a href="#about" class="nav-link">Tentang Kami</a>
          </li>
        </ul>
        
        <ul class="navbar-nav ml-auto">
            <li class="nav-item">
                <a href="{{ route('login') }}" class="nav-link text-primary font-weight-bold">Masuk</a>
            </li>
            <li class="nav-item">
                <a href="{{ route('register') }}" class="btn btn-primary font-weight-bold ml-md-2">Daftar</a>
            </li>
        </ul>
      </div>
    </div>
  </nav>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper" style="margin-top: 56px; background-color: #fff;">
    
    <!-- Hero Section -->
    <div class="hero-section">
      <div class="container">
        <div class="row align-items-center">
          <div class="col-lg-6">
            <h1 class="mb-4">Raih Masa Depanmu <br><span class="text-primary-custom">bersama EduCommand</span></h1>
            <p class="lead mb-5 text-white">Akses kursus kelas dunia dari pakar industri dan akademisi terkemuka. Mulai perjalanan belajarmu hari ini dengan pendekatan pembelajaran terstruktur kami.</p>
            <div>
                <a href="#catalog" class="btn btn-primary btn-lg mr-3 shadow">Jelajahi Kursus <i class="fas fa-arrow-right ml-2"></i></a>
                <a href="{{ route('register') }}" class="btn btn-light btn-lg text-primary shadow mt-3 mt-sm-0">Bergabung Gratis</a>
            </div>
          </div>
          <div class="col-lg-6 mt-5 mt-lg-0 text-center">
            <img src="https://lh3.googleusercontent.com/aida-public/AB6AXuD_6bJt0Pai42XEKuEdlpMV33zsWxZDK1-eBg-dZ1DhKx8RpPN8qYX3Km7OR7WwFb9Rjlizj-tSRa1alHx2NH5TZAXsvhYmzzAh4WH1r3RiBUI7bH1QqlbiIy5j6pbKhze4bm8S-mvHyqPmE4j_trpuYf24oWEOFzCVStYNfzpCFtuY41nLsRTIWpEZKRQB-ZV4bqT7-AKzFVVRtlEk6hektxaaHusurlURRZ3vhnfbzWCQOAHu8DZChGgD6mGxFhL1N_b9sxL7shU" class="img-fluid rounded shadow-lg" alt="Hero Image" style="transform: rotate(2deg);">
          </div>
        </div>
      </div>
    </div>

    <!-- Stats Section -->
    <div class="stats-section py-5">
      <div class="container">
        <div class="row text-center">
          <div class="col-md-3 col-6 mb-4 mb-md-0">
            <h2 class="display-4 font-weight-bold text-primary-custom">12k+</h2>
            <p class="text-uppercase tracking-wide font-weight-bold">Pelajar Aktif</p>
          </div>
          <div class="col-md-3 col-6 mb-4 mb-md-0">
            <h2 class="display-4 font-weight-bold text-primary-custom">1.4k+</h2>
            <p class="text-uppercase tracking-wide font-weight-bold">Total Kursus</p>
          </div>
          <div class="col-md-3 col-6">
            <h2 class="display-4 font-weight-bold text-primary-custom">400+</h2>
            <p class="text-uppercase tracking-wide font-weight-bold">Kelas Master</p>
          </div>
          <div class="col-md-3 col-6">
            <h2 class="display-4 font-weight-bold text-primary-custom">95%</h2>
            <p class="text-uppercase tracking-wide font-weight-bold">Tingkat Penyelesaian</p>
          </div>
        </div>
      </div>
    </div>

    <!-- Features Section -->
    <div id="features" class="py-5 bg-white">
      <div class="container py-5">
        <div class="text-center mb-5">
          <h2 class="font-weight-bold">Mendefinisikan Ulang Standar Pendidikan</h2>
          <p class="lead text-muted mx-auto" style="max-width: 600px;">Kami menyediakan struktur dan konten yang Anda butuhkan untuk memimpin karir Anda melalui metode pedagogis berbasis data.</p>
        </div>
        <div class="row">
          <div class="col-md-4 mb-4">
            <div class="card h-100 shadow-sm border-0 bg-light">
              <div class="card-body p-4 text-center">
                <div class="mb-4 text-primary" style="font-size: 3rem;">
                  <i class="fas fa-graduation-cap"></i>
                </div>
                <h4 class="font-weight-bold">Konten dari Para Ahli</h4>
                <p class="text-muted">Kursus yang dirancang dan diajarkan oleh para pemimpin industri yang diakui, dari akademisi papan atas hingga praktisi teknologi terkemuka.</p>
              </div>
            </div>
          </div>
          <div class="col-md-4 mb-4">
            <div class="card h-100 shadow-sm border-0 bg-light">
              <div class="card-body p-4 text-center">
                <div class="mb-4 text-warning" style="font-size: 3rem;">
                  <i class="fas fa-clock"></i>
                </div>
                <h4 class="font-weight-bold">Pembelajaran Fleksibel</h4>
                <p class="text-muted">Belajar dengan jadwal Anda sendiri dengan akses seumur hidup ke semua materi di berbagai perangkat yang Anda miliki.</p>
              </div>
            </div>
          </div>
          <div class="col-md-4 mb-4">
            <div class="card h-100 shadow-sm border-0 bg-light">
              <div class="card-body p-4 text-center">
                <div class="mb-4 text-info" style="font-size: 3rem;">
                  <i class="fas fa-medal"></i>
                </div>
                <h4 class="font-weight-bold">Sertifikasi Industri</h4>
                <p class="text-muted">Dapatkan kredensial yang diakui dan diverifikasi oleh perusahaan global untuk meningkatkan otoritas profesional Anda.</p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Catalog Section -->
    <div id="catalog" class="py-5 bg-light-custom">
      <div class="container py-5">
        <div class="d-flex justify-content-between align-items-end mb-4">
          <div>
            <span class="text-primary font-weight-bold text-uppercase tracking-wide">Daftar Sekarang</span>
            <h2 class="font-weight-bold mt-2">Katalog Kursus Pilihan</h2>
          </div>
          <a href="{{ route('catalog') }}" class="font-weight-bold text-primary d-none d-sm-block">Lihat Semua Katalog <i class="fas fa-chevron-right ml-1"></i></a>
        </div>
        
        <div class="row">
          @forelse($courses as $course)
          <div class="col-lg-4 col-md-6 mb-4">
            <div class="card h-100 shadow-sm border-0 course-card">
              <img src="{{ $course->thumbnail ? asset('storage/'.$course->thumbnail) : 'https://placehold.co/600x400?text='.urlencode($course->title) }}" class="card-img-top" alt="Gambar Kursus">
              <div class="card-body d-flex flex-column">
                <div class="d-flex justify-content-between mb-2">
                    <span class="badge badge-primary px-2 py-1">Kursus</span>
                    <span class="text-primary font-weight-bold">Gratis</span>
                </div>
                <h5 class="card-title font-weight-bold mb-3">{{ $course->title }}</h5>
                <p class="card-text text-muted mb-4">{{ Str::limit(strip_tags($course->description), 100) }}</p>
                <div class="mt-auto border-top pt-3 d-flex justify-content-between align-items-center">
                  <div class="text-muted">
                    <i class="fas fa-clock mr-1"></i> {{ $course->duration_weeks ?? 0 }} Minggu
                  </div>
                  <a href="{{ route('course.preview', $course->id) }}" class="btn btn-outline-primary btn-sm font-weight-bold">Pratinjau</a>
                </div>
              </div>
            </div>
          </div>
          @empty
          <div class="col-12 text-center py-5">
            <p class="text-muted">Belum ada kursus yang tersedia saat ini.</p>
          </div>
          @endforelse
        </div>
        <div class="text-center d-block d-sm-none mt-3">
          <a href="{{ route('catalog') }}" class="btn btn-outline-primary">Lihat Semua Katalog</a>
        </div>
      </div>
    </div>

    <!-- Instructor Spotlight -->
    <div id="instructors" class="py-5 bg-white">
      <div class="container py-5">
        <div class="row align-items-center">
          <div class="col-lg-5 mb-5 mb-lg-0">
            <img src="https://lh3.googleusercontent.com/aida-public/AB6AXuCKNUIdey5peYAUnW-bjUK4HPSSdYI_W4Timed6YaZtjlolPZnhZib9p0RsvzFrzdZirHmzKNvXUoTLA3Gd1TzsAmUtOsaEGjGwc4qfK4BlBkp8P742a_5ncrc0lgz0FWj50X4VhaX-bzKMhjFViwmRAiFdiwI6UN3I7YSuGir0qox15GJiGJHaVJZSJ5IyBp4UTX1p1GF1n5u2Eh-UDqN0HLg3FbjtPdkXx4Kid-QJK6AZIxxl3VTq6uUw8o7P5gse--RYrbcm5xQ" class="img-fluid rounded shadow-lg" alt="Instruktur">
          </div>
          <div class="col-lg-6 offset-lg-1">
            <span class="text-primary font-weight-bold text-uppercase tracking-wide">Sorotan Instruktur</span>
            <h2 class="font-weight-bold mt-3 mb-4">Belajar dari Ahli Global</h2>
            <div class="p-4 bg-light rounded border-left border-primary shadow-sm mb-4" style="border-left-width: 4px !important;">
              <p class="font-italic text-muted mb-3">"Di EduCommand, kami tidak hanya mengajarkan teknologi; kami mengajarkan fondasi masa depan. Tujuan kami adalah memberikan setiap siswa alat bantu yang presisi untuk memimpin masa depan mereka sendiri."</p>
              <h5 class="font-weight-bold mb-0">Dr. Julian Thorne</h5>
              <small class="text-muted">Arsitek Cloud Utama & Instruktur Kepala</small>
            </div>
            <div class="row mt-4">
              <div class="col-md-6 mb-3">
                <div class="d-flex">
                  <div class="text-primary mr-3"><i class="fas fa-check-circle fa-2x"></i></div>
                  <div>
                    <h6 class="font-weight-bold mb-1">Kredensial Terverifikasi</h6>
                    <small class="text-muted">Semua instruktur disaring oleh Dewan Akademik kami.</small>
                  </div>
                </div>
              </div>
              <div class="col-md-6 mb-3">
                <div class="d-flex">
                  <div class="text-primary mr-3"><i class="fas fa-users fa-2x"></i></div>
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

    <!-- CTA Section -->
    <div class="py-5 bg-white">
      <div class="container">
        <div class="cta-section text-center position-relative overflow-hidden">
          <h2 class="display-4 font-weight-bold mb-4">Siap untuk Memimpin Masa Depanmu?</h2>
          <p class="lead mb-5 mx-auto text-white" style="max-width: 600px;">Bergabunglah dengan ribuan profesional yang telah menguasai keterampilan baru di platform kami. Masa depan Anda dimulai dari sekarang.</p>
          <div class="d-flex justify-content-center flex-wrap">
            <a href="{{ route('register') }}" class="btn btn-light btn-lg text-primary font-weight-bold shadow-lg mx-2 mb-3">Mulai Hari Ini</a>
            <a href="#catalog" class="btn btn-outline-light btn-lg font-weight-bold mx-2 mb-3">Lihat Katalog</a>
          </div>
        </div>
      </div>
    </div>

  </div>
  <!-- /.content-wrapper -->

  <!-- Footer -->
  <footer id="about" class="main-footer ml-0 text-center text-md-left">
    <div class="container d-flex flex-column flex-md-row justify-content-between align-items-center">
      <div class="mb-3 mb-md-0">
        <h5 class="font-weight-bold mb-1">EduCommand</h5>
        <small class="text-muted">&copy; 2024 EduArch High-Density Learning. Hak Cipta Dilindungi.</small>
      </div>
      <div class="mb-3 mb-md-0 d-flex flex-wrap justify-content-center">
        <a href="#" class="text-muted mx-3">Kebijakan Privasi</a>
        <a href="#" class="text-muted mx-3">Syarat & Ketentuan</a>
        <a href="#" class="text-muted mx-3">Pusat Bantuan</a>
        <a href="#" class="text-muted mx-3">Hubungi Dukungan</a>
      </div>
      <div>
        <a href="#" class="btn btn-light btn-sm rounded-circle text-muted mx-1"><i class="fab fa-twitter"></i></a>
        <a href="#" class="btn btn-light btn-sm rounded-circle text-muted mx-1"><i class="fab fa-linkedin-in"></i></a>
        <a href="#" class="btn btn-light btn-sm rounded-circle text-muted mx-1"><i class="fab fa-github"></i></a>
      </div>
    </div>
  </footer>

</div>
<!-- ./wrapper -->

<!-- jQuery -->
<script src="{{ asset('plugins/jquery/jquery.min.js') }}"></script>
<!-- Bootstrap 4 -->
<script src="{{ asset('plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<!-- AdminLTE App -->
<script src="{{ asset('dist/js/adminlte.min.js') }}"></script>
<script>
    // Smooth scrolling for anchor links
    $(document).ready(function(){
        $("a.nav-link, a.btn").on('click', function(event) {
            if (this.hash !== "") {
                var hash = this.hash;
                if ($(hash).length) {
                    event.preventDefault();
                    $('html, body').animate({
                        scrollTop: $(hash).offset().top - 60
                    }, 800, function(){
                        // Optional: update hash in URL
                    });
                }
            }
        });
    });
</script>
</body>
</html>