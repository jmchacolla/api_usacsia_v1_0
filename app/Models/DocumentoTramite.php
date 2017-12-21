<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property Documento $documento
 * @property EmpresaTramite $empresaTramite
 * @property int $dt_id
 * @property int $doc_id
 * @property int $et_id
 * @property string $dt_estado
 * @property string $dt_url
 * @property string $dt_nombre
 * @property string $dt_observacion
 * @property string $dt_fecha_presentado
 * @property string $dt_fecha_revision
 * @property string $created_at
 * @property string $updated_at
 * @property string $deleted_at
 * @property int $userid_at
 */
class DocumentoTramite extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'documento_tramite';

    /**
     * The primary key for the model.
     * 
     * @var string
     */
    protected $primaryKey = 'dt_id';

    /**
     * @var array
     */
    protected $fillable = ['doc_id', 'et_id', 'dt_estado', 'dt_url', 'dt_nombre', 'dt_observacion', 'dt_fecha_presentado', 'dt_fecha_revision'];
     protected $hidden = ['created_at', 'updated_at', 'deleted_at', 'userid_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function documento()
    {
        return $this->belongsTo('App\Documento', 'doc_id', 'doc_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function empresaTramite()
    {
        return $this->belongsTo('App\EmpresaTramite', 'et_id', 'et_id');
    }
}
