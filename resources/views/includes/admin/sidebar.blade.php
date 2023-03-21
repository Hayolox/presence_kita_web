   <!-- Sidebar -->
   <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Divider -->
    <hr class="sidebar-divider my-0">


    @if (auth()->guard('web')->check())
        <!-- Nav Item - Dashboard -->
        <li class="nav-item active">
            <a class="nav-link" href="{{ route('Dashboard') }}">
                <i class="fas fa-fw fa-tachometer-alt"></i>
                <span>Dashboard</span></a>
        </li>

        <!-- Divider -->
        <hr class="sidebar-divider">


        <!-- Nav Item - Charts -->
        <li class="nav-item">
            <a class="nav-link" href="{{ route('ManageSubject.index') }}">
                <span>Kelola Mata Kuliah</span></a>
        </li>

        <!-- Nav Item - Charts -->
        <li class="nav-item">
            <a class="nav-link" href="{{ route('ManageLecturer.index') }}">
                <span>Kelola Dosen</span></a>
        </li>


        <!-- Nav Item - Charts -->
        <li class="nav-item">
            <a class="nav-link" href="{{ route('ManageStudent.index') }}">
                <span>Kelola Mahasiswa</span></a>
        </li>

        <!-- Nav Item - Charts -->
        <li class="nav-item">
            <a class="nav-link" href="{{ route('ManagePresence') }}">
                <span>Kelola Presensi</span></a>
        </li>

        <!-- Nav Item - Charts -->
        <li class="nav-item">
            <a class="nav-link" href="{{ route('ManagePresencePratikum') }}">
                <span>Kelola Presensi Pratikum</span></a>
        </li>

        <!-- Nav Item - Charts -->
        <li class="nav-item">
            <a class="nav-link" href="{{ route('ManageSystem.index') }}">
                <span>Kelola Sistem</span></a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{ route('check.login') }}">
                <span>Kelola Kecurangan</span></a>
        </li>

        <li class="nav-item">
            <a class="nav-link" href="{{ route('change.password.admin') }}">
                <span>Ubah Password</span></a>
        </li>


        <li class="nav-item">
            <a class="nav-link" href="{{ route('ManageSUS') }}">
                <span>SUS</span></a>
        </li>
    @endif

    @if (auth()->guard('lecturer')->check())
        <!-- Nav Item - Charts -->
        <li class="nav-item">
            <a class="nav-link" href="{{ route('ManagePresence') }}">
                <span>Kelola Presensi</span></a>
        </li>
    @endif

    <li class="nav-item">
        <a class="nav-link" href="{{ route('login.logout') }}">
            <span>Logout</span></a>
    </li>
    <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block">




</ul>
<!-- End of Sidebar -->
