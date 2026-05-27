<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Producto;
use App\Models\Almacen;
use App\Models\Inventario;

class ProductoSeeder extends Seeder
{
    public function run()
    {
        $productos = [
            [
                'codigo' => 'PROD001',
                'nombre' => 'Laptop HP',
                'descripcion' => 'Laptop HP 15.6" 8GB RAM',
                'precio_compra' => 800,
                'precio_venta' => 1200,
                'stock_minimo' => 5
            ],
            [
                'codigo' => 'PROD002',
                'nombre' => 'Mouse Inalámbrico',
                'descripcion' => 'Mouse óptico inalámbrico',
                'precio_compra' => 15,
                'precio_venta' => 25,
                'stock_minimo' => 20
            ],
            [
                'codigo' => 'PROD003',
                'nombre' => 'Teclado Mecánico',
                'descripcion' => 'Teclado mecánico RGB',
                'precio_compra' => 45,
                'precio_venta' => 75,
                'stock_minimo' => 10
            ]
        ];

        $almacenes = Almacen::all();

        foreach ($productos as $productoData) {
            $producto = Producto::create($productoData);
            
            // Agregar stock inicial en cada almacén
            foreach ($almacenes as $almacen) {
                Inventario::create([
                    'producto_id' => $producto->id,
                    'almacen_id' => $almacen->id,
                    'cantidad' => rand(10, 50) // Stock inicial aleatorio
                ]);
            }
        }
    }
}