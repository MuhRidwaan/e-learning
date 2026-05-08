<!DOCTYPE html>
<html>
<head>
    <title>Profile</title>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/css/adminlte.min.css">

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">

</head>

<body class="hold-transition sidebar-mini">

<div class="wrapper">

    <div class="content-wrapper p-4">

        <div class="content-header">
            <h1>Profile</h1>
        </div>

        <section class="content">

            <div class="container-fluid">

                <div class="row">

                    {{-- LEFT PROFILE --}}
                    <div class="col-md-4">

                        <div class="card card-primary card-outline">

                            <div class="card-body box-profile text-center">

                                <img
                                    class="profile-user-img img-fluid img-circle"
                                    src="https://i.pravatar.cc/150"
                                >

                                <h3 class="profile-username mt-3">
                                    Budi Sulistiyo
                                </h3>

                                <p class="text-muted">
                                    Fullstack Developer
                                </p>

                            </div>

                        </div>

                    </div>

                    {{-- RIGHT FORM --}}
                    <div class="col-md-8">

                        <div class="card">

                            <div class="card-header bg-primary">
                                <h3 class="card-title">
                                    Setting Form
                                </h3>
                            </div>

                            <div class="card-body">

                                <form
                                    action="/profile/update"
                                    method="POST"
                                    enctype="multipart/form-data"
                                >

                                    @csrf

                                    {{-- NAME --}}
                                    <div class="form-group mb-3">
                                        <label>Nama Lengkap</label>

                                        <input
                                            type="text"
                                            name="name"
                                            class="form-control"
                                            required
                                        >
                                    </div>

                                    {{-- EMAIL --}}
                                    <div class="form-group mb-3">
                                        <label>Email</label>

                                        <input
                                            type="email"
                                            name="email"
                                            class="form-control"
                                            required
                                        >
                                    </div>

                                    {{-- PHONE --}}
                                    <div class="form-group mb-3">
                                        <label>No HP</label>

                                        <input
                                            type="text"
                                            name="phone"
                                            class="form-control"
                                        >
                                    </div>

                                    {{-- BIO --}}
                                    <div class="form-group mb-3">
                                        <label>Bio</label>

                                        <textarea
                                            name="bio"
                                            class="form-control"
                                            rows="4"
                                        ></textarea>
                                    </div>

                                    {{-- AVATAR --}}
                                    <div class="form-group mb-3">
                                        <label>Avatar</label>

                                        <input
                                            type="file"
                                            name="avatar"
                                            class="form-control"
                                        >
                                    </div>

                                    {{-- PASSWORD --}}
                                    <div class="form-group mb-3">
                                        <label>Password Baru</label>

                                        <input
                                            type="password"
                                            name="password"
                                            class="form-control"
                                        >
                                    </div>

                                    {{-- PASSWORD CONFIRM --}}
                                    <div class="form-group mb-3">
                                        <label>Konfirmasi Password</label>

                                        <input
                                            type="password"
                                            name="password_confirmation"
                                            class="form-control"
                                        >
                                    </div>

                                    <button class="btn btn-primary">
                                        Update Profile
                                    </button>

                                </form>

                            </div>

                        </div>

                    </div>

                </div>

            </div>

        </section>

    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<script src="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/js/adminlte.min.js"></script>

</body>
</html>