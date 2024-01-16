<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RolesSeksi extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'roles_bidang_id ',
    ];

    public function RolesBidang()
    {
        return $this->belongsTo(RolesBidang::class, 'roles_bidang_id');
    }
}
