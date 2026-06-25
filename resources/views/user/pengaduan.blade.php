@extends('user.app')

@section('content')

<div class="container-fluid pt-5">
<form action="/user/pengaduan" class="mt-3" method="GET">
    <div class="row ">
        <div class="col-md-3">
            <label for="status" class="form-label">Status Pengaduan</label>
            <select name="status" id="status" class="form-control">
                <option value="">Pilih Status</option>
                <option value="0" @if(request('status') == '0') selected @endif>Belum Diterima</option>
                <option value="proses" @if(request('status') == 'proses') selected @endif>Dalam Proses</option>
                <option value="selesai" @if(request('status') == 'selesai') selected @endif>Selesai</option>
            </select>
        </div>
        <div class="col-md-3">
            <label for="start_date" class="form-label">Dari Tanggal</label>
            <input type="date" id="start_date" name="start_date" value="{{ request('start_date') }}" class="form-control">
        </div>
        <div class="col-md-3">
            <label for="end_date" class="form-label">Sampai Tanggal</label>
            <input type="date" id="end_date" name="end_date" value="{{ request('end_date') }}" class="form-control" >
        </div>
        <div class="col-md-3 d-flex align-items-end">
            <button type="submit" class="btn btn-info w-100 mr-3">Cari Pengaduan</button>
            <a href="/user/pengaduan" class="btn btn-secondary ms-2 w-100">Reset</a>
        </div>
    </div>
</form>
<a href="#" class="btn btn-primary mt-3 mb-3 mr-5 " style="width: 24%;" data-toggle="modal" data-target="#modalPengaduan" >
    <i class="fas fa-plus-square-o"></i> Tambah Pengaduan
</a>
    <table class="table table-striped table-responsive">
        <thead>
            <tr>
                <th class="w-auto text-nowrap">No.</th>
                <th class="w-auto text-nowrap">Tanggal Pengaduan</th>
                <th>Isi Laporan</th>
                <th>Foto</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
        </thead>
        @if($pengaduan->isNotEmpty())
        <tbody class="justify-content-center">
            @foreach($pengaduan as $index => $p)
            <tr>
                <td class="w-auto text-nowrap">{{ $index + 1}}</td>
                <td class="w-auto text-nowrap">{{ $p->tgl_pengaduan }}</td>
                <td class="text-truncate w-25">
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
                        Tidak ada bukti
                    @endif
                </td>
                <td>
                    @if ($p->status == '0')
                        <span class="badge bg-secondary text-white">Belum diterima</span>
                    @elseif ($p->status == 'proses')
                        <span class="badge bg-warning text-dark">Diproses</span>
                    @elseif ($p->status == 'selesai')
                        <span class="badge bg-success">Selesai</span>
                    @else
                        <span class="badge bg-secondary">Tidak Diketahui</span>
                    @endif
                </td>
                <td>
                    @if ($p->status == '0')
                    <form action="{{ route('user.pengaduan.hapus', $p->id_pengaduan) }}" method="POST" style="display:inline;" id="verifikasiForm{{$p->id_pengaduan}}">
                        @csrf
                        @method('DELETE')
                        <button type="button" class="btn btn-danger btn-sm" title="Verifikasi" id="verifikasiBtn{{$p->id_pengaduan}}">
                            <i class="fas fa-trash"></i>
                        </button>
                    </form>
                    @elseif ($p->status == 'proses')
                    <span class="badge bg-warning text-dark">Menunggu...</span>
                    @elseif ($p->status == 'selesai')
                    <a href="#" class="btn btn-success btn-sm" data-toggle="modal" data-target="#modalTampilTanggapan{{$p->id_pengaduan}}" data-placement="top" title="Lihat Tanggapan">
                        <i class="fas fa-eye"></i>
                    </a>

                    <!-- Modal Lihat Tanggapan -->
                    <div class="modal fade" id="modalTampilTanggapan{{$p->id_pengaduan}}" tabindex="-1" aria-labelledby="modalTampilTanggapanLabel{{$p->id_pengaduan}}" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="modalTampilTanggapanLabel{{$p->id_pengaduan}}">Detail Tanggapan</h5>
                                    <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
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
                    @else
                        <span class="badge bg-secondary">Tidak Diketahui</span>
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
        @else
            <div class="alert alert-info text-center">
                <strong>Tidak ada data pengaduan</strong>
            </div>
        @endif
    </table>
    <!-- Modal Form Tambah Pengaduan -->
    <div class="modal fade" id="modalPengaduan" tabindex="-1" role="dialog" aria-labelledby="modalPengaduanLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalPengaduanLabel">Form Tambah Data Pengaduan</h5>
                </div>

                <form id="pengaduanForm" action="/user/pengaduan/tambah" method="post">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="tgl_pengaduan">Tanggal Pengaduan</label>
                            <input type="date" id="tgl_pengaduan" name="tgl_pengaduan" readonly class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="isi_laporan">Isi</label>
                            <textarea id="isi_laporan" name="isi_laporan" required class="form-control"></textarea>
                        </div>
                        <div class="form-group">
                            <label for="foto">Foto</label>
                            <input type="file" id="foto" name="foto" required class="form-control">
                        </div>
                    </div>
                    
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                        <button type="button" class="btn btn-primary" onclick="submitFormWithNotification()">Tambah</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{ $pengaduan->links('pagination::bootstrap-5') }}

    <script>
        document.getElementById('tgl_pengaduan').value = new Date().toISOString().split('T')[0];

        function submitFormWithNotification() {
            const form = document.getElementById('pengaduanForm');
            if (!form.checkValidity()) {
                form.reportValidity();
                return;
            }

            Swal.fire({
                title: 'Sukses!',
                text: 'Data telah berhasiil ditambahkan',
                icon: 'success',
                confirmButtonText: 'OK',
            }).then((result) => {
                if (result.isConfirmed) {
                    const formData = new FormData(form);

                    fetch(form.action, {
                        method: 'POST',
                        body: formData,
                    })
                    .then(response => {
                        if (response.ok) {
                            window.location.href = '/user/pengaduan';
                        } else {
                            Swal.fire({
                                title: 'Error!',
                                text: 'Terjadi kesalahan saat memproses pesanan.',
                                icon: 'error',
                                confirmButtonText: 'OK',
                                background: '#3D3B40',
                                color: '#FFFFFF',
                                confirmButtonColor: '#B8001F'
                            });
                        }
                    })
                    .catch(error => {
                        Swal.fire({
                            title: 'Error!',
                            text: 'Tidak dapat menghubungi server.',
                            icon: 'error',
                            confirmButtonText: 'OK',
                            background: '#3D3B40',
                            color: '#FFFFFF',
                            confirmButtonColor: '#B8001F'
                        });
                    });
                }
            });
        }

        document.querySelectorAll('[id^="verifikasiBtn"]').forEach(function(btn) {
            btn.addEventListener('click', function(e) {
                e.preventDefault();

                const formId = 'verifikasiForm' + btn.id.replace('verifikasiBtn', '');

                Swal.fire({
                    title: 'Apakah Anda yakin?',
                    text: "Anda akan menghapus pengaduan ini.",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Hapus',
                    cancelButtonText: 'Batal',
                    reverseButtons: true
                }).then((result) => {
                    if (result.isConfirmed) {
                        document.getElementById(formId).submit();
                    } else {
                        Swal.fire(
                            'Dibatalkan',
                            'Pengaduan tidak jadi dihapus.',
                            'info'
                        );
                    }
                });
            });
        });

        function toggleTeks(tombol) {
            var lengkap = tombol.parentElement;
            var teksSisa = lengkap.querySelector('#teks-sisa');

            if(teksSisa.style.display === "none") {
                teksSisa.style.display = "inline";
                tombol.innerText = "Sembunyikan";
            } else {
                teksSisa.style.display = "none";
                tombol.innerText =" ...Selengkapnya"
            }
        }
    </script>
    
</div>
</div>
</div>
@endsection