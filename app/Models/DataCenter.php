<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DataCenter extends Model
{
    use HasFactory;

    protected $fillable = [
        'folder_name',
        'slug',
        'users_id',
        'roles_bidang_id',
        'roles_seksi_id',
        'parent_name_id',
        'is_recycle',
        'tanggal',
    ];

    public function rolesBidang()
    {
        return $this->belongsTo(RolesBidang::class, 'roles_bidang_id');
    }

    public function rolesSeksi()
    {
        return $this->belongsTo(RolesSeksi::class, 'roles_seksi_id');
    }

    public function Users()
    {
        return $this->belongsTo(User::class);
    }
}
