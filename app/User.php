<?php

namespace App;

use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable implements MustVerifyEmail, JWTSubject
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];


    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }

    public function roles() {
        return $this->belongsToMany('App\Role');
    }

    public function hasAnyRoles($roles) {
        return $this->roles()->whereIn('name', $roles)->first() ? TRUE : FALSE;
    }

    public function hasRole($role) {
        return $this->roles()->where('name', $role)->first() ? TRUE : FALSE;
    }

    public function whoHasRole($role) {
        return self::whereHas('roles', function($q) use ($role) {
            $q->where('name', $role);
        });
    }

    public function penjemputan() {
        return $this->hasMany('App\Penjemputan', 'nasabah_id', 'id');
    }
}
