<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property ClasificacionGeneral $clasificacionGeneral
 * @property int $cle_id
 * @property int $cg_id
 * @property string $cle_codigo
 * @property string $cle_nombre
 * @property string $created_at
 * @property string $updated_at
 * @property string $deleted_at
 * @property int $userid_at
 */
class ClasificacionEspecialidad extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'clasificacion_especialidad';

    /**
     * The primary key for the model.
     * 
     * @var string
     */
    protected $primaryKey = 'cle_id';

    /**
     * @var array
     */
    protected $fillable = ['cg_id', 'cle_codigo', 'cle_nombre'];
    protected $hidden = ['created_at','updated_at','userid_at','deleted_at'];
    protected $dates=['deleted_at'];
    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function clasificacionGeneral()
    {
        return $this->belongsTo('App\ClasificacionGeneral', 'cg_id', 'cg_id');
    }
}
