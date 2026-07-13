<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $course->title }} | EduCommand</title>
    
    <!-- Google Font -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('plugins/fontawesome-free/css/all.min.css') }}">
    <!-- Theme style (AdminLTE includes Bootstrap 4) -->
    <link rel="stylesheet" href="{{ asset('dist/css/adminlte.min.css') }}">
    
    <style>
        .page-header {
            background: linear-gradient(135deg, #00628c 0%, #247caa 100%);
            color: white;
            padding: 80px 0;
        }
        .course-img {
            max-height: 400px;
            object-fit: cover;
            width: 100%;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }
        .module-list {
            list-style: none;
            padding: 0;
        }
        .module-list li {
            padding: 15px;
            border: 1px solid #dee2e6;
            margin-bottom: 10px;
            border-radius: 8px;
            background-color: #fff;
            display: flex;
            align-items: center;
        }
        .module-icon {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background-color: #f0f4f8;
            color: #00628c;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 15px;
            font-size: 1.2rem;
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
            <a href="{{ route('catalog') }}" class="nav-link font-weight-bold">Katalog</a>
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

  <!-- Content Wrapper -->
  <div class="content-wrapper" style="margin-top: 56px; background-color: #f8f9fa;">
    
    <!-- Page Header -->
    <div class="page-header">
      <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-8">
                <span class="badge badge-light px-3 py-2 text-primary mb-3 text-uppercase" style="letter-spacing: 0.1em;">Pratinjau Kursus</span>
                <h1 class="font-weight-bold display-4 mb-3">{{ $course->title }}</h1>
                <div class="d-flex align-items-center text-white-50 mb-4">
                    <div class="mr-4"><i class="fas fa-clock mr-1"></i> {{ $course->duration_weeks ?? 0 }} Minggu</div>
                    <div class="mr-4"><i class="fas fa-users mr-1"></i> Maks: {{ $course->max_students ?? 'Tidak Terbatas' }} Siswa</div>
                    @if($course->instructor)
                        <div><i class="fas fa-chalkboard-teacher mr-1"></i> {{ $course->instructor->name }}</div>
                    @endif
                </div>
            </div>
        </div>
      </div>
    </div>

    <!-- Course Content -->
    <div class="py-5">
      <div class="container">
        <div class="row">
          
          <div class="col-lg-8 mb-4">
            <!-- Thumbnail -->
            <img src="{{ $course->thumbnail ? asset('storage/'.$course->thumbnail) : 'https://placehold.co/800x400?text='.urlencode($course->title) }}" class="course-img mb-5" alt="Gambar Kursus">
            
            <!-- Description -->
            <h3 class="font-weight-bold mb-4">Tentang Kursus Ini</h3>
            <div class="bg-white p-4 rounded shadow-sm mb-5" style="font-size: 1.1rem; line-height: 1.8;">
                {!! $course->description !!}
            </div>

            <!-- Modules / Syllabus -->
            <h3 class="font-weight-bold mb-4">Ringkasan Silabus</h3>
            @if($course->modules && $course->modules->count() > 0)
                <ul class="module-list">
                    @foreach($course->modules as $index => $module)
                        <li>
                            <div class="module-icon">{{ $index + 1 }}</div>
                            <div>
                                <h5 class="font-weight-bold mb-1">{{ $module->title }}</h5>
                                <p class="text-muted mb-0 small">{{ $module->description ?? 'Pelajari dasar-dasar pada modul ini.' }}</p>
                            </div>
                        </li>
                    @endforeach
                </ul>
            @else
                <div class="alert alert-light text-muted border">
                    Silabus akan segera dipublikasikan.
                </div>
            @endif
          </div>
          
          <!-- Sidebar -->
          <div class="col-lg-4">
            <div class="card shadow-sm border-0 sticky-top" style="top: 100px;">
                <div class="card-body p-4">
                    <h4 class="font-weight-bold text-center mb-4">Daftar untuk Mengakses Konten Penuh</h4>
                    
                    <ul class="list-unstyled mb-4">
                        <li class="mb-3 d-flex align-items-center">
                            <i class="fas fa-check-circle text-primary mr-3"></i> Akses seumur hidup
                        </li>
                        <li class="mb-3 d-flex align-items-center">
                            <i class="fas fa-check-circle text-primary mr-3"></i> Akses di semua perangkat
                        </li>
                        <li class="mb-3 d-flex align-items-center">
                            <i class="fas fa-check-circle text-primary mr-3"></i> Sertifikat penyelesaian
                        </li>
                        <li class="mb-3 d-flex align-items-center">
                            <i class="fas fa-check-circle text-primary mr-3"></i> Tugas & Kuis Interaktif
                        </li>
                    </ul>

                    <a href="{{ route('register') }}" class="btn btn-primary btn-lg btn-block font-weight-bold shadow-sm">
                        Daftar Sekarang
                    </a>
                    <div class="text-center mt-3">
                        <span class="text-muted">Sudah punya akun?</span> <a href="{{ route('login') }}" class="font-weight-bold">Masuk</a>
                    </div>
                </div>
            </div>
          </div>
          
        </div>
      </div>
    </div>

  </div>

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

<!-- jQuery -->
<script src="{{ asset('plugins/jquery/jquery.min.js') }}"></script>
<!-- Bootstrap 4 -->
<script src="{{ asset('plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<!-- AdminLTE App -->
<script src="{{ asset('dist/js/adminlte.min.js') }}"></script>
</body>
</html>
