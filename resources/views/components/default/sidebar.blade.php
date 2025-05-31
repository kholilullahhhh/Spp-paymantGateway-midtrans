<div class="main-sidebar sidebar-style-2">
    <aside id="sidebar-wrapper">
        <div class="sidebar-brand">
            <a href="{{route('dashboard') }}">RPPH Makassar</a>
        </div>
        <div class="sidebar-brand sidebar-brand-sm">
            <a href="{{route('dashboard') }}">RPPH</a>
        </div>

        <ul class="sidebar-menu">

            <li class="menu-header">Dashboard</li>

            <li class="nav-item  {{ $menu == 'dashboard' ? 'active' : '' }}">
                <a href="{{ route('dashboard') }}" class="nav-link "><i
                        class="fas fa-fire"></i><span>Dashboard</span></a>
            </li>

            @if (session('role') == 'admin')
                <li class="nav-item dropdown {{ $menu == 'siswa' || 'jadwal' ? 'active' : '' }}">
                    <a href="#" class="nav-link has-dropdown"><i class="fas fa-sitemap"></i>
                        <span>Master Data</span></a>
                    <ul class="dropdown-menu">

                        <li class="{{ $menu == 'siswa' ? 'active' : '' }}">
                            <a class="nav-link" href="{{ route('siswa.index') }}">
                                Data Siswa
                            </a>
                        </li>
                        <li class="{{ $menu == 'kelas' ? 'active' : '' }}">
                            <a class="nav-link" href="{{ route('kelas.index') }}">
                                Data Kelas
                            </a>
                        </li>
                        <li class="{{ $menu == 'spp' ? 'active' : '' }}">
                            <a class="nav-link" href="{{ route('spp.index') }}">
                                Data SPP
                            </a>
                        </li>

                    </ul>
                </li>


                <!-- <li class="nav-item dropdown {{ $menu == 'kegiatan' || $menu == 'peserta' ? 'active' : '' }}">
                                    <a href="#" class="nav-link has-dropdown"><i class="fas fa-calendar-week"></i>
                                        <span>Data Kegiatan</span></a>
                                    <ul class="dropdown-menu">

                                        <li class="{{ $menu == 'kegiatan' ? 'active' : '' }}">
                                            <a class="nav-link" href="{{ route('kegiatan.index') }}">
                                                Kegiatan</span>
                                            </a>
                                        </li>

                                        <li class="{{ $menu == 'peserta' ? 'active' : '' }}">
                                            <a class="nav-link" href="{{ route('peserta.index') }}">
                                                Peserta Kegiatan
                                            </a>
                                        </li>
                                    </ul>
                                </li> -->


                <li class="{{ $menu == 'akun' ? 'active' : '' }}">
                    <a class="nav-link" href="{{ route('akun.index') }}">
                        <i class="fas fa-user"></i> <span>Data Akun</span>
                    </a>
                </li>

                <li class="menu-header">Landing Page</li>
                <li class="nav-item  {{ $menu == 'agenda' ? 'active' : '' }}">
                    <a href="{{ route('agenda.index') }}" class="nav-link "><i class="fas fa-thumbtack"></i>
                        <span>Data Agenda</span>
                    </a>
                </li>
                <li class="nav-item  {{ $menu == 'tema' ? 'active' : '' }}">
                    <a href="{{ route('tema.index') }}" class="nav-link "><i class="fas fa-newspaper"></i>
                        <span>Data Tema</span>
                    </a>
                </li>
                <li class="nav-item  {{ $menu == 'modul' ? 'active' : '' }}">
                    <a href="{{ route('modul.index') }}" class="nav-link "><i class="fas fa-window-maximize"></i>
                        <span>Modul Pembelajaran</span>
                    </a>
                </li>
            @endif

            @if (session('role') == 'siswa')
                    <li class="nav-item dropdown {{ $menu == 'jadwal' || 'siswa' ? 'active' : '' }}">
                        <a href="#" class="nav-link has-dropdown"><i class="fas fa-sitemap"></i>
                            <span>Master Data</span></a>
                        <ul class="dropdown-menu">

                            <li class="{{ $menu == 'siswa' ? 'active' : '' }}">
                                <a class="nav-link" href="{{ route('siswa.index') }}">
                                    Data Siswa RPPH
                                </a>
                            </li>

                            <li class="{{ $menu == 'spp' ? 'active' : '' }}">
                                <a class="nav-link" href="{{ route('spp.index') }}">
                                    Data SPP
                                </a>
                            </li>
                    </li>

                </ul>
                </li>

                <li class="nav-item dropdown {{ $menu == 'kegiatan' || $menu == 'peserta' ? 'active' : '' }}">
                    <a href="#" class="nav-link has-dropdown"><i class="fas fa-calendar-week"></i>
                        <span>Data Kegiatan</span></a>
                    <ul class="dropdown-menu">

                        <li class="{{ $menu == 'kegiatan' ? 'active' : '' }}">
                            <a class="nav-link" href="{{ route('kegiatan.index') }}">
                                Kegiatan</span>
                            </a>
                        </li>

                        <li class="{{ $menu == 'peserta' ? 'active' : '' }}">
                            <a class="nav-link" href="{{ route('peserta.index') }}">
                                Peserta Kegiatan
                            </a>
                        </li>
                    </ul>
                </li>


                <li class="{{ $menu == 'akun' ? 'active' : '' }}">
                    <a class="nav-link" href="{{ route('akun.index') }}">
                        <i class="fas fa-user"></i> <span>Data Akun</span>
                    </a>
                </li>

                <li class="menu-header">Landing Page</li>
                <li class="nav-item  {{ $menu == 'agenda' ? 'active' : '' }}">
                    <a href="{{ route('agenda.index') }}" class="nav-link "><i class="fas fa-thumbtack"></i>
                        <span>Data Agenda</span>
                    </a>
                </li>
                <li class="nav-item  {{ $menu == 'tema' ? 'active' : '' }}">
                    <a href="{{ route('tema.index') }}" class="nav-link "><i class="fas fa-newspaper"></i>
                        <span>Data Berita</span>
                    </a>
                </li>
                <li class="nav-item  {{ $menu == 'modul' ? 'active' : '' }}">
                    <a href="{{ route('modul.index') }}" class="nav-link "><i class="fas fa-window-maximize"></i>
                        <span>Modul Pembelajaran</span>
                    </a>
                </li>
            @endif





        </ul>

        <div class="mt-4 mb-4 p-3 hide-sidebar-mini">
            <a href="{{ route('logout') }}" class="btn btn-danger btn-lg btn-block btn-icon-split">
                <i class="fas fa-sign-out-alt"></i> Logout
            </a>
        </div>
    </aside>
</div>