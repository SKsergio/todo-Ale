<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CategoriaProductos extends Model
{
    use SoftDeletes;

    protected $table ="categoria_productos";
    protected $primaryKey = 'id';
    protected $fillable = [
        "nombre",
        "descripcion"
    ];

    public $timestamps = true;
}
