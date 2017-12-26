<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property Categorium[] $categorias
 * @property int $subc_id
 * @property int $cle_id
 * @property string $sub_codigo
 * @property string $sub_nombre
 * @property string $created_at
 * @property string $updated_at
 * @property string $deleted_at
 * @property int $userid_at
 */
class Subclasificacion extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'subclasificacion';

    /**
     * The primary key for the model.
     * 
     * @var string
     */
    protected $primaryKey = 'sub_id';

    /**
     * @var array
     */
    protected $fillable = ['cle_id', 'sub_codigo', 'sub_nombre'];
    protected $hidden = ['created_at','updated_at','userid_at','deleted_at'];
    protected $dates=['deleted_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function categoria()
    {
        return $this->hasMany('App\Categoria', 'sub_id', 'sub_id');
    }
}
