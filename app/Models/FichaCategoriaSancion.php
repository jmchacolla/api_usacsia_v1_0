<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property FichaCategorium $fichaCategorium
 * @property Categorium $categorium
 * @property PagoSancion[] $pagoSancions
 * @property int $fcs_id
 * @property int $fc_id
 * @property int $cat_id
 * @property string $created_at
 * @property string $updated_at
 * @property string $deleted_at
 * @property int $userid_at
 */
class FichaCategoriaSancion extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'ficha_categoria_sancion';

    /**
     * The primary key for the model.
     * 
     * @var string
     */
    protected $primaryKey = 'fcs_id';

    /**
     * @var array
     */
    protected $fillable = ['fc_id', 'cat_id'];
    protected $hidden = ['created_at', 'updated_at', 'userid_at'];
    protected $dates=['deleted_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function fichaCategorium()
    {
        return $this->belongsTo('App\FichaCategorium', 'fc_id', 'fc_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function categorium()
    {
        return $this->belongsTo('App\Categorium', 'cat_id', 'cat_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function pagoSancions()
    {
        return $this->hasMany('App\PagoSancion', 'fcs_id', 'fcs_id');
    }
}
