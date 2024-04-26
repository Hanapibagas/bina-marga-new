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
        $user = User::where('id', '>', 1)->get();
        $roles = RolesBidang::join('users', 'users.id', '=', 'roles_bidangs.users_id')
            ->select('users.email', 'roles_bidangs.id', 'roles_bidangs.name_bidang')
            ->get();

        return view('components.struktur-organisasi', compact('roles', 'user'));
    }

    public function getSeksi()
    {
        $user = User::where('id', '>', 1)->get();
        $roles = RolesBidang::where('id', '>', 1)->get();
        $rolesSeksi = RolesSeksi::leftJoin('roles_bidangs', 'roles_bidangs.id', '=', 'roles_seksis.roles_bidang_id')
            ->join('users', 'users.id', '=', 'roles_seksis.users_id')
            ->select('users.email', 'roles_seksis.id', 'roles_seksis.name_seksi',  'roles_bidangs.name_bidang')
            ->get();

        // return response()->json($rolesSeksi);
        return view('components.struktur-organisasi-seksi', compact('roles', 'user', 'rolesSeksi'));
    }

    public function postSeksi(Request $request)
    {
        $role = RolesSeksi::create([
            'roles_bidang_id' => $request->roles_bidang_id,
            'users_id' => $request->users_id,
            'name_seksi' => $request->name_seksi
        ]);

        $user = User::find($request->users_id);

        if ($user) {
            $user->roles_seksi_id = $role->id;
            $user->save();
        }

        return redirect()->back()->with('status', 'Selamat data anda berhasil terinput');
    }

    public function postStrukturOrganisasi(Request $request)
    {
        $role = RolesBidang::create([
            'users_id' => $request->users_id,
            'name_bidang' => $request->name_bidang
        ]);

        $user = User::find($request->users_id);

        if ($user) {
            $user->roles_bidang_id = $role->id;
            $user->save();
        }

        return redirect()->back()->with('status', 'Selamat data anda berhasil terinput');
    }

    public function updateNameBidang(Request $request, $id)
    {
        $update = RolesBidang::find($id);

        if (!$update) {
            return redirect()->back()->with('error', 'Data tidak ditemukan');
        }

        $update->update([
            'users_id' => $request->users_id,
            'name_bidang' => $request->name_bidang
        ]);

        return redirect()->back()->with('status', 'Selamat data anda berhasil diperbarui');
    }
    public function updateNameSeksi(Request $request, $id)
    {
        $update = RolesSeksi::find($id);

        if (!$update) {
            return redirect()->back()->with('error', 'Data tidak ditemukan');
        }

        $update->update([
            'users_id' => $request->users_id,
            'roles_bidang_id' => $request->roles_bidang_id,
            'name_seksi' => $request->name_seksi
        ]);

        return redirect()->back()->with('status', 'Selamat data anda berhasil diperbarui');
    }

    public function deleteNameBidang(Request $request, $name_bidang)
    {
        $role = RolesBidang::where('name_bidang', $name_bidang)->first();
        $role->delete();

        return redirect()->back()->with('status', 'Selamat data anda berhasil terhapus');
    }
    public function deleteNameSeksi(Request $request, $name_seksi)
    {
        $role = RolesSeksi::where('name_seksi', $name_seksi)->first();
        $role->delete();

        return redirect()->back()->with('status', 'Selamat data anda berhasil terhapus');
    }
}
