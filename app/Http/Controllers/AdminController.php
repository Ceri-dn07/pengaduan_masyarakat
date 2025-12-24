<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;
use App\Models\Masyarakat;
use App\Models\Pengaduan;
use App\Models\Petugas;
use App\Models\Tanggapan;
use PDF;

class AdminController extends Controller
{
    public function showDashboard()
    {
        $user = Masyarakat::all();
        $jumlahMasyarakat = Masyarakat::count();
        $jumlahPetugas = Petugas::count();
        $pengaduanProses = Pengaduan::where('status', 'proses')->count();
        $pengaduanSelesai = Pengaduan::where('status', 'selesai')->count();

        // Statistik jumlah pengaduan dalam 7 hari terakhir
        $tanggal = [];
        $jumlahPengaduan = [];
        for ($i = 6; $i >= 0; $i--) {
            $tanggal[] = Carbon::now()->subDays($i)->format('Y-m-d');
            $jumlahPengaduan[] = Pengaduan::whereDate('tgl_pengaduan', Carbon::now()->subDays($i)->toDateString())->count();
        }

        // Pengaduan terbaru
        $pengaduanTerbaru = Pengaduan::orderBy('tgl_pengaduan', 'desc')->limit(5)->get();
        return view('admin.dashboard', compact(
            'user', 
            'jumlahMasyarakat',
            'jumlahPetugas',
            'pengaduanProses',
            'pengaduanSelesai',
            'pengaduanTerbaru',
            'tanggal',
            'jumlahPengaduan'));
    }
    
    public function showUser()
    {
        $user = Masyarakat::orderby('nik','ASC')->paginate(5);
        return view('admin.user.user', compact('user'));
    }

    public function showPetugas()
    {
        $petugas = Petugas::orderby('id_petugas','ASC')->paginate(5);
        return view('admin.user.petugas', compact('petugas'));
    }

    public function tambahPetugas(Request $request)
    {
        try {
            $request->validate([
                'nama_petugas' => 'required|string|max:35',
                'username' => 'required|string|max:25|unique:petugas,username',
                'password' => 'required|string|min:8',
                'telp' => 'required|digits_between:10,13',
            ]);

            Petugas::create([
                'nama_petugas' => $request->nama_petugas,
                'username' => $request->username,
                'password' => Hash::make($request['password']),
                'telp' => $request->telp,
                'level' => 'petugas',
            ]);
    
            return redirect()->back()->with('success', 'Data berhasil ditambahkan.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function showPengaduanBaru()
    {
        $pengaduan = Pengaduan::where('status', '0')->orderby('id_pengaduan','ASC')->paginate(5);
        return view('admin.pengaduan.baru', compact('pengaduan'));
    }

    public function verifikasiPengaduan($id)
    {
        $pengaduan = Pengaduan::findOrFail($id);

        $pengaduan->status = 'proses';
        $pengaduan->save();

        return redirect()->back()->with('success', 'Pengaduan berhasil diverifikasi.');
    }

    public function showPengaduanProses()
    {
        $pengaduan = Pengaduan::where('status', 'proses')->orderby('id_pengaduan','ASC')->paginate(5);
        return view('admin.pengaduan.proses', compact('pengaduan'));
    }

    public function tanggapanPengaduan(Request $request, $id)
    {
        $request->validate([
            'id_pengaduan' => 'required|exists:pengaduan,id_pengaduan',
            'isi_laporan' => 'required|string',
            'tgl_tanggapan' => 'required|date',
            'tanggapan' => 'required|string|max:1000',
        ]);
    
        $petugas = Auth::guard('petugas')->user()->id_petugas;
        Tanggapan::create([
            'id_pengaduan' => $request->id_pengaduan,
            'tgl_tanggapan' => $request->tgl_tanggapan,
            'tanggapan' => $request->tanggapan,
            'id_petugas' => $petugas,
        ]);

        $pengaduan = Pengaduan::findOrFail($id);
        $pengaduan->update([
            'status' => 'selesai',
        ]);

        return redirect()->back()->with('success', 'Tanggapan berhasil dikirim.');
    }

    public function showPengaduanSelesai()
    {
        $pengaduan = Pengaduan::where('status', 'selesai')->orderby('id_pengaduan','ASC')->paginate(5);
        return view('admin.pengaduan.selesai', compact('pengaduan'));
    }

    public function showTanggapan()
    {
        $tanggapan = Tanggapan::orderby('id_pengaduan','ASC')->paginate(5);
        return view('admin.tanggapan.tanggapan', compact('tanggapan'));
    }

    public function laporan(Request $request)
    {
        $pengaduan = collect();

        if ($request->has(['start_date', 'end_date'])) {
            $pengaduan = Pengaduan::whereBetween('tgl_pengaduan', [$request->start_date, $request->end_date])->get();
        }

        return view('admin.laporan.layout', compact('pengaduan', 'request'));
    }

    public function generatePdf(Request $request)
    {
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');

        $pengaduan = Pengaduan::whereBetween('tgl_pengaduan', [$startDate, $endDate])->get();

        $pdf = PDF::loadView('admin.laporan.pdf_laporan', compact('pengaduan', 'startDate', 'endDate'))->setPaper('a4', 'landscape');
        return $pdf->stream('Laporan_Pengaduan.pdf');
    }

}
