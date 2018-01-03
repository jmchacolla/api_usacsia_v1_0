<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property FichaInspeccion $fichaInspeccion
 * @property int $fi6_id
 * @property int $fi_id
 * @property int $fi6_ubicacion
 * @property int $fi6_exibicion_certificado
 * @property int $fi6_capacidad_dependencias
 * @property int $fi6_piso
 * @property int $fi6_cielo_raso
 * @property int $fi6_muralla
 * @property int $fi6_puerta_ventana
 * @property int $fi6_ventilacion
 * @property int $fi6_iluminacion
 * @property int $fi6_abastecimiento_agua
 * @property int $fi6_purificacion_agua
 * @property int $fi6_eliminacion_agua
 * @property int $fi6_servicios_higienicos
 * @property int $fi6_facilidad_aseo
 * @property int $fi6_guardaropa
 * @property int $fi6_eliminacion_basura
 * @property int $fi6_aseo_dependencias
 * @property int $fi6_maquinaria_artefactos
 * @property int $fi6_fitros
 * @property int $fi6_transfugadora
 * @property int $fi6_lavado_envases
 * @property int $fi6_desinfeccion_envases
 * @property int $fi6_materia_prima
 * @property int $fi6_eliminacion_productos
 * @property int $fi6_proteccion_contaminacion
 * @property int $fi6_deposito
 * @property int $fi6_manipulador_salud
 * @property int $fi6_manipulador_aseo
 * @property int $fi6_manipulador_habitos
 * @property int $fi6_manipulador_carne
 * @property int $fi6_overoles
 * @property int $fi6_botiquin
 * @property int $fi6_extinguidor
 * @property string $fi6_control_vectores
 * @property string $fi6_observaciones
 * @property string $created_at
 * @property string $updated_at
 * @property string $deleted_at
 * @property int $userid_at
 */
class Ficha6 extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'ficha6';

    /**
     * The primary key for the model.
     * 
     * @var string
     */
    protected $primaryKey = 'fi6_id';

    /**
     * @var array
     */
    protected $fillable = ['fi_id', 'fi6_ubicacion', 'fi6_exibicion_certificado', 'fi6_capacidad_dependencias', 'fi6_piso', 'fi6_cielo_raso', 'fi6_muralla', 'fi6_puerta_ventana', 'fi6_ventilacion', 'fi6_iluminacion', 'fi6_abastecimiento_agua', 'fi6_purificacion_agua', 'fi6_eliminacion_agua', 'fi6_servicios_higienicos', 'fi6_facilidad_aseo', 'fi6_guardaropa', 'fi6_eliminacion_basura', 'fi6_aseo_dependencias', 'fi6_maquinaria_artefactos', 'fi6_fitros', 'fi6_transfugadora', 'fi6_lavado_envases', 'fi6_desinfeccion_envases', 'fi6_materia_prima', 'fi6_eliminacion_productos', 'fi6_proteccion_contaminacion', 'fi6_deposito', 'fi6_manipulador_salud', 'fi6_manipulador_aseo', 'fi6_manipulador_habitos', 'fi6_manipulador_carne', 'fi6_overoles', 'fi6_botiquin', 'fi6_extinguidor', 'fi6_control_vectores', 'fi6_observaciones'];
    protected $hidden = ['created_at', 'updated_at', 'userid_at'];
    protected $dates=['deleted_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function fichaInspeccion()
    {
        return $this->belongsTo('App\FichaInspeccion', 'fi_id', 'fi_id');
    }
}
