<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use App\Models\Almacen;
use App\Models\Movimiento;
use App\Models\Inventario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MovimientoController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Mostrar formulario de entrada de productos
     */
    public function createEntrada(Request $request)
    {
        $productos = Producto::where('activo', true)->orderBy('nombre')->get();
        $almacenes = Almacen::where('activo', true)->orderBy('nombre')->get();
        
        // Si viene con parámetro almacen (desde vista de almacén)
        $almacenSeleccionado = $request->get('almacen');
        
        return view('movimientos.entrada', compact('productos', 'almacenes', 'almacenSeleccionado'));
    }

    /**
     * Registrar entrada de productos
     */
    public function storeEntrada(Request $request)
    {
        $request->validate([
            'producto_id' => 'required|exists:productos,id',
            'cantidad' => 'required|integer|min:1',
            'almacen_destino_id' => 'required|exists:almacenes,id',
            'referencia' => 'nullable|string|max:255',
            'observaciones' => 'nullable|string'
        ]);

        try {
            DB::beginTransaction();

            // Verificar que el producto esté activo
            $producto = Producto::findOrFail($request->producto_id);
            if (!$producto->activo) {
                throw new \Exception('El producto no está activo.');
            }

            // Registrar movimiento
            $movimiento = Movimiento::create([
                'tipo' => 'entrada',
                'producto_id' => $request->producto_id,
                'cantidad' => $request->cantidad,
                'almacen_destino_id' => $request->almacen_destino_id,
                'referencia' => $request->referencia,
                'observaciones' => $request->observaciones,
                'usuario_id' => auth()->id()
            ]);

            // Actualizar inventario
            $inventario = Inventario::firstOrCreate(
                [
                    'producto_id' => $request->producto_id,
                    'almacen_id' => $request->almacen_destino_id
                ],
                ['cantidad' => 0]
            );

            $inventario->cantidad += $request->cantidad;
            $inventario->save();

            DB::commit();

            return redirect()->route('movimientos.historial')
                ->with('success', 'Entrada registrada exitosamente.');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Error al registrar la entrada: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Mostrar formulario de salida de productos
     */
    public function createSalida(Request $request)
    {
        $productos = Producto::where('activo', true)->orderBy('nombre')->get();
        $almacenes = Almacen::where('activo', true)->orderBy('nombre')->get();
        
        // Si viene con parámetro almacen (desde vista de almacén)
        $almacenSeleccionado = $request->get('almacen');
        
        return view('movimientos.salida', compact('productos', 'almacenes', 'almacenSeleccionado'));
    }

    /**
     * Registrar salida de productos
     */
    public function storeSalida(Request $request)
    {
        $request->validate([
            'producto_id' => 'required|exists:productos,id',
            'cantidad' => 'required|integer|min:1',
            'almacen_origen_id' => 'required|exists:almacenes,id',
            'referencia' => 'nullable|string|max:255',
            'observaciones' => 'nullable|string'
        ]);

        try {
            DB::beginTransaction();

            // Verificar stock suficiente
            $inventario = Inventario::where('producto_id', $request->producto_id)
                ->where('almacen_id', $request->almacen_origen_id)
                ->first();

            if (!$inventario || $inventario->cantidad < $request->cantidad) {
                throw new \Exception('Stock insuficiente en el almacén seleccionado.');
            }

            // Registrar movimiento
            Movimiento::create([
                'tipo' => 'salida',
                'producto_id' => $request->producto_id,
                'cantidad' => $request->cantidad,
                'almacen_origen_id' => $request->almacen_origen_id,
                'referencia' => $request->referencia,
                'observaciones' => $request->observaciones,
                'usuario_id' => auth()->id()
            ]);

            // Actualizar inventario
            $inventario->cantidad -= $request->cantidad;
            $inventario->save();

            DB::commit();

            return redirect()->route('movimientos.historial')
                ->with('success', 'Salida registrada exitosamente.');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Error al registrar la salida: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Mostrar formulario de traslado entre almacenes
     */
    public function createTraslado(Request $request)
    {
        $productos = Producto::where('activo', true)->orderBy('nombre')->get();
        $almacenes = Almacen::where('activo', true)->orderBy('nombre')->get();
        
        // Si viene con parámetro origen (desde vista de almacén)
        $origenSeleccionado = $request->get('origen');
        
        return view('movimientos.traslado', compact('productos', 'almacenes', 'origenSeleccionado'));
    }

    /**
     * Registrar traslado entre almacenes
     */
    public function storeTraslado(Request $request)
    {
        $request->validate([
            'producto_id' => 'required|exists:productos,id',
            'cantidad' => 'required|integer|min:1',
            'almacen_origen_id' => 'required|exists:almacenes,id|different:almacen_destino_id',
            'almacen_destino_id' => 'required|exists:almacenes,id',
            'observaciones' => 'nullable|string'
        ]);

        try {
            DB::beginTransaction();

            // Verificar stock suficiente en origen
            $inventarioOrigen = Inventario::where('producto_id', $request->producto_id)
                ->where('almacen_id', $request->almacen_origen_id)
                ->first();

            if (!$inventarioOrigen || $inventarioOrigen->cantidad < $request->cantidad) {
                throw new \Exception('Stock insuficiente en el almacén de origen.');
            }

            // Registrar movimiento
            Movimiento::create([
                'tipo' => 'traslado',
                'producto_id' => $request->producto_id,
                'cantidad' => $request->cantidad,
                'almacen_origen_id' => $request->almacen_origen_id,
                'almacen_destino_id' => $request->almacen_destino_id,
                'observaciones' => $request->observaciones,
                'usuario_id' => auth()->id()
            ]);

            // Restar del origen
            $inventarioOrigen->cantidad -= $request->cantidad;
            $inventarioOrigen->save();

            // Sumar al destino
            $inventarioDestino = Inventario::firstOrCreate(
                [
                    'producto_id' => $request->producto_id,
                    'almacen_id' => $request->almacen_destino_id
                ],
                ['cantidad' => 0]
            );
            $inventarioDestino->cantidad += $request->cantidad;
            $inventarioDestino->save();

            DB::commit();

            return redirect()->route('movimientos.historial')
                ->with('success', 'Traslado registrado exitosamente.');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Error al registrar el traslado: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Mostrar historial de movimientos
     */
    public function historial(Request $request)
    {
        $query = Movimiento::with(['producto', 'almacenOrigen', 'almacenDestino', 'usuario']);
        
        // Filtros
        if ($request->has('tipo') && $request->tipo != '') {
            $query->where('tipo', $request->tipo);
        }
        
        if ($request->has('producto_id') && $request->producto_id != '') {
            $query->where('producto_id', $request->producto_id);
        }
        
        if ($request->has('almacen_id') && $request->almacen_id != '') {
            $query->where(function($q) use ($request) {
                $q->where('almacen_origen_id', $request->almacen_id)
                  ->orWhere('almacen_destino_id', $request->almacen_id);
            });
        }
        
        if ($request->has('fecha_desde') && $request->fecha_desde != '') {
            $query->whereDate('created_at', '>=', $request->fecha_desde);
        }
        
        if ($request->has('fecha_hasta') && $request->fecha_hasta != '') {
            $query->whereDate('created_at', '<=', $request->fecha_hasta);
        }
        
        $movimientos = $query->orderBy('created_at', 'desc')->paginate(20);
        
        $productos = Producto::where('activo', true)->orderBy('nombre')->get();
        $almacenes = Almacen::where('activo', true)->orderBy('nombre')->get();
        
        return view('movimientos.historial', compact('movimientos', 'productos', 'almacenes'));
    }

    /**
     * Obtener stock disponible de un producto en un almacén (para AJAX)
     */
    public function getStock(Request $request)
    {
        $request->validate([
            'producto_id' => 'required|exists:productos,id',
            'almacen_id' => 'required|exists:almacenes,id'
        ]);
        
        $inventario = Inventario::where('producto_id', $request->producto_id)
            ->where('almacen_id', $request->almacen_id)
            ->first();
        
        $stock = $inventario ? $inventario->cantidad : 0;
        
        return response()->json([
            'success' => true,
            'stock' => $stock
        ]);
    }
}