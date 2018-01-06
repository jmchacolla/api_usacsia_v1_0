<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property Aprobacion[] $aprobacions
 * @property int $eta_id
 * @property string $eta_nombre
 * @property string $created_at
 * @property string $updated_at
 * @property string $deleted_at
 * @property int $userid_at
 */
class Etapa extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'etapa';

    /**
     * The primary key for the model.
     * 
     * @var string
     */
    protected $primaryKey = 'eta_id';

    /**
     * @var array
     */
    protected $fillable = ['eta_nombre'];
    protected $hidden = ['created_at','updated_at','userid_at','deleted_at'];
    protected $dates=['deleted_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function aprobacions()
    {
        return $this->hasMany('App\TramitecerEstado', 'eta_id', 'eta_id');
    }
}
