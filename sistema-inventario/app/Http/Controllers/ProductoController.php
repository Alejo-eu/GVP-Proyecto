<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use App\Models\Inventario;
use App\Models\Almacen;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductoController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Producto::query();

        // Búsqueda por código, nombre o descripción
        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('codigo', 'like', "%{$search}%")
                  ->orWhere('nombre', 'like', "%{$search}%")
                  ->orWhere('descripcion', 'like', "%{$search}%");
            });
        }

        // Filtro por estado
        if ($request->has('estado') && $request->estado != '') {
            $query->where('activo', $request->estado);
        }

        $productos = $query->orderBy('created_at', 'desc')->paginate(10);
        
        return view('productos.index', compact('productos'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $almacenes = Almacen::where('activo', true)->get();
        return view('productos.create', compact('almacenes'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'codigo' => 'required|unique:productos,codigo|max:50',
            'nombre' => 'required|max:255',
            'descripcion' => 'nullable|string',
            'precio_compra' => 'required|numeric|min:0',
            'precio_venta' => 'required|numeric|min:0',
            'stock_minimo' => 'required|integer|min:0',
            'stock_maximo' => 'nullable|integer|min:0',
            'stock_inicial' => 'nullable|array',
            'stock_inicial.*' => 'integer|min:0'
        ]);

        try {
            DB::beginTransaction();

            // Crear el producto
            $producto = Producto::create([
                'codigo' => $request->codigo,
                'nombre' => $request->nombre,
                'descripcion' => $request->descripcion,
                'precio_compra' => $request->precio_compra,
                'precio_venta' => $request->precio_venta,
                'stock_minimo' => $request->stock_minimo,
                'stock_maximo' => $request->stock_maximo,
                'activo' => true
            ]);

            // Asignar stock inicial a los almacenes seleccionados
            if ($request->has('stock_inicial')) {
                foreach ($request->stock_inicial as $almacen_id => $cantidad) {
                    if ($cantidad > 0) {
                        Inventario::create([
                            'producto_id' => $producto->id,
                            'almacen_id' => $almacen_id,
                            'cantidad' => $cantidad
                        ]);
                    }
                }
            }

            DB::commit();

            return redirect()->route('productos.index')
                ->with('success', 'Producto creado exitosamente.');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Error al crear el producto: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Producto $producto)
    {
        $producto->load(['inventarios.almacen', 'movimientos' => function($query) {
            $query->with(['almacenOrigen', 'almacenDestino', 'usuario'])
                  ->orderBy('created_at', 'desc')
                  ->limit(20);
        }]);
        
        return view('productos.show', compact('producto'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Producto $producto)
    {
        $almacenes = Almacen::where('activo', true)->get();
        $inventarioActual = $producto->inventarios()
            ->with('almacen')
            ->get()
            ->keyBy('almacen_id');
        
        return view('productos.edit', compact('producto', 'almacenes', 'inventarioActual'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Producto $producto)
    {
        $request->validate([
            'codigo' => 'required|max:50|unique:productos,codigo,' . $producto->id,
            'nombre' => 'required|max:255',
            'descripcion' => 'nullable|string',
            'precio_compra' => 'required|numeric|min:0',
            'precio_venta' => 'required|numeric|min:0',
            'stock_minimo' => 'required|integer|min:0',
            'stock_maximo' => 'nullable|integer|min:0',
        ]);

        try {
            $producto->update([
                'codigo' => $request->codigo,
                'nombre' => $request->nombre,
                'descripcion' => $request->descripcion,
                'precio_compra' => $request->precio_compra,
                'precio_venta' => $request->precio_venta,
                'stock_minimo' => $request->stock_minimo,
                'stock_maximo' => $request->stock_maximo,
            ]);

            return redirect()->route('productos.index')
                ->with('success', 'Producto actualizado exitosamente.');

        } catch (\Exception $e) {
            return back()->with('error', 'Error al actualizar el producto: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Producto $producto)
    {
        try {
            // Verificar si tiene movimientos
            if ($producto->movimientos()->count() > 0) {
                // Si tiene movimientos, solo desactivar
                $producto->update(['activo' => false]);
                $message = 'Producto desactivado porque tiene movimientos asociados.';
            } else {
                // Si no tiene movimientos, eliminar físicamente
                $producto->delete();
                $message = 'Producto eliminado exitosamente.';
            }

            return redirect()->route('productos.index')
                ->with('success', $message);

        } catch (\Exception $e) {
            return back()->with('error', 'Error al eliminar el producto: ' . $e->getMessage());
        }
    }

    /**
     * Toggle product status.
     */
    public function toggleStatus(Producto $producto)
    {
        try {
            $producto->update(['activo' => !$producto->activo]);
            
            $estado = $producto->activo ? 'activado' : 'desactivado';
            
            return redirect()->route('productos.index')
                ->with('success', "Producto {$estado} exitosamente.");

        } catch (\Exception $e) {
            return back()->with('error', 'Error al cambiar el estado del producto.');
        }
    }

    /**
     * Ajustar stock de producto
     */
    public function ajustarStock(Request $request, Producto $producto)
    {
        $request->validate([
            'almacen_id' => 'required|exists:almacenes,id',
            'cantidad' => 'required|integer',
            'tipo' => 'required|in:sumar,restar,establecer',
            'motivo' => 'nullable|string|max:255'
        ]);

        try {
            DB::beginTransaction();

            $inventario = Inventario::firstOrCreate(
                [
                    'producto_id' => $producto->id,
                    'almacen_id' => $request->almacen_id
                ],
                ['cantidad' => 0]
            );

            $cantidadAnterior = $inventario->cantidad;

            switch ($request->tipo) {
                case 'sumar':
                    $inventario->cantidad += $request->cantidad;
                    break;
                case 'restar':
                    if ($inventario->cantidad < $request->cantidad) {
                        throw new \Exception('No hay suficiente stock para restar.');
                    }
                    $inventario->cantidad -= $request->cantidad;
                    break;
                case 'establecer':
                    $inventario->cantidad = $request->cantidad;
                    break;
            }

            $inventario->save();

            // Registrar movimiento de ajuste
            \App\Models\Movimiento::create([
                'tipo' => 'ajuste',
                'producto_id' => $producto->id,
                'cantidad' => abs($inventario->cantidad - $cantidadAnterior),
                'almacen_destino_id' => $request->almacen_id,
                'observaciones' => "Ajuste de stock: {$request->motivo}",
                'usuario_id' => auth()->id()
            ]);

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Stock ajustado exitosamente.',
                'nuevo_stock' => $inventario->cantidad
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Error al ajustar stock: ' . $e->getMessage()
            ], 500);
        }
    }
}