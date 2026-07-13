<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Katalog Kursus | EduCommand</title>
    
    <!-- Google Font -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('plugins/fontawesome-free/css/all.min.css') }}">
    <!-- Theme style (AdminLTE includes Bootstrap 4) -->
    <link rel="stylesheet" href="{{ asset('dist/css/adminlte.min.css') }}">
    
    <style>
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
        .tracking-wide {
            letter-spacing: 0.1em;
        }
        .page-header {
            background: linear-gradient(135deg, #00628c 0%, #247caa 100%);
            color: white;
            padding: 80px 0 40px;
        }
    </style>
</head>
<body class="hold-transition layout-top-nav">
<div class="wrapper">

  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand-md navbar-light navbar-white fixed-top shadow-sm">
    <div class="container">
      <a href="{{ route('home') }}" class="navbar-brand">
        <span class="brand-text font-weight-bold text-primary">EduCommand</span>
      </a>

      <button class="navbar-toggler order-1" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="collapse navbar-collapse order-3" id="navbarCollapse">
        <ul class="navbar-nav mx-auto">
          <li class="nav-item">
            <a href="{{ route('home') }}#catalog" class="nav-link">Beranda</a>
          </li>
          <li class="nav-item">
            <a href="{{ route('catalog') }}" class="nav-link font-weight-bold text-primary">Katalog</a>
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
  <div class="content-wrapper" style="margin-top: 56px; background-color: #f8f9fa;">
    
    <!-- Page Header -->
    <div class="page-header text-center">
      <div class="container">
        <h1 class="font-weight-bold display-4">Katalog Lengkap Kursus</h1>
        <p class="lead text-white-50">Jelajahi seluruh kursus unggulan kami dan mulai belajar hari ini.</p>
      </div>
    </div>

    <!-- Catalog Section -->
    <div class="py-5">
      <div class="container">
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
        
        <!-- Pagination -->
        <div class="d-flex justify-content-center mt-4">
          {{ $courses->links() }}
        </div>
      </div>
    </div>

  </div>
  <!-- /.content-wrapper -->

  <!-- Footer -->
  <footer class="main-footer ml-0 text-center text-md-left">
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
</body>
</html>
