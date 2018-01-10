<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property Categorium $categorium
 * @property FichaInspeccion $fichaInspeccion
 * @property int $fc_id
 * @property int $cat_id
 * @property int $fi_id
 * @property string $created_at
 * @property string $updated_at
 * @property string $deleted_at
 * @property int $userid_at
 */
class Ficha_categoria extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'ficha_categoria';

    /**
     * The primary key for the model.
     * 
     * @var string
     */
    protected $primaryKey = 'fc_id';
    /**
     * @var array
     */
    protected $fillable = ['cat_id', 'fi_id','cat_monto'];
    protected $hidden = ['created_at', 'updated_at', 'userid_at'];
    protected $dates=['deleted_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function categorium()
    {
        return $this->belongsTo('App\Categorium', 'cat_id', 'cat_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function fichaInspeccion()
    {
        return $this->belongsTo('App\FichaInspeccion', 'fi_id', 'fi_id');
    }
}
