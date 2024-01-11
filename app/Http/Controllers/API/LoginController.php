<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;

class LoginController extends Controller
{
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required',
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors(), 400);
        }

        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            $user = Auth::user();
            $success['token'] =  $user->createToken('MyApp')->accessToken;
            $success['id'] =  $user->id;
            $success['roles'] =  $user->roles;
            $success['name'] =  $user->name;
            $success['permission_edit'] =  $user->permission_edit;
            $success['permission_upload'] =  $user->permission_upload;
            $success['permission_edit'] =  $user->permission_edit;
            $success['permission_create'] =  $user->permission_create;
            $success['permission_download'] =  $user->permission_download;

            return response()->json([
                'message' => 'Login successful.',
                'data' => $success
            ], 200);
        } else {
            return response()->json([
                'message' => 'Login failed.',
                'error' => 'Mohon maaf email atau password yang dimasukkan salah'
            ], 401);
        }
    }

    public function getDetailsUser()
    {
        $user = Auth::user();

        $foto = null;
        if ($user->picture) {
            $foto = asset('storage/' . $user->picture);
        }

        $user->picture = $foto;

        return response()->json([
            'message' => 'Successful.',
            'data' => $user
        ], 200);
    }

    public function putUpdateProfile(Request $request)
    {
        $user = Auth::user();
        $validator = Validator::make($request->all(), [
            'nama_penanggung_jawab' => 'string|max:255',
            'nip_oprator' => 'string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 400,
                'message' => 'Validation Error',
                'errors' => $validator->errors(),
            ], 400);
        }

        if ($request->has('nama_penanggung_jawab')) {
            $user->nama_penanggung_jawab = $request->input('nama_penanggung_jawab');
        }

        if ($request->has('nip_oprator')) {
            $user->nip_oprator = $request->input('nip_oprator');
        }

        if ($request->file('picture')) {
            $uploadedFile = $request->file('picture');
            $originalFileName = $uploadedFile->getClientOriginalName();

            $file = $uploadedFile->storeAs('foto-profile', $originalFileName, 'public');
            $user->picture = $file;
        }

        $user->save();

        return response()->json([
            'status' => 200,
            'message' => 'Profile updated successfully',
            'data' => $user,
        ], 200);
    }

    public function postPassword(Request $request)
    {
        $user = auth()->user(); // Mengambil pengguna yang sedang masuk

        // Validasi permintaan
        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|string|min:8|confirmed',
        ]);

        // Periksa apakah password saat ini benar
        if (!Hash::check($request->current_password, $user->password)) {
            return response()->json(['message' => 'Password saat ini salah'], 422);
        }

        // Perbarui password
        $user->update([
            'password' => Hash::make($request->new_password),
        ]);

        return response()->json(['message' => 'Password berhasil diperbarui']);
    }
}
