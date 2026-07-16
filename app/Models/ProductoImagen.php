<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductoImagen extends Model
{
    protected $table = 'producto_imagenes';

    protected $fillable = [
        'producto_id',
        'image_url',
        'es_principal',
    ];

    /**
     * Relación: Una imagen pertenece a un producto.
     */
    public function producto()
    {
        return $this->belongsTo(Productos::class);
    }
}