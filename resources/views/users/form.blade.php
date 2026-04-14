@extends('main')

@php $editUser = $user ?? null; @endphp

@section('title', $editUser ? 'Edit User' : 'Tambah User')

@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">{{ $editUser ? 'Edit User' : 'Tambah User' }}</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('users.index') }}">User</a></li>
                    <li class="breadcrumb-item active">{{ $editUser ? 'Edit' : 'Tambah' }}</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<section class="content">
    <div class="container-fluid">
        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title">{{ $editUser ? 'Edit User' : 'Form Tambah User' }}</h3>
            </div>

            <form id="userForm" action="{{ $editUser ? route('users.update', $editUser) : route('users.store') }}" method="POST">
                @csrf
                @if($editUser) @method('PUT') @endif

                <div class="card-body">

                    @if($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach($errors->all() as $err)
                                    <li>{{ $err }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Nama <span class="text-danger">*</span></label>
                                <input type="text" name="name"
                                       class="form-control @error('name') is-invalid @enderror"
                                       value="{{ old('name', $editUser->name ?? '') }}"
                                       placeholder="Nama lengkap">
                                @error('name') <span class="invalid-feedback">{{ $message }}</span> @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Email <span class="text-danger">*</span></label>
                                <input type="email" name="email"
                                       class="form-control @error('email') is-invalid @enderror"
                                       value="{{ old('email', $editUser->email ?? '') }}"
                                       placeholder="email@example.com">
                                @error('email') <span class="invalid-feedback">{{ $message }}</span> @enderror
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>
                                    Password
                                    @if($editUser) <small class="text-muted">(kosongkan jika tidak diubah)</small> @endif
                                    @if(!$editUser) <span class="text-danger">*</span> @endif
                                </label>
                                <input type="password" name="password"
                                       class="form-control @error('password') is-invalid @enderror"
                                       placeholder="Password">
                                @error('password') <span class="invalid-feedback">{{ $message }}</span> @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Konfirmasi Password</label>
                                <input type="password" name="password_confirmation"
                                       class="form-control" placeholder="Ulangi password">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>No. Telepon</label>
                                <input type="text" name="phone" class="form-control"
                                       value="{{ old('phone', $editUser->phone ?? '') }}"
                                       placeholder="08xxxxxxxxxx">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Role <span class="text-danger">*</span></label>
                                <select name="role_id" class="form-control select2 @error('role_id') is-invalid @enderror">
                                    <option value="">-- Pilih Role --</option>
                                    @foreach($roles as $roleItem)
                                        <option value="{{ $roleItem->id }}"
                                            {{ old('role_id', $editUser?->roles?->first()?->id ?? '') == $roleItem->id ? 'selected' : '' }}>
                                            {{ $roleItem->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('role_id') <span class="invalid-feedback">{{ $message }}</span> @enderror
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="custom-control custom-switch">
                            <input type="checkbox" class="custom-control-input" id="is_active"
                                   name="is_active" value="1"
                                   {{ old('is_active', $editUser->is_active ?? true) ? 'checked' : '' }}>
                            <label class="custom-control-label" for="is_active">User Aktif</label>
                        </div>
                    </div>

                </div>

                <div class="card-footer">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> {{ $editUser ? 'Update' : 'Simpan' }}
                    </button>
                    <a href="{{ route('users.index') }}" class="btn btn-secondary ml-2">
                        <i class="fas fa-arrow-left"></i> Kembali
                    </a>
                </div>
            </form>
        </div>
    </div>
</section>
@endsection

@push('scripts')
<script>
    $(document).ready(function () {
        $('.select2').select2({ theme: 'bootstrap4', placeholder: '-- Pilih Role --' });
    });
    ajaxForm('#userForm');
</script>
@endpush
