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
    <div class="row g-4 mb-4">
        <div class="col-md-8">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white border-0 py-3">
                    <h5 class="fw-bold mb-0">Movimientos Recientes</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead class="table-light">
                                <tr>
                                    <th>Fecha</th>
                                    <th>Tipo</th>
                                    <th>Producto</th>
                                    <th>Cantidad</th>
                                    <th>Origen/Destino</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($ultimosMovimientos as $movimiento)
                                <tr>
                                    <td>{{ $movimiento->created_at->format('d/m/Y H:i') }}</td>
                                    <td>
                                        @if($movimiento->tipo == 'entrada')
                                            <span class="badge bg-success">Entrada</span>
                                        @elseif($movimiento->tipo == 'salida')
                                            <span class="badge bg-danger">Salida</span>
                                        @else
                                            <span class="badge bg-warning text-dark">Traslado</span>
                                        @endif
                                    </td>
                                    <td>{{ $movimiento->producto->nombre }}</td>
                                    <td>{{ $movimiento->cantidad }}</td>
                                    <td>
                                        @if($movimiento->tipo == 'entrada')
                                            {{ $movimiento->almacenDestino->nombre ?? 'N/A' }}
                                        @elseif($movimiento->tipo == 'salida')
                                            {{ $movimiento->almacenOrigen->nombre ?? 'N/A' }}
                                        @else
                                            {{ $movimiento->almacenOrigen->nombre ?? 'N/A' }} 
                                            <i class="bi bi-arrow-right"></i> 
                                            {{ $movimiento->almacenDestino->nombre ?? 'N/A' }}
                                        @endif
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="text-center text-muted">
                                        No hay movimientos recientes
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-md-4">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white border-0 py-3">
                    <h5 class="fw-bold mb-0">Stock Bajo</h5>
                </div>
                <div class="card-body">
                    <div class="list-group list-group-flush">
                        @forelse($stockBajo as $item)
                        <div class="list-group-item px-0">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="mb-1">{{ $item->producto->nombre }}</h6>
                                    <small class="text-muted">
                                        Almacén: {{ $item->almacen->nombre }}
                                    </small>
                                </div>
                                <div class="text-end">
                                    <span class="badge bg-danger rounded-pill">
                                        {{ $item->cantidad }} / {{ $item->producto->stock_minimo }}
                                    </span>
                                </div>
                            </div>
                        </div>
                        @empty
                        <p class="text-muted text-center py-4">
                            <i class="bi bi-check-circle text-success fs-4 d-block mb-2"></i>
                            Todo en orden, stock suficiente
                        </p>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection