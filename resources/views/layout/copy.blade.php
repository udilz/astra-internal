<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion absolute" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ route('dashboard') }}">

        <div class="sidebar-brand-text mx-5">Schedule Monitoring</div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Nav Item - Dashboard -->
    <li class="nav-item">
        <a class="nav-link" href="{{ route('dashboard') }}">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span></a>
    </li>
    <!-- Divider -->
    <hr class="sidebar-divider">

    @if(auth()->user()->level == 'Admin')
    <li class="nav-item">
        <a class="nav-link" href="{{ route('dataunit') }}">
            <i class="fa fa-plus-square" aria-hidden="true"></i>
            <span>Create Data Unit</span></a>
    </li>
    @endif

    <li class="nav-item">
        <a class="nav-link" href="{{ route('kirimunit') }}">
            <i class="fa fa-truck" aria-hidden="true"></i>
            <span>Kirim Unit</span></a>
    </li>

    <li class="nav-item">
        <a class="nav-link" href="{{ route('prosesstnk') }}">
            <i class="fa fa-address-card" aria-hidden="true"></i>
            <span>Proses STNK</span></a>
    </li>

    <li class="nav-item">
        <a class="nav-link" href="{{ route('prosespenagihan') }}">
            <i class="fa fa-credit-card" aria-hidden="true"></i>
            <span>Proses Penagihan</span></a>
    </li>


    @if(auth()->user()->level == 'Admin')
    <li class="nav-item">
        <a class="nav-link" href="{{ route('updatestatus') }}">
            <i class="fa fa-check" aria-hidden="true"></i>
            <span>Update Status</span></a>
    </li>
    @endif

    <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block">

    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>

</ul>
