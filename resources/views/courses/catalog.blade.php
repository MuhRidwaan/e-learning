@extends('main')
@section('content')
<div class="col-sm-6 col-md-4">
  <div class="card p-3 shadow-sm h-100">
    <div class="d-flex">
      <img src="{{ $image }}"
           class="rounded"
           style="width: 60px; height: 60px; object-fit: cover;">

      <div class="ms-3 flex-grow-1">
        <h5 class="mb-1">{{ $title }}</h5>
        <small class="text-muted">Tutor: {{ $tutor }}</small>

        <div class="mt-2 text-muted">
          👤 {{ $peserta }} Peserta
        </div>

        <p class="mt-2 mb-0">
          {{ $deskripsi }}
        </p>
      </div>
    </div>

    <div class="d-flex justify-content-end mt-3">
      <a href="{{ $link }}" class="btn btn-primary">Ikuti</a>
    </div>
  </div>
</div>

@endsection