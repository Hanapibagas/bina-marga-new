<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class RolesBidang extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'users_id',
        'name_bidang',
    ];

    protected $dates = ['deleted_at'];

    public function RolesSeksi()
    {
        return $this->hasMany(RolesSeksi::class, 'roles_bidang_id');
    }
}
