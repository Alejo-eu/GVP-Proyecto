@extends('layouts.app')

@section('content')
<div class="container-fluid px-4">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold">
                <i class="bi bi-clock-history me-2"></i>
                Historial de Movimientos
            </h2>
            <p class="text-muted">Registro completo de todas las operaciones</p>
        </div>
        <div>
            <a href="{{ route('movimientos.entrada') }}" class="btn btn-success me-2">
                <i class="bi bi-box-arrow-in-down me-2"></i>
                Nueva Entrada
            </a>
            <a href="{{ route('movimientos.salida') }}" class="btn btn-danger me-2">
                <i class="bi bi-box-arrow-up me-2"></i>
                Nueva Salida
            </a>
            <a href="{{ route('movimientos.traslado') }}" class="btn btn-warning text-dark">
                <i class="bi bi-arrow-left-right me-2"></i>
                Nuevo Traslado
            </a>
        </div>
    </div>

    <!-- Filtros -->
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body">
            <form method="GET" action="{{ route('movimientos.historial') }}" class="row g-3">
                <div class="col-md-2">
                    <select name="tipo" class="form-select">
                        <option value="">Todos los tipos</option>
                        <option value="entrada" {{ request('tipo') == 'entrada' ? 'selected' : '' }}>Entrada</option>
                        <option value="salida" {{ request('tipo') == 'salida' ? 'selected' : '' }}>Salida</option>
                        <option value="traslado" {{ request('tipo') == 'traslado' ? 'selected' : '' }}>Traslado</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <select name="producto_id" class="form-select select2">
                        <option value="">Todos los productos</option>
                        @foreach($productos as $producto)
                            <option value="{{ $producto->id }}" {{ request('producto_id') == $producto->id ? 'selected' : '' }}>
                                {{ $producto->nombre }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <select name="almacen_id" class="form-select">
                        <option value="">Todos los almacenes</option>
                        @foreach($almacenes as $almacen)
                            <option value="{{ $almacen->id }}" {{ request('almacen_id') == $almacen->id ? 'selected' : '' }}>
                                {{ $almacen->nombre }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">
                    <input type="date" name="fecha_desde" class="form-control" placeholder="Fecha desde" value="{{ request('fecha_desde') }}">
                </div>
                <div class="col-md-2">
                    <input type="date" name="fecha_hasta" class="form-control" placeholder="Fecha hasta" value="{{ request('fecha_hasta') }}">
                </div>
                <div class="col-md-12">
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-funnel me-2"></i>
                        Filtrar
                    </button>
                    <a href="{{ route('movimientos.historial') }}" class="btn btn-outline-secondary">
                        <i class="bi bi-arrow-counterclockwise me-2"></i>
                        Limpiar
                    </a>
                </div>
            </form>
        </div>
    </div>

    <!-- Tabla de movimientos -->
    <div class="card border-0 shadow-sm">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="table-light">
                        <tr>
                            <th class="ps-4">Fecha</th>
                            <th>Tipo</th>
                            <th>Producto</th>
                            <th>Cantidad</th>
                            <th>Origen</th>
                            <th>Destino</th>
                            <th>Referencia</th>
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
                                @else
                                    <span class="badge bg-warning text-dark">Traslado</span>
                                @endif
                            </td>
                            <td>
                                <div>
                                    <strong>{{ $movimiento->producto->nombre }}</strong>
                                    <br>
                                    <small class="text-muted">Cód: {{ $movimiento->producto->codigo }}</small>
                                </div>
                            </td>
                            <td class="fw-bold">{{ $movimiento->cantidad }}</td>
                            <td>{{ $movimiento->almacenOrigen->nombre ?? '-' }}</td>
                            <td>{{ $movimiento->almacenDestino->nombre ?? '-' }}</td>
                            <td>{{ $movimiento->referencia ?? '-' }}</td>
                            <td>{{ $movimiento->usuario->name ?? 'Sistema' }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="8" class="text-center text-muted py-4">
                                No hay movimientos registrados
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Paginación -->
            <div class="px-4 py-3 border-top">
                {{ $movimientos->withQueryString()->links() }}
            </div>
        </div>
    </div>
</div>
@endsection