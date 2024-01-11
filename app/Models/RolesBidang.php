<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RolesBidang extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
    ];

    public function RolesSeksi()
    {
        return $this->hasMany(RolesSeksi::class, 'roles_bidang_id');
    }
}
