@extends('layouts.app')

@section('content')
<div class="container-fluid px-4">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold">Dashboard</h2>
            <p class="text-muted">Bienvenido de nuevo, {{ Auth::user()->name }}</p>
        </div>
        <div>
            <span class="badge bg-primary p-2">
                <i class="bi bi-calendar me-1"></i>
                {{ now()->format('d/m/Y') }}
            </span>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="row g-4 mb-4">
        <div class="col-md-3">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <span class="text-muted text-uppercase small">Productos</span>
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
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <span class="text-muted text-uppercase small">Almacenes</span>
                            <h3 class="fw-bold mt-2">{{ $totalAlmacenes }}</h3>
                        </div>
                        <div class="bg-success bg-opacity-10 p-3 rounded">
                            <i class="bi bi-buildings text-success fs-4"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-md-3">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <span class="text-muted text-uppercase small">Movimientos Hoy</span>
                            <h3 class="fw-bold mt-2">{{ $movimientosHoy }}</h3>
                        </div>
                        <div class="bg-info bg-opacity-10 p-3 rounded">
                            <i class="bi bi-arrow-left-right text-info fs-4"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-md-3">
            <div class="card border-0 shadow-sm">
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

    <!-- Charts Row -->
    <div class="row g-4">
        <div class="col-md-8">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white border-0 py-3">
                    <h5 class="fw-bold mb-0">
                        <i class="bi bi-clock-history me-2 text-primary"></i>
                        Movimientos Recientes
                    </h5>
                </div>
                <div class="card-body">
                    @if($ultimosMovimientos->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead class="table-light">
                                    <tr>
                                        <th>Fecha</th>
                                        <th>Tipo</th>
                                        <th>Producto</th>
                                        <th>Cantidad</th>
                                        <th>Origen/Destino</th>
                                        <th>Usuario</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($ultimosMovimientos as $movimiento)
                                    <tr>
                                        <td>{{ $movimiento->created_at->format('d/m/Y H:i') }}</td>
                                        <td>
                                            @if($movimiento->tipo == 'entrada')
                                                <span class="badge bg-success">
                                                    <i class="bi bi-box-arrow-in-down me-1"></i>
                                                    Entrada
                                                </span>
                                            @elseif($movimiento->tipo == 'salida')
                                                <span class="badge bg-danger">
                                                    <i class="bi bi-box-arrow-up me-1"></i>
                                                    Salida
                                                </span>
                                            @else
                                                <span class="badge bg-warning text-dark">
                                                    <i class="bi bi-arrow-left-right me-1"></i>
                                                    Traslado
                                                </span>
                                            @endif
                                        </td>
                                        <td>
                                            <strong>{{ $movimiento->producto->nombre }}</strong>
                                        </td>
                                        <td>
                                            <span class="fw-bold">{{ $movimiento->cantidad }}</span>
                                        </td>
                                        <td>
                                            @if($movimiento->tipo == 'entrada')
                                                <i class="bi bi-arrow-right-circle text-success me-1"></i>
                                                {{ $movimiento->almacenDestino->nombre ?? 'N/A' }}
                                            @elseif($movimiento->tipo == 'salida')
                                                <i class="bi bi-arrow-left-circle text-danger me-1"></i>
                                                {{ $movimiento->almacenOrigen->nombre ?? 'N/A' }}
                                            @else
                                                <i class="bi bi-arrow-right-circle text-warning me-1"></i>
                                                {{ $movimiento->almacenOrigen->nombre ?? 'N/A' }} 
                                                <i class="bi bi-arrow-right mx-1"></i> 
                                                <i class="bi bi-arrow-left-circle text-success me-1"></i>
                                                {{ $movimiento->almacenDestino->nombre ?? 'N/A' }}
                                            @endif
                                        </td>
                                        <td>
                                            <i class="bi bi-person-circle me-1"></i>
                                            {{ $movimiento->usuario->name ?? 'Sistema' }}
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-5">
                            <i class="bi bi-inbox fs-1 text-muted"></i>
                            <p class="text-muted mt-3">No hay movimientos recientes</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
        
        <div class="col-md-4">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white border-0 py-3">
                    <h5 class="fw-bold mb-0">
                        <i class="bi bi-exclamation-triangle me-2 text-warning"></i>
                        Stock Bajo
                    </h5>
                </div>
                <div class="card-body">
                    @if($stockBajo->count() > 0)
                        <div class="list-group list-group-flush">
                            @foreach($stockBajo as $item)
                            <div class="list-group-item px-0">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <h6 class="mb-1">{{ $item->producto->nombre }}</h6>
                                        <small class="text-muted">
                                            <i class="bi bi-building me-1"></i>
                                            {{ $item->almacen->nombre }}
                                        </small>
                                    </div>
                                    <div class="text-end">
                                        <span class="badge bg-danger rounded-pill">
                                            {{ $item->cantidad }} / {{ $item->producto->stock_minimo }}
                                        </span>
                                    </div>
                                </div>
                                <div class="progress mt-2" style="height: 5px;">
                                    @php
                                        $porcentaje = ($item->cantidad / $item->producto->stock_minimo) * 100;
                                    @endphp
                                    <div class="progress-bar bg-danger" 
                                         style="width: {{ min($porcentaje, 100) }}%"></div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                        <div class="text-center mt-3">
                            <a href="{{ route('productos.index') }}" class="btn btn-sm btn-outline-primary">
                                Ver todos los productos
                            </a>
                        </div>
                    @else
                        <div class="text-center py-4">
                            <i class="bi bi-check-circle-fill text-success fs-1"></i>
                            <p class="text-muted mt-3">Todo en orden, stock suficiente</p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="card border-0 shadow-sm mt-4">
                <div class="card-header bg-white border-0 py-3">
                    <h5 class="fw-bold mb-0">
                        <i class="bi bi-lightning-charge me-2 text-primary"></i>
                        Acciones Rápidas
                    </h5>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <a href="{{ route('movimientos.entrada') }}" class="btn btn-success">
                            <i class="bi bi-box-arrow-in-down me-2"></i>
                            Nueva Entrada
                        </a>
                        <a href="{{ route('movimientos.salida') }}" class="btn btn-danger">
                            <i class="bi bi-box-arrow-up me-2"></i>
                            Nueva Salida
                        </a>
                        <a href="{{ route('movimientos.traslado') }}" class="btn btn-warning text-dark">
                            <i class="bi bi-arrow-left-right me-2"></i>
                            Nuevo Traslado
                        </a>
                        <a href="{{ route('productos.create') }}" class="btn btn-primary">
                            <i class="bi bi-plus-circle me-2"></i>
                            Nuevo Producto
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection