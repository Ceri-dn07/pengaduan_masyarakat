<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use App\Models\Pengaduan;

class UserController extends Controller
{
    public function showPengaduan(Request $request)
    { 
        $user = Auth::user()->nik;

        $query = Pengaduan::where('nik', $user);

        if ($request->status != '') {
            $query->where('status', $request->status);
        } 

        if ($request->filled('start_date')) {
            $query->where('tgl_pengaduan', '>=', $request->start_date);
        }

        if($request->filled('end_date')) {
            $query->where('tgl_pengaduan', '<=', $request->end_date);
        }

        $pengaduan = $query->orderBy('id_pengaduan', 'ASC')->paginate(5);

        return view('user.pengaduan', compact('pengaduan', 'request'));
    }

    public function pengaduanTambah(Request $request)
    {
        try {
            $request->validate([
                'tgl_pengaduan' => 'required|date',
                'isi_laporan' => 'required|string',
                'foto' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            ]);

            $nik = Auth::user()->nik;

            $buktiPath = null;
            if ($request->hasFile('foto') && $request->file('foto')->isValid()) {
                $file = $request->file('foto');
                $buktiPath = time() . "_" . $file->getClientOriginalName();
                
                $tujuanupload = public_path('foto_pengaduan');
                if (!file_exists($tujuanupload)) {
                    mkdir($tujuanupload, 0755, true);
                }
                try {
                    $file->move($tujuanupload, $buktiPath);
                } catch (\Exception $e) {
                    return redirect()->back()->with('error', 'Gagal menyimpan file foto: ' . $e->getMessage());
                }
            } else {
                return redirect()->back()->with('error', 'Foto wajib diunggah!');
            }

            Pengaduan::create([
                'tgl_pengaduan' => $request->tgl_pengaduan,
                'nik' => $nik,
                'isi_laporan' => $request->isi_laporan,
                'foto' => $buktiPath,
                'status' => '0',
            ]);
    
            return redirect()->back()->with('success', 'Data berhasil disimpan');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function pengaduanHapus($id)
    {
        $pengaduan = Pengaduan::findOrFail($id);
        $pengaduan->delete();

        return redirect()->back()->with('success', 'Data berhasil dihapus.');
    }

}
