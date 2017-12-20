<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Rol extends Model
{
    protected $table='_rol';
	
	protected $primaryKey = 'rol_id';

	protected $fillable = array('rol_nombre','rol_descripcion');

	protected $hidden = ['created_at','updated_at','userid_at','deleted_at'];

	protected $dates = ['deleted_at'];

}
