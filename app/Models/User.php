<?php

namespace App\Models;

use Laravel\Passport\HasApiTokens;
use Illuminate\Support\Facades\Hash;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Zizaco\Entrust\Traits\EntrustUserTrait;

class User extends Authenticatable
{
    use HasApiTokens, Notifiable, EntrustUserTrait;

    protected $table = "users";
    protected $fillable = [
        'name', 'apellido_materno', 'apellido_paterno','username','fecha_nacimiento','telefono',
        'created_at','updated_at','dni','direccion','genero',
        'estado_civil','email','password','estado','remember_token','pathimagen','urlimagen',
        'celular', 'notas', 'id_carrera', 'id_tipo_usuario', 'id_local', 'numero_carne'
    ];
    protected $dates = ['deleted_at'];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function getFullNameAttribute()
    {
        return ucfirst($this->nombres) . ' ' . ucfirst($this->apellido_paterno) . ' ' . ucfirst($this->apellido_materno);
    }

    public function getRoleAttribute()
    {
        $roles = $this->roles()->get();
        $rol = "";
        foreach($roles as $aux){
            $rol = $aux->display_name.", ".$rol;
        }
        $rol = rtrim($rol, ', ');
        return $rol;
    }

    public function getRoleIdAttribute()
    {
        return $this->roles()->first()->id;
    }

    public function roles()
    {
        return $this->belongsToMany('App\Models\Role');
    }

    public function isRole($roleId)
    {
        foreach ($this->roles()->get() as $role)
        {
            if ($role->id == $roleId)
            {
                return true;
            }
        }
        return false;
    }

    public function findForPassport($username)
    {
        return $this->where('username', $username)->first();
    }

    public function validateForPassportPasswordGrant($password)
    {
        //check for password
        if (Hash::check($password, $this->getAuthPassword())) {
            //is user active?
            return $this->estado;
        }
    }
}
