
<aside class="left-sidebar">
    <!-- Sidebar scroll-->
    <div class="scroll-sidebar">
        <!-- Sidebar navigation-->
        <nav class="sidebar-nav">
            <ul id="sidebarnav">
                
                <li><a href="{{ url('/')}}"><i class="fa fa-home"></i> Dashboard</a></li>

                <li> <a class="has-arrow waves-effect waves-dark" href="#" aria-expanded="false"><span class="hide-menu"><i class="fa fa-file-text"></i> Laporan</span></a>
                    <ul aria-expanded="false" class="collapse">
                        <li><a href="{{ route('laporan.mahasiswa')}}">Per Mahasiswa</a></li>
                        <li><a href="{{ route('laporan.program_studi')}}">Per Program Studi</a></li>
                        <li><a href="{{ route('laporan.semester')}}">Per Semester</a></li>
                        <li><a href="{{ route('laporan.angkatan')}}">Per Angkatan</a></li>
                        <li><a href="{{ route('laporan.tahun')}}">Per Tahun</a></li>
                        <li><a href="{{ route('laporan.kasir')}}">Per Kasir</a></li>
                        <li><a href="{{ route('laporan.jenis_transaksi')}}">Per Jenis Transaksi</a></li>
                    </ul>
                </li>
                <li><a href="{{ url('/mahasiswa')}}"><i class="fa fa-users"></i> Mahasiswa</a></li>
                <li><a href="{{ url('/tagihan')}}"><i class="fa fa-money"></i> Tagihan</a></li>
                <li><a href="{{ url('/pengguna')}}"><i class="fa fa-user"></i> Pengguna</a></li>
            </ul>
        </nav>
        <!-- End Sidebar navigation -->
    </div>
    <!-- End Sidebar scroll-->
</aside>
