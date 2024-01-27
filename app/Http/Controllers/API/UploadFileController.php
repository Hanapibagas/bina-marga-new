<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Ativitas;
use App\Models\DataCenter;
use App\Models\DownloadLog;
use App\Models\LogEdit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Lcobucci\JWT\Token\DataSet;

class UploadFileController extends Controller
{
    public function storeFile(Request $request)
    {
        $user = Auth::id();
        $file = null;

        if ($request->file('folder_name')) {
            $uploadedFile = $request->file('folder_name');
            $originalFileName = $uploadedFile->getClientOriginalName();

            $file = $uploadedFile->storeAs('folder-file', $originalFileName, 'public');
        }

        if ($file) {
            $DataCenter = DataCenter::create([
                'folder_name' => $file,
                'users_id' => $user,
                'parent_name_id' => $request->input('parent_name_id'),
                'tanggal' => date('Y-m-d'),
            ]);

            Ativitas::create([
                'users_id' => $user,
                'file_id' => $DataCenter->id
            ]);

            return response()->json([
                'message' => 'successful.',
                'data' => $DataCenter
            ], 200);
        } else {
            return response()->json(['data' => 'Error'], 400);
        }
    }

    public function Folder(Request $request)
    {
        $user = Auth::id();

        $DataCenter = DataCenter::create([
            'folder_name' => $request->input('folder_name'),
            'users_id' => $user,
            'parent_name_id' => $request->input('parent_name_id'),
            'tanggal' => date('Y-m-d'),
        ]);

        Ativitas::create([
            'users_id' => $user,
            'file_id' => $DataCenter->id
        ]);

        if ($DataCenter) {
            return response()->json([
                'message' => 'successful.',
                'data' => $DataCenter
            ], 200);
        } else {
            return response()->json(['data' => 'Error'], 400);
        }
    }

    public function getListData()
    {
        $user = Auth::user();

        // if ($user->hasRole('super_admin')) {
        //     $dataCenters = DataCenter::where('is_recycle', true)->get();
        // } else {
        //     $userId = $user->id;
        //     $dataCenters = DataCenter::where('users_id', $userId)
        //         ->where('is_recycle', true)
        //         ->get();
        // }
        $rolesBidang = $user->rolesBidang;

        $rolesSeksi = $user->rolesSeksi;

        $dataCenters = DataCenter::where(function ($query) use ($user) {
            if ($user->rolesBidang->id != 1) {
                if ($user->rolesSeksi) {
                    $query->where('roles_seksi_id', $user->rolesSeksi->id)->where('is_recycle', 1);
                } else {
                    $query->where('roles_bidang_id', $user->rolesBidang->id)->where('is_recycle', 1);
                }
            }
            $query->where('is_recycle', 1);
        })->get();

        $responseData = [];

        foreach ($dataCenters as $dataCenter) {
            $fileExtension = pathinfo($dataCenter->folder_name, PATHINFO_EXTENSION);

            $fileType = 'folder';
            if (in_array($fileExtension, [
                'docx', 'doc',
                'pdf', 'doc',
                'ppt', 'txt',
                'pptx', 'ppt',
                'xlsx', 'xls',
                'jpg', 'png',
                'jpeg', 'gif',
                'svg', 'webp',
                'mp4', 'avi',
                'mkv', 'wmv',
                'mpg', 'mpeg',
                'ogg', '3gp',
                'mp3', 'wav',
                'sql', 'html'
            ])) {
                $fileType = $fileExtension;
            }

            $fileUrl = null;
            if (file_exists(asset('storage/' . $dataCenter->folder_name))) {
                $fileUrl = asset('storage/' . $dataCenter->folder_name);
            }
            if ($fileType != "folder") {
                $fileSize = filesize(public_path('storage/' . $dataCenter->folder_name));

                if ($fileSize >= 1024 * 1024 * 1024) {
                    $formattedSize = round($fileSize / (1024 * 1024 * 1024), 2) . ' GB';
                } elseif ($fileSize >= 1024 * 1024) {
                    $formattedSize = round($fileSize / (1024 * 1024), 2) . ' MB';
                } elseif ($fileSize >= 1024) {
                    $formattedSize = round($fileSize / 1024, 2) . ' KB';
                } else {
                    $formattedSize = $fileSize . ' B';
                }
            } else {
                $formattedSize = null;
            }

            $responseData[] = [
                'id' => $dataCenter->id,
                'fileName' => $dataCenter->folder_name,
                'fileType' => $fileType,
                'fileSize' => $formattedSize ?: null,
                'timeAgo' => $dataCenter->created_at->diffForHumans(),
                'fileUrl' => $fileUrl,
                'parentNameId' => $dataCenter->parent_name_id,
                'users' => $dataCenter->users,
            ];
        }

        return response()->json([
            'message' => 'successful.',
            'data' => $responseData
        ]);
    }

    public function getListFoder()
    {
        $user = Auth::user();
        $userId = $user->id;

        $rolesBidang = $user->rolesBidang;

        $rolesSeksi = $user->rolesSeksi;

        $dataCenters = DataCenter::where(function ($query) use ($user) {
            if ($user->rolesBidang->id != 1) {
                if ($user->rolesSeksi) {
                    $query->where('roles_seksi_id', $user->rolesSeksi->id)->where('is_recycle', 1);
                } else {
                    $query->where('roles_bidang_id', $user->rolesBidang->id)->where('is_recycle', 1);
                }
            }
            $query->where('is_recycle', 1);
        })->get();

        $responseData = [];

        foreach ($dataCenters as $dataCenter) {
            $folderName = $dataCenter->folder_name;

            if (strpos($folderName, 'folder-file') !== 0) {
                $responseData[] = [
                    'id' => $dataCenter->id,
                    'fileName' => $folderName,
                    'users_id' => $dataCenter->Users,
                ];
            }
        }

        return response()->json([
            'message' => 'successful.',
            'data' => $responseData,
        ]);
    }

    public function getListFile()
    {
        $user = Auth::user();
        $userId = $user->id;

        $rolesBidang = $user->rolesBidang;

        $rolesSeksi = $user->rolesSeksi;

        $dataCenters = DataCenter::where(function ($query) use ($user) {
            if ($user->rolesBidang->id != 1) {
                if ($user->rolesSeksi) {
                    $query->where('roles_seksi_id', $user->rolesSeksi->id)->where('is_recycle', 1);
                } else {
                    $query->where('roles_bidang_id', $user->rolesBidang->id)->where('is_recycle', 1);
                }
            }
            $query->where('is_recycle', 1);
        })->get();

        $responseData = [];

        foreach ($dataCenters as $dataCenter) {
            $folderName = $dataCenter->folder_name;

            if (str_starts_with($folderName, 'folder-file')) {
                $responseData[] = [
                    'id' => $dataCenter->id,
                    'fileName' => $folderName,
                    'users_id' => $dataCenter->users
                ];
            }
        }

        return response()->json([
            'message' => 'successful.',
            'data' => $responseData
        ]);
    }

    public function putEditFolder(Request $request, $id)
    {
        $user = Auth::user();

        $dataCenter = DataCenter::find($id);

        if (!$dataCenter) {
            return response()->json(['error' => 'DataCenter not found'], 404);
        }

        $dataCenter->update([
            'folder_name' => $request->input('folder_name')
        ]);

        LogEdit::create([
            'users_id' => $user->id,
            'file_id' => $dataCenter->id
        ]);


        return response()->json([
            'message' => 'DataCenter updated successfully',
            'data' => $dataCenter
        ]);
    }

    public function putEditStatus(Request $request, $id)
    {
        $dataCenter = DataCenter::find($id);

        if (!$dataCenter) {
            return response()->json(['error' => 'DataCenter not found'], 404);
        }

        $dataCenter->is_recycle = $request->input('is_recycle');
        $dataCenter->save();

        return response()->json([
            'message' => 'DataCenter updated successfully',
            'data' => $dataCenter
        ]);
    }

    public function getLogFolder($id)
    {
        $fileId = DataCenter::find($id);

        $logAtivitas = Ativitas::where('file_id', $fileId->id)->get();
        $logEdit = LogEdit::where('file_id', $fileId->id)->get();
        $logDownload = DownloadLog::where('file_id', $fileId->id)->get();

        $usersAtivitas = [];
        $usersLogEdit = [];
        $usersDownload = [];

        foreach ($logAtivitas as $log) {
            $usersAtivitas[] = [
                'name' => $log->Users->nama_penanggung_jawab,
                'nip_operator' => $log->Users->nip_oprator,
                'date' => $log->created_at
            ];
        }

        foreach ($logEdit as $log) {
            $usersLogEdit[] = [
                'name' => $log->Users->nama_penanggung_jawab,
                'nip_operator' => $log->Users->nip_oprator,
                'date' => $log->created_at
            ];
        }

        foreach ($logDownload as $log) {
            $usersDownload[] = [
                'name' => $log->Users->nama_penanggung_jawab,
                'nip_operator' => $log->Users->nip_oprator,
                'date' => $log->created_at
            ];
        }

        return response()->json([
            'message' => 'DataCenter Log successfully',
            'data' => [
                'usersAtivitas' => $usersAtivitas,
                'usersLogEdit' => $usersLogEdit,
                'usersLogDownload' => $usersDownload,
            ]
        ]);
    }

    public function downloadFile($id)
    {
        $user = Auth::user();
        $file = DataCenter::find($id);


        $log = DownloadLog::create([
            'users_id' => $user->id,
            'file_id' => $file->id,
        ]);


        return response()->json([
            'message' => 'Datacenter Log Download successfuly',
            'data' => $file
        ]);
    }
}
