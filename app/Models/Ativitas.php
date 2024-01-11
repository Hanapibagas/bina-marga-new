<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ativitas extends Model
{
    use HasFactory;

    protected $fillable = [
        'users_id', 'file_id'
    ];

    public function Users()
    {
        return $this->belongsTo(User::class, 'users_id');
    }

    public function File()
    {
        return $this->belongsTo(DataCenter::class, 'file_id');
    }
}
