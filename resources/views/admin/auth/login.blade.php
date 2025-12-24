<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login dan Register</title>
    <link type="text/css" href="{{asset('bs')}}/css/bootstrap.min.css" rel="stylesheet">
    <link type="text/css" href="{{asset('bs')}}/fontawesome-free/css/all.min.css" rel="stylesheet">
    <link type="text/css" href="{{asset('bs')}}/css/sweetalert2.min.css" rel="stylesheet">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background-color: #f0f0f0;
        }

        .container {
            width: 300px;
            padding: 20px;
            background: white;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            border-radius: 8px;
        }

        h2 {
            text-align: center;
            margin-bottom: 20px;
            color: #333;
        }

        form {
            display: flex;
            flex-direction: column;
        }

        label {
            margin-bottom: 5px;
            font-weight: bold;
        }

        input {
            margin-bottom: 15px;
            padding: 10px;
            font-size: 14px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        button {
            padding: 10px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        button:hover {
            background-color: #0056b3;
        }

        .link {
            text-align: center;
            margin-top: 10px;
        }

        .link a {
            text-decoration: none;
            color: #007bff;
        }

        .link a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>

    <!-- Halaman Login -->
    <div class="container" id="login">
        <h2>Login</h2>
        <form action="{{ route('login-admin.aksi') }}" method="POST">
            @csrf
            <label for="username">Username</label>
            <input type="text" id="username" name="username" placeholder="Masukkan username" required>

            <label for="password">Password</label>
            <input type="password" id="password" name="password" placeholder="Masukkan password" required>

            <button type="submit">Login</button>
        </form>
        @if($errors->has('login_error'))
            <div class="alert alert-danger mt-3">
                {{ $errors->first('login_error') }}
            </div>
        @endif
    </div>

    <!-- Halaman Register -->
    <div class="container" id="register" style="display: none;">
        <h2>Register</h2>
        <form action="{{ route('register') }}" method="POST">
            @csrf
            <label for="nama_petugas">Nama Petugas</label>
            <input type="text" id="nama_petugas" name="nama_petugas" placeholder="Masukkan nama petugas" required>

            <label for="username">Username</label>
            <input type="text" id="username" name="username" placeholder="Masukkan username" required>

            <label for="password">Password</label>
            <input type="password" id="password" name="password" placeholder="Masukkan password" required>

            <label for="telp">No. Telepon</label>
            <input type="tel" id="telp" name="telp" placeholder="Masukkan nomor telepon" required>

            <button type="submit">Register</button>
        </form>
        <div class="link">
            <p>Sudah punya akun? <a href="#" onclick="showLogin()">Login di sini</a></p>
        </div>
    </div>

    <script>
        const loginContainer = document.getElementById('login');
        const registerContainer = document.getElementById('register');

        function showRegister() {
            loginContainer.style.display = 'none';
            registerContainer.style.display = 'block';
        }

        function showLogin() {
            registerContainer.style.display = 'none';
            loginContainer.style.display = 'block';
        }
    </script>

    <script type="text/javascript" src="{{asset('bs')}}/js/sweetalert2.min.js"></script>
    <script type="text/javascript" src="{{asset('bs')}}/js/jquery.js"></script>
    <script type="text/javascript" src="{{asset('bs')}}/js/popper.js"></script>
    <script type="text/javascript" src="{{asset('bs')}}/js/bootstrap.bundle.min.js"></script>

</body>
</html>
