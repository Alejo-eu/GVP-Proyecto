@extends('layouts.app')

@section('content')
<div class="container-fluid px-4">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold">
                <i class="bi bi-eye me-2"></i>
                Detalles del Producto
            </h2>
            <p class="text-muted">Información completa del producto</p>
        </div>
        <div>
            <a href="{{ route('productos.edit', $producto) }}" class="btn btn-primary me-2">
                <i class="bi bi-pencil me-2"></i>
                Editar
            </a>
            <a href="{{ route('productos.index') }}" class="btn btn-outline-secondary">
                <i class="bi bi-arrow-left me-2"></i>
                Volver
            </a>
        </div>
    </div>

    <div class="row">
        <!-- Información del producto -->
        <div class="col-md-4">
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-body text-center p-4">
                    <div class="avatar-lg bg-light rounded-circle mx-auto mb-3 d-flex align-items-center justify-content-center" style="width: 100px; height: 100px;">
                        <i class="bi bi-box text-primary" style="font-size: 3rem;"></i>
                    </div>
                    <h4 class="fw-bold">{{ $producto->nombre }}</h4>
                    <p class="text-muted mb-2">Código: {{ $producto->codigo }}</p>
                    <span class="badge bg-{{ $producto->activo ? 'success' : 'secondary' }} p-2">
                        {{ $producto->activo ? 'Activo' : 'Inactivo' }}
                    </span>
                </div>
            </div>

            <div class="card border-0 shadow-sm">
                <div class="card-body p-4">
                    <h5 class="fw-bold mb-3">Precios</h5>
                    <div class="d-flex justify-content-between mb-2">
                        <span class="text-muted">Precio de compra:</span>
                        <span class="fw-bold">${{ number_format($producto->precio_compra, 2) }}</span>
                    </div>
                    <div class="d-flex justify-content-between mb-2">
                        <span class="text-muted">Precio de venta:</span>
                        <span class="fw-bold">${{ number_format($producto->precio_venta, 2) }}</span>
                    </div>
                    <hr>
                    <div class="d-flex justify-content-between">
                        <span class="text-muted">Margen:</span>
                        <span class="fw-bold text-success">
                            @php
                                $margen = (($producto->precio_venta - $producto->precio_compra) / $producto->precio_compra) * 100;
                            @endphp
                            {{ number_format($margen, 2) }}%
                        </span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Stock por almacenes -->
        <div class="col-md-8">
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-white border-0 py-3">
                    <h5 class="fw-bold mb-0">
                        <i class="bi bi-buildings me-2"></i>
                        Stock por Almacenes
                    </h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table">
                            <thead class="table-light">
                                <tr>
                                    <th>Almacén</th>
                                    <th>Cantidad</th>
                                    <th>Estado</th>
                                    <th>Última actualización</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($producto->inventarios as $inventario)
                                <tr>
                                    <td>
                                        <i class="bi bi-building me-2"></i>
                                        {{ $inventario->almacen->nombre }}
                                    </td>
                                    <td>
                                        <span class="fw-bold">{{ $inventario->cantidad }}</span>
                                    </td>
                                    <td>
                                        @if($inventario->cantidad <= $producto->stock_minimo)
                                            <span class="badge bg-danger">Stock bajo</span>
                                        @else
                                            <span class="badge bg-success">Stock normal</span>
                                        @endif
                                    </td>
                                    <td>{{ $inventario->updated_at->format('d/m/Y H:i') }}</td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="4" class="text-center text-muted">
                                        No hay stock en ningún almacén
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Descripción -->
            @if($producto->descripcion)
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-white border-0 py-3">
                    <h5 class="fw-bold mb-0">
                        <i class="bi bi-file-text me-2"></i>
                        Descripción
                    </h5>
                </div>
                <div class="card-body">
                    <p class="mb-0">{{ $producto->descripcion }}</p>
                </div>
            </div>
            @endif

            <!-- Últimos movimientos -->
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white border-0 py-3">
                    <h5 class="fw-bold mb-0">
                        <i class="bi bi-clock-history me-2"></i>
                        Últimos Movimientos
                    </h5>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th class="ps-4">Fecha</th>
                                    <th>Tipo</th>
                                    <th>Cantidad</th>
                                    <th>Origen/Destino</th>
                                    <th>Usuario</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($producto->movimientos as $movimiento)
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
                                    <td>{{ $movimiento->cantidad }}</td>
                                    <td>
                                        @if($movimiento->tipo == 'entrada')
                                            <i class="bi bi-arrow-right-circle text-success me-1"></i>
                                            {{ $movimiento->almacenDestino->nombre ?? 'N/A' }}
                                        @elseif($movimiento->tipo == 'salida')
                                            <i class="bi bi-arrow-left-circle text-danger me-1"></i>
                                            {{ $movimiento->almacenOrigen->nombre ?? 'N/A' }}
                                        @elseif($movimiento->tipo == 'traslado')
                                            <i class="bi bi-arrow-right-circle text-warning me-1"></i>
                                            {{ $movimiento->almacenOrigen->nombre ?? 'N/A' }} 
                                            <i class="bi bi-arrow-right mx-1"></i> 
                                            <i class="bi bi-arrow-left-circle text-success me-1"></i>
                                            {{ $movimiento->almacenDestino->nombre ?? 'N/A' }}
                                        @else
                                            Ajuste manual
                                        @endif
                                    </td>
                                    <td>{{ $movimiento->usuario->name ?? 'Sistema' }}</td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="text-center text-muted py-4">
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