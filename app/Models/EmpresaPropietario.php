<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @property Empresa $empresa
 * @property Propietario $propietario
 * @property int $ep_id
 * @property int $emp_id
 * @property int $pro_id
 * @property string $created_at
 * @property string $updated_at
 * @property string $deleted_at
 * @property int $userid_at
 */
class EmpresaPropietario extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'empresa_propietario';

    /**
     * The primary key for the model.
     * 
     * @var string
     */
    protected $primaryKey = 'ep_id';

    /**
     * @var array
     */
    protected $fillable = ['emp_id', 'pro_id', 'created_at', 'updated_at', 'deleted_at', 'userid_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function empresa()
    {
        return $this->belongsTo('App\Empresa', 'emp_id', 'emp_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function propietario()
    {
        return $this->belongsTo('App\Propietario', 'pro_id', 'pro_id');
    }
}
