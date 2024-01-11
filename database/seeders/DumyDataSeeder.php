<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\RolesBidang;
use App\Models\RolesSeksi;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DumyDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        RolesBidang::create([
            'name' => 'super_admin'
        ]);
        RolesBidang::create([
            'name' => 'sekretarian'
        ]);
        RolesSeksi::create([
            'roles_bidang_id' => 2,
            'nama' => 'bidang bina teknik'
        ]);

        User::create([
            'name' => 'Ir. Hj. Astina Abbas, MT',
            'email' => 'superadmin@admin.com',
            'nama_penanggung_jawab' => 'Ir. Hj. Astina Abbas, MT',
            'nip_oprator' => '196610011992032017',
            'pangakat' => 'Pembina Tk.I - IV/b',
            'roles_bidang_id' => 1,
            'permission_edit' => '1',
            'permission_delete' => '1',
            'permission_upload' => '1',
            'permission_create' => '1',
            'permission_download' => '1',
            'password' => bcrypt('12345678')
        ]);


        User::create([
            'name' => 'Sekretariat',
            'email' => 'sekretariat@admin.com',
            'nama_penanggung_jawab' => 'sekretariat',
            'nip_oprator' => '196610011992032017',
            'pangakat' => 'sekretariat',
            'roles_bidang_id' => 2,
            'permission_edit' => '1',
            'permission_delete' => '1',
            'permission_upload' => '1',
            'permission_create' => '1',
            'permission_download' => '1',
            'password' => bcrypt('12345678')
        ]);

        User::create([
            'name' => 'subbagian program',
            'email' => 'bagianprogram@admin.com',
            'nama_penanggung_jawab' => 'bagianprogram',
            'nip_oprator' => '196610011992032017',
            'pangakat' => 'bagianprogram',
            'roles_bidang_id' => 2,
            'roles_seksi_id' => 1,
            'permission_edit' => '1',
            'permission_delete' => '1',
            'permission_upload' => '1',
            'permission_create' => '1',
            'permission_download' => '1',
            'password' => bcrypt('12345678')
        ]);
    }
}
