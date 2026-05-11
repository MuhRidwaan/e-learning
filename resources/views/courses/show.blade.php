@extends('main')

@section('title', 'Detail Kelas — ' . $course->title)

@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 font-weight-bold">Detail Kelas</h1>
            </div>
        </div>
    </div>
</div>

<section class="content">
    <div class="container-fluid">
        <div class="row">
            {{-- Bagian Tengah --}}
            <div class="col-lg-8 col-md-12 mb-4">
                <div class="card shadow-sm border-0" style="border-radius: 15px;">
                    <div class="card-body p-4">
                        {{-- 1. Judul Kelas --}}
                        <div class="mb-3">
                            @php
                                $statusClass = $course->status === 'published' ? 'success' : ($course->status === 'archived' ? 'secondary' : 'warning');
                            @endphp
                            <span class="badge badge-{{ $statusClass }} px-3 py-2 mr-2 mb-2" style="border-radius: 20px;">
                                {{ ucfirst($course->status) }}
                            </span>
                            @if($course->duration_weeks)
                                <span class="badge badge-info px-3 py-2 mb-2" style="border-radius: 20px;">
                                    {{ $course->duration_weeks }} minggu
                                </span>
                            @endif
                        </div>
                        <h2 class="font-weight-bold text-dark mb-3">{{ $course->title }}</h2>
                        
                        {{-- 2. Deskripsi singkat Kelas --}}
                        @if($course->description)
                            <p class="text-muted" style="font-size: 1.1rem; line-height: 1.6;">
                                {{ $course->description }}
                            </p>
                        @else
                            <p class="text-muted" style="font-size: 1.1rem; line-height: 1.6;">
                                Deskripsi kelas belum tersedia.
                            </p>
                        @endif

                        {{-- 3. Thumbnail Kelas --}}
                        @php
                            $thumb = $course->thumbnail;
                            $thumbUrl = $thumb
                                ? (Str::startsWith($thumb, ['http://', 'https://'])
                                    ? $thumb
                                    : (Str::startsWith($thumb, ['img/', 'storage/']) ? asset($thumb) : asset('storage/' . ltrim($thumb, '/'))))
                                : asset('img/images.jpg');
                        @endphp
                        <div class="mt-4">
                            <img src="{{ $thumbUrl }}" alt="{{ $course->title }}" class="img-fluid rounded shadow-sm" style="width: 100%; max-height: 420px; object-fit: cover;">
                        </div>
                        
                        <div class="mt-4 pt-3 border-top">
                            <a href="{{ route('assignments.index') }}" class="btn btn-primary rounded-pill px-4 py-2 font-weight-bold shadow-sm mr-2">
                                <i class="fas fa-book-open mr-2"></i> Tugas
                            </a>
                            <a href="{{ route('courses.materials.index', $course->id) }}" class="btn btn-outline-secondary rounded-pill px-4 py-2 font-weight-bold mr-2">
                                Mulai Materi
                            </a>
                            <a href="{{ route('forum.index', $course->id) }}" class="btn btn-outline-primary rounded-pill px-4 py-2 font-weight-bold">
                                Forum Diskusi
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Sisi Kanan (Profile Pengajar) --}}
            <div class="col-lg-4 col-md-12">
                <div class="card shadow-sm border-0 sticky-top" style="border-radius: 15px; top: 20px;">
                    <div class="card-header bg-transparent border-0 pt-4 px-4 pb-0 text-center">
                        <h5 class="font-weight-bold mb-0">Profile Pengajar</h5>
                    </div>
                    <div class="card-body px-4 text-center">
                        <div class="position-relative d-inline-block mb-3">
                            @php $instructorName = optional($course->instructor)->name ?? 'Pengajar'; @endphp
                            <img src="{{ 'https://ui-avatars.com/api/?name=' . urlencode($instructorName) . '&background=4f46e5&color=fff&size=128' }}" alt="Tutor" class="img-circle shadow" style="width: 120px; height: 120px; object-fit: cover; border: 4px solid #fff;">
                            <span class="position-absolute bottom-0 right-0 bg-success border border-white rounded-circle" style="width: 20px; height: 20px; right: 10px; bottom: 5px;" title="Online"></span>
                        </div>
                        
                        <h4 class="font-weight-bold mb-1">{{ $instructorName }}</h4>
                        <p class="text-primary font-weight-bold mb-3">
                            <i class="fas fa-check-circle mr-1"></i>Pengajar
                        </p>
                        
                        <p class="text-muted text-justify mb-4" style="font-size: 0.9rem; line-height: 1.5;">
                            Instruktur untuk kelas ini.
                        </p>

                        <hr class="mb-4">

                        <div class="row text-center mb-4">
                            <div class="col-6 border-right">
                                <h5 class="font-weight-bold mb-0">{{ $course->duration_weeks ?? '—' }}</h5>
                                <small class="text-muted">Minggu</small>
                            </div>
                            <div class="col-6">
                                <h5 class="font-weight-bold mb-0">{{ $course->max_students ?? '—' }}</h5>
                                <small class="text-muted">Maks. Siswa</small>
                            </div>
                        </div>

                        <div class="mt-4 pt-3 border-top text-left">
                            <h6 class="font-weight-bold mb-2"><i class="fas fa-info-circle text-secondary mr-2"></i>Info</h6>
                            <small class="text-muted d-block">Kelas ini terhubung ke modul materi dan forum diskusi.</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
