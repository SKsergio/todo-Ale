<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Productos extends Model
{
    use SoftDeletes;

    protected $table = 'productos';
    protected $primaryKey = 'id';

    public $timestamps = true; //habilitar las fechas


    protected $fillable = [
        'nombre',
        'descripcion',
        'precio_estimado',
        'estado',
        'image_url',
        'categoria_producto_id',
        'created_by',
        'updated_by',
    ];

    protected $casts = [
        'precio_estimado' => 'decimal:2',
        'estado' => 'string',
    ];

    public function categoria_producto()
    {
        return $this->belongsTo(CategoriaProductos::class, 'categoria_producto_id');
    }

    public function creador()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function editador()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    public function pedidos()
    {
        return $this->belongsToMany(Pedido::class, 'pedido_producto')
            ->withPivot('cantidad', 'precio_unitario', 'detalles_personalizados')
            ->withTimestamps();
    }
}
