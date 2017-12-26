<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property PNatural[] $pNaturals
 * @property PJuridica[] $pJuridicas
 * @property EmpresaPropietario[] $empresaPropietarios
 * @property int $pro_id
 * @property int $pro_telefono
 * @property string $created_at
 * @property string $updated_at
 * @property string $deleted_at
 * @property int $userid_at
 */
class Propietario extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'propietario';

    /**
     * The primary key for the model.
     * 
     * @var string
     */
    protected $primaryKey = 'pro_id';

    /**
     * @var array
     */
    protected $fillable = ['pro_telefono'];
    protected $hidden = ['created_at', 'updated_at', 'deleted_at', 'userid_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function pNaturals()
    {
        return $this->hasMany('App\PNatural', 'pro_id', 'pro_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function pJuridicas()
    {
        return $this->hasMany('App\PJuridica', 'pro_id', 'pro_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function empresaPropietarios()
    {
        return $this->hasMany('App\EmpresaPropietario', 'pro_id', 'pro_id');
    }
}
