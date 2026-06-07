<nav class="sidebar sidebar-offcanvas" id="sidebar">
    <ul class="nav">
        <li class="nav-item">
            <a class="nav-link" href="{{ route('home') }}">
                <span class="menu-title">Dashboard</span>
                <i class="mdi mdi-home menu-icon"></i>
            </a>
        </li>

        <li class="nav-item border-bottom">
            <a class="nav-link" data-bs-toggle="collapse" href="#cust-menu" aria-expanded="false" aria-controls="cust-menu">
                <span class="menu-title">Customer</span>
                <i class="mdi mdi-account-multiple menu-icon"></i>
                <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="cust-menu">
                <ul class="nav flex-column sub-menu">
                    <li class="nav-item"> 
                        <a class="nav-link" href="{{ route('customer.index') }}">Data Customer</a>
                    </li>
                    <li class="nav-item"> 
                        <a class="nav-link" href="{{ route('customer.create1') }}">Tambah Customer 1 (Blob)</a>
                    </li>
                    <li class="nav-item"> 
                        <a class="nav-link" href="{{ route('customer.create2') }}">Tambah Customer 2 (Path)</a>
                    </li>
                </ul>
            </div>
        </li>

        <li class="nav-item">
            <a class="nav-link" href="{{ route('barang.index') }}"> 
                <span class="menu-title">Tag Harga (Barcode)</span>
                <i class="mdi mdi-barcode menu-icon"></i>
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link" href="{{ route('scan.barcode') }}"> 
                <span class="menu-title">Scanner Barcode</span>
                <i class="mdi mdi-barcode-scan menu-icon"></i>
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link" href="{{ route('riwayat') }}">
                <span class="menu-title">Riwayat & QR Struk</span>
                <i class="mdi mdi-receipt menu-icon"></i>
            </a>
        </li>
        <li class="nav-item">
    <a class="nav-link" href="{{ route('toko.index') }}">
        <span class="menu-title">Data Toko (Geolo)</span>
        <i class="mdi mdi-map-marker menu-icon"></i>
    </a>
</li>
<li class="nav-item">
    <a class="nav-link" data-bs-toggle="collapse" href="#ui-antrian" aria-expanded="false" aria-controls="ui-antrian">
        <span class="menu-title">Sistem Antrian</span>
        <i class="menu-arrow"></i>
        <i class="mdi mdi-format-list-numbered menu-icon"></i>
    </a>
    <div class="collapse" id="ui-antrian">
        <ul class="nav flex-column sub-menu">
            <li class="nav-item"> <a class="nav-link" href="{{ route('antrian.admin') }}">Dashboard Admin</a></li>
            <li class="nav-item"> <a class="nav-link" href="{{ route('antrian.guest') }}">Pendaftaran Guest</a></li>
            <li class="nav-item"> <a class="nav-link" href="{{ route('antrian.papan') }}">Papan Antrian</a></li>
        </ul>
    </div>
</li>
    </ul>
</nav>