<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @property FichaCategoriaSancion $fichaCategoriaSancion
 * @property Funcionario $funcionario
 * @property int $ps_id
 * @property int $fcs_id
 * @property int $fun_id
 * @property float $pp_monto_total
 * @property string $pp_fecha_emision
 * @property string $pp_fecha_pagado
 * @property string $pp_descripcion
 * @property string $pp_estado_pago
 * @property string $created_at
 * @property string $updated_at
 * @property string $deleted_at
 * @property int $userid_at
 */
class PagoSancion extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'pago_sancion';

    /**
     * The primary key for the model.
     * 
     * @var string
     */
    protected $primaryKey = 'ps_id';

    /**
     * @var array
     */
    protected $fillable = ['fcs_id', 'fun_id', 'pp_monto_total', 'pp_fecha_emision', 'pp_fecha_pagado', 'pp_descripcion', 'pp_estado_pago', 'created_at', 'updated_at', 'deleted_at', 'userid_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function fichaCategoriaSancion()
    {
        return $this->belongsTo('App\FichaCategoriaSancion', 'fcs_id', 'fcs_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function funcionario()
    {
        return $this->belongsTo('App\Funcionario', 'fun_id', 'fun_id');
    }
}
