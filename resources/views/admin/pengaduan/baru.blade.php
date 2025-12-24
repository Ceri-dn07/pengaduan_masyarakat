@extends('admin.app')

@section('content')

<div class="container-fluid">
    <div class="card p-4">
        <p>
        <table class="table table-responsive table-striped">
            <thead>
                <tr>
                    <th>No.</th>
                    <th>Id Pengaduan</th>
                    <th>Tanggal Pengaduan</th>
                    <th>NIK</th>
                    <th>Isi Laporan</th>
                    <th>Foto</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($pengaduan as $index => $p)
                <tr>
                    <td>{{ $index + 1}}.</td>
                    <td>{{ $p->id_pengaduan }}</td>
                    <td>{{ $p->tgl_pengaduan }}</td>
                    <td>{{ $p->nik }}</td>
                    <td>{{ $p->isi_laporan }}</td>
                    <td>@if($p->foto)
                    <a href="{{ asset('foto_pengaduan') }}/{{($p->foto) }}" target="_blank"><img src="{{ asset('foto_pengaduan/' . $p->foto) }}" alt="Foto Pengaduan" style="width: 50px; height: 50px;"></a>
                            
                        @else
                            Tidak ada foto
                        @endif
                    </td>
                    <td>
                        @if ($p->status == '0')
                            <span class="badge bg-secondary">Belum diproses</span>
                        @elseif ($p->status == 'proses')
                            <span class="badge bg-info text-dark">Proses</span>
                        @elseif ($p->status == 'selesai')
                            <span class="badge bg-success">Selesai</span>
                        @else
                            <span class="badge bg-secondary">Tidak Diketahui</span>
                        @endif
                    </td>
                    <td>
                        <form action="{{ route('admin.pengaduan.verifikasi', $p->id_pengaduan) }}" method="POST" style="display:inline;" id="verifikasiForm{{$p->id_pengaduan}}">
                            @csrf
                            @method('PUT')
                            <button type="button" class="btn btn-warning btn-sm" title="Verifikasi" id="verifikasiBtn{{$p->id_pengaduan}}">
                                <i class="fas fa-check-circle"></i>
                            </button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

        {{ $pengaduan->links('pagination::bootstrap-5') }}

    </div>
</div>

<script>
    document.querySelectorAll('[id^="verifikasiBtn"]').forEach(function(btn) {
        btn.addEventListener('click', function(e) {
            e.preventDefault();

            const formId = 'verifikasiForm' + btn.id.replace('verifikasiBtn', '');

            // Konfirmasi dengan SweetAlert2
            Swal.fire({
                title: 'Apakah Anda yakin?',
                text: "Anda akan memverifikasi pengaduan ini.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Ya, verifikasi!',
                cancelButtonText: 'Batal',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    // Jika pengguna memilih untuk verifikasi, submit form
                    document.getElementById(formId).submit();
                } else {
                    // Jika memilih batal, tidak lakukan apa-apa
                    Swal.fire(
                        'Dibatalkan',
                        'Pengaduan tidak jadi diverifikasi.',
                        'info'
                    );
                }
            });
        });
    });
</script>
@endsection