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
            <a class="nav-link" href="{{ route('riwayat') }}">
                <span class="menu-title">Riwayat & QR Struk</span>
                <i class="mdi mdi-receipt menu-icon"></i>
            </a>
        </li>
    </ul>
</nav>