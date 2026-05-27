@extends('layouts.app')

@section('content')
<div class="container-fluid px-4">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold">
                <i class="bi bi-box me-2"></i>
                Inventario: {{ $almacen->nombre }}
            </h2>
            <p class="text-muted">Listado completo de productos en este almacén</p>
        </div>
        <a href="{{ route('almacenes.show', $almacen) }}" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left me-2"></i>
            Volver al Almacén
        </a>
    </div>

    <!-- Búsqueda -->
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body">
            <form method="GET" class="row g-3">
                <div class="col-md-8">
                    <div class="input-group">
                        <span class="input-group-text bg-white border-end-0">
                            <i class="bi bi-search"></i>
                        </span>
                        <input type="text" 
                               class="form-control border-start-0 ps-0" 
                               name="search" 
                               placeholder="Buscar producto por nombre o código..."
                               value="{{ request('search') }}">
                    </div>
                </div>
                <div class="col-md-4">
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="bi bi-search me-2"></i>
                        Buscar
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Tabla de inventario -->
    <div class="card border-0 shadow-sm">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="table-light">
                        <tr>
                            <th class="ps-4">Código</th>
                            <th>Producto</th>
                            <th>Cantidad</th>
                            <th>Precio Compra</th>
                            <th>Precio Venta</th>
                            <th class="text-end pe-4">Valor Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($inventario as $item)
                        <tr>
                            <td class="ps-4">{{ $item->producto->codigo }}</td>
                            <td>
                                <div>
                                    <span class="fw-bold">{{ $item->producto->nombre }}</span>
                                    @if($item->cantidad <= $item->producto->stock_minimo)
                                        <span class="badge bg-danger ms-2">Stock bajo</span>
                                    @endif
                                </div>
                                <small class="text-muted">{{ Str::limit($item->producto->descripcion, 50) }}</small>
                            </td>
                            <td>
                                <span class="fw-bold">{{ $item->cantidad }}</span>
                            </td>
                            <td>${{ number_format($item->producto->precio_compra, 2) }}</td>
                            <td>${{ number_format($item->producto->precio_venta, 2) }}</td>
                            <td class="text-end pe-4 fw-bold">
                                ${{ number_format($item->cantidad * $item->producto->precio_compra, 2) }}
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center text-muted py-4">
                                No hay productos en este almacén
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Paginación -->
            <div class="px-4 py-3 border-top">
                {{ $inventario->withQueryString()->links() }}
            </div>
        </div>
    </div>
</div>
@endsection