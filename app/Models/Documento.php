<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property DocumentoTramite[] $documentoTramites
 * @property int $doc_id
 * @property string $doc_nombre
 * @property string $doc_importancia
 * @property string $created_at
 * @property string $updated_at
 * @property string $deleted_at
 * @property int $userid_at
 */
class Documento extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'documento';

    /**
     * The primary key for the model.
     * 
     * @var string
     */
    protected $primaryKey = 'doc_id';

    /**
     * @var array
     */
    protected $fillable = ['doc_nombre', 'doc_importancia'];
    protected $hidden = ['created_at', 'updated_at', 'deleted_at', 'userid_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function documentoTramites()
    {
        return $this->hasMany('App\DocumentoTramite', 'doc_id', 'doc_id');
    }
}
