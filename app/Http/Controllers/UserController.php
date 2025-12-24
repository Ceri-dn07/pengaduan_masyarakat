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
        // $request->validate([
        //     'start_date' => 'required_with:end_date|date',
        //     'end_date' => 'required_with:start_date|date|after_or_equal:start_date',
        // ], [
        //     'start_date.required_with' => 'Tanggal awal harus diisi jika tanggal akhir diisi.',
        //     'end_date.required_with' => 'Tanggal akhir harus diisi jika tanggal awal diisi.',
        //     'end_date.after_or_equal' => 'Tanggal akhir harus sama atau setelah tanggal awal.',
        // ]);
        // Ambil data pengguna yang sedang login
        $user = Auth::user()->nik;

        $query = Pengaduan::where('nik', $user);

        if ($request->has('status') && $request->status != '') {
            $query->where('status', $request->status);
        } else if ($request->has('start_date') && $request->has('end_date')) {
            $query->whereBetween('tgl_pengaduan', [$request->start_date, $request->end_date]);
        } else if($request->has('status') && $request->has('start_date') && $request->has('end_date')) {

        }

        // Ambil data pengaduan yang sudah difilter dan urutkan berdasarkan id_pengaduan
        $pengaduan = $query->orderBy('id_pengaduan', 'ASC')->paginate(5);

        return view('user.pengaduan', compact('pengaduan'));
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

    public function pengaduanEdit()
    {

    }

    public function pengaduanHapus($id)
    {
        $pengaduan = Pengaduan::findOrFail($id);
        $pengaduan->delete();

        return redirect()->back()->with('success', 'Data berhasil dihapus.');
    }

    // public function showProfil()
    // {
    //     $user = Auth::user()->nik;
    //     $masyarakat = Masyarakat::where('nik', $user);
    //     return view('user.profil', compact('masyarakat'));
    // }

    // public function updateProfile(Request $request)
    // {
    //     // Validasi data input
    //     $request->validate([
    //         'nik' => 'required|numeric',
    //         'nama' => 'required|string|max:255',
    //         'username' => 'required|string|max:255|unique:users,username,' . auth()->id(),
    //         'telp' => 'required|numeric',
    //     ]);

    //     // Update data pengguna
    //     $user = auth()->user();
    //     $user->update([
    //         'nik' => $request->nik,
    //         'nama' => $request->nama,
    //         'username' => $request->username,
    //         'telp' => $request->telp,
    //     ]);

    //     // Redirect kembali dengan pesan sukses
    //     return back()->with('success', 'Profil berhasil diperbarui.');
    // }

    // public function updatePassword(Request $request)
    // {
    //     // Validasi data input
    //     $request->validate([
    //         'current_password
    //         ' => 'required',
    //         'new_password' => 'required|min:8',
    //         'confirm_password' => 'required|same:new_password',
    //         'nik' => 'required|numeric',
    //         'nama' => 'required|string|max:255',
    //         'username' => 'required|string|max:255|unique:users,username,' . auth()->id(),
    //         'telp' => 'required|numeric',
    //     ]);
    //         // Cek apakah password lama benar
    //         if (!Hash::check($request->current_password, auth()->user()->password)) {
    //             return back()->with('error', 'Password lama tidak sesuai.');
    //         }

    //         // Update password
    //         auth()->user()->update([
    //             'password' => Hash::make($request->new_password),
    //         ]);
    //         // Redirect kembali dengan pesan sukses
    //         return back()->with('success', 'Password berhasil diperbarui.');

    // }

}
