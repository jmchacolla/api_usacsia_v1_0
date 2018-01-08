<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property Funcionario $funcionario
 * @property EmpresaTramite $empresaTramite
 * @property Etapa $etapa
 * @property int $te_id
 * @property int $fun_id
 * @property int $et_id
 * @property int $eta_id
 * @property string $te_estado
 * @property string $te_observacion
 * @property string $created_at
 * @property string $updated_at
 * @property string $deleted_at
 * @property int $userid_at
 */
class TramitecerEstado extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'tramitecer_estado';

    /**
     * The primary key for the model.
     * 
     * @var string
     */
    protected $primaryKey = 'te_id';

    /**
     * @var array
     */
    protected $fillable = ['te_id','te_fecha','fun_id', 'et_id', 'eta_id', 'te_estado', 'te_observacion'];
    protected $hidden = ['created_at','updated_at','userid_at','deleted_at'];
    protected $dates=['deleted_at'];

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
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function etapa()
    {
        return $this->belongsTo('App\Etapa', 'eta_id', 'eta_id');
    }
}
