@extends('layouts.app')

@section('content')
<style>
    @import url('https://fonts.googleapis.com/css2?family=Manrope:wght@600;700&family=Source+Sans+3:wght@400;600&display=swap');

    .dashboard-wrapper {
        font-family: 'Source Sans 3', sans-serif;
    }

    .dashboard-wrapper h2, .dashboard-wrapper h3, .dashboard-wrapper h5 {
        font-family: 'Manrope', sans-serif;
        color: var(--text-main);
    }

    .dashboard-wrapper .text-muted {
        color: var(--text-muted) !important;
    }

    .custom-card {
        background-color: var(--surface);
        border: 1px solid rgba(229, 231, 235, 0.6);
        border-radius: 24px;
        box-shadow: var(--shadow-sm);
        transition: var(--transition);
        padding: 8px;
    }

    .custom-card:hover {
        transform: translateY(-4px);
        box-shadow: var(--shadow-hover);
        border-color: var(--border-color);
    }

    .custom-icon-box {
        width: 56px;
        height: 56px;
        border-radius: 16px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 24px;
    }

    .icon-primary { background-color: var(--primary-light); color: var(--primary); }
    .icon-success { background-color: var(--secondary-light); color: var(--secondary); }
    .icon-info { background-color: #E0F2FE; color: #0284C7; }
    .icon-warning { background-color: #FEF3C7; color: #D97706; }

    .custom-table-container {
        border-radius: 16px;
        overflow: hidden;
    }

    .custom-table {
        margin-bottom: 0;
    }

    .custom-table th {
        background-color: #F9FAFB;
        color: var(--text-muted);
        font-family: 'Source Sans 3', sans-serif;
        font-weight: 600;
        text-transform: uppercase;
        font-size: 12px;
        letter-spacing: 0.05em;
        padding: 16px 24px;
        border-bottom: 1px solid var(--border-color);
    }

    .custom-table td {
        padding: 16px 24px;
        vertical-align: middle;
        border-bottom: 1px solid rgba(229, 231, 235, 0.5);
        color: var(--text-main);
    }

    .custom-table tbody tr:last-child td {
        border-bottom: none;
    }

    .custom-badge {
        padding: 6px 12px;
        border-radius: 999px;
        font-weight: 600;
        font-size: 12px;
    }

    .custom-badge.entrada { background-color: var(--secondary-light); color: var(--secondary); }
    .custom-badge.salida { background-color: #FEE2E2; color: #DC2626; }
    .custom-badge.traslado { background-color: #FEF3C7; color: #D97706; }

    .custom-list-item {
        border: none;
        border-bottom: 1px solid rgba(229, 231, 235, 0.5);
        padding: 16px 24px;
        background-color: transparent;
    }

    .custom-list-item:last-child {
        border-bottom: none;
    }

    .badge-stock {
        background-color: #FEE2E2;
        color: #DC2626;
        padding: 6px 12px;
        border-radius: 999px;
        font-weight: 600;
        font-size: 14px;
    }
</style>

<div class="container-fluid px-4 dashboard-wrapper">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold">Panel Principal</h2>
            <p class="text-muted">Bienvenido de nuevo, {{ Auth::user()->name }}</p>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="row g-4 mb-4">
        <div class="col-md-3">
            <div class="card custom-card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <span class="text-muted text-uppercase small fw-bold">Productos</span>
                            <h3 class="fw-bold mt-2 mb-0">{{ $totalProductos }}</h3>
                        </div>
                        <div class="custom-icon-box icon-primary">
                            <i class="bi bi-box"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-md-3">
            <div class="card custom-card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <span class="text-muted text-uppercase small fw-bold">Almacenes</span>
                            <h3 class="fw-bold mt-2 mb-0">{{ $totalAlmacenes }}</h3>
                        </div>
                        <div class="custom-icon-box icon-success">
                            <i class="bi bi-buildings"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-md-3">
            <div class="card custom-card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <span class="text-muted text-uppercase small fw-bold">Movimientos Hoy</span>
                            <h3 class="fw-bold mt-2 mb-0">{{ $movimientosHoy }}</h3>
                        </div>
                        <div class="custom-icon-box icon-info">
                            <i class="bi bi-arrow-left-right"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-md-3">
            <div class="card custom-card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <span class="text-muted text-uppercase small fw-bold">Stock Bajo</span>
                            <h3 class="fw-bold mt-2 mb-0">{{ $stockBajo->count() }}</h3>
                        </div>
                        <div class="custom-icon-box icon-warning">
                            <i class="bi bi-exclamation-triangle"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Charts Row -->
    <div class="row g-4 mb-4">
        <div class="col-md-8">
            <div class="card custom-card">
                <div class="card-header bg-transparent border-0 pt-4 pb-2 px-4">
                    <h5 class="fw-bold mb-0">Movimientos Recientes</h5>
                </div>
                <div class="card-body px-0 pb-0">
                    <div class="table-responsive custom-table-container">
                        <table class="table custom-table">
                            <thead>
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
                                            <span class="custom-badge entrada">Entrada</span>
                                        @elseif($movimiento->tipo == 'salida')
                                            <span class="custom-badge salida">Salida</span>
                                        @else
                                            <span class="custom-badge traslado">Traslado</span>
                                        @endif
                                    </td>
                                    <td class="fw-semibold">{{ $movimiento->producto->nombre }}</td>
                                    <td>{{ $movimiento->cantidad }}</td>
                                    <td class="text-muted">
                                        @if($movimiento->tipo == 'entrada')
                                            {{ $movimiento->almacenDestino->nombre ?? 'N/A' }}
                                        @elseif($movimiento->tipo == 'salida')
                                            {{ $movimiento->almacenOrigen->nombre ?? 'N/A' }}
                                        @else
                                            {{ $movimiento->almacenOrigen->nombre ?? 'N/A' }} 
                                            <i class="bi bi-arrow-right mx-1"></i> 
                                            {{ $movimiento->almacenDestino->nombre ?? 'N/A' }}
                                        @endif
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="text-center text-muted py-5">
                                        <i class="bi bi-inbox fs-2 d-block mb-2 text-black-50"></i>
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
            <div class="card custom-card">
                <div class="card-header bg-transparent border-0 pt-4 pb-2 px-4">
                    <h5 class="fw-bold mb-0">Alertas de Stock</h5>
                </div>
                <div class="card-body px-0">
                    <div class="list-group list-group-flush">
                        @forelse($stockBajo as $item)
                        <div class="list-group-item custom-list-item">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="mb-1 fw-semibold">{{ $item->producto->nombre }}</h6>
                                    <small class="text-muted">
                                        <i class="bi bi-geo-alt me-1"></i> {{ $item->almacen->nombre }}
                                    </small>
                                </div>
                                <div class="text-end">
                                    <span class="badge-stock">
                                        {{ $item->cantidad }} / {{ $item->producto->stock_minimo }}
                                    </span>
                                </div>
                            </div>
                        </div>
                        @empty
                        <div class="text-center py-5">
                            <i class="bi bi-check-circle-fill" style="color: rgba(56, 100, 113, 0.5); font-size: 3rem;"></i>
                            <p class="text-muted mt-3 mb-0">Todo en orden, stock suficiente</p>
                        </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
