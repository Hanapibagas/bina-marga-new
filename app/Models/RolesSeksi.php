<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class RolesSeksi extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name_seksi',
        'roles_bidang_id',
        'users_id',
    ];

    protected $dates = ['deleted_at'];
    public function RolesBidang()
    {
        return $this->belongsTo(RolesBidang::class, 'roles_bidang_id');
    }
}
