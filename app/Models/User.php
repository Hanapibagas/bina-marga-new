<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'nama_penanggung_jawab',
        'nip_oprator',
        'pangakat',
        'roles_bidang_id',
        'roles_seksi_id',
        'google_id',
        'permission_edit',
        'permission_delete',
        'permission_upload',
        'permission_create',
        'permission_download',
        'picture',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function hasRole($roles)
    {
        return $this->roles === $roles;
    }

    public function rolesBidang()
    {
        return $this->belongsTo(RolesBidang::class, 'roles_bidang_id');
    }

    public function rolesSeksi()
    {
        return $this->belongsTo(RolesSeksi::class, 'roles_seksi_id');
    }

    public function DataSet()
    {
        return $this->hasMany(DataCenter::class, 'users_id');
    }
}
