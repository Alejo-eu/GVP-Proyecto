@extends('layouts.app')

@section('content')
<div class="container-fluid px-4">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold">
                <i class="bi bi-clock-history me-2"></i>
                Movimientos: {{ $almacen->nombre }}
            </h2>
            <p class="text-muted">Historial completo de movimientos de este almacén</p>
        </div>
        <a href="{{ route('almacenes.show', $almacen) }}" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left me-2"></i>
            Volver al Almacén
        </a>
    </div>

    <!-- Tabla de movimientos -->
    <div class="card">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="table-light">
                        <tr>
                            <th class="ps-4">Fecha</th>
                            <th>Tipo</th>
                            <th>Producto</th>
                            <th>Cantidad</th>
                            <th>Origen/Destino</th>
                            <th>Observaciones</th>
                            <th>Usuario</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($movimientos as $movimiento)
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
                            <td>
                                <span class="fw-bold">{{ $movimiento->producto->nombre }}</span>
                                <br>
                                <small class="text-muted">Código: {{ $movimiento->producto->codigo }}</small>
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
                            <td>{{ $movimiento->observaciones ?? '-' }}</td>
                            <td>{{ $movimiento->usuario->name ?? 'Sistema' }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center text-muted py-4">
                                No hay movimientos registrados
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Paginación -->
            <div class="px-4 py-3 border-top">
                {{ $movimientos->links() }}
            </div>
        </div>
    </div>
</div>
@endsection
