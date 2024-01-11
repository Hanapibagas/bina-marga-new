<?php

use App\Http\Controllers\API\DetailsFolderController;
use App\Http\Controllers\API\LoginController;
use App\Http\Controllers\API\PengumumanController;
use App\Http\Controllers\API\UploadFileController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::post('/v1/login', [LoginController::class, 'login']);

Route::middleware('auth:api')->group(function () {
    Route::get('/v1/details-user', [LoginController::class, 'getDetailsUser']);
    Route::post('/v1/update-password', [LoginController::class, 'postPassword']);
    Route::put('/v1/update-profile', [LoginController::class, 'putUpdateProfile']);

    Route::get('/v1/pengumuman', [PengumumanController::class, 'getIndexPengmumumann']);
    Route::post('/v1/upload-file', [UploadFileController::class, 'storeFile']);
    Route::post('/v1/upload-folder', [UploadFileController::class, 'Folder']);
    Route::get('/v1/list-data', [UploadFileController::class, 'getListData']);
    Route::get('/v1/list-folder', [UploadFileController::class, 'getListFoder']);
    Route::get('/v1/list-file', [UploadFileController::class, 'getListFile']);
    Route::put('/v1/update-folder/{id}', [UploadFileController::class, 'putEditFolder']);
    Route::put('/v1/update-file/{id}', [UploadFileController::class, 'putEditStatus']);

    Route::get('/v1/log-data-folder/{id}', [UploadFileController::class, 'getLogFolder']);
    Route::get('/v1/download-file/{id}', [UploadFileController::class, 'downloadFile']);

    Route::get('/v1/details/{id}', [DetailsFolderController::class, 'getDetails']);
});
