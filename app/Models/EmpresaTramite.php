<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @property DocumentoTramite[] $documentoTramites
 * @property CertificadoSanitario[] $certificadoSanitarios
 * @property PagoPendiente[] $pagoPendientes
 * @property int $et_id
 * @property int $tra_id
 * @property int $ess_id
 * @property int $et_numero_tramite
 * @property float $et_estado_pago
 * @property string $et_fecha_ini
 * @property string $et_fecha_fin
 * @property string $et_estado
 * @property float $et_monto
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
    protected $fillable = ['tra_id', 'ess_id', 'et_numero_tramite', 'et_estado_pago', 'et_fecha_ini', 'et_fecha_fin', 'et_estado', 'et_monto', 'created_at', 'updated_at', 'deleted_at', 'userid_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function documentoTramites()
    {
        return $this->hasMany('App\DocumentoTramite', 'et_id', 'et_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function certificadoSanitarios()
    {
        return $this->hasMany('App\CertificadoSanitario', 'et_id', 'et_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function pagoPendientes()
    {
        return $this->hasMany('App\PagoPendiente', 'et_id', 'et_id');
    }
}
