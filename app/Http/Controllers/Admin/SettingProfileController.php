<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class SettingProfileController extends Controller
{
    public function getIndex()
    {
        $login = Auth::user();
        $user = User::find($login->id);

        return view('components.pengaturan', compact('user'));
    }

    public function postUpdatePassword(Request $request)
    {
        $user = Auth::user();

        $user->nama_penanggung_jawab = $request->nama_penanggung_jawab;
        $user->nip_oprator = $request->nip_oprator;
        $user->password = Hash::make($request->password);

        $user->save();

        return redirect()->back()->with('status', 'Selamat data profile anda berhasil diperbarui');
    }
}
