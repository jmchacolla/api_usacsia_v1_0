<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property FichaInspeccion $fichaInspeccion
 * @property int $fi3_id
 * @property int $fi_id
 * @property float $fi3_superficie_util
 * @property string $fi3_muros_pintados
 * @property string $fi3_muros_pintados_obs
 * @property string $fi3_zocalos
 * @property string $fi3_zocalos_obs
 * @property string $fi3_piso
 * @property string $fi3_piso_obs
 * @property string $fi3_sumidero_desague
 * @property string $fi3_sumidero_desague_obs
 * @property string $fi3_cielo_raso
 * @property string $fi3_cielo_raso_obs
 * @property boolean $fi3_ventilacion_inyeccion
 * @property boolean $fi3_ventilacion_extraccion
 * @property boolean $fi3_ventilacion_electrica
 * @property boolean $fi3_ventilacion_eolico
 * @property string $fi3_abastecimiento_agua
 * @property string $fi3_abastecimiento_agua_obs
 * @property string $fi3_eliminacion_agua
 * @property string $fi3_eliminacion_agua_obs
 * @property string $fi3_agua_piso
 * @property string $fi3_agua_piso_obs
 * @property string $fi3_serv_higienicos
 * @property string $fi3_serv_higienicos_obs
 * @property string $fi3_disp_desperdicios
 * @property string $fi3_disp_desperdicios_obs
 * @property string $fi3_roedores_insectos
 * @property string $fi3_roedores_insectos_obs
 * @property string $fi3_establecimiento
 * @property string $fi3_establecimiento_obs
 * @property string $fi3_paredes_pisos
 * @property string $fi3_paredes_pisos_obs
 * @property string $fi3_menaje
 * @property string $fi3_menaje_obs
 * @property string $fi3_personal
 * @property string $fi3_personal_obs
 * @property string $fi3_ropa
 * @property string $fi3_ropa_obs
 * @property string $fi3_detergente
 * @property string $fi3_detergente_obs
 * @property string $fi3_man_alimento
 * @property string $fi3_man_alimento_obs
 * @property string $fi3_con_alimento
 * @property string $fi3_con_alimento_obs
 * @property string $fi3_producto_registro
 * @property string $fi3_producto_registro_obs
 * @property string $fi3_almacenamiento
 * @property string $fi3_almacenamiento_obs
 * @property string $fi3_observacion
 * @property string $created_at
 * @property string $updated_at
 * @property string $deleted_at
 * @property int $userid_at
 */
class Ficha3 extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'ficha3';

    /**
     * The primary key for the model.
     * 
     * @var string
     */
    protected $primaryKey = 'fi3_id';

    /**
     * @var array
     */
    protected $fillable = ['fi_id', 'fi3_superficie_util', 'fi3_muros_pintados', 'fi3_muros_pintados_obs', 'fi3_zocalos', 'fi3_zocalos_obs', 'fi3_piso', 'fi3_piso_obs', 'fi3_sumidero_desague', 'fi3_sumidero_desague_obs', 'fi3_cielo_raso', 'fi3_cielo_raso_obs', 'fi3_ventilacion_inyeccion', 'fi3_ventilacion_extraccion', 'fi3_ventilacion_electrica', 'fi3_ventilacion_eolico', 'fi3_abastecimiento_agua', 'fi3_abastecimiento_agua_obs', 'fi3_eliminacion_agua', 'fi3_eliminacion_agua_obs', 'fi3_agua_piso', 'fi3_agua_piso_obs', 'fi3_serv_higienicos', 'fi3_serv_higienicos_obs', 'fi3_disp_desperdicios', 'fi3_disp_desperdicios_obs', 'fi3_roedores_insectos', 'fi3_roedores_insectos_obs', 'fi3_establecimiento', 'fi3_establecimiento_obs', 'fi3_paredes_pisos', 'fi3_paredes_pisos_obs', 'fi3_menaje', 'fi3_menaje_obs', 'fi3_personal', 'fi3_personal_obs', 'fi3_ropa', 'fi3_ropa_obs', 'fi3_detergente', 'fi3_detergente_obs', 'fi3_man_alimento', 'fi3_man_alimento_obs', 'fi3_con_alimento', 'fi3_con_alimento_obs', 'fi3_producto_registro', 'fi3_producto_registro_obs', 'fi3_almacenamiento', 'fi3_almacenamiento_obs', 'fi3_observacion'];
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
