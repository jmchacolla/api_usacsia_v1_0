<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property PruebaMedica $pruebaMedica
 * @property int $rec_id
 * @property int $pm_id
 * @property string $rec_texto
 * @property string $rec_estado
 * @property string $rec_fecha_presentado
 * @property string $created_at
 * @property string $updated_at
 * @property string $deleted_at
 * @property int $userid_at
 */
class Receta extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'receta';

    /**
     * The primary key for the model.
     * 
     * @var string
     */
    protected $primaryKey = 'rec_id';

    /**
     * @var array
     */
    protected $fillable = ['pm_id', 'rec_texto', 'rec_estado', 'rec_fecha_presentado','rec_img_nombre', 'rec_img_enlace'];
    protected $hidden = ['created_at','updated_at','userid_at','deleted_at'];
    protected $dates=['deleted_at'];
    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function pruebaMedica()
    {
        return $this->belongsTo('App\PruebaMedica', 'pm_id', 'pm_id');
    }
}
