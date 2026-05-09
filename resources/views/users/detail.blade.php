@extends('main')

@section('title', 'Detail Profile Pengguna')

@section('content')

<div class="content-wrapper">

    <section class="content-header">
        <div class="container-fluid">
            <h1>Detail Profile Pengguna</h1>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">

            <div class="card card-primary">

                <div class="card-header">
                    <h3 class="card-title">
                        Profile Pengguna
                    </h3>
                </div>

                <div class="card-body box-profile">

                    <div class="text-center mb-3">
                        <img class="profile-user-img img-fluid img-circle"
                             src="https://adminlte.io/themes/v3/dist/img/user4-128x128.jpg"
                             alt="User profile picture">
                    </div>

                    <h3 class="profile-username text-center">
                        {{ $user->name }}
                    </h3>

                    <p class="text-muted text-center">
                        {{ $user->roles->first()->name ?? 'No Role' }}
                    </p>

                    <ul class="list-group list-group-unbordered mb-3">

                        <li class="list-group-item">
                            <b>Email</b>
                            <a class="float-right">
                                {{ $user->email }}
                            </a>
                        </li>

                        <li class="list-group-item">
                            <b>No HP</b>
                            <a class="float-right">
                                {{ $user->phone ?? '-' }}
                            </a>
                        </li>

                        <li class="list-group-item">
                            <b>Status</b>

                            <span class="float-right badge badge-success">
                                {{ $user->is_active ? 'Aktif' : 'Nonaktif' }}
                            </span>
                        </li>

                    </ul>

                    <a href="{{ route('users.edit', $user->id) }}"
                       class="btn btn-primary btn-block">

                        <b>Edit Profile</b>

                    </a>

                </div>

            </div>

        </div>
    </section>

</div>

@endsection