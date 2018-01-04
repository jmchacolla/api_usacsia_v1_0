<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property EmpresaTramite $empresaTramite
 * @property int $ces_id
 * @property int $et_id
 * @property int $ces_numero
 * @property string $ces_fecha_inicio
 * @property string $ces_fecha_fin
 * @property string $created_at
 * @property string $updated_at
 * @property string $deleted_at
 * @property int $userid_at
 * @property string $ces__fir_url1
 * @property string $ces__fir_url2
 * @property string $ces__fir_url3
 * @property string $ces__fir_nombre1
 * @property string $ces__fir_nombre2
 * @property string $ces__fir_nombre3
 */
class Certificado_sanitario extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'certificado_sanitario';

    /**
     * The primary key for the model.
     * 
     * @var string
     */
    protected $primaryKey = 'ces_id';

    /**
     * @var array
     */
    protected $fillable = ['et_id', 'ces_numero', 'ces_fecha_inicio', 'ces_fecha_fin', 'ces_fir_url1', 'ces_fir_url2', 'ces_fir_url3', 'ces_fir_nombre1', 'ces_fir_nombre2', 'ces_fir_nombre3'];
    protected $hidden = ['created_at', 'updated_at', 'deleted_at', 'userid_at'];
    protected $dates=['deleted_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function empresaTramite()
    {
        return $this->belongsTo('App\EmpresaTramite', 'et_id', 'et_id');
    }
}
