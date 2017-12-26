<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property FichaInspeccion $fichaInspeccion
 * @property int $fi1_id
 * @property int $fi_id
 * @property string $fi1_fecha_realizacion
 * @property string $fi1_observacion
 * @property string $fi1_estado
 * @property boolean $fi1_foco_insalubridad
 * @property boolean $fi1_exibe_certificado
 * @property boolean $fi1_exibe_carnes
 * @property string $fi1_infraestructura
 * @property int $fi1_servicios_higienicos
 * @property int $fi1_otros_servicios
 * @property int $fi1_inodoro
 * @property int $fi1_jaboncillo
 * @property int $fi1_lavamanos_porcelana
 * @property int $fi1_toallas
 * @property int $fi1_duchas
 * @property string $fi1_detalle_equipo
 * @property string $fi1_detalle_utencilios
 * @property string $fi1_otros
 * @property string $fi1_recomendaciones
 * @property string $fi1_aseo_personal
 * @property string $fi1_residuos_solidos
 * @property string $fi1_abastecimiento_agua
 * @property string $fi1_control_insectos_roedores
 * @property string $fi1_residuos_liquidos
 * @property string $fi1_distribucion_dependencias
 * @property string $fi1_conservacion_productos_materia_prima
 * @property string $created_at
 * @property string $updated_at
 * @property string $deleted_at
 * @property int $userid_at
 */
class Ficha1 extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'ficha1';

    /**
     * The primary key for the model.
     * 
     * @var string
     */
    protected $primaryKey = 'fi1_id';

    /**
     * @var array
     */
    protected $fillable = ['fi_id', 'fi1_fecha_realizacion', 'fi1_observacion', 'fi1_estado', 'fi1_foco_insalubridad', 'fi1_exibe_certificado', 'fi1_exibe_carnes', 'fi1_infraestructura', 'fi1_servicios_higienicos', 'fi1_otros_servicios', 'fi1_inodoro', 'fi1_jaboncillo', 'fi1_lavamanos_porcelana', 'fi1_toallas', 'fi1_duchas', 'fi1_detalle_equipo', 'fi1_detalle_utencilios', 'fi1_otros', 'fi1_recomendaciones', 'fi1_aseo_personal', 'fi1_residuos_solidos', 'fi1_abastecimiento_agua', 'fi1_control_insectos_roedores', 'fi1_residuos_liquidos', 'fi1_distribucion_dependencias', 'fi1_conservacion_productos_materia_prima', 'created_at', 'updated_at', 'deleted_at', 'userid_at'];
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
