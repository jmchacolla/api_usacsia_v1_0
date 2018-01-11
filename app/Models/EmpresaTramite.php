<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property Tramite $tramite
 * @property EstablecimientoSolicitante $establecimientoSolicitante
 * @property Funcionario $funcionario
 * @property int $et_id
 * @property int $tra_id
 * @property int $ess_id
 * @property int $fun_id
 * @property int $et_numero_tramite
 * @property string $et_vigencia_pago
 * @property string $et_fecha_ini
 * @property string $et_fecha_fin
 * @property string $et_estado_pago
 * @property string $et_estado_tramite
 * @property float $et_monto
 * @property string $et_tipo_tramite
 * @property string $et_vigencia_documento
 * @property string $created_at
 * @property string $updated_at
 * @property string $deleted_at
 * @property int $userid_at
 */
class EmpresaTramite extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'empresa_tramite';

    /**
     * The primary key for the model.
     * 
     * @var string
     */
    protected $primaryKey = 'et_id';

    /**
     * @var array
     */

    protected $fillable = ['tra_id', 'ess_id', 'fun_id', 'et_numero_tramite', 'et_vigencia_pago', 'et_fecha_ini', 'et_fecha_fin', 'et_estado_pago', 'et_estado_tramite', 'et_monto', 'et_tipo_tramite', 'et_vigencia_documento'];
    protected $hidden = ['created_at', 'updated_at', 'userid_at'];
    protected $dates=['deleted_at'];
    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function tramite()
    {
        return $this->belongsTo('App\Tramite', 'tra_id', 'tra_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function establecimientoSolicitante()
    {
        return $this->belongsTo('App\EstablecimientoSolicitante', 'ess_id', 'ess_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function funcionario()
    {
        return $this->belongsTo('App\Funcionario', 'fun_id', 'fun_id');
    }

   /**
    * @return \Illuminate\Database\Eloquent\Relations\HasMany
    */
   public function ordenpago()
   {
       return $this->hasMany('App\OrdenPago', 'et_id', 'et_id');
   }
}