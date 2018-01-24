<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property PersonaTramite $personaTramite
 * @property int $cas_id
 * @property int $pt_id
 * @property string $cas_numero
 * @property string $cas_fecha_inicio
 * @property string $cas_fecha_fin
 * @property string $cas_url
 * @property string $created_at
 * @property string $updated_at
 * @property string $deleted_at
 * @property int $userid_at
 * @property string $cas_nombre
 */
class Carnet_sanitario extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'carnet_sanitario';

    /**
     * The primary key for the model.
     * 
     * @var string
     */
    protected $primaryKey = 'cas_id';

    /**
     * @var array
     */
    protected $fillable = ['pt_id', 'cas_numero', 'cas_fecha_inicio', 'cas_fecha_fin', 'cas_url','cas_nombre'];
    protected $hidden = [ 'updated_at', 'deleted_at', 'userid_at'];
    protected $dates=['created_at','deleted_at'];
    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function personaTramite()
    {
        return $this->belongsTo('App\PersonaTramite', 'pt_id', 'pt_id');
    }
    public function scopeCrear_carnet($query, $pt_id)
    {
        $carnet_sanitario= new Carnet_sanitario();
        $carnet_sanitario->pt_id=$pt_id;
        $carnet_sanitario->cas_numero=$request->cas_numero;
        $carnet_sanitario->cas_fecha_inicio=$request->cas_fecha_inicio;
        $carnet_sanitario->cas_fecha_fin=$request->cas_fecha_fin;
        $carnet_sanitario->cas_url=$request->cas_url;
        $carnet_sanitario->cas_nombre=$request->cas_nombre;
        $carnet_sanitario->userid_at='2';
        $carnet_sanitario->save();

            /*$paciente_establecimiento= new Paciente_establecimiento();
            $paciente_establecimiento->es_id=$es_id;
            $paciente_establecimiento->pac_id=$pac_id;
            $paciente_establecimiento->pe_hist_clinico=$pe_hist_clinico;
            $paciente_establecimiento->pe_estado='ACTIVO';
            $paciente_establecimiento->userid_at='2';
            $paciente_establecimiento->save();

            return $paciente_establecimiento;*/

    }
}
