<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property EstablecimientoSolicitante $establecimientoSolicitante
 * @property Persona $persona
 * @property int $ep_id
 * @property int $ess_id
 * @property int $per_id
 * @property string $ep_inicio_trabajo
 * @property string $ep_fin_trabajo
 * @property string $ep_cargo
 * @property string $ep_estado_laboral
 * @property string $created_at
 * @property string $updated_at
 * @property string $deleted_at
 * @property int $userid_at
 */
class Establecimiento_persona extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'establecimiento_persona';

    /**
     * The primary key for the model.
     * 
     * @var string
     */
    protected $primaryKey = 'ep_id';

    /**
     * @var array
     */
    protected $fillable = ['ess_id', 'per_id', 'ep_inicio_trabajo', 'ep_fin_trabajo', 'ep_cargo', 'ep_estado_laboral'];
    protected $hidden = ['created_at', 'updated_at', 'userid_at'];
    protected $dates=['deleted_at'];


    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function establecimientoSolicitante()
    {
        return $this->belongsTo('App\EstablecimientoSolicitante', 'ess_id', 'ess_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function persona()
    {
        return $this->belongsTo('App\Persona', 'per_id', 'per_id');
    }


    // public function scopeContarEstados($query,$ess_id,$personas_x_establecimiento)
    // {
    //     foreach ($personas_x_establecimiento as $value){
    //             if($value->){
    //                     $tramite_estado->te_estado='OBSERVADO';
    //             }
    //         }
        
    //     $iniciados=Establecimiento_persona::select()
    //     if($edad=="")    
    //         return -1;
    //     return $edad;
    // }



}
