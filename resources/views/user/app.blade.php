<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Layanan Pengaduan Masyarakat') }}</title>
    <link rel="icon" type="image/x-icon" href="{{ asset('images/logo.png') }}">
    <link type="text/css" href="{{asset('bs')}}/css/bootstrap.min.css" rel="stylesheet">
    <link type="text/css" href="{{asset('bs')}}/fontawesome-free/css/all.min.css" rel="stylesheet">
    <link type="text/css" href="{{asset('bs')}}/css/sweetalert2.min.css" rel="stylesheet">

    <style>
        .slide-img,
        .slide-text {
            opacity: 0;
            transform: translateY(50px);
            animation: slideUp 1s ease forwards;
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
            width: 100%;
        }

        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateY(50px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
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
    <nav class="navbar navbar-expand-lg navbar-light bg-light fixed-top shadow-lg" >
        <div class="container-fluid">
            <a class="navbar-brand d-flex align-items-center" href="#">
                <img src="{{ asset('images/logo.png') }}" alt="Logo" width="50" class="d-inline-block align-text-top me-1 pr-2">
                HaloWarga
            </a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link" href="/user/dashboard">Home</a></li>
                    <li class="nav-item"><a class="nav-link" href="/user/pengaduan">Pengaduan</a></li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-expanded="false">
                            Halo, {{ Auth::user()->nama }}
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="userDropdown">
                            <li>
                                <a class="dropdown-item" href="#" data-toggle="modal" data-target="#profileModal">
                                    <i class="fas fa-user-circle me-2"></i> Profil
                                </a>
                            </li>
                            <li>
                                <form method="POST" action="{{ route('logout.user') }}">
                                    @csrf
                                    <button type="submit" class="dropdown-item">
                                        <i class="fas fa-sign-out-alt me-2"></i> Logout
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Modal Profile -->
    <div class="modal fade" id="profileModal" tabindex="-1" role="dialog" aria-labelledby="profileModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header flex-column align-items-center">
                    <div class="user-icon-container mb-2">
                        <i class="fas fa-user-circle text-primary" style="font-size: 4rem;"></i>
                    </div>
                    <h5 class="modal-title" id="profileModalLabel">Profil Pengguna</h5>
                </div>
                <div class="modal-body">
                    <form id="profileForm">
                        @csrf
                        <!-- NIK -->
                        <div class="mb-3">
                            <label for="nik" class="form-label">NIK</label>
                            <input type="text" class="form-control" id="nik" name="nik" value="{{ auth()->user()->nik }}" readonly>
                        </div>
                        <!-- Nama -->
                        <div class="mb-3">
                            <label for="nama" class="form-label">Nama</label>
                            <input type="text" class="form-control" id="nama" name="nama" value="{{ auth()->user()->nama }}" readonly>
                        </div>
                        <!-- Username -->
                        <div class="mb-3">
                            <label for="username" class="form-label">Username</label>
                            <input type="text" class="form-control" id="username" name="username" value="{{ auth()->user()->username }}" readonly>
                        </div>
                        <!-- Telepon -->
                        <div class="mb-3">
                            <label for="telp" class="form-label">Telepon</label>
                            <input type="text" class="form-control" id="telp" name="telp" value="{{ auth()->user()->telp }}" readonly>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>

    <main class="pt-5">
        @yield('content')
    </main>

    <footer class="bg-light text-center py-3">
        <p>&copy; {{ date('Y') }} HaloWarga. All Rights Reserved.</p>
    </footer>
    
    <script type="text/javascript" src="{{asset('bs')}}/js/sweetalert2.min.js"></script>
    <script type="text/javascript" src="{{asset('bs')}}/js/jquery.js"></script>
    <script type="text/javascript" src="{{asset('bs')}}/js/popper.js"></script>
    <script type="text/javascript" src="{{asset('bs')}}/js/bootstrap.bundle.min.js"></script>
   
</body>
</html>
