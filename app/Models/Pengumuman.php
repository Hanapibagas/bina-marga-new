<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pengumuman extends Model
{
    use HasFactory;

    protected $fillable = [
        'judul',
        'file',
        'tannggal',
        'users_id',
    ];

    public function Users()
    {
        return $this->belongsTo(User::class, 'users_id');
    }
}
