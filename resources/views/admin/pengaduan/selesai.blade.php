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
                    <th>Tanggapan</th>
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
                            <span class="badge bg-danger">0</span>
                        @elseif ($p->status == 'proses')
                            <span class="badge bg-warning text-dark">Proses</span>
                        @elseif ($p->status == 'selesai')
                            <span class="badge bg-success">Selesai</span>
                        @else
                            <span class="badge bg-secondary">Tidak Diketahui</span>
                        @endif
                    </td>
                    <td>
                        <a href="#" class="btn btn-success btn-sm" data-toggle="modal" data-target="#modalTampilTanggapan{{$p->id_pengaduan}}" data-placement="top" title="Lihat Tanggapan">
                            <i class="fas fa-eye"></i>
                        </a>

                        <!-- Modal Lihat Tanggapan -->
                        <div class="modal fade" id="modalTampilTanggapan{{$p->id_pengaduan}}" tabindex="-1" aria-labelledby="modalTampilTanggapanLabel{{$p->id_pengaduan}}" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="modalTampilTanggapanLabel{{$p->id_pengaduan}}">Detail Tanggapan</h5>
                                    </div>
                                    <div class="modal-body">
                                        <div class="mb-3">
                                            <strong>Dari:</strong>
                                            <p>{{ $p->tanggapan->petugas->nama_petugas ?? 'Belum Ada' }}</p>
                                        </div>
                                        <div class="mb-3">
                                            <strong>Kepada:</strong>
                                            <p>{{ $p->masyarakat->nama ?? 'Tidak Diketahui' }}</p>
                                        </div>
                                        <div class="mb-3">
                                            <strong>Tanggal Tanggapan:</strong>
                                            <p>{{ $p->tanggapan->tgl_tanggapan ?? '-' }}</p>
                                        </div>
                                        <div class="mb-3">
                                            <strong>Isi Tanggapan:</strong>
                                            <p>{{ $p->tanggapan->tanggapan ?? 'Belum Ditanggapi' }}</p>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        {{ $pengaduan->links('pagination::bootstrap-5') }}
    </div>
</div>
@endsection