<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property Propietario $propietario
 * @property Persona $persona
 * @property int $pnat_id
 * @property int $pro_id
 * @property int $per_id
 * @property string $created_at
 * @property string $updated_at
 * @property string $deleted_at
 * @property int $userid_at
 */
class PersonaNatural extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'p_natural';

    /**
     * The primary key for the model.
     * 
     * @var string
     */
    protected $primaryKey = 'pnat_id';

    /**
     * @var array
     */
    protected $fillable = ['pro_id', 'per_id'];
    protected $hidden = ['created_at', 'updated_at', 'deleted_at', 'userid_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function propietario()
    {
        return $this->belongsTo('App\Propietario', 'pro_id', 'pro_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function persona()
    {
        return $this->belongsTo('App\Persona', 'per_id', 'per_id');
    }
}
