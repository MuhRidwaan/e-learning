@include('layouts.header')
<!-- Navigasi -->
@include('layouts.nav')
<!-- Sidebar -->
@include('layouts.sidebar')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">

    <!-- Content -->
    @yield('content')

    <!-- /.content -->
</div>
<!-- Footer -->
@include('layouts.footer')
