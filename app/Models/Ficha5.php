<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property FichaInspeccion $fichaInspeccion
 * @property int $fi5_id
 * @property int $fi_id
 * @property int $fi5_ubicacion
 * @property int $fi5_capacidad_dependencia
 * @property int $fi5_sauna_sec_vapor
 * @property int $fi5_enfermedades
 * @property int $fi5_limpieza
 * @property int $fi5_pisos
 * @property int $fi5_cielo
 * @property int $fi5_zocalo
 * @property int $fi5_iluminacion
 * @property int $fi5_abastecimiento
 * @property int $fi5_red_desague
 * @property int $fi5_ventilacion
 * @property int $fi5_guardaropa
 * @property int $fi5_serv_higienico
 * @property int $fi5_artefactos
 * @property int $fi5_puerta_auto
 * @property int $fi5_ducha
 * @property int $fi5_rejilla_piso
 * @property int $fi5_rejilla_suf
 * @property int $fi5_puerta_ventana
 * @property int $fi5_puerta_cierre
 * @property int $fi5_muebles
 * @property int $fi5_maquinarias
 * @property int $fi5_estado_maquinaria
 * @property int $fi5_term_res
 * @property int $fi5_valvulas
 * @property int $fi5_caldero
 * @property int $fi5_aseo_maquinaria
 * @property int $fi5_seguridad
 * @property int $fi5_polvo
 * @property int $fi5_verif_presion
 * @property int $fi5_desinf_maq
 * @property int $fi5_desinfectante
 * @property int $fi5_temp_agua
 * @property int $fi5_certificado_tratamiento
 * @property string $fi5_certificado_tratamiento_otro
 * @property int $fi5_salud_personal
 * @property int $fi5_habitos
 * @property int $fi5_aseo_personal
 * @property int $fi5_depositos_ropa
 * @property int $fi5_ausensia_mat
 * @property int $fi5_extin_botiq
 * @property string $fi5_recomendacion
 * @property int $fi5_total
 * @property string $fi5_estado
 * @property string $created_at
 * @property string $updated_at
 * @property string $deleted_at
 * @property int $userid_at
 */
class Ficha5 extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'ficha5';

    /**
     * The primary key for the model.
     * 
     * @var string
     */
    protected $primaryKey = 'fi5_id';

    /**
     * @var array
     */
    protected $fillable = ['fi_id', 'fi5_ubicacion', 'fi5_capacidad_dependencia', 'fi5_sauna_sec_vapor', 'fi5_enfermedades', 'fi5_limpieza', 'fi5_pisos', 'fi5_cielo', 'fi5_zocalo', 'fi5_iluminacion', 'fi5_abastecimiento', 'fi5_red_desague', 'fi5_ventilacion', 'fi5_guardaropa', 'fi5_serv_higienico', 'fi5_artefactos', 'fi5_puerta_auto', 'fi5_ducha', 'fi5_rejilla_piso', 'fi5_rejilla_suf', 'fi5_puerta_ventana', 'fi5_puerta_cierre', 'fi5_muebles', 'fi5_maquinarias', 'fi5_estado_maquinaria', 'fi5_term_res', 'fi5_valvulas', 'fi5_caldero', 'fi5_aseo_maquinaria', 'fi5_seguridad', 'fi5_polvo', 'fi5_verif_presion', 'fi5_desinf_maq', 'fi5_desinfectante', 'fi5_temp_agua', 'fi5_certificado_tratamiento', 'fi5_certificado_tratamiento_otro', 'fi5_salud_personal', 'fi5_habitos', 'fi5_aseo_personal', 'fi5_depositos_ropa', 'fi5_ausensia_mat', 'fi5_extin_botiq', 'fi5_recomendacion', 'fi5_total', 'fi5_estado','fi5_autorizados','fi5_adecuados'];
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
