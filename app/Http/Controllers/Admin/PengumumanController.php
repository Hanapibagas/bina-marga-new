<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pengumuman;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PengumumanController extends Controller
{
    public function getIndex()
    {
        $pengumuman = Pengumuman::orderBy('created_at', 'desc')->get();

        return view('components.pengumuman', compact('pengumuman'));
    }

    public function storePengumuman(Request $request)
    {
        $user = Auth::id();
        if ($request->file('file')) {
            $uploadFile = $request->file('file');
            $originalFileName = $uploadFile->getClientOriginalName();

            $file = $uploadFile->storeAs('pengumuman', $originalFileName, 'public');
        }
        Pengumuman::create([
            'users_id' => $user,
            'judul' => $request->input('judul'),
            'file' => $file,
            'tannggal' => $request->input('tannggal'),
        ]);

        return redirect()->back()->with('status', 'Selamat data anda berhasil terinput');
    }

    public function putPengumuman(Request $request, $id)
    {
        $pengumuman = Pengumuman::where('id', $id)->first();
        if ($request->file('file')) {
            $uploadFile = $request->file('file');
            $originalFileName = $uploadFile->getClientOriginalName();

            $file = $uploadFile->storeAs('pengumuman', $originalFileName, 'public');
        }

        $pengumuman->update([
            'judul' => $request->input('judul'),
            'file' => $file,
            'tannggal' => $request->input('tannggal'),
        ]);

        return redirect()->back()->with('status', 'Selamat data anda berhasil diperbarui');
    }

    public function deletePengumuman($id)
    {
        $pengumuman = Pengumuman::where('id', $id)->first();

        $pengumuman->delete();

        return redirect()->back()->with('status', 'Selamat data anda berhasil dihapus');
    }
}
