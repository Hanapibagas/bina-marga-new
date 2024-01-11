<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Pengumuman;
use Illuminate\Http\Request;

class PengumumanController extends Controller
{
    public function getIndexPengmumumann()
    {
        $pengumuman = Pengumuman::orderBy('created_at', 'desc')->first();

        $responseData = [
            'id' => $pengumuman->id,
            'judul' => $pengumuman->judul,
            'file' => $pengumuman->file,
            'tanggal' => $pengumuman->tannggal,
            'users' => $pengumuman->Users,
        ];
        return response()->json([
            'success' => "Berhasil",
            'data' => $responseData
        ]);
    }
}
