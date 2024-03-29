<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\RolesBidang;
use App\Models\RolesSeksi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GetRoleController extends Controller
{
    public function getRole()
    {
        $user = Auth::user();
        $id = $user->roles_bidang_id;

        // $rolesBidang = RolesBidang::find($id);

        if ($id == 1) {

            $rolesBidang = RolesBidang::all();
            $rolesSeksi = RolesSeksi::all();
            $response = $rolesBidang;
        } else {
            $rolesSeksi = RolesSeksi::where('roles_bidang_id', $id)->get();
            $response = $rolesSeksi;
        }

        return response()->json([
            'message' => 'success',
            'data' => $response
        ]);
    }
}
