<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\DataCenter;
use Illuminate\Http\Request;

class DetailsFolderController extends Controller
{
    public function getDetails($id)
    {
        $details = DataCenter::where('id', $id)->get();

        if ($details) {
            return response()->json([
                'error' => 'Data profile tidak ditemukan'
            ], 400);
        }

        $foto = asset('storage/' . $details->picture);

        return response()->json([
            'data' => [
                '$details
        ]);
    }
}
