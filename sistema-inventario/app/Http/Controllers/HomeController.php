<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Producto;
use App\Models\Almacen;
use App\Models\Movimiento;
use App\Models\Inventario;

class HomeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        // Estadísticas principales
        $totalProductos = Producto::count();
        $totalAlmacenes = Almacen::count();
        $movimientosHoy = Movimiento::whereDate('created_at', today())->count();
        
        // Productos con stock bajo (donde la cantidad en inventario es menor al stock_minimo)
        $stockBajo = Inventario::with(['producto', 'almacen'])
            ->whereHas('producto', function($query) {
                $query->where('activo', true);
            })
            ->get()
            ->filter(function($inventario) {
                return $inventario->cantidad <= $inventario->producto->stock_minimo;
            })
            ->take(5);
        
        // Últimos 10 movimientos
        $ultimosMovimientos = Movimiento::with(['producto', 'almacenOrigen', 'almacenDestino', 'usuario'])
            ->orderBy('created_at', 'desc')
            ->take(10)
            ->get();

        return view('home', compact(
            'totalProductos', 
            'totalAlmacenes', 
            'movimientosHoy', 
            'stockBajo', 
            'ultimosMovimientos'
        ));
    }
}