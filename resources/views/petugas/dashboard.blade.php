@extends('petugas.app')

@section('content')

<h3 class="mb-4">Dashboard</h3>
    <div class="row mb-3">
        <!-- Card Pengaduan -->
        <div class="col-md-6">
            <div class="card p-4 shadow-sm">
                <div class="d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">{{ App\Models\Pengaduan::all()->count() }}</h5>
                    <i class="fas fa-file-alt text-info fs-3"></i>
                </div>
                <p class="text-muted mb-0">Total Pengaduan</p>
            </div>
        </div>
        
        <!-- Card Tanggapan -->
        <div class="col-md-6">
            <div class="card p-4 shadow-sm">
                <div class="d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">{{ App\Models\Tanggapan::all()->count() }}</h5>
                    <i class="fas fa-comment-dots text-secondary fs-3"></i>
                </div>
                <p class="text-muted mb-0">Total Tanggapan</p>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Card Pengaduan Belum Diproses -->
        <div class="col-md-4">
            <div class="card p-4 shadow-sm">
                <div class="d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">{{ App\Models\Pengaduan::where('status', '0')->count() }}</h5>
                    <i class="fas fa-clock text-primary fs-3"></i>
                </div>
                <p class="text-muted mb-0">Pengaduan Belum Diproses</p>
            </div>
        </div>

        <!-- Card Pengaduan Dalam Proses -->
        <div class="col-md-4">
            <div class="card p-4 shadow-sm">
                <div class="d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">{{ App\Models\Pengaduan::where('status', 'proses')->count() }}</h5>
                    <i class="fas fa-spinner text-danger fs-3"></i>
                </div>
                <p class="text-muted mb-0">Pengaduan Dalam Proses</p>
            </div>
        </div>

        <!-- Card Pengaduan Selesai -->
        <div class="col-md-4">
            <div class="card p-4 shadow-sm">
                <div class="d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">{{ App\Models\Pengaduan::where('status', 'selesai')->count() }}</h5>
                    <i class="fas fa-check-circle text-success fs-3"></i>
                </div>
                <p class="text-muted mb-0">Pengaduan Selesai Diproses</p>
            </div>
        </div>
    </div>

    <!-- Statistik Pengaduan -->
    <div class="row mt-4">
        <div class="col-md-8">
            <div class="card mb-4">
                <div class="card-header">
                    <h3>Statistik Pengaduan 7 Hari Terakhir</h3>
                </div>
                <div class="card-body">
                    <canvas id="pengaduanPerHariChart" ></canvas>
                </div>
            </div>
        </div>
        
        <div class="col-md-4">
            <div class="card p-3">
                <canvas id="pengaduanChart"></canvas>
            </div>
        </div>
    </div>

    <!-- Daftar Pengaduan Terbaru -->
    <div class="card mt-4">
        <div class="card-header">
            <h3>Pengaduan Terbaru</h3>
        </div>
        <div class="card-body">
            <table class="table table-responsive table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Tanggal</th>
                        <th>NIK</th>
                        <th>Isi Laporan</th>
                        <th>Status</th>
                        <th>Foto</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($pengaduanTerbaru as $pengaduan)
                    <tr>
                        <td>{{ $pengaduan->id_pengaduan }}</td>
                        <td>{{ $pengaduan->tgl_pengaduan }}</td>
                        <td>{{ $pengaduan->nik }}</td>
                        <td>{{ Str::limit($pengaduan->isi_laporan, 50) }}</td>
                        <td>
                            @if ($pengaduan->status == '0')
                                <span class="badge bg-secondary">Belum diproses</span>
                            @elseif ($pengaduan->status == 'proses')
                                <span class="badge bg-info text-dark">Proses</span>
                            @elseif ($pengaduan->status == 'selesai')
                                <span class="badge bg-success">Selesai</span>
                            @else
                                <span class="badge bg-secondary">Tidak Diketahui</span>
                            @endif
                        </td>
                        <td>
                            @if ($pengaduan->foto)
                            <a href="{{ asset('foto_pengaduan') }}/{{($pengaduan->foto) }}" target="_blank"><img src="{{ asset('foto_pengaduan/' . $pengaduan->foto) }}" alt="Foto Pengaduan" style="width: 50px; height: 50px;"></a>
                            @else
                                Tidak ada
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <script>
        const tanggal = @json($tanggal);
        const jumlahPengaduan = @json($jumlahPengaduan);

        console.log(tanggal, jumlahPengaduan);
        console.log('Chart.js version:', Chart.version);

        const pengaduanPerHariCtx = document.getElementById('pengaduanPerHariChart').getContext('2d');

        const pengaduanPerHariChart = new Chart(pengaduanPerHariCtx, {
            type: 'line',
            data: {
                labels: tanggal,
                datasets: [{
                    label: 'Jumlah Pengaduan',
                    data: jumlahPengaduan,
                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                    borderColor: 'rgba(75, 192, 192, 1)',
                    borderWidth: 2,
                    fill: true
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'top',
                    },
                    title: {
                        display: true,
                        text: 'Pengaduan dalam 7 Hari Terakhir'
                    }
                },
                scales: {
                    x: {
                        title: {
                            display: true,
                            text: 'Tanggal'
                        }
                    },
                    y: {
                        beginAtZero: true,
                        title: {
                            display: true,
                            text: 'Jumlah Pengaduan'
                        }
                    }
                }
            }
        });
    </script>

    <script>
        const pengaduanCtx = document.getElementById('pengaduanChart').getContext('2d');
        const pengaduanChart = new Chart(pengaduanCtx, {
            type: 'doughnut',
            data: {
                labels: ['Proses', 'Selesai'],
                datasets: [{
                    data: [{{ $pengaduanProses }}, {{ $pengaduanSelesai }}],
                    backgroundColor: ['#ffc107', '#28a745'],
                    borderColor: ['#ffffff', '#ffffff'],
                    borderWidth: 2
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'top',
                    },
                    title: {
                        display: true,
                        text: 'Statistik Pengaduan'
                    }
                }
            }
        });
    </script>
@endsection