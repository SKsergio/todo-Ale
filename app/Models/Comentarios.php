<?php

namespace App\Models;
use App\Models\Tareas;
use App\Models\User;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Comentarios extends Model
{
    use SoftDeletes;

    protected $table = 'comentarios';
    protected $primaryKey = 'id';
    protected $fillable = [
        'contenido',
        'tarea_id',
        'created_by',
        'updated_by',
    ];

    public $timestamps = true;//habilitar las fechas

    protected $casts = [
        'created_by' => 'integer',
        'updated_by' => 'integer',
    ];

    public function tarea()
    {
        return $this->belongsTo(Tareas::class, 'tarea_id');
    }

    public function creador()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function editador()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }
}
