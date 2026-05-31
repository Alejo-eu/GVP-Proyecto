@extends('layouts.app')

@section('content')
<div class="container-fluid px-4">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold">
                <i class="bi bi-building me-2"></i>
                {{ $almacen->nombre }}
            </h2>
            <p class="text-muted">
                <i class="bi bi-geo-alt me-1"></i>
                {{ $almacen->ubicacion ?? 'Ubicación no especificada' }}
            </p>
        </div>
        <div>
            <a href="{{ route('almacenes.edit', $almacen) }}" class="btn btn-primary me-2">
                <i class="bi bi-pencil me-2"></i>
                Editar
            </a>
            <a href="{{ route('almacenes.index') }}" class="btn btn-outline-secondary">
                <i class="bi bi-arrow-left me-2"></i>
                Volver
            </a>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="row g-4 mb-4">
        <div class="col-md-3">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <span class="text-muted text-uppercase small">Total Productos</span>
                            <h3 class="fw-bold mt-2">{{ $totalProductos }}</h3>
                        </div>
                        <div class="bg-primary bg-opacity-10 p-3 rounded">
                            <i class="bi bi-box text-primary fs-4"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-md-3">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <span class="text-muted text-uppercase small">Productos Únicos</span>
                            <h3 class="fw-bold mt-2">{{ $almacen->inventarios->count() }}</h3>
                        </div>
                        <div class="bg-success bg-opacity-10 p-3 rounded">
                            <i class="bi bi-grid text-success fs-4"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-md-3">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <span class="text-muted text-uppercase small">Valor Inventario</span>
                            <h3 class="fw-bold mt-2">${{ number_format($valorInventario, 2) }}</h3>
                        </div>
                        <div class="bg-info bg-opacity-10 p-3 rounded">
                            <i class="bi bi-cash-stack text-info fs-4"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-md-3">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <span class="text-muted text-uppercase small">Stock Bajo</span>
                            <h3 class="fw-bold mt-2">{{ $stockBajo->count() }}</h3>
                        </div>
                        <div class="bg-warning bg-opacity-10 p-3 rounded">
                            <i class="bi bi-exclamation-triangle text-warning fs-4"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Inventario -->
        <div class="col-md-7">
            <div class="card mb-4">
                <div class="card-header bg-white border-0 py-3 d-flex justify-content-between align-items-center">
                    <h5 class="fw-bold mb-0">
                        <i class="bi bi-box me-2"></i>
                        Inventario Actual
                    </h5>
                    <div>
                        <a href="{{ route('almacenes.inventario', $almacen) }}" class="btn btn-sm btn-primary">
                            Ver todo
                        </a>
                    </div>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th class="ps-4">Producto</th>
                                    <th>Código</th>
                                    <th class="text-center">Cantidad</th>
                                    <th class="text-end pe-4">Valor</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($almacen->inventarios->take(5) as $inventario)
                                <tr>
                                    <td class="ps-4">
                                        <div>
                                            <span class="fw-bold">{{ $inventario->producto->nombre }}</span>
                                            @if($inventario->cantidad <= $inventario->producto->stock_minimo)
                                                <span class="badge bg-danger ms-2">Stock bajo</span>
                                            @endif
                                        </div>
                                    </td>
                                    <td>{{ $inventario->producto->codigo }}</td>
                                    <td class="text-center">{{ $inventario->cantidad }}</td>
                                    <td class="text-end pe-4">
                                        ${{ number_format($inventario->cantidad * $inventario->producto->precio_compra, 2) }}
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="4" class="text-center text-muted py-4">
                                        No hay productos en este almacén
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Información y acciones -->
        <div class="col-md-5">
            <!-- Descripción -->
            <div class="card mb-4">
                <div class="card-header bg-white border-0 py-3">
                    <h5 class="fw-bold mb-0">
                        <i class="bi bi-file-text me-2"></i>
                        Descripción
                    </h5>
                </div>
                <div class="card-body">
                    @if($almacen->descripcion)
                        <p class="mb-0">{{ $almacen->descripcion }}</p>
                    @else
                        <p class="text-muted mb-0">No hay descripción disponible</p>
                    @endif
                </div>
            </div>

            <!-- Stock Bajo -->
            @if($stockBajo->count() > 0)
            <div class="card mb-4">
                <div class="card-header bg-white border-0 py-3">
                    <h5 class="fw-bold mb-0 text-warning">
                        <i class="bi bi-exclamation-triangle me-2"></i>
                        Productos con Stock Bajo
                    </h5>
                </div>
                <div class="card-body p-0">
                    <div class="list-group list-group-flush">
                        @foreach($stockBajo as $item)
                        <div class="list-group-item">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="mb-1">{{ $item->producto->nombre }}</h6>
                                    <small class="text-muted">Código: {{ $item->producto->codigo }}</small>
                                </div>
                                <div class="text-end">
                                    <span class="badge bg-danger">
                                        {{ $item->cantidad }} / {{ $item->producto->stock_minimo }}
                                    </span>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
            @endif

            <!-- Acciones rápidas -->
            <div class="card">
                <div class="card-header bg-white border-0 py-3">
                    <h5 class="fw-bold mb-0">
                        <i class="bi bi-lightning-charge me-2"></i>
                        Acciones Rápidas
                    </h5>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <a href="{{ route('movimientos.entrada') }}?almacen={{ $almacen->id }}" class="btn btn-success">
                            <i class="bi bi-box-arrow-in-down me-2"></i>
                            Registrar Entrada
                        </a>
                        <a href="{{ route('movimientos.salida') }}?almacen={{ $almacen->id }}" class="btn btn-danger">
                            <i class="bi bi-box-arrow-up me-2"></i>
                            Registrar Salida
                        </a>
                        <a href="{{ route('movimientos.traslado') }}?origen={{ $almacen->id }}" class="btn btn-warning text-dark">
                            <i class="bi bi-arrow-left-right me-2"></i>
                            Realizar Traslado
                        </a>
                        <a href="{{ route('almacenes.exportar-inventario', $almacen) }}" class="btn btn-info text-white">
                            <i class="bi bi-file-pdf me-2"></i>
                            Exportar Inventario
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Últimos movimientos -->
    <div class="row mt-4">
        <div class="col-12">
            <div class="card">
                <div class="card-header bg-white border-0 py-3 d-flex justify-content-between align-items-center">
                    <h5 class="fw-bold mb-0">
                        <i class="bi bi-clock-history me-2"></i>
                        Últimos Movimientos
                    </h5>
                    <a href="{{ route('almacenes.movimientos', $almacen) }}" class="btn btn-sm btn-primary">
                        Ver todos
                    </a>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th class="ps-4">Fecha</th>
                                    <th>Tipo</th>
                                    <th>Producto</th>
                                    <th>Cantidad</th>
                                    <th>Detalle</th>
                                    <th>Usuario</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($ultimosMovimientos as $movimiento)
                                <tr>
                                    <td class="ps-4">{{ $movimiento->created_at->format('d/m/Y H:i') }}</td>
                                    <td>
                                        @if($movimiento->tipo == 'entrada')
                                            <span class="badge bg-success">Entrada</span>
                                        @elseif($movimiento->tipo == 'salida')
                                            <span class="badge bg-danger">Salida</span>
                                        @elseif($movimiento->tipo == 'traslado')
                                            <span class="badge bg-warning text-dark">Traslado</span>
                                        @else
                                            <span class="badge bg-info">Ajuste</span>
                                        @endif
                                    </td>
                                    <td>{{ $movimiento->producto->nombre }}</td>
                                    <td>{{ $movimiento->cantidad }}</td>
                                    <td>
                                        @if($movimiento->tipo == 'entrada')
                                            <i class="bi bi-arrow-right-circle text-success me-1"></i>
                                            Entrada a {{ $movimiento->almacenDestino->nombre ?? 'N/A' }}
                                        @elseif($movimiento->tipo == 'salida')
                                            <i class="bi bi-arrow-left-circle text-danger me-1"></i>
                                            Salida de {{ $movimiento->almacenOrigen->nombre ?? 'N/A' }}
                                        @elseif($movimiento->tipo == 'traslado')
                                            <i class="bi bi-arrow-right-circle text-warning me-1"></i>
                                            Desde {{ $movimiento->almacenOrigen->nombre ?? 'N/A' }}
                                            <i class="bi bi-arrow-right mx-1"></i>
                                            <i class="bi bi-arrow-left-circle text-success me-1"></i>
                                            Hacia {{ $movimiento->almacenDestino->nombre ?? 'N/A' }}
                                        @else
                                            Ajuste manual
                                        @endif
                                    </td>
                                    <td>{{ $movimiento->usuario->name ?? 'Sistema' }}</td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="6" class="text-center text-muted py-4">
                                        No hay movimientos registrados
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
