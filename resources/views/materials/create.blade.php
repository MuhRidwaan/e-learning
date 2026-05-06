@extends('main')

@section('title', 'Tambah Materi')

@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Tambah Materi</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('courses.index') }}">Kelas</a></li>
                    <li class="breadcrumb-item">
                        <a href="{{ route('courses.materials.index', $course->id) }}">Materi</a>
                    </li>
                    <li class="breadcrumb-item active">Tambah</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<section class="content">
    <div class="container-fluid">
        <div class="card card-primary card-outline">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-plus mr-2"></i>
                    Tambah Materi — {{ $course->title }}
                </h3>
            </div>
            <div class="card-body">
                <form id="formMaterial"
                      action="{{ route('courses.materials.store', $course->id) }}"
                      method="POST"
                      enctype="multipart/form-data">
                    @csrf

                    <div class="row">
                        <div class="col-md-8">
                            {{-- Title --}}
                            <div class="form-group">
                                <label for="materialTitle">Judul Materi <span class="text-danger">*</span></label>
                                <input type="text"
                                       name="title"
                                       id="materialTitle"
                                       class="form-control"
                                       placeholder="Judul materi"
                                       maxlength="255"
                                       required>
                            </div>
                        </div>
                        <div class="col-md-4">
                            {{-- Order --}}
                            <div class="form-group">
                                <label for="materialOrder">Urutan <span class="text-danger">*</span></label>
                                <input type="number"
                                       name="order"
                                       id="materialOrder"
                                       class="form-control"
                                       min="0"
                                       value="0"
                                       required>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            {{-- Module --}}
                            <div class="form-group">
                                <label for="materialModule">Modul <span class="text-danger">*</span></label>
                                <select name="module_id" id="materialModule" class="form-control select2" required>
                                    <option value="">-- Pilih Modul --</option>
                                    @foreach($modules as $module)
                                    <option value="{{ $module->id }}">{{ $module->title }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            {{-- Type --}}
                            <div class="form-group">
                                <label for="materialType">Tipe Materi <span class="text-danger">*</span></label>
                                <select name="type" id="materialType" class="form-control select2" required>
                                    <option value="">-- Pilih Tipe --</option>
                                    <option value="video"><i class="fas fa-play-circle"></i> Video</option>
                                    <option value="pdf">PDF</option>
                                    <option value="text">Teks</option>
                                    <option value="link">Link</option>
                                    <option value="audio">Audio</option>
                                    <option value="image">Gambar</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    {{-- Duration (video & audio only) --}}
                    <div class="form-group" id="fieldDuration" style="display:none">
                        <label for="materialDuration">Durasi (menit)</label>
                        <input type="number"
                               name="duration_minutes"
                               id="materialDuration"
                               class="form-control"
                               min="0"
                               placeholder="Contoh: 15">
                    </div>

                    {{-- File upload (video, audio, pdf, image) --}}
                    <div class="form-group" id="fieldFile" style="display:none">
                        <label for="materialFile" id="labelFile">Upload File <span class="text-danger" id="fileRequired">*</span></label>
                        <div class="custom-file">
                            <input type="file"
                                   name="file_path"
                                   id="materialFile"
                                   class="custom-file-input"
                                   accept="">
                            <label class="custom-file-label" for="materialFile">Pilih file...</label>
                        </div>
                        <small class="form-text text-muted" id="fileHint"></small>
                    </div>

                    {{-- Content (video YouTube URL, text textarea, link URL) --}}
                    <div class="form-group" id="fieldContent" style="display:none">
                        <label for="materialContent" id="labelContent">Konten</label>
                        <textarea name="content"
                                  id="materialContent"
                                  class="form-control"
                                  rows="5"
                                  placeholder=""></textarea>
                        <small class="form-text text-muted" id="contentHint"></small>
                    </div>

                    {{-- is_preview --}}
                    <div class="form-group">
                        <div class="custom-control custom-switch">
                            <input type="checkbox"
                                   name="is_preview"
                                   id="materialIsPreview"
                                   class="custom-control-input"
                                   value="1">
                            <label class="custom-control-label" for="materialIsPreview">
                                Materi Preview (dapat diakses tanpa enrollment)
                            </label>
                        </div>
                    </div>

                    <div class="mt-3">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save mr-1"></i> Simpan Materi
                        </button>
                        <a href="{{ route('courses.materials.index', $course->id) }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left mr-1"></i> Kembali
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>
@endsection

@push('scripts')
<script>
$(document).ready(function () {

    // Initialize Select2
    $('#materialModule, #materialType').select2({
        theme: 'bootstrap4',
        width: '100%',
    });

    // Dynamic field visibility
    function toggleMaterialFields(type) {
        // Hide all conditional fields first
        $('#fieldDuration, #fieldFile, #fieldContent').hide();
        $('#materialFile').removeAttr('required');
        $('#materialContent').removeAttr('required');

        switch (type) {
            case 'video':
                $('#fieldDuration').show();
                $('#fieldFile').show();
                $('#labelFile').html('File Video <small class="text-muted">(opsional jika ada URL YouTube)</small>');
                $('#fileRequired').hide();
                $('#fileHint').text('Format: mp4, webm. Maks 100MB. Opsional jika menggunakan URL YouTube.');
                $('#fieldContent').show();
                $('#labelContent').text('URL YouTube Embed (opsional)');
                $('#materialContent').attr('placeholder', 'https://www.youtube.com/embed/...');
                $('#contentHint').text('Masukkan URL embed YouTube jika tidak upload file.');
                // Change textarea to input for URL
                $('#materialContent').attr('rows', 2);
                break;

            case 'audio':
                $('#fieldDuration').show();
                $('#fieldFile').show();
                $('#labelFile').html('File Audio <span class="text-danger">*</span>');
                $('#fileRequired').show();
                $('#fileHint').text('Format: mp3, wav. Maks 100MB.');
                $('#materialFile').attr('required', true);
                break;

            case 'pdf':
                $('#fieldFile').show();
                $('#labelFile').html('File PDF <span class="text-danger">*</span>');
                $('#fileRequired').show();
                $('#fileHint').text('Format: pdf. Maks 100MB.');
                $('#materialFile').attr('required', true);
                break;

            case 'image':
                $('#fieldFile').show();
                $('#labelFile').html('File Gambar <span class="text-danger">*</span>');
                $('#fileRequired').show();
                $('#fileHint').text('Format: jpg, jpeg, png, webp. Maks 100MB.');
                $('#materialFile').attr('required', true);
                break;

            case 'text':
                $('#fieldContent').show();
                $('#labelContent').text('Konten Teks');
                $('#materialContent').attr('placeholder', 'Tulis konten materi di sini...');
                $('#materialContent').attr('rows', 10);
                $('#contentHint').text('Mendukung HTML dasar.');
                break;

            case 'link':
                $('#fieldContent').show();
                $('#labelContent').text('URL Link');
                $('#materialContent').attr('placeholder', 'https://...');
                $('#materialContent').attr('rows', 2);
                $('#contentHint').text('Masukkan URL lengkap yang akan dibuka di tab baru.');
                break;
        }

        // Update file accept attribute
        const acceptMap = {
            video: 'video/mp4,video/webm',
            audio: 'audio/mpeg,audio/wav',
            pdf:   'application/pdf',
            image: 'image/jpeg,image/png,image/webp',
        };
        $('#materialFile').attr('accept', acceptMap[type] || '');
    }

    // Bind type change
    $('#materialType').on('change', function () {
        toggleMaterialFields($(this).val());
    });

    // Custom file label update
    $(document).on('change', '#materialFile', function () {
        const fileName = this.files[0] ? this.files[0].name : 'Pilih file...';
        $(this).next('.custom-file-label').text(fileName);
    });

    // AJAX form submit
    ajaxForm('#formMaterial');

});
</script>
@endpush
