@extends('main')
@section('title', 'Catalog Course')
@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Catalog Courses</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item active">Kelas</li>
                </ol>
            </div>
        </div>
    </div>
</div>
<section>
<!-- CARD 1 -->
    <div class="col-md-6">
      <div class="card p-3 shadow-sm h-100">
        <div class="d-flex">
          <img src="../../../dist/assets/img/avatar.png"
               class="rounded"
               style="width: 60px; height: 60px; object-fit: cover;">

          <div class="ms-3 flex-grow-1">
            <h5 class="mb-1">Sejarah</h5>
            <small class="text-muted">Tutor: Alexander Graham</small>

            <div class="mt-2 text-muted">
              🙍‍♂️ 125 Peserta
            </div>

            <p class="mt-2 mb-0">
              Belajar aljabar, geometri, trigonometri, dan kalkulus.
            </p>
          </div>
        </div>
</section>
@endsection