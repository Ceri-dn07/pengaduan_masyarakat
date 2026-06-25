<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name', 'Layanan Pengaduan Masyarakat') }}</title>
    <link rel="icon" type="image/x-icon" href="{{ asset('images/logo.png') }}">
    <link rel="stylesheet" type="text/css" href="{{asset('bs')}}/css/bootstrap.min.css">

    <style>
        .slide-img,
        .slide-text {
            opacity: 0;
            transform: translateY(50px);
            animation: slideUp 1s ease forwards;
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
    <header>
        <nav class="navbar navbar-expand-lg navbar-light bg-light fixed-top shadow-lg">
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
                        <li class="nav-item mr-3"><a class="nav-link" href="/">Home</a></li>
                        <li class="nav-item"><div class="btn-group" role="group">
                            <a href="{{ route('register') }}" class="btn btn-info me-2">Register</a>
                            <a href="{{ route('login') }}" class="btn btn-secondary">Login</a>                                                                               
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
    </header>

    <main class="pt-5">
        @yield('content')
    </main>

    <footer class="bg-light text-center py-3">
        <p>&copy; {{ date('Y') }} HaloWarga. All Rights Reserved.</p>
    </footer>

    <script type="text/javascript" src="{{asset('bs')}}/js/jquery.js"></script>
    <script type="text/javascript" src="{{asset('bs')}}/js/popper.js"></script>
    <script type="text/javascript" src="{{asset('bs')}}/js/bootstrap.bundle.min.js"></script>

</body>
</html>
