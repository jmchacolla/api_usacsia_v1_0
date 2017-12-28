<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property Funcionario $funcionario
 * @property Mora[] $moras
 * @property Sancion[] $sancions
 * @property PagoArancel[] $pagoArancels
 * @property int $pp_id
 * @property int $fun_id
 * @property int $et_id
 * @property float $pp_monto_total
 * @property string $pp_descripcion
 * @property string $pp_estado_pago
 * @property string $created_at
 * @property string $updated_at
 * @property string $deleted_at
 * @property int $userid_at
 * @property string $pp_fecha_emision
 * @property string $pp_fecha_pagado
 */
class PagoPendiente extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'pago_pendiente';

    /**
     * The primary key for the model.
     * 
     * @var string
     */
    protected $primaryKey = 'pp_id';

    /**
     * @var array
     */
    protected $fillable = ['fun_id', 'et_id', 'pp_monto_total', 'pp_descripcion', 'pp_estado_pago', 'pp_fecha_emision', 'pp_fecha_pagado'];
    protected $hidden = ['created_at','updated_at','userid_at','deleted_at'];
    protected $dates=['deleted_at'];
    /**

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
    public function moras()
    {
        return $this->hasMany('App\Mora', 'pp_id', 'pp_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function sancions()
    {
        return $this->hasMany('App\Sancion', 'pp_id', 'pp_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function pagoArancels()
    {
        return $this->hasMany('App\PagoArancel', 'pp_id', 'pp_id');
    }
}
