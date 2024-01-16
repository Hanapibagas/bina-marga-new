<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\RolesBidang;
use App\Models\RolesSeksi;
use App\Models\User;
use Illuminate\Http\Request;

class DaftarPenggunaController extends Controller
{
    public function getIndex()
    {
        $pengguna = User::with('RolesBidang', 'RolesSeksi')->where('id', '>', 1)->get();
        $roles = RolesBidang::with('RolesSeksi')->where('id', '>', 1)->get();
        $subBagian = RolesSeksi::all();

        return view('components.list-pengguna', compact('pengguna', 'roles', 'subBagian'));
    }

    public function getStrukturOrganisasi()
    {
        $roles = RolesBidang::with('RolesSeksi')->where('id', '>', 1)->get();

        return view('components.struktur-organisasi', compact('roles'));
    }

    public function postStrukturOrganisasi(Request $request)
    {
        if ($request->has('name')) {
            $rolesBidang = RolesBidang::create([
                'name' => $request->name[0],
            ]);

            foreach ($request->name as $namaSubBagian) {
                $rolesSeksi = new RolesSeksi([
                    'name' => $namaSubBagian,
                ]);

                $rolesBidang->rolesSeksi()->save($rolesSeksi);
            }

            return redirect()->back()->with('status', 'Selamat data anda berhasil terinput');
        } else {
            return redirect()->back()->with('status', 'Gagal input data. Nama tidak ditemukan.');
        }
    }
}
