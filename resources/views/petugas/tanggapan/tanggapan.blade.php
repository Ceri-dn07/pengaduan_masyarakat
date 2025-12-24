@extends('petugas.app')

@section('content')

<div class="container-fluid">
    <div class="card p-4">
        <p>
        <table class="table table-responsive table-striped">
            <thead>
                <tr>
                    <th>No.</th>
                    <th>Tanggal Tanggapan</th>
                    <th>Tanggapan</th>
                    <th>Nama Petugas</th>
                    <th>Tanggal Pengaduan</th>
                    <th>Nama Pengadu</th>
                    <th>Isi Pengaduan</th>
                </tr>
            </thead>
            
            <tbody>
                @foreach($tanggapan as $index => $t)
                <tr>
                    <td>{{ $index + 1}}.</td>
                    <td>{{ $t->tgl_tanggapan }}</td>
                    <td>{{ $t->tanggapan }}</td>
                    <td>{{ $t->petugas->nama_petugas }}</td>
                    <td>{{ $t->pengaduan->tgl_pengaduan }}</td>
                    <td>{{ $t->pengaduan->masyarakat->nama }}</td>
                    <td>{{ $t->pengaduan->isi_laporan }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>

        {{ $tanggapan->links('pagination::bootstrap-5') }}
    </div>
</div>
@endsection