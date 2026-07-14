<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PedidoProducto extends Model
{
    use SoftDeletes;

    protected $table = 'pedido_producto';
    protected $primaryKey = 'id';

    public $timestamps = true; //habilitar las fechas

    protected $fillable = [
        'pedido_id',
        'producto_id',
        'cantidad',
        'precio_unitario',
        'detalles_personalizados',
    ];

    protected $casts = [
        'precio_unitario' => 'decimal:2',
    ];

}
