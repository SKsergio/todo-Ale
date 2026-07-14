<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Categoria;

class CategoriaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Categoria::create([
            'nombre' => 'Trabajo',
            'nombre' => 'Tareas relacionadas con el trabajo',
        ]);

        Categoria::create([
            'nombre' => 'Estudios',
            'nombre' => 'Tareas y activiades que quiero lograr en el ambito academico',
        ]);

        Categoria::create([
            'nombre' => 'Cosas que quiero Comprar',
            'nombre' => 'Una lista de deseos con cosas que quiero comprar por mi misma',
        ]);

        Categoria::create([
            'nombre' => 'Nosotros',
            'nombre' => 'Actividades y metas que quiero lograr con mi hombre',
        ]);
    }
}
