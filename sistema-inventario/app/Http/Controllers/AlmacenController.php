<?php

namespace App\Http\Controllers;

use App\Models\Almacen;
use App\Models\Inventario;
use App\Models\Movimiento;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AlmacenController extends Controller
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
        $query = Almacen::query();

        // Búsqueda por nombre o ubicación
        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('nombre', 'like', "%{$search}%")
                  ->orWhere('ubicacion', 'like', "%{$search}%")
                  ->orWhere('descripcion', 'like', "%{$search}%");
            });
        }

        // Filtro por estado
        if ($request->has('estado') && $request->estado != '') {
            $query->where('activo', $request->estado);
        }

        $almacenes = $query->withCount(['inventarios as total_productos' => function($query) {
                $query->select(DB::raw('SUM(cantidad)'));
            }])
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('almacenes.index', compact('almacenes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('almacenes.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255|unique:almacenes,nombre',
            'ubicacion' => 'nullable|string|max:255',
            'descripcion' => 'nullable|string',
        ]);

        try {
            Almacen::create([
                'nombre' => $request->nombre,
                'ubicacion' => $request->ubicacion,
                'descripcion' => $request->descripcion,
                'activo' => true
            ]);

            return redirect()->route('almacenes.index')
                ->with('success', 'Almacén creado exitosamente.');

        } catch (\Exception $e) {
            return back()->with('error', 'Error al crear el almacén: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Almacen $almacen)
    {
        // Cargar relaciones
        $almacen->load(['inventarios.producto' => function($query) {
            $query->orderBy('nombre');
        }]);

        // Obtener estadísticas
        $totalProductos = $almacen->inventarios->sum('cantidad');
        $valorInventario = $almacen->inventarios->sum(function($inventario) {
            return $inventario->cantidad * $inventario->producto->precio_compra;
        });

        // Últimos movimientos
        $ultimosMovimientos = Movimiento::where('almacen_origen_id', $almacen->id)
            ->orWhere('almacen_destino_id', $almacen->id)
            ->with(['producto', 'usuario'])
            ->orderBy('created_at', 'desc')
            ->take(20)
            ->get();

        // Productos con stock bajo
        $stockBajo = $almacen->inventarios()
            ->with('producto')
            ->get()
            ->filter(function($inventario) {
                return $inventario->cantidad <= $inventario->producto->stock_minimo;
            });

        return view('almacenes.show', compact(
            'almacen', 
            'totalProductos', 
            'valorInventario', 
            'ultimosMovimientos',
            'stockBajo'
        ));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Almacen $almacen)
    {
        return view('almacenes.edit', compact('almacen'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Almacen $almacen)
    {
        $request->validate([
            'nombre' => 'required|string|max:255|unique:almacenes,nombre,' . $almacen->id,
            'ubicacion' => 'nullable|string|max:255',
            'descripcion' => 'nullable|string',
        ]);

        try {
            $almacen->update([
                'nombre' => $request->nombre,
                'ubicacion' => $request->ubicacion,
                'descripcion' => $request->descripcion,
            ]);

            return redirect()->route('almacenes.index')
                ->with('success', 'Almacén actualizado exitosamente.');

        } catch (\Exception $e) {
            return back()->with('error', 'Error al actualizar el almacén: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Almacen $almacen)
    {
        try {
            // Verificar si tiene productos en inventario
            if ($almacen->inventarios()->where('cantidad', '>', 0)->exists()) {
                return back()->with('error', 'No se puede eliminar el almacén porque tiene productos con stock.');
            }

            // Verificar si tiene movimientos
            if ($almacen->movimientosOrigen()->exists() || $almacen->movimientosDestino()->exists()) {
                // Si tiene movimientos, solo desactivar
                $almacen->update(['activo' => false]);
                $message = 'Almacén desactivado porque tiene movimientos asociados.';
            } else {
                // Si no tiene movimientos, eliminar físicamente
                $almacen->delete();
                $message = 'Almacén eliminado exitosamente.';
            }

            return redirect()->route('almacenes.index')
                ->with('success', $message);

        } catch (\Exception $e) {
            return back()->with('error', 'Error al eliminar el almacén: ' . $e->getMessage());
        }
    }

    /**
     * Toggle almacen status.
     */
    public function toggleStatus(Almacen $almacen)
    {
        try {
            // Verificar si tiene productos con stock antes de desactivar
            if ($almacen->activo && $almacen->inventarios()->where('cantidad', '>', 0)->exists()) {
                return back()->with('error', 'No se puede desactivar el almacén porque tiene productos con stock.');
            }

            $almacen->update(['activo' => !$almacen->activo]);
            
            $estado = $almacen->activo ? 'activado' : 'desactivado';
            
            return redirect()->route('almacenes.index')
                ->with('success', "Almacén {$estado} exitosamente.");

        } catch (\Exception $e) {
            return back()->with('error', 'Error al cambiar el estado del almacén.');
        }
    }

    /**
     * Get inventory by almacen
     */
    public function inventario(Almacen $almacen, Request $request)
    {
        $query = $almacen->inventarios()
            ->with('producto')
            ->where('cantidad', '>', 0);

        // Búsqueda por producto
        if ($request->has('search')) {
            $search = $request->search;
            $query->whereHas('producto', function($q) use ($search) {
                $q->where('nombre', 'like', "%{$search}%")
                  ->orWhere('codigo', 'like', "%{$search}%");
            });
        }

        $inventario = $query->orderBy('cantidad', 'desc')
            ->paginate(15);

        return view('almacenes.inventario', compact('almacen', 'inventario'));
    }

    /**
     * Get movements by almacen
     */
    public function movimientos(Almacen $almacen, Request $request)
    {
        $movimientos = Movimiento::where('almacen_origen_id', $almacen->id)
            ->orWhere('almacen_destino_id', $almacen->id)
            ->with(['producto', 'usuario', 'almacenOrigen', 'almacenDestino'])
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        return view('almacenes.movimientos', compact('almacen', 'movimientos'));
    }

    /**
     * Export inventory report
     */
    public function exportarInventario(Almacen $almacen)
    {
        // Aquí puedes implementar la exportación a PDF/Excel
        // Por ahora solo redirigimos con un mensaje
        return redirect()->route('almacenes.show', $almacen)
            ->with('info', 'Funcionalidad de exportación en desarrollo.');
    }
}