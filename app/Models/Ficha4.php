<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property FichaInspeccion $fichaInspeccion
 * @property int $fi4_id
 * @property int $fi_id
 * @property int $fi4_ubicacion
 * @property int $fi4_certificado
 * @property int $fi4_dependencias
 * @property int $fi4_pisos
 * @property int $fi4_cielo
 * @property int $fi4_murallas
 * @property float $fi4_muralla_altura
 * @property int $fi4_puerta_ventana
 * @property int $fi4_iluminacion
 * @property int $fi4_ventilacion
 * @property int $fi4_abastecimiento
 * @property int $fi4_servicio_higienico
 * @property int $fi4_lavamanos
 * @property int $fi4_jabocillo
 * @property int $fi4_ducha
 * @property int $fi4_desagues
 * @property int $fi4_desgrasadores
 * @property int $fi4_basurero
 * @property int $fi4_insectos
 * @property int $fi4_roedores
 * @property int $fi4_artezas
 * @property int $fi4_enfriadores
 * @property int $fi4_clavijeras
 * @property int $fi4_mesones
 * @property int $fi4_maquinarias
 * @property int $fi4_lavado_envases
 * @property int $fi4_depositos
 * @property int $fi4_heridas
 * @property int $fi4_dinero
 * @property int $fi4_botiquin_extinguidor
 * @property string $fi4__recomendaciones
 * @property string $fi4_estado
 * @property int $fi4_total
 * @property string $created_at
 * @property string $updated_at
 * @property string $deleted_at
 * @property int $userid_at
 */
class Ficha4 extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'ficha4';

    /**
     * The primary key for the model.
     * 
     * @var string
     */
    protected $primaryKey = 'fi4_id';

    /**
     * @var array
     */
    protected $fillable = ['fi_id', 'fi4_ubicacion', 'fi4_certificado', 'fi4_dependencias', 'fi4_pisos', 'fi4_cielo', 'fi4_murallas', 'fi4_muralla_altura', 'fi4_puerta_ventana', 'fi4_iluminacion', 'fi4_ventilacion', 'fi4_abastecimiento', 'fi4_servicio_higienico', 'fi4_lavamanos', 'fi4_jabocillo', 'fi4_ducha', 'fi4_desagues', 'fi4_desgrasadores', 'fi4_basurero', 'fi4_insectos', 'fi4_roedores', 'fi4_artezas', 'fi4_enfriadores', 'fi4_clavijeras', 'fi4_mesones', 'fi4_maquinarias', 'fi4_lavado_envases', 'fi4_depositos', 'fi4_heridas', 'fi4_dinero', 'fi4_botiquin_extinguidor', 'fi4__recomendaciones', 'fi4_estado', 'fi4_total'];
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
