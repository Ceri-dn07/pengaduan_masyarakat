@extends('admin.app')

@section('content')

<div class="card p-4 shadow mb-4">
    <h4 class="card-title">Filter Laporan Pengaduan</h4>
    <form action="{{ route('admin.laporan') }}" method="GET">
        <div class="row">
            <div class="col-md-4">
                <label for="start_date" class="form-label">Dari Tanggal</label>
                <input type="date" id="start_date" name="start_date" class="form-control" placeholder="Pilih tanggal awal" required>
            </div>
            <div class="col-md-4">
                <label for="end_date" class="form-label">Sampai Tanggal</label>
                <input type="date" id="end_date" name="end_date" class="form-control" placeholder="Pilih tanggal akhir" required>
            </div>
            <div class="col-md-3 d-flex align-items-end">
                <button type="submit" class="btn btn-primary w-100 mr-3">Tampilkan</button>
                <a href="{{ route('admin.laporan') }}" class="btn btn-secondary ms-2 w-100">Reset</a>
            </div>
        </div>
    </form>
</div>

@if($pengaduan->isNotEmpty())
    <div class="card shadow">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Laporan Pengaduan</h5>
            <span class="badge bg-primary">Total: {{ $pengaduan->count() }}</span>
        </div>
        <div class="card-body">
            <p>
                Dari tanggal: <strong>{{ $request->start_date }}</strong> 
                sampai tanggal: <strong>{{ $request->end_date }}</strong>
            </p>
            <div class="table-responsive">
                <table class="table table-bordered table-striped align-middle">
                    <thead class="table-primary">
                        <tr>
                            <th>No</th>
                            <th>Nama Pengadu</th>
                            <th>Tanggal Pengaduan</th>
                            <th>Status</th>
                            <th>Isi Pengaduan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($pengaduan as $index => $p)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $p->masyarakat->nama }}</td>
                            <td>{{ $p->tgl_pengaduan }}</td>
                            <td>
                                <span class="badge 
                                    {{ $p->status == 'proses' ? 'bg-warning' : ($p->status == 'selesai' ? 'bg-success' : 'bg-secondary') }}">
                                    {{ ucfirst($p->status) }}
                                </span>
                            </td>
                            <td>{{ $p->isi_laporan }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <form action="{{ route('admin.laporan.pdf') }}" method="GET">
            <input type="hidden" name="start_date" value="{{ $request->start_date }}">
            <input type="hidden" name="end_date" value="{{ $request->end_date }}">
            <button type="submit" class="btn btn-primary w-100"><i class="fas fa-download"></i> Unduh PDF</button>
        </form>
        </div>
    </div>
@else
    <div class="alert alert-info text-center">
        <strong>Tidak ada data pengaduan</strong> pada rentang tanggal yang dipilih.
    </div>
@endif

@endsection
