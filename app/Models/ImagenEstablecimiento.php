<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property EstablecimientoSolicitante $establecimientoSolicitante
 * @property int $ie_id
 * @property int $ess_id
 * @property string $ima_nombre
 * @property string $ie_enlace
 * @property string $ie_tipo
 * @property string $created_at
 * @property string $updated_at
 * @property string $deleted_at
 * @property int $userid_at
 */
class ImagenEstablecimiento extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'imagen_establecimiento';

    /**
     * The primary key for the model.
     * 
     * @var string
     */
    protected $primaryKey = 'ie_id';

    /**
     * @var array
     */
    protected $fillable = ['ess_id', 'ima_nombre', 'ie_enlace', 'ie_tipo'];
    protected $hidden = ['created_at', 'updated_at', 'deleted_at', 'userid_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function establecimientoSolicitante()
    {
        return $this->belongsTo('App\EstablecimientoSolicitante', 'ess_id', 'ess_id');
    }
}
