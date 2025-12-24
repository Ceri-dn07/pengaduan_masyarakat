@extends('layouts.app')

@section('content')
<style>
.card-img-top {
    width: 100%;
    height: 200px;
    object-fit: cover;
    margin: 0 auto;
}
</style>
<div class="container-fluid ">
    <div class="row align-items-center text-white py-5 mb-5" style="background: #003366">
        <div class="col-md-6">
            <h1 class="display-4" style="font-weight: bold; font-size: 50px;">Layanan Pengaduan Masyarakat</h1>
            <p class="lead">Sampaikan keluhan Anda dengan mudah dan cepat melalui platform kami.</p>
        </div>
        <div class="col-md-6">
            <img src="{{ asset('images/complaint.png') }}" alt="Illustration" class="img-fluid">
        </div>
    </div>

    <!-- Tentang -->
    <div class="row mb-4">
        <div class="col-md-12 mb-4">
            <div class="card shadow">
                <div class="card-body">
                    <h2 class="mb-3">Tentang Aplikasi Pengaduan Masyarakat</h2>
                    <p>Aplikasi pengaduan masyarakat adalah platform digital yang memungkinkan warga untuk melaporkan berbagai masalah atau keluhan terkait pelayanan publik, fasilitas umum, atau isu sosial yang mereka temui di lingkungan sekitar. Dengan aplikasi ini, masyarakat dapat dengan mudah mengajukan pengaduan secara langsung melalui perangkat mobile atau komputer, tanpa perlu datang ke kantor pemerintahan atau instansi terkait. Fitur-fitur seperti pengisian form pengaduan serta pengunggahan bukti foto membuat proses pengaduan menjadi lebih cepat dan efisien.</p>

                    <p>Setelah pengaduan diajukan, aplikasi ini memungkinkan petugas atau pihak yang berwenang untuk memantau dan menindaklanjuti laporan tersebut. Status pengaduan dapat dilacak secara real-time oleh pelapor, mulai dari status "belum diterima", "proses", hingga "selesai". Selain itu, aplikasi ini sering dilengkapi dengan fitur untuk memberikan feedback atau solusi atas pengaduan yang telah ditangani, sehingga transparansi dalam penyelesaian masalah dapat terjaga.</p>

                    <p>Aplikasi pengaduan masyarakat tidak hanya mempermudah masyarakat dalam mengakses layanan, tetapi juga memberikan manfaat bagi pemerintah atau instansi terkait untuk lebih responsif dalam menangani masalah yang dihadapi oleh masyarakat. Melalui aplikasi ini, proses pengelolaan pengaduan menjadi lebih terorganisir dan terukur, memungkinkan evaluasi dan perbaikan layanan publik yang lebih baik di masa depan. Inovasi ini turut mendukung terciptanya pemerintahan yang lebih transparan dan akuntabel, serta meningkatkan partisipasi aktif masyarakat dalam pembangunan dan perbaikan kualitas hidup di lingkungan mereka.</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Proses -->
    <div class="row mb-4">
        <div class="col-md-3 mb-4">
            <div class="card shadow">
                <img src="{{ asset('images/tulis_laporan.png') }}" class="card-img-top" alt="Pengaduan Baru">
                <div class="card-body">
                    <h5 class="card-title text-center">1. Tulis Laporan</h5>
                    <p class="card-text text-center">Tuliskan laporan keluhan Anda dengan jelas</p>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-4">
            <div class="card shadow">
                <img src="{{ asset('images/verifikasi.png') }}" class="card-img-top" alt="Pengaduan Proses">
                <div class="card-body">
                    <h5 class="card-title text-center">2. Proses Verifikasi</h5>
                    <p class="card-text text-center">Tunggu sampai laporan Anda di verifikasi</p>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-4">
            <div class="card shadow">
                <img src="{{ asset('images/tindak_lanjut.png') }}" class="card-img-top" alt="Pengaduan Selesai">
                <div class="card-body">
                    <h5 class="card-title text-center">3. Tindak Lanjut</h5>
                    <p class="card-text text-center">Laporan Anda sedang dalam tindak lanjut</p>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-4">
            <div class="card shadow">
                <img src="{{ asset('images/selesai.png') }}" class="card-img-top" alt="Pengaduan Ditutup">
                <div class="card-body">
                    <h5 class="card-title text-center">4. Selesai</h5>
                    <p class="card-text text-center">Laporan pengaduan telah selesai ditindak</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Kontak & Bantuan -->
    <div class="row mb-5">
        <div class="col-md-12 mb-4">
            <div class="card shadow">
                <div class="card-body">
                    <h5 class="card-title">Kontak Kami</h5>
                    <p class="card-text">Jika Anda membutuhkan bantuan atau memiliki pertanyaan, jangan ragu untuk menghubungi kami.</p>
                    <ul class="list-unstyled">
                        <li>Email: <a href="mailto:support@pengaduan.com">support@pengaduan.com</a></li>
                        <li>Telp: <a href="tel:+621234567890">+62 123 456 7890</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>


    <script>
    window.onload = function() {
        const colors = ['#007bff', '#00c6ff', '#28a745', '#ffc107', '#dc3545', '#003366'];
        const randomColor = colors[Math.floor(Math.random() * colors.length)];
        document.querySelector('.bg-atas').style.backgroundColor = randomColor;
    };
</script>

@endsection
