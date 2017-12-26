<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property ClasificacionEspecialidad[] $clasificacionEspecialidads
 * @property int $cg_id
 * @property string $cg_codigo
 * @property string $cg_nombre
 * @property string $created_at
 * @property string $updated_at
 * @property string $deleted_at
 * @property int $userid_at
 */
class ClasificacionGeneral extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'clasificacion_general';

    /**
     * The primary key for the model.
     * 
     * @var string
     */
    protected $primaryKey = 'cg_id';

    /**
     * @var array
     */
    protected $fillable = ['cg_codigo', 'cg_nombre'];
    protected $hidden = ['created_at','updated_at','userid_at','deleted_at'];
    protected $dates=['deleted_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function clasificacionEspecialidads()
    {
        return $this->hasMany('App\ClasificacionEspecialidad', 'cg_id', 'cg_id');
    }
}
