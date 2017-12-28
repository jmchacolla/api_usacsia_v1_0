<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property Propietario $propietario
 * @property int $pjur_id
 * @property int $pro_id
 * @property string $pjur_razon_social
 * @property int $pjur_nit
 * @property string $created_at
 * @property string $updated_at
 * @property string $deleted_at
 * @property int $userid_at
 */
class PersonaJuridica extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'p_juridica';

    /**
     * The primary key for the model.
     * 
     * @var string
     */
    protected $primaryKey = 'pjur_id';

    /**
     * @var array
     */
    protected $fillable = ['pro_id', 'pjur_razon_social', 'pjur_nit'];
    protected $hidden = ['created_at','updated_at','userid_at','deleted_at'];
    protected $dates=['deleted_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function propietario()
    {
        return $this->belongsTo('App\Propietario', 'pro_id', 'pro_id');
    }
}
