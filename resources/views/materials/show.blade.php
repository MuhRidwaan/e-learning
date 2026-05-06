@extends('main')

@section('title', $material->title)

@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-8">
                <h1 class="m-0" style="font-size:1.3rem">{{ $material->title }}</h1>
            </div>
            <div class="col-sm-4">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('courses.index') }}">Kelas</a></li>
                    <li class="breadcrumb-item">
                        <a href="{{ route('courses.materials.index', $course->id) }}">Materi</a>
                    </li>
                    <li class="breadcrumb-item active">{{ Str::limit($material->title, 30) }}</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<section class="content">
    <div class="container-fluid">
        <div class="row">

            {{-- Main content --}}
            <div class="col-lg-9">
                <div class="card card-primary card-outline">
                    <div class="card-header">
                        <div class="d-flex align-items-center justify-content-between flex-wrap">
                            <div>
                                <h5 class="card-title mb-0">{{ $material->title }}</h5>
                                <div class="mt-1" style="gap:4px; display:flex; flex-wrap:wrap">
                                    <span class="badge badge-secondary">
                                        @switch($material->type)
                                            @case('video') <i class="fas fa-play-circle mr-1"></i>Video @break
                                            @case('pdf')   <i class="fas fa-file-pdf mr-1"></i>PDF @break
                                            @case('text')  <i class="fas fa-file-alt mr-1"></i>Teks @break
                                            @case('link')  <i class="fas fa-link mr-1"></i>Link @break
                                            @case('audio') <i class="fas fa-headphones mr-1"></i>Audio @break
                                            @case('image') <i class="fas fa-image mr-1"></i>Gambar @break
                                        @endswitch
                                    </span>
                                    @if($material->is_preview)
                                    <span class="badge badge-info">
                                        <i class="fas fa-eye mr-1"></i>Preview
                                    </span>
                                    @endif
                                    @if($material->duration_minutes)
                                    <span class="badge badge-light border">
                                        <i class="fas fa-clock mr-1"></i>{{ $material->duration_minutes }} menit
                                    </span>
                                    @endif
                                </div>
                            </div>
                            {{-- Pengajar actions --}}
                            @if($isPengajar)
                            <div class="d-flex" style="gap:6px">
                                <a href="{{ route('courses.materials.edit', [$course->id, $material->id]) }}"
                                   class="btn btn-warning btn-sm">
                                    <i class="fas fa-edit mr-1"></i>Edit
                                </a>
                                <button type="button"
                                        class="btn btn-danger btn-sm btn-delete-material"
                                        data-url="{{ route('courses.materials.destroy', [$course->id, $material->id]) }}">
                                    <i class="fas fa-trash mr-1"></i>Hapus
                                </button>
                            </div>
                            @endif
                        </div>
                    </div>

                    <div class="card-body">
                        {{-- ── Content Viewer ─────────────────────────────────── --}}

                        @if($material->type === 'video')
                            @if($material->file_path)
                            {{-- HTML5 Video Player --}}
                            <div class="embed-responsive embed-responsive-16by9 mb-3">
                                <video id="mediaPlayer"
                                       class="embed-responsive-item"
                                       controls
                                       controlsList="nodownload"
                                       data-material-id="{{ $material->id }}"
                                       data-last-position="{{ $progress->last_position ?? 0 }}">
                                    <source src="{{ asset('storage/' . $material->file_path) }}"
                                            type="video/mp4">
                                    Browser Anda tidak mendukung tag video.
                                </video>
                            </div>
                            @elseif($material->content)
                            {{-- YouTube Embed --}}
                            <div class="embed-responsive embed-responsive-16by9 mb-3">
                                <iframe class="embed-responsive-item"
                                        src="{{ $material->content }}"
                                        allowfullscreen
                                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture">
                                </iframe>
                            </div>
                            @endif

                        @elseif($material->type === 'pdf')
                            <div class="mb-3">
                                <embed src="{{ asset('storage/' . $material->file_path) }}"
                                       type="application/pdf"
                                       width="100%"
                                       height="600px"
                                       class="border rounded">
                                <div class="mt-2">
                                    <a href="{{ asset('storage/' . $material->file_path) }}"
                                       target="_blank"
                                       class="btn btn-outline-danger btn-sm">
                                        <i class="fas fa-external-link-alt mr-1"></i>Buka di Tab Baru
                                    </a>
                                </div>
                            </div>

                        @elseif($material->type === 'text')
                            <div class="material-text-content p-3 border rounded bg-white">
                                {!! $material->content !!}
                            </div>

                        @elseif($material->type === 'link')
                            <div class="text-center py-4">
                                <i class="fas fa-link fa-3x text-primary mb-3 d-block"></i>
                                <p class="text-muted mb-3">Klik tombol di bawah untuk membuka link materi.</p>
                                <a href="{{ $material->content }}"
                                   target="_blank"
                                   rel="noopener noreferrer"
                                   class="btn btn-primary btn-lg">
                                    <i class="fas fa-external-link-alt mr-2"></i>Buka Link
                                </a>
                                <div class="mt-2">
                                    <small class="text-muted">{{ $material->content }}</small>
                                </div>
                            </div>

                        @elseif($material->type === 'audio')
                            <div class="text-center py-3">
                                <i class="fas fa-headphones fa-3x text-warning mb-3 d-block"></i>
                                <audio id="mediaPlayer"
                                       controls
                                       class="w-100"
                                       data-material-id="{{ $material->id }}"
                                       data-last-position="{{ $progress->last_position ?? 0 }}">
                                    <source src="{{ asset('storage/' . $material->file_path) }}"
                                            type="audio/mpeg">
                                    Browser Anda tidak mendukung tag audio.
                                </audio>
                            </div>

                        @elseif($material->type === 'image')
                            <div class="text-center">
                                <img src="{{ asset('storage/' . $material->file_path) }}"
                                     alt="{{ $material->title }}"
                                     class="img-fluid rounded border"
                                     style="max-height:600px">
                            </div>
                        @endif

                    </div>

                    <div class="card-footer">
                        <a href="{{ route('courses.materials.index', $course->id) }}"
                           class="btn btn-secondary btn-sm">
                            <i class="fas fa-arrow-left mr-1"></i>Kembali ke Daftar Materi
                        </a>
                    </div>
                </div>
            </div>

            {{-- Sidebar: progress & bookmark --}}
            <div class="col-lg-3">

                {{-- Progress Card (enrolled students only) --}}
                @if($isEnrolled && !$isPengajar)
                <div class="card card-outline card-success">
                    <div class="card-header py-2">
                        <h6 class="card-title mb-0">
                            <i class="fas fa-tasks mr-2 text-success"></i>Progress
                        </h6>
                    </div>
                    <div class="card-body text-center">
                        @if($progress && $progress->is_completed)
                        <div id="progressStatus" class="mb-2">
                            <span class="badge badge-success badge-lg px-3 py-2">
                                <i class="fas fa-check-circle mr-1"></i>Selesai
                            </span>
                            @if($progress->completed_at)
                            <div class="mt-1">
                                <small class="text-muted">
                                    {{ $progress->completed_at->format('d M Y H:i') }}
                                </small>
                            </div>
                            @endif
                        </div>
                        @else
                        <div id="progressStatus" class="mb-2">
                            <span class="badge badge-secondary badge-lg px-3 py-2">
                                <i class="far fa-circle mr-1"></i>Belum Selesai
                            </span>
                        </div>
                        @endif

                        <button type="button"
                                id="btnMarkComplete"
                                class="btn btn-success btn-sm btn-block mt-2"
                                data-material-id="{{ $material->id }}"
                                data-completed="{{ $progress && $progress->is_completed ? '1' : '0' }}">
                            @if($progress && $progress->is_completed)
                            <i class="fas fa-undo mr-1"></i>Tandai Belum Selesai
                            @else
                            <i class="fas fa-check mr-1"></i>Tandai Selesai
                            @endif
                        </button>
                    </div>
                </div>

                {{-- Bookmark Card --}}
                <div class="card card-outline card-warning">
                    <div class="card-header py-2">
                        <h6 class="card-title mb-0">
                            <i class="fas fa-bookmark mr-2 text-warning"></i>Bookmark
                        </h6>
                    </div>
                    <div class="card-body text-center">
                        <button type="button"
                                id="btnBookmark"
                                class="btn btn-sm btn-block {{ $isBookmarked ? 'btn-warning' : 'btn-outline-warning' }}"
                                data-material-id="{{ $material->id }}"
                                data-bookmarked="{{ $isBookmarked ? '1' : '0' }}">
                            @if($isBookmarked)
                            <i class="fas fa-bookmark mr-1"></i>Hapus Bookmark
                            @else
                            <i class="far fa-bookmark mr-1"></i>Tambah Bookmark
                            @endif
                        </button>
                    </div>
                </div>
                @endif

                {{-- Module info --}}
                <div class="card card-outline card-secondary">
                    <div class="card-header py-2">
                        <h6 class="card-title mb-0">
                            <i class="fas fa-folder-open mr-2"></i>Modul
                        </h6>
                    </div>
                    <div class="card-body py-2">
                        <p class="mb-0 font-weight-bold">{{ $material->module->title }}</p>
                        @if($material->module->description)
                        <small class="text-muted">{{ $material->module->description }}</small>
                        @endif
                    </div>
                </div>

            </div>
        </div>
    </div>
</section>
@endsection

@push('scripts')
<script>
$(document).ready(function () {

    const CSRF = $('meta[name="csrf-token"]').attr('content');

    // ── Media player: restore last position ──────────────────────────────
    const $player = $('#mediaPlayer');
    if ($player.length) {
        const lastPos = parseFloat($player.data('last-position')) || 0;
        if (lastPos > 0) {
            $player[0].addEventListener('loadedmetadata', function () {
                this.currentTime = lastPos;
            });
        }

        // Save last position — debounced
        let saveTimer = null;
        $player[0].addEventListener('timeupdate', function () {
            const pos = Math.floor(this.currentTime);
            clearTimeout(saveTimer);
            saveTimer = setTimeout(function () {
                saveLastPosition($player.data('material-id'), pos);
            }, 3000);
        });
    }

    // ── Save last position ────────────────────────────────────────────────
    function saveLastPosition(materialId, position) {
        const courseId = {{ $course->id }};
        $.ajax({
            url: '/courses/' + courseId + '/materials/' + materialId + '/progress',
            type: 'POST',
            data: {
                _token:        CSRF,
                last_position: position,
                is_completed:  0,
            },
            // Silent — no notification
        });
    }

    // ── Mark complete / incomplete ────────────────────────────────────────
    $('#btnMarkComplete').on('click', function () {
        const btn         = $(this);
        const materialId  = btn.data('material-id');
        const isCompleted = btn.data('completed') == '1';
        const courseId    = {{ $course->id }};

        btn.prop('disabled', true);

        $.ajax({
            url: '/courses/' + courseId + '/materials/' + materialId + '/progress',
            type: 'POST',
            data: {
                _token:       CSRF,
                is_completed: isCompleted ? 0 : 1,
            },
            success: function (res) {
                btn.prop('disabled', false);

                if (res.is_completed) {
                    btn.data('completed', '1')
                       .removeClass('btn-success').addClass('btn-outline-success')
                       .html('<i class="fas fa-undo mr-1"></i>Tandai Belum Selesai');
                    $('#progressStatus').html(`
                        <span class="badge badge-success badge-lg px-3 py-2">
                            <i class="fas fa-check-circle mr-1"></i>Selesai
                        </span>`);
                } else {
                    btn.data('completed', '0')
                       .removeClass('btn-outline-success').addClass('btn-success')
                       .html('<i class="fas fa-check mr-1"></i>Tandai Selesai');
                    $('#progressStatus').html(`
                        <span class="badge badge-secondary badge-lg px-3 py-2">
                            <i class="far fa-circle mr-1"></i>Belum Selesai
                        </span>`);
                }

                Swal.fire({
                    icon: 'success', title: 'Berhasil!', text: res.message,
                    toast: true, position: 'top-end', timer: 2000, showConfirmButton: false,
                });
            },
            error: function () {
                btn.prop('disabled', false);
                Swal.fire('Error', 'Gagal memperbarui progress.', 'error');
            }
        });
    });

    // ── Bookmark toggle ───────────────────────────────────────────────────
    $('#btnBookmark').on('click', function () {
        const btn        = $(this);
        const materialId = btn.data('material-id');
        const courseId   = {{ $course->id }};

        btn.prop('disabled', true);

        $.ajax({
            url: '/courses/' + courseId + '/materials/' + materialId + '/bookmark',
            type: 'POST',
            data: { _token: CSRF },
            success: function (res) {
                btn.prop('disabled', false);

                if (res.is_bookmarked) {
                    btn.data('bookmarked', '1')
                       .removeClass('btn-outline-warning').addClass('btn-warning')
                       .html('<i class="fas fa-bookmark mr-1"></i>Hapus Bookmark');
                } else {
                    btn.data('bookmarked', '0')
                       .removeClass('btn-warning').addClass('btn-outline-warning')
                       .html('<i class="far fa-bookmark mr-1"></i>Tambah Bookmark');
                }

                Swal.fire({
                    icon: 'success', title: 'Berhasil!', text: res.message,
                    toast: true, position: 'top-end', timer: 2000, showConfirmButton: false,
                });
            },
            error: function () {
                btn.prop('disabled', false);
                Swal.fire('Error', 'Gagal memperbarui bookmark.', 'error');
            }
        });
    });

    // ── Delete material ───────────────────────────────────────────────────
    ajaxDelete('.btn-delete-material', 'Hapus materi ini?');

});
</script>
@endpush
