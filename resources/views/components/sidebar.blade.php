<div class="sidebar" data-color="purple" data-background-color="white">
    <div class="logo">
        <a href="{{ url('/') }}" class="simple-text logo-normal">
            Sistem Pakar HVAS
        </a>
    </div>
    <div class="sidebar-wrapper">
        <ul class="nav">
            <li class="nav-item {{ request()->is('dashboard') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('dashboard') }}">
                    <i class="material-icons">dashboard</i>
                    <p>Dashboard</p>
                </a>
            </li>

            @if(auth()->user()->isAdmin())
                <li class="nav-item {{ request()->is('admin/users*') ? 'active' : '' }}">
                    <a class="nav-link" href="{{ route('users.index') }}">
                        <i class="material-icons">people</i>
                        <p>Kelola Pengguna</p>
                    </a>
                </li>
            @endif

            @if(auth()->user()->isAdmin() || auth()->user()->isTeknisi())
                <li class="nav-item {{ request()->is('teknisi/gejala*') ? 'active' : '' }}">
                    <a class="nav-link" href="{{ route('gejala.index') }}">
                        <i class="material-icons">healing</i>
                        <p>Data Gejala</p>
                    </a>
                </li>

                <li class="nav-item {{ request()->is('teknisi/kerusakan*') ? 'active' : '' }}">
                    <a class="nav-link" href="{{ route('kerusakan.index') }}">
                        <i class="material-icons">build</i>
                        <p>Data Kerusakan</p>
                    </a>
                </li>

                <li class="nav-item {{ request()->is('teknisi/aturan*') ? 'active' : '' }}">
                    <a class="nav-link" href="{{ route('aturan.index') }}">
                        <i class="material-icons">rule</i>
                        <p>Data Aturan</p>
                    </a>
                </li>

                <li class="nav-item {{ request()->is('teknisi/solusi*') ? 'active' : '' }}">
                    <a class="nav-link" href="{{ route('solusi.index') }}">
                        <i class="material-icons">lightbulb</i>
                        <p>Data Solusi</p>
                    </a>
                </li>
            @endif

            <li class="nav-item {{ request()->is('user/diagnosa*') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('diagnosa.index') }}">
                    <i class="material-icons">search</i>
                    <p>Diagnosa</p>
                </a>
            </li>

            <li class="nav-item {{ request()->is('user/riwayat*') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('riwayat.index') }}">
                    <i class="material-icons">history</i>
                    <p>Riwayat Konsultasi</p>
                </a>
            </li>

            <li class="nav-item {{ request()->is('user/predictive-maintenance*') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('predictive-maintenance.index') }}">
                    <i class="material-icons">schedule</i>
                    <p>Predictive Maintenance</p>
                </a>
            </li>
        </ul>
    </div>
</div>
