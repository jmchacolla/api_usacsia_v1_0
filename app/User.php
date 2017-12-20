<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;

use Hash;

class User extends Authenticatable
{
    protected $table='_usuario';
    
    //protected $primaryKey = 'usu_id';

    protected $fillable = array('usu_nick','usu_tipo','password','usu_inicio_vigencia','usu_fin_vigencia','usu_clave_publica');

    protected $hidden = ['created_at','updated_at','userid_at','deleted_at','password','remember_token',];

    protected $dates = ['created_at','updated_at','userid_at','deleted_at'];



}
