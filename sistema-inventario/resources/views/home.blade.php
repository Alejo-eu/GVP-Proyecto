@extends('layouts.app')

@section('content')
    <div class="container-fluid px-4">
        <!-- Premium Header Banner -->
        <div class="card border-0 mb-5 overflow-hidden position-relative shadow-lg" style="border-radius: 24px; background: linear-gradient(135deg, #4F46E5 0%, #7C3AED 50%, #EC4899 100%);">
            
            <!-- Abstract background elements -->
            <div class="position-absolute top-0 start-0 w-100 h-100" style="background-image: radial-gradient(rgba(255, 255, 255, 0.15) 1px, transparent 1px); background-size: 20px 20px; pointer-events: none;"></div>
            
            <div class="position-absolute top-0 end-0 rounded-circle" style="width: 300px; height: 300px; background: radial-gradient(circle, rgba(255,255,255,0.2) 0%, rgba(255,255,255,0) 70%); transform: translate(30%, -30%); pointer-events: none;"></div>
            <div class="position-absolute bottom-0 start-50 rounded-circle" style="width: 400px; height: 400px; background: radial-gradient(circle, rgba(255,255,255,0.15) 0%, rgba(255,255,255,0) 70%); transform: translate(-50%, 50%); pointer-events: none;"></div>

            <div class="card-body p-4 p-lg-5 position-relative z-1">
                <div class="d-flex justify-content-between align-items-center">
                    <div class="text-white">
                        <div class="d-inline-flex align-items-center bg-white bg-opacity-25 rounded-pill px-3 py-2 mb-4 shadow-sm border border-white border-opacity-25" style="backdrop-filter: blur(10px);">
                            <span class="d-flex align-items-center justify-content-center bg-white text-primary rounded-circle me-2" style="width: 24px; height: 24px;">
                                <i class="bi bi-star-fill" style="font-size: 10px;"></i>
                            </span>
                            <span class="fw-semibold text-white" style="font-size: 0.85rem; letter-spacing: 0.05em; text-transform: uppercase;">Sistema de Inventario</span>
                        </div>
                        
                        <h2 class="fw-bolder mb-3 display-5 text-white" style="letter-spacing: -0.03em; text-shadow: 0 2px 10px rgba(0,0,0,0.1);">
                            ¡Hola, {{ Auth::user()->name }}! 👋
                        </h2>
                        
                        <p class="mb-0 fs-5" style="color: rgba(255,255,255,0.9); max-width: 500px; line-height: 1.6;">
                            Aquí tienes el resumen en tiempo real de tus recursos educativos, aulas y movimientos recientes.
                        </p>
                    </div>
                    
                    <div class="d-none d-md-block opacity-25" style="transform: rotate(5deg);">
                        <i class="bi bi-mortarboard-fill" style="font-size: 8rem; color: white; filter: drop-shadow(0 10px 20px rgba(0,0,0,0.2));"></i>
                    </div>
                </div>
            </div>
            
            <style>
                .hover-glass:hover {
                    background-color: rgba(255,255,255,0.3) !important;
                    transform: translateY(-2px);
                }
                .hover-scale:hover {
                    transform: scale(1.05) translateY(-2px);
                }
                .hover-float:hover {
                    transform: rotate(0deg) scale(1.05) !important;
                }
                .hover-float-reverse:hover {
                    transform: rotate(0deg) scale(1.1) !important;
                }
                .tracking-wide {
                    letter-spacing: 0.05em;
                }
            </style>
        </div>

        <!-- Stats Cards -->
        <div class="row g-4 mb-4">
            <div class="col-md-3">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <span class="text-muted text-uppercase small">Materiales</span>
                                <h3 class="fw-bold mt-2">{{ $totalProductos }}</h3>
                            </div>
                            <div class="bg-primary bg-opacity-10 p-3 rounded-circle">
                                <i class="bi bi-journals text-primary fs-4"></i>
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
                                <span class="text-muted text-uppercase small">Aulas/ambientes</span>
                                <h3 class="fw-bold mt-2">{{ $totalAlmacenes }}</h3>
                            </div>
                            <div class="bg-success bg-opacity-10 p-3 rounded-circle">
                                <i class="bi bi-building text-success fs-4"></i>
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
                                <span class="text-muted text-uppercase small">Registros Hoy</span>
                                <h3 class="fw-bold mt-2">{{ $movimientosHoy }}</h3>
                            </div>
                            <div class="bg-info bg-opacity-10 p-3 rounded-circle">
                                <i class="bi bi-clipboard-data text-info fs-4"></i>
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
                                <span class="text-muted text-uppercase small">Material Faltante</span>
                                <h3 class="fw-bold mt-2">{{ $stockBajo->count() }}</h3>
                            </div>
                            <div class="bg-warning bg-opacity-10 p-3 rounded-circle">
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
                <div class="card">
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
                                            <th>Material</th>
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
                                                        <span
                                                            class="badge bg-success bg-opacity-10 text-success border border-success border-opacity-25">
                                                            <i class="bi bi-box-arrow-in-right me-1"></i>
                                                            Ingreso
                                                        </span>
                                                    @elseif($movimiento->tipo == 'salida')
                                                        <span
                                                            class="badge bg-danger bg-opacity-10 text-danger border border-danger border-opacity-25">
                                                            <i class="bi bi-box-arrow-right me-1"></i>
                                                            Salida
                                                        </span>
                                                    @else
                                                        <span
                                                            class="badge bg-warning bg-opacity-10 text-warning border border-warning border-opacity-25">
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
                <div class="card">
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
                                            <div class="progress-bar bg-danger" style="width: {{ min($porcentaje, 100) }}%"></div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            <div class="text-center mt-3">
                                <a href="{{ route('productos.index') }}"
                                    class="btn btn-sm btn-outline-primary rounded-pill px-4">
                                    Ver todos los materiales
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
                <div class="card mt-4">
                    <div class="card-header bg-white border-0 py-3">
                        <h5 class="fw-bold mb-0">
                            <i class="bi bi-lightning-charge me-2 text-primary"></i>
                            Acciones Rápidas
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="d-grid gap-3">
                            <a href="{{ route('movimientos.entrada') }}" class="btn btn-success p-2">
                                <i class="bi bi-box-arrow-in-right me-2"></i>
                                Registrar Ingreso
                            </a>
                            <a href="{{ route('movimientos.salida') }}" class="btn btn-danger p-2">
                                <i class="bi bi-box-arrow-right me-2"></i>
                                Registrar Salida
                            </a>
                            <a href="{{ route('movimientos.traslado') }}" class="btn btn-warning text-dark p-2">
                                <i class="bi bi-arrow-left-right me-2"></i>
                                Registrar Traslado
                            </a>
                            <a href="{{ route('productos.create') }}" class="btn btn-primary p-2">
                                <i class="bi bi-plus-circle me-2"></i>
                                Nuevo Material
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection