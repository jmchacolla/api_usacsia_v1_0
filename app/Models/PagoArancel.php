<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property OrdenPago $ordenPago
 * @property Funcionario $funcionario
 * @property FichaCategorium $fichaCategorium
 * @property int $pa_id
 * @property int $op_id
 * @property int $fun_id
 * @property int $fc_id
 * @property float $pp_monto
 * @property string $created_at
 * @property string $updated_at
 * @property string $deleted_at
 * @property int $userid_at
 */
class PagoArancel extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'pago_arancel';

    /**
     * The primary key for the model.
     * 
     * @var string
     */
    protected $primaryKey = 'pa_id';

    /**
     * @var array
     */
    protected $fillable = ['op_id', 'fun_id', 'fc_id', 'pa_monto'];
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
    public function fichaCategorium()
    {
        return $this->belongsTo('App\FichaCategorium', 'fc_id', 'fc_id');
    }
}
