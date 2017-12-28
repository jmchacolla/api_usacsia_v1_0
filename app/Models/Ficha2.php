<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property FichaInspeccion $fichaInspeccion
 * @property int $fi2_id
 * @property int $fi_id
 * @property string $fi2_fecha_realizacion
 * @property string $fi2_cama
 * @property int $fi2_nro_habitaciones
 * @property int $fi2_nro_almacenes
 * @property int $fi2_nro_salones
 * @property int $fi2_salones_bueno
 * @property int $fi2_salones_regular
 * @property int $fi2_piscina_o_sauna
 * @property int $fi2_piscina_regular
 * @property int $fi2_piscina_bueno
 * @property int $fi2_nro_cocina
 * @property int $fi2_nro_cocinas_apart_hotel
 * @property int $fi2_total_gambusas
 * @property string $fi2_recepcion
 * @property int $fi2_nro_restautant
 * @property string $fi2_aire_acondicionado
 * @property string $fi2_agua_caliente
 * @property string $fi2_calefaccion
 * @property string $fi2_frigobar
 * @property string $fi2_room_service
 * @property string $fi2_telefono_hab
 * @property string $fi2_tv
 * @property string $fi2_cubrecolchones
 * @property string $fi2_mesa
 * @property string $fi2_tocador
 * @property string $fi2_lampara
 * @property string $fi2_sillones
 * @property string $fi2_espejo
 * @property string $fi2_cesto_basura
 * @property string $fi2_portamaletas
 * @property string $fi2_ropero
 * @property string $fi2_lavanderia
 * @property string $fi2_cortina
 * @property string $fi2_pisos_baño
 * @property string $fi2_azulejos
 * @property string $fi2_depiso
 * @property string $fi2_inodoro
 * @property string $fi2_lavamanos
 * @property string $fi2_porta_papel
 * @property string $fi2_basura_baño
 * @property string $fi2_ducha
 * @property string $fi2_pieducha
 * @property string $fi2_colgador
 * @property string $fi2_sala_maquina
 * @property string $fi2_refrigeracion
 * @property string $fi2_grasas
 * @property string $fi2_iluminacion
 * @property string $fi2_mantenimieno
 * @property string $fi2_depositos
 * @property string $fi2_area_lavado_planchado
 * @property string $fi2_extinguidor
 * @property string $fi2_vectores
 * @property string $fi2_observacion
 * @property string $fi2_estado
 * @property string $created_at
 * @property string $updated_at
 * @property string $deleted_at
 * @property int $userid_at
 */
class Ficha2 extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'ficha2';

    /**
     * The primary key for the model.
     * 
     * @var string
     */
    protected $primaryKey = 'fi2_id';

    /**
     * @var array
     */
    protected $fillable = ['fi_id', 'fi2_fecha_realizacion', 'fi2_cama', 'fi2_nro_habitaciones', 'fi2_nro_almacenes', 'fi2_nro_salones', 'fi2_salones_bueno', 'fi2_salones_regular', 'fi2_piscina_o_sauna', 'fi2_piscina_regular', 'fi2_piscina_bueno', 'fi2_nro_cocina', 'fi2_nro_cocinas_apart_hotel', 'fi2_total_gambusas', 'fi2_recepcion', 'fi2_nro_restautant', 'fi2_aire_acondicionado', 'fi2_agua_caliente', 'fi2_calefaccion', 'fi2_frigobar', 'fi2_room_service', 'fi2_telefono_hab', 'fi2_tv', 'fi2_cubrecolchones', 'fi2_mesa', 'fi2_tocador', 'fi2_lampara', 'fi2_sillones', 'fi2_espejo', 'fi2_cesto_basura', 'fi2_portamaletas', 'fi2_ropero', 'fi2_lavanderia', 'fi2_cortina', 'fi2_pisos_baño', 'fi2_azulejos', 'fi2_depiso', 'fi2_inodoro', 'fi2_lavamanos', 'fi2_porta_papel', 'fi2_basura_baño', 'fi2_ducha', 'fi2_pieducha', 'fi2_colgador', 'fi2_sala_maquina', 'fi2_refrigeracion', 'fi2_grasas', 'fi2_iluminacion', 'fi2_mantenimieno', 'fi2_depositos', 'fi2_area_lavado_planchado', 'fi2_extinguidor', 'fi2_vectores', 'fi2_observacion', 'fi2_estado'];
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
