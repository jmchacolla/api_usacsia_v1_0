<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property Zona $zona
 * @property Funcionario $funcionario
 * @property int $zi_id
 * @property int $zon_id
 * @property int $fun_id
 * @property string $created_at
 * @property string $updated_at
 * @property string $deleted_at
 * @property int $userid_at
 */
class Zona_inspeccion extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'zona_inspeccion';

    /**
     * The primary key for the model.
     * 
     * @var string
     */
    protected $primaryKey = 'zi_id';

    /**
     * @var array
     */
    protected $fillable = ['zon_id', 'fun_id'];
    protected $hidden = ['created_at','updated_at','userid_at','deleted_at'];
    protected $dates=['deleted_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function zona()
    {
        return $this->belongsTo('App\Zona', 'zon_id', 'zon_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function funcionario()
    {
        return $this->belongsTo('App\Funcionario', 'fun_id', 'fun_id');
    }
}
