<?php

namespace App;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;

use DB;

class User extends Model implements AuthenticatableContract,
                                    AuthorizableContract,
                                    CanResetPasswordContract
{
    use Authenticatable, Authorizable, CanResetPassword;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'users';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['nom', 'prenom', 'email', 'password'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = ['password', 'remember_token'];

    public function fullName() {
        if($this->nom && $this->prenom) {
            return ucfirst(strtolower($this->nom)) . ' ' . ucfirst(strtolower($this->prenom));
        } 
        if($this->nom) {
            return ucfirst(strtolower($this->nom));
        }
        if($this->prenom) {
            return ucfirst(strtolower($this->prenom));
        }

        return null;
    }

    public function deptName() {
        $deptName = DB::table('departements')->where('id',$this->departement)->value('nom');

        if($deptName) {
            return '- ' . $deptName;
        } 

        return null;
    }
}
