<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property Funcionario $funcionario
 * @property Funcionario $funcionario
 * @property EmpresaTramite $empresaTramite
 * @property PagoSancion[] $pagoSancions
 * @property PagoArancel[] $pagoArancels
 * @property int $op_id
 * @property int $fun_cajero_id
 * @property int $fun_id
 * @property int $et_id
 * @property float $op_monto_total
 * @property string $op_fecha_emision
 * @property string $op_fecha_pagado
 * @property string $op_descripcion
 * @property string $op_estado_pago
 * @property string $created_at
 * @property string $updated_at
 * @property string $deleted_at
 * @property int $userid_at
 */
class OrdenPago extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'orden_pago';

    /**
     * The primary key for the model.
     * 
     * @var string
     */
    protected $primaryKey = 'op_id';

    /**
     * @var array
     */
    protected $fillable = ['fun_cajero_id', 'fun_id', 'et_id', 'op_monto_total', 'op_fecha_emision', 'op_fecha_pagado', 'op_descripcion', 'op_estado_pago'];
    protected $hidden = ['created_at','updated_at','userid_at','deleted_at'];
    protected $dates=['deleted_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function funcionariocajero()
    {
        return $this->belongsTo('App\Funcionario', 'fun_cajero_id', 'fun_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function funcionario()
    {
        return $this->belongsTo('App\Funcionario', 'fun_id', 'fun_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function empresaTramite()
    {
        return $this->belongsTo('App\EmpresaTramite', 'et_id', 'et_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function pagoSancions()
    {
        return $this->hasMany('App\PagoSancion', 'op_id', 'op_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function pagoArancels()
    {
        return $this->hasMany('App\PagoArancel', 'op_id', 'op_id');
    }
}
