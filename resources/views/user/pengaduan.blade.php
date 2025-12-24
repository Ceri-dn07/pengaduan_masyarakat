@extends('user.app')

@section('content')

<!-- <style>
    .table-responsive{
        width: 100%;
        overflow-x: auto;
    }
    .table{
        width: 100%;
        /* max-width: 100%; Membatasi lebar maksimal */
        /* table-layout: fixed; Membuat kolom memiliki lebar tetap */
        text-align: center; /* Mengatur teks menjadi di tengah */
        vertical-align: middle; /* Pastikan juga sejajar secara vertikal */
    }

    .table td,
    .table th {
        /* word-wrap: break-word; Memastikan teks tidak melampaui kolom */
        /* white-space: normal; Mengizinkan teks terbungkus */
    }

    
</style> -->

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
            <button type="submit" class="btn btn-info" style="width: 100%;">Cari Pengaduan</button>
        </div>
    </div>
</form>
<a href="#" class="btn btn-primary mt-3 mb-3 mr-5 " style="width: 24%;" data-toggle="modal" data-target="#modalPengaduan" >
    <i class="fas fa-plus-square-o"></i> Tambah Pengaduan
</a>

<p>
    <div class="table-responsive">
        <table class="table table-striped">
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
            <tbody class="justify-content-center">
                @foreach($pengaduan as $index => $p)
                <tr>
                    <td class="w-auto text-nowrap">{{ $index + 1}}</td>
                    <td class="w-auto text-nowrap">{{ $p->tgl_pengaduan }}</td>
                    <td class="text-truncate w-25">{{ $p->isi_laporan }}</td>
                    <td>@if($p->foto)
                    <a href="{{ asset('foto_pengaduan') }}/{{($p->foto) }}" target="_blank"><img src="{{ asset('foto_pengaduan/' . $p->foto) }}" alt="Foto Pengaduan" style="width: 50px; height: 50px;"></a>
                        @else
                            Tidak ada bukti
                        @endif
                    </td>
                    <td>
                        @if ($p->status == '0')
                            <span class="badge bg-secondary">Belum diterima</span>
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
                        <span class="badge bg-secondary">Menunggu...</span>
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
        </table>
    </div>

    <!-- Modal Form Tambah Pengaduan -->
    <div class="modal fade" id="modalPengaduan" tabindex="-1" role="dialog" aria-labelledby="modalPengaduanLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalPengaduanLabel">Form Tambah Data Pengaduan</h5>
                </div>

                <form id="pengaduanForm" action="/user/pengaduan/tambah" method="post">
                    @csrf <!-- Tambahkan CSRF token -->
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
    <!-- Akhir Modal Form Tambah Pengaduan -->

    
    <!--awal pagination-->
    {{ $pengaduan->links('pagination::bootstrap-5') }}

    <!--akhir pagination-->

    <script>
        // Mengisi input tanggal dengan tanggal hari ini
        document.getElementById('tgl_pengaduan').value = new Date().toISOString().split('T')[0];

        // Fungsi Button
        function submitFormWithNotification() {
            // Validasi manual (opsional, karena `required` sudah cukup)
            const form = document.getElementById('pengaduanForm');
            if (!form.checkValidity()) {
                form.reportValidity();
                return;
            }

             // Tampilkan notifikasi SweetAlert2
            Swal.fire({
                title: 'Sukses!',
                text: 'Data telah berhasiil ditambahkan',
                icon: 'success',
                confirmButtonText: 'OK',
            }).then((result) => {
                if (result.isConfirmed) {
                    // Kirim form dengan JavaScript
                    const formData = new FormData(form);

                    // Kirim menggunakan Fetch API
                    fetch(form.action, {
                        method: 'POST',
                        body: formData,
                    })
                    .then(response => {
                        if (response.ok) {
                            // Arahkan ke halaman cetak PDF
                            window.location.href = '/user/pengaduan';
                        } else {
                            // Tampilkan pesan error jika gagal
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
                        // Tangani error jaringan
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
    </script>
    
</div>
</div>
</div>
@endsection