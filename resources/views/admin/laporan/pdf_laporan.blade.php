<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Pengaduan</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }
        .table {
            width: 100%;
            border-collapse: collapse;
        }
        .table-bordered th, .table-bordered td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: center;
        }
        .table-primary {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
    <h1 style="text-align: center;">Laporan Pengaduan</h1>
    <p>Dari Tanggal: <strong>{{ $startDate }}</strong> Sampai Tanggal: <strong>{{ $endDate }}</strong></p>
    <table class="table table-bordered">
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
                @if ($p->status == '0')
                        <span >Belum diproses</span>
                    @elseif ($p->status == 'proses')
                        <span>Proses</span>
                    @elseif ($p->status == 'selesai')
                        <span>Selesai</span>
                    @else
                        <span class="badge ">Tidak Diketahui</span>
                    @endif
                </td>
                <td>{{ $p->isi_laporan }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
