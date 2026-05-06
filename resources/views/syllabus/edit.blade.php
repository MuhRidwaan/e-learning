@extends('main')
@section('title', 'Edit Silabus')
@section('content')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow">
                <div class="card-header bg-warning text-dark">
                    <h4 class="mb-0">Edit Silabus</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('syllabus.update', $syllabus->id) }}" method="POST">
                        @csrf
                        @method('PUT')                        
                        <div class="form-group mb-3">
                            <label>Judul Silabus</label>
                            <input type="text" name="name" class="form-control" value="{{ $syllabus->name }}" required>
                        </div>

                        <div class="form-group mb-3">
                            <label>Nama Pengajar</label>
                            <input type="text" name="instructor" class="form-control" placeholder="Contoh: Budi Santoso" value="{{ $syllabus->instructor }}" required>
                        </div>

                        <div class="form-group mb-3">
                            <label>Durasi</label>
                            <input type="number" name="duration_weeks" class="form-control" value="{{ $syllabus->duration_weeks }}" required> 
                        </div>

                        <div class="form-group mb-3">
                            <label>Nama File Gambar</label>
                            <input type="text" name="theme" class="form-control" value="{{ $syllabus->theme }}" required>
                        </div>

                        <div class="form-group mb-3">
                            <label>Deskripsi</label>
                            <textarea name="description" class="form-control" rows="4" required>{{ $syllabus->description }}</textarea>
                        </div>


                        <div class="d-flex justify-content-between">
                            <a href="{{ route('syllabus.index') }}" class="btn btn-secondary">Batal</a>
                            <button type="submit" class="btn btn-primary">Perbarui Data</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection