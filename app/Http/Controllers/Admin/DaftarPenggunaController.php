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
        $rolesBidang = RolesBidang::create([
            'name' => $request->name,
        ]);

        if ($request->has('nama')) {
            foreach ($request->nama as $namaSubBagian) {
                $rolesSeksi = new RolesSeksi([
                    'nama' => $namaSubBagian,
                ]);

                $rolesBidang->rolesSeksi()->save($rolesSeksi);
            }
        }

        return redirect()->back()->with('status', 'Selamat data anda berhasil terinput');
    }
}
