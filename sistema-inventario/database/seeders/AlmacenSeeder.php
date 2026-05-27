<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Almacen;

class AlmacenSeeder extends Seeder
{
    public function run()
    {
        $almacenes = [
            [
                'nombre' => 'Almacén Central',
                'ubicacion' => 'Av. Principal #123',
                'descripcion' => 'Almacén principal de la empresa'
            ],
            [
                'nombre' => 'Almacén Norte',
                'ubicacion' => 'Calle Norte #456',
                'descripcion' => 'Sucursal zona norte'
            ],
            [
                'nombre' => 'Almacén Sur',
                'ubicacion' => 'Av. Sur #789',
                'descripcion' => 'Sucursal zona sur'
            ]
        ];

        foreach ($almacenes as $almacen) {
            Almacen::create($almacen);
        }
    }
}