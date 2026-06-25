@extends('admin.app')

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
                    <td>
                        @if(strlen($t->tanggapan) > 50)
                            <span>{{ substr($t->tanggapan, 0, 50) }}</span>
                            <span id="teks-sisa" style="display: none">{{ substr($t->tanggapan, 50)}}</span>
                            <span style="color: #0095f6; cursor: pointer" id="lengkap" onClick="toggleTeks(this)" href="">...Selengkapnya</span>
                        @else
                            <span>{{ $t->tanggapan }}</span>
                        @endif
                    </td>
                    <td>{{ $t->petugas->nama_petugas }}</td>
                    <td>{{ $t->pengaduan->tgl_pengaduan }}</td>
                    <td>{{ $t->pengaduan->masyarakat->nama }}</td>
                    <td>
                        @if(strlen($t->pengaduan->isi_laporan) > 50)
                            <span>{{ substr($t->pengaduan->isi_laporan, 0, 50) }}</span>
                            <span id="teks-sisa" style="display: none">{{ substr($t->pengaduan->isi_laporan, 50)}}</span>
                            <span style="color: #0095f6; cursor: pointer" id="lengkap" onClick="toggleTeks(this)" href="">...Selengkapnya</span>
                        @else
                            <span>{{ $t->pengaduan->isi_laporan }}</span>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        {{ $tanggapan->links('pagination::bootstrap-5') }}
    </div>
</div>
@endsection