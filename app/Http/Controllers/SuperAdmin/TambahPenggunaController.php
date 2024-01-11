<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class TambahPenggunaController extends Controller
{
    public function getStorePengguna()
    {
        $rolesSeksiId = request('roles_seksi_id');

        if ($rolesSeksiId !== null && is_numeric($rolesSeksiId)) {
            User::create([
                'roles_bidang_id' => request('roles_bidang_id'),
                'roles_seksi_id' => (int)$rolesSeksiId,
                'name' => request('name'),
                'email' => request('email'),
                'nip_oprator' => request('nip_oprator'),
                'pangakat' => request('pangakat'),
                'permission_edit' => request('permission_edit'),
                'permission_delete' => request('permission_delete'),
                'permission_upload' => request('permission_upload'),
                'permission_create' => request('permission_create'),
                'permission_download' => request('permission_download'),
                'password' => bcrypt('12345678'),
            ]);
        } else {
            User::create([
                'roles_bidang_id' => request('roles_bidang_id'),
                'roles_seksi_id' => null,
                'name' => request('name'),
                'email' => request('email'),
                'nip_oprator' => request('nip_oprator'),
                'pangakat' => request('pangakat'),
                'permission_edit' => request('permission_edit'),
                'permission_delete' => request('permission_delete'),
                'permission_upload' => request('permission_upload'),
                'permission_create' => request('permission_create'),
                'permission_download' => request('permission_download'),
                'password' => bcrypt('12345678'),
            ]);
        }

        return redirect()->back()->with('status', 'Pengguna berhasil ditambahkan.');
    }

    public function putUpdatepengguna(Request $request, $id)
    {
        $user = User::where('id', $id)->first();

        $data = $request->only([
            'permission_edit',
            'permission_delete',
            'permission_upload',
            'permission_create',
            'permission_download'
        ]);

        $user->update($data);

        return redirect()->back()->with('status', 'Pengguna berhasil diperbarui.');
    }
}
