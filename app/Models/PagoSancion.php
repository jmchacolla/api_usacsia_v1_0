<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property OrdenPago $ordenPago
 * @property Funcionario $funcionario
 * @property FichaCategoriaSancion $fichaCategoriaSancion
 * @property int $ps_id
 * @property int $op_id
 * @property int $fun_id
 * @property int $fcs_id
 * @property float $pp_monto_total
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
    protected $fillable = ['op_id', 'fun_id', 'fcs_id', 'ps_monto', 'ps_descripcion'];
    protected $hidden = ['created_at','updated_at','userid_at','deleted_at'];
    protected $dates=['deleted_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function ordenPago()
    {
        return $this->belongsTo('App\OrdenPago', 'op_id', 'op_id');
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
    public function fichaCategoriaSancion()
    {
        return $this->belongsTo('App\FichaCategoriaSancion', 'fcs_id', 'fcs_id');
    }
}
