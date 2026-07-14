<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Pedido extends Model
{
    use SoftDeletes;

    protected $table = 'productos';
    protected $primaryKey = 'id';

    public $timestamps = true; //habilitar las fechas

    protected $fillable = [
        'cliente_id',
        'estado',
        'total',
        'estado',
        'costo_envio',
        'fecha_aprox_entrega',
    ];

    protected $casts = [
        'total' => 'decimal',
        'costo_envio' => 'decimal',
    ];

    public function productos()
    {
        return $this->hasMany(Pedido::class);
    }
}
