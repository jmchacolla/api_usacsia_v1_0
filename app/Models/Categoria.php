<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property Subclasificacion $subclasificacion
 * @property int $cat_id
 * @property int $subc_id
 * @property string $cat_secuencial
 * @property string $cat_area
 * @property string $cat_categoria
 * @property string $cat_codigo
 * @property float $cat_monto
 * @property string $cat_descripcion
 * @property string $cat_servicio
 * @property string $created_at
 * @property string $updated_at
 * @property string $deleted_at
 * @property int $userid_at
 */
class Categoria extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'categoria';

    /**
     * The primary key for the model.
     * 
     * @var string
     */
    protected $primaryKey = 'cat_id';

    /**
     * @var array
     */
    protected $fillable = ['sub_id', 'cat_secuencial', 'cat_area', 'cat_categoria', 'cat_codigo', 'cat_monto', 'cat_descripcion', 'cat_servicio'];
    protected $hidden = ['created_at','updated_at','userid_at','deleted_at'];
    protected $dates=['deleted_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function subclasificacion()
    {
        return $this->belongsTo('App\Subclasificacion', 'sub_id', 'sub_id');
    }
}
