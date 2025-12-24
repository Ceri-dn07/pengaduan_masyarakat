<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Models\Masyarakat;
use App\Models\Pengaduan;
use App\Models\Petugas;
use App\Models\Tanggapan;

class PetugasController extends Controller
{
    public function showDashboard()
    {
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
        return view('petugas.dashboard', compact(
            'jumlahMasyarakat',
            'jumlahPetugas',
            'pengaduanProses',
            'pengaduanSelesai',
            'pengaduanTerbaru',
            'tanggal',
            'jumlahPengaduan'));
    }

    public function showPengaduanBaru()
    {
        $pengaduan = Pengaduan::where('status', '0')->orderby('id_pengaduan','ASC')->paginate(5);
        return view('petugas.pengaduan.baru', compact('pengaduan'));
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
        return view('petugas.pengaduan.proses', compact('pengaduan'));
    }


    public function tanggapanPengaduan(Request $request, $id)
    {
        $request->validate([
            'id_pengaduan' => 'required|exists:pengaduan,id_pengaduan',
            'isi_laporan' => 'required|string|max:1000',
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
        return view('petugas.pengaduan.selesai', compact('pengaduan'));
    }

    public function showTanggapan()
    {
        $tanggapan = Tanggapan::orderby('id_tanggapan','ASC')->paginate(5);
        return view('petugas.tanggapan.tanggapan', compact('tanggapan'));
    }

}
