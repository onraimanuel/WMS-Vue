<aside class="main-sidebar sidebar-dark-primary d-flex flex-column">
    <a href="{{url('/')}}" class="brand-link">
        <span class="brand-text font-weight-light">WMS - RKT</span>
    </a>
    <div class="sidebar d-flex flex-column h-100">
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="info">
                <a href="{{url('/')}}" class="d-block">Onra Imanuel</a>
            </div>
        </div>
        <nav class="mt-2 flex-grow-1">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <li class="nav-header">DASHBOARD</li>
                <li class="nav-item">
                    <a href="{{url('/')}}" class="nav-link">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>
                            Dashboard Warehouse
                        </p>
                    </a>
                </li>
                <li class="nav-header">STOK</li>
                <li class="nav-item">
                    <a href="{{url('/ProdukToko')}}" class="nav-link">
                        <i class="nav-icon fas fa-th"></i>
                        <p>Produk Toko</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{url('/PembelianProduk')}}" class="nav-link">
                        <i class="nav-icon fas fa-store"></i>
                        <p>Pembelian Produk</p>
                    </a>
                </li>
                <li class="nav-header">LAPORAN</li>
                <li class="nav-item">
                    <a href="{{url('/LaporanPemesanan')}}" class="nav-link">
                        <i class="fas fa-file nav-icon"></i>
                        <p>Laporan Pemesanan</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{url('/LaporanStok')}}" class="nav-link">
                        <i class="fas fa-book nav-icon"></i>
                        <p>Laporan Stok</p>
                    </a>
                </li>
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>
