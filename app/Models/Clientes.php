<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Clientes extends Model
{
    use SoftDeletes;

    protected $table = 'clientes';
    protected $primaryKey = 'id';

    public $timestamps = true; //habilitar las fechas

    protected $fillable = [
        'nombre',
        'numero_telefono',
        'instangram',
        'direccion_envio',
    ];

    public function pedidos()
    {
        return $this->belongsToMany(Pedido::class, 'pedido')
        ->withPivot('estado','total','fecha_aprox_entrega');
    }
} 
