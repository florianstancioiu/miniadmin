<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Traits\RolesAndPermissions;
use App\Models\Role;
use App\Models\UserRole;

class User extends Authenticatable
{
    use HasFactory,
        Notifiable,
        RolesAndPermissions;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'image',
        'first_name',
        'last_name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function getFullNameAttribute()
    {
        return $this->first_name . " " . $this->last_name;
    }

    public function getRolesAttribute()
    {
        return UserRole::where('user_id', $this->id)
            ->join('roles', 'user_role.role_id', '=', 'roles.id')
            ->select('roles.title')
            ->get();
    }

    public function getImageUrlAttribute()
    {
        return url('storage/'. $this->image);
    }

    public function scopeSearch($query, $keyword)
    {
        return $query
            ->whereRaw('LOWER(`email`) LIKE ? ', ['%' . strtolower($keyword) .'%'])
            ->orWhereRaw('LOWER(`first_name`) LIKE ? ', ['%' . strtolower($keyword) .'%'])
            ->orWhereRaw('LOWER(`last_name`) LIKE ? ', ['%' . strtolower($keyword) .'%']);
    }
}
