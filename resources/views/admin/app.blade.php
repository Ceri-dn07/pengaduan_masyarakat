<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HaloWarga-Admin</title>
    <link rel="icon" type="image/x-icon" href="{{ asset('images/logo.png') }}">
    <link type="text/css" href="{{asset('bs')}}/css/bootstrap.min.css" rel="stylesheet">
    <link type="text/css" href="{{asset('bs')}}/fontawesome-free/css/all.min.css" rel="stylesheet">
    <link type="text/css" href="{{asset('bs')}}/css/sweetalert2.min.css" rel="stylesheet">
    <script type="text/javascript" src="{{asset('bs')}}/js/sweetalert2.min.js"></script>
    <script type="text/javascript" src="{{asset('bs')}}/chart.js/Chart.js"></script>

    <style>
        .header {
            background-color: #ffffff;
            border-bottom: 1px solid #ddd;
            padding: 15px 20px;
            position: fixed;
            margin-left: 250px; 
            height: 60px;
            width: calc(100% - 250px);
            top: 0;
            z-index: 1000;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .header .logo {
            font-weight: bold;
            color: #5DEBD7;
            font-size: 22px;
        }

        .sidebar {
            background-color: #ffffff;
            width: 250px;
            height: 100vh;
            position: fixed;
            top: 0;
            left: 0;    
            display: flex;
            flex-direction: column;
            padding-top: 20px;
            border-right: 1px solid #ddd;
            overflow-y: auto;
            box-shadow: 2px 0px 5px rgba(0, 0, 0, 0.1);
        }

        .sidebar a {
            color: #5D5D5D;
            text-decoration: none;
            display: flex;
            align-items: center;
            padding: 12px 15px;
            border-radius: 5px;
            margin: 5px 10px;
            transition: background-color 0.3s ease, color 0.3s ease;
            position: relative;
        }

        .sidebar a:hover {
            background-color: #f1f1f1;
            color: #5DEBD7;
        }

        .sidebar a.active {
            background-color: #5DEBD7;
            color: white;
            font-weight: bold;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .sidebar a i {
            margin-right: 10px;
            font-size: 18px;
        }

        .submenu {
            display: none; 
            list-style: none;
            padding-left: 20px;
        }

        .submenu a {
            padding: 5px 10px;
            color: #bdc3c7;
            text-decoration: none;
            border-radius: 4px;
            display: block;
        }

        .submenu a:hover {
            background-color: #3d566e;
            color: #fff;
        }

        .submenu.show {
            display: block;
        }

        .menu-link .submenu-toggle {
            font-size: 14px;
            margin-left: auto;
        }

        .content {
            margin-top: 60px;
            margin-left: 250px;
            padding: 20px;
            background-color: #f4f6f9;
            min-height: 100vh;
        }

        .table {
            width: 100%;
            max-width: 100%;
            table-layout: fixed;
            text-align: center;
            vertical-align: middle;
            border-radius: 10px;
        }

        .table td,
        .table th {
            word-wrap: break-word;
            white-space: normal;
            width: 15%;
        }

        @media (max-width: 768px) {
            .sidebar {
                width: 200px;
            }

            .header {
                margin-left: 200px;
                width: calc(100% - 200px);
            }

            .content {
                margin-left: 200px;
                width: calc(100% - 200px);
            }
        }

        @media (max-width: 480px) {
            .sidebar {
                width: 40%;
            }

            .header {
                margin-left: 40%;
                width: 60%;
            }

            .content {
                margin-left: 40%;
                width: 60%;
            }
        }
    </style>
</head>

<body>
    @if (session('success'))
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: '{{ session('success') }}',
                showConfirmButton: false,
                timer: 1500
            });
        </script>
    @endif
    <div class="layout-wrapper">
        <!-- Sidebar -->
        <div class="sidebar pt-5">
            <div class=" mt-5 pb-3 text-center">
                <div class="" style="font-weight: bold; color: #5DEBD7; font-size: 22px; text-transform: uppercase;">{{ Auth::user()->level }}</div>
            </div>

            <a href="/admin/dashboard" class="{{ request()->is('admin/dashboard') ? 'active' : '' }}">
                <i class="fas fa-home"></i>
                Dashboard
            </a>
            
            <!-- Menu User dengan submenu Masyarakat dan Petugas -->
            <div class="menu-item {{ request()->is('admin/user*') ? 'active' : '' }}">
                <a href="#" class="menu-link">
                    <i class="fas fa-users"></i>
                    User
                    <span class="submenu-toggle"><i class="fas fa-caret-down right"></i></span>
                </a>
                <ul class="submenu {{ request()->is('admin/user/*') ? 'show' : '' }}">
                    <li>
                        <a href="/admin/user/masyarakat" class="{{ request()->is('admin/user/masyarakat') ? 'active' : '' }}">
                            <i class="fas fa-user"></i> Masyarakat
                        </a>
                    </li>
                    <li>
                        <a href="/admin/user/petugas" class="{{ request()->is('admin/user/petugas') ? 'active' : '' }}">
                            <i class="fas fa-user-shield"></i> Petugas
                        </a>
                    </li>
                </ul>
            </div>

            <div class="menu-item {{ request()->is('admin/pengaduan*') ? 'active' : '' }}">
                <a href="#" class="menu-link">
                    <i class="fas fa-building"></i>
                    Pengaduan
                    <span class="submenu-toggle"><i class="fas fa-caret-down"></i></span>
                </a>
                <ul class="submenu {{ request()->is('admin/pengaduan*') ? 'show' : '' }}">
                    <li>
                        <a href="/admin/pengaduan/belum-ditanggapi" class="{{ request()->is('admin/pengaduan/belum-ditanggapi') ? 'active' : '' }}">
                            <i class="fas fa-clock"></i>
                            Belum Ditanggapi
                        </a>
                    </li>
                    <li>
                        <a href="/admin/pengaduan/proses" class="{{ request()->is('admin/pengaduan/proses') ? 'active' : '' }}">
                            <i class="fas fa-sync"></i> 
                            Proses
                        </a>
                    </li>
                    <li>
                        <a href="/admin/pengaduan/selesai" class="{{ request()->is('admin/pengaduan/selesai') ? 'active' : '' }}">
                            <i class="fas fa-check-circle"></i>
                            Selesai
                        </a>
                    </li>
                </ul>
            </div>

            <a href="/admin/tanggapan" class="{{ request()->is('admin/tanggapan') ? 'active' : '' }}">
                <i class="fas fa-tasks"></i>
                Tanggapan
            </a>

            <a href="/admin/laporan" class="{{ request()->is('admin/laporan') ? 'active' : '' }}">
                <i class="fas fa-bullhorn"></i>
                Laporan
            </a>

            <a href="#" onclick="logoutWithConfirmation()" class="{{ request()->is('admin/logout') ? 'active' : '' }}">
                <i class="fas fa-sign-out-alt"></i>
                Logout
            </a>
            <form id="logout-form" action="{{ route('logout.admin') }}" method="POST" style="display: none;">
                @csrf
            </form>
        </div>

        <!-- Header -->
        <div class="header">
            <div class="logo">HaloWarga</div>
            <div class="nav-right">
                <span>Hi, {{ Auth::user()->nama_petugas }}</span>
            </div>
        </div>

        <!-- Main Content -->
        <div class="content" >
            @yield('content')
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const toggles = document.querySelectorAll('.menu-item > .menu-link');
            console.log(toggles); 

            toggles.forEach(toggle => {
                toggle.addEventListener('click', function (e) {
                    e.preventDefault();
                    console.log('Menu clicked'); 

                    const submenu = this.nextElementSibling;
                    const isActive = submenu.classList.contains('show');

                    document.querySelectorAll('.submenu').forEach(sub => sub.classList.remove('show'));

                    if (!isActive) {
                        submenu.classList.add('show');
                    }
                });
            });
        });
    </script>

    <script>
        function logoutWithConfirmation() {
            Swal.fire({
                title: 'Anda yakin ingin logout?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Ya, Logout!',
                cancelButtonText: 'Batal',
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('logout-form').submit();
                }
            });
        }

        function toggleTeks(tombol) {
            var lengkap = tombol.parentElement;
            var teksSisa = lengkap.querySelector('#teks-sisa');

            if(teksSisa.style.display === "none") {
                teksSisa.style.display = "inline";
                tombol.innerText = "Sembunyikan";
            } else {
                teksSisa.style.display = "none";
                tombol.innerText =" ...Selengkapnya"
            }
        }
    </script>

    <script type="text/javascript" src="{{asset('bs')}}/js/jquery.js"></script>
    <script type="text/javascript" src="{{asset('bs')}}/js/popper.js"></script>
    <script type="text/javascript" src="{{asset('bs')}}/js/bootstrap.bundle.min.js"></script>

</body>
</html>
