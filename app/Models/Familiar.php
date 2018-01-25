<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property Persona $persona
 * @property Persona $persona
 * @property int $fam_id
 * @property int $per_id
 * @property int $per_id_familiar
 * @property string $fam_parentesco
 * @property string $created_at
 * @property string $updated_at
 * @property string $deleted_at
 * @property int $userid_at
 */
class Familiar extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'familiar';

    /**
     * The primary key for the model.
     * 
     * @var string
     */
    protected $primaryKey = 'fam_id';

    /**
     * @var array
     */
    protected $fillable = array('fam_parentesco');
    // Aquí ponemos los campos que no queremos que se devuelvan en las consultas.
    protected $hidden = ['created_at','updated_at','userid_at','deleted_at'];

    protected $dates = ['deleted_at'];

   
}
