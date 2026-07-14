<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Categoria;
use App\Models\User;
use App\Models\Comentarios;

class Tareas extends Model
{

    use SoftDeletes; //agragado para el borrado logico

    protected $table = 'tareas';
    protected $primaryKey = 'id';

    public $timestamps = true; //habilitar las fechas

    protected $fillable = [
        'titulo',
        'descripcion',
        'fecha_inicio',
        'fecha_fin',
        'fecha_aproximada',
        'valor_puntos',
        'estado',
        'categoria_id',
        'created_by',
        'updated_by',
    ];

    protected $casts = [
        'fecha_inicio' => 'date',
        'fecha_fin' => 'date',
        'fecha_aproximada' => 'date',
        'valor_puntos' => 'integer',
        'estado' => 'string',
    ];

    public function categoria()
    {
        return $this->belongsTo(Categoria::class, 'categoria_id');
    }

    public function creador()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function editador()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    public function comentarios()
    {
        return $this->hasMany(Comentarios::class, 'tarea_id');
    }
}
