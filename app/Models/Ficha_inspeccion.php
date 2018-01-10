<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property EmpresaTramite $empresaTramite
 * @property Funcionario $funcionario
 * @property Categorium $categorium
 * @property Citacion[] $citacions
 * @property Ficha1[] $ficha1s
 * @property Ficha2[] $ficha2s
 * @property Ficha3[] $ficha3s
 * @property Ficha4[] $ficha4s
 * @property Ficha5[] $ficha5s
 * @property Ficha6[] $ficha6s
 * @property int $fi_id
 * @property int $et_id
 * @property int $fun_id
 * @property int $cat_id
 * @property string $fi_fecha_asignacion
 * @property string $fi_fecha_realizacion
 * @property string $fi_observacion
 * @property string $fi_estado
 * @property boolean $fi_foco_insalubridad
 * @property boolean $fi_exibe_certificado
 * @property boolean $fi_exibe_carne
 * @property string $fi_extinguidor
 * @property string $fi_botiquin
 * @property string $created_at
 * @property string $updated_at
 * @property string $deleted_at
 * @property int $userid_at
 */
class Ficha_inspeccion extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'ficha_inspeccion';

    /**
     * The primary key for the model.
     * 
     * @var string
     */
    protected $primaryKey = 'fi_id';

    /**
     * @var array
     */
    protected $fillable = ['et_id', 'fun_id', 'cat_id', 'fi_fecha_asignacion', 'fi_fecha_realizacion', 'fi_observacion', 'fi_estado', 'fi_foco_insalubridad', 'fi_exibe_certificado', 'fi_exibe_carne', 'fi_extinguidor', 'fi_botiquin'];
    protected $hidden = ['created_at','updated_at','userid_at','deleted_at'];
    protected $dates=['deleted_at'];
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
    public function funcionario()
    {
        return $this->belongsTo('App\Funcionario', 'fun_id', 'fun_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function categorium()
    {
        return $this->belongsTo('App\Categorium', 'cat_id', 'cat_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function citacions()
    {
        return $this->hasMany('App\Citacion', 'fi_id', 'fi_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function ficha1s()
    {
        return $this->hasMany('App\Ficha1', 'fi_id', 'fi_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function ficha2s()
    {
        return $this->hasMany('App\Ficha2', 'fi_id', 'fi_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function ficha3s()
    {
        return $this->hasMany('App\Ficha3', 'fi_id', 'fi_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function ficha4s()
    {
        return $this->hasMany('App\Ficha4', 'fi_id', 'fi_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function ficha5s()
    {
        return $this->hasMany('App\Ficha5', 'fi_id', 'fi_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function ficha6s()
    {
        return $this->hasMany('App\Ficha6', 'fi_id', 'fi_id');
    }
}
