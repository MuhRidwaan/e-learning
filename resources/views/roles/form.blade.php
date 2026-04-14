@extends('main')

@section('title', isset($role) ? 'Edit Role' : 'Tambah Role')

@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">{{ isset($role) ? 'Edit Role' : 'Tambah Role' }}</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('roles.index') }}">Roles</a></li>
                    <li class="breadcrumb-item active">{{ isset($role) ? 'Edit' : 'Tambah' }}</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<section class="content">
    <div class="container-fluid">
            <form id="roleForm" action="{{ isset($role) ? route('roles.update', $role) : route('roles.store') }}" method="POST">
            @csrf
            @if(isset($role)) @method('PUT') @endif

            @if($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach
                    </ul>
                </div>
            @endif

            {{-- Info Role --}}
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">Informasi Role</h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Nama Role <span class="text-danger">*</span></label>
                                <input type="text" name="name"
                                       class="form-control @error('name') is-invalid @enderror"
                                       value="{{ old('name', $role->name ?? '') }}"
                                       placeholder="contoh: pengajar">
                                @error('name') <span class="invalid-feedback">{{ $message }}</span> @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Deskripsi</label>
                                <input type="text" name="description" class="form-control"
                                       value="{{ old('description', $role->description ?? '') }}"
                                       placeholder="Deskripsi singkat role">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Permissions --}}
            <div class="card card-secondary">
                <div class="card-header">
                    <h3 class="card-title mb-0">Permissions</h3>
                    <div class="card-tools">
                        <button type="button" class="btn btn-sm btn-light border" id="toggleAll">
                            <i class="fas fa-check-square mr-1"></i> Pilih Semua
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        @foreach($permissions as $module => $perms)
                        @php $moduleId = 'module_' . Str::slug($module); @endphp
                        <div class="col-md-4 col-sm-6 mb-3">
                            <div class="card card-outline card-primary h-100 mb-0">
                                <div class="card-header py-2 d-flex justify-content-between align-items-center">
                                    <h6 class="card-title mb-0 text-uppercase">
                                        <i class="fas fa-layer-group mr-1 text-primary"></i>
                                        {{ $module }}
                                    </h6>
                                    <span class="badge badge-primary module-badge" data-module="{{ $moduleId }}">
                                        {{ $perms->filter(fn($p) => (isset($role) && $role->permissions->contains($p->id)) || in_array($p->id, old('permissions', [])))->count() }}/{{ $perms->count() }}
                                    </span>
                                </div>
                                <div class="card-body py-2">
                                    @foreach($perms as $permission)
                                    <div class="custom-control custom-checkbox mb-1">
                                        <input type="checkbox"
                                               class="custom-control-input perm-check"
                                               data-module="{{ $moduleId }}"
                                               id="perm_{{ $permission->id }}"
                                               name="permissions[]"
                                               value="{{ $permission->id }}"
                                               {{ (isset($role) && $role->permissions->contains($permission->id)) || in_array($permission->id, old('permissions', [])) ? 'checked' : '' }}>
                                        <label class="custom-control-label" for="perm_{{ $permission->id }}">
                                            <code class="text-sm">{{ $permission->name }}</code>
                                        </label>
                                    </div>
                                    @endforeach
                                </div>
                                <div class="card-footer py-1">
                                    <button type="button" class="btn btn-xs btn-outline-primary toggle-module"
                                            data-module="{{ $moduleId }}">
                                        Pilih Semua
                                    </button>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <div class="mb-4">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i> {{ isset($role) ? 'Update' : 'Simpan' }}
                </button>
                <a href="{{ route('roles.index') }}" class="btn btn-secondary ml-2">
                    <i class="fas fa-arrow-left"></i> Kembali
                </a>
            </div>

        </form>
    </div>
</section>

@push('scripts')
<script>
    $(document).ready(function () {
        $('.select2').select2({ theme: 'bootstrap4' });
    });

    ajaxForm('#roleForm');

    function updateBadge(moduleId) {
        const checks  = document.querySelectorAll(`.perm-check[data-module="${moduleId}"]`);
        const checked = [...checks].filter(c => c.checked).length;
        const badge   = document.querySelector(`.module-badge[data-module="${moduleId}"]`);
        if (badge) badge.textContent = `${checked}/${checks.length}`;
    }

    document.getElementById('toggleAll').addEventListener('click', function () {
        const checks     = document.querySelectorAll('.perm-check');
        const allChecked = [...checks].every(c => c.checked);
        checks.forEach(c => c.checked = !allChecked);
        document.querySelectorAll('.module-badge').forEach(b => updateBadge(b.dataset.module));
        this.innerHTML = allChecked
            ? '<i class="fas fa-check-square mr-1"></i> Pilih Semua'
            : '<i class="fas fa-minus-square mr-1"></i> Hapus Semua';
    });

    document.querySelectorAll('.toggle-module').forEach(btn => {
        btn.addEventListener('click', function () {
            const moduleId   = this.dataset.module;
            const checks     = document.querySelectorAll(`.perm-check[data-module="${moduleId}"]`);
            const allChecked = [...checks].every(c => c.checked);
            checks.forEach(c => c.checked = !allChecked);
            updateBadge(moduleId);
            this.textContent = allChecked ? 'Pilih Semua' : 'Hapus Semua';
        });
    });

    document.querySelectorAll('.perm-check').forEach(c => {
        c.addEventListener('change', () => updateBadge(c.dataset.module));
    });
</script>
@endpush
@endsection
