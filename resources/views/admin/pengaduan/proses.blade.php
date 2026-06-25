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
                    <th>Nama</th>
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
                    <td>{{ $p->masyarakat->nama }}</td>
                    <td>
                        @if(strlen($p->isi_laporan) > 50)
                            <span>{{ substr($p->isi_laporan, 0, 50) }}</span>
                            <span id="teks-sisa" style="display: none">{{ substr($p->isi_laporan, 50)}}</span>
                            <span style="color: #0095f6; cursor: pointer" id="lengkap" onClick="toggleTeks(this)" href="">...Selengkapnya</span>
                        @else
                            <span>{{ $p->isi_laporan }}</span>
                        @endif
                    </td>
                    <td>@if($p->foto)
                    <a href="{{ asset('foto_pengaduan') }}/{{($p->foto) }}" target="_blank"><img src="{{ asset('foto_pengaduan/' . $p->foto) }}" alt="Foto Pengaduan" style="width: 50px; height: 50px;"></a>
                        @else
                            Tidak ada foto
                        @endif
                    </td>
                    <td>
                        @if ($p->status == '0')
                            <span class="badge bg-secondary">0</span>
                        @elseif ($p->status == 'proses')
                            <span class="badge bg-warning text-dark">Proses</span>
                        @elseif ($p->status == 'selesai')
                            <span class="badge bg-success">Selesai</span>
                        @else
                            <span class="badge bg-secondary">Tidak Diketahui</span>
                        @endif
                    </td>
                    <td>
                        <a href="#" class="btn btn-warning btn-sm" data-toggle="modal" data-target="#modalTanggapan{{$p->id_pengaduan}}" data-placement="top" title="Tanggapan">
                            <i class="fas fa-comment"></i>
                        </a>
                    </td>

                    <!-- Modal untuk Tanggapan -->
                    <div class="modal fade" id="modalTanggapan{{$p->id_pengaduan}}" tabindex="-1" aria-labelledby="modalTanggapanLabel{{$p->id_pengaduan}}" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="modalTanggapanLabel{{$p->id_pengaduan}}">Tanggapan Pengaduan</h5>
                                </div>
                                <form action="{{ route('admin.pengaduan.tanggapan', $p->id_pengaduan) }}" method="POST">
                                    @csrf
                                    @method('POST')
                                    <div class="modal-body">
                                        <!-- ID Pengaduan -->
                                        <div class="form-group">
                                            <label for="id_pengaduan">ID Pengaduan</label>
                                            <input type="text" name="id_pengaduan" id="id_pengaduan{{$p->id_pengaduan}}" value="{{$p->id_pengaduan}}" class="form-control" readonly>
                                        </div>

                                        <!-- Isi Pengaduan -->
                                        <div class="form-group">
                                            <label for="isi_laporan">Isi Pengaduan</label>
                                            <textarea name="isi_laporan" id="isi_laporan{{$p->id_pengaduan}}" rows="4" class="form-control" readonly>{{$p->isi_laporan}}</textarea>
                                        </div>

                                        <!-- Tanggal Tanggapan -->
                                        <div class="form-group">
                                            <label for="tgl_tanggapan">Tanggal Tanggapan</label>
                                            <input type="date" name="tgl_tanggapan" id="tgl_tanggapan{{$p->id_pengaduan}}" class="form-control" readonly>
                                        </div>

                                        <!-- Tanggapan -->
                                        <div class="form-group">
                                            <label for="tanggapan">Tanggapan</label>
                                            <textarea name="tanggapan" id="tanggapan{{$p->id_pengaduan}}" rows="4" class="form-control" placeholder="Tulis tanggapan Anda di sini" required></textarea>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                                        <button type="submit" class="btn btn-primary">Kirim Tanggapan</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                </tr>
                @endforeach
            </tbody>
        </table>
        {{ $pengaduan->links('pagination::bootstrap-5') }}
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        document.querySelectorAll('input[id^="tgl_tanggapan"]').forEach(input => {
            input.value = new Date().toISOString().split('T')[0];
        });
    });
</script>
@endsection