@extends('layouts.app')

@section('content')
    <div class="container-fluid px-4">
        <!-- Header -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h2 class="fw-bold">
                    <i class="bi bi-building me-2"></i>
                    Aulas y Ambientes
                </h2>
                <p class="text-muted">Gestiona las aulas, Ambientes y espacios físicos</p>
            </div>
            <a href="{{ route('almacenes.create') }}" class="btn btn-primary">
                <i class="bi bi-plus-circle me-2"></i>
                Nueva Aula/Ambiente
            </a>
        </div>

        <!-- Filtros y búsqueda -->
        <div class="card mb-4">
            <div class="card-body">
                <form method="GET" action="{{ route('almacenes.index') }}" class="row g-3">
                    <div class="col-md-6">
                        <div class="input-group">
                            <span class="input-group-text bg-white border-end-0">
                                <i class="bi bi-search"></i>
                            </span>
                            <input type="text" class="form-control border-start-0 ps-0" name="search"
                                placeholder="Buscar por nombre, ubicación o descripción..." value="{{ request('search') }}">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <select name="estado" class="form-select">
                            <option value="">Todos los estados</option>
                            <option value="1" {{ request('estado') === '1' ? 'selected' : '' }}>Activos</option>
                            <option value="0" {{ request('estado') === '0' ? 'selected' : '' }}>Inactivos</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <button type="submit" class="btn btn-primary w-100">
                            <i class="bi bi-funnel me-2"></i>
                            Filtrar
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Grid de almacenes -->
        @if($almacenes->count() > 0)
            <div class="row g-4">
                @foreach($almacenes as $almacen)
                    <div class="col-md-6 col-xl-4">
                        <div class="card h-100">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-start mb-3">
                                    <div class="d-flex align-items-center">
                                        <div class="avatar-lg bg-light bg-opacity-50 rounded p-3 me-3">
                                            <i class="bi bi-building fs-2 text-primary"></i>
                                        </div>
                                        <div>
                                            <h5 class="fw-bold mb-1">{{ $almacen->nombre }}</h5>
                                            @if($almacen->ubicacion)
                                                <small class="text-muted">
                                                    <i class="bi bi-geo-alt me-1"></i>
                                                    {{ $almacen->ubicacion }}
                                                </small>
                                            @endif
                                        </div>
                                    </div>
                                    @if($almacen->activo)
                                        <span class="badge bg-success">Activo</span>
                                    @else
                                        <span class="badge bg-secondary">Inactivo</span>
                                    @endif
                                </div>

                                @if($almacen->descripcion)
                                    <p class="text-muted small mb-3">
                                        {{ Str::limit($almacen->descripcion, 100) }}
                                    </p>
                                @endif

                                <!-- Estadísticas rápidas -->
                                <div class="row g-2 mb-3">
                                    <div class="col-6">
                                        <div class="bg-light bg-opacity-50 rounded p-2 text-center">
                                            <small class="text-muted d-block">Materiales</small>
                                            <span class="fw-bold">{{ $almacen->inventarios_count ?? 0 }}</span>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="bg-light bg-opacity-50 rounded p-2 text-center">
                                            <small class="text-muted d-block">Total Items</small>
                                            <span class="fw-bold">{{ $almacen->total_productos ?? 0 }}</span>
                                        </div>
                                    </div>
                                </div>

                                <!-- Acciones -->
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <a href="{{ route('almacenes.show', $almacen) }}" class="btn btn-sm btn-outline-info me-1"
                                            title="Ver detalles">
                                            <i class="bi bi-eye"></i>
                                        </a>
                                        <a href="{{ route('almacenes.edit', $almacen) }}"
                                            class="btn btn-sm btn-outline-primary me-1" title="Editar">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        <a href="{{ route('almacenes.inventario', $almacen) }}"
                                            class="btn btn-sm btn-outline-success me-1" title="Ver inventario">
                                            <i class="bi bi-box"></i>
                                        </a>
                                    </div>
                                    <div>
                                        @if($almacen->activo)
                                            <form action="{{ route('almacenes.toggle-status', $almacen) }}" method="POST"
                                                class="d-inline"
                                                onsubmit="return confirm('¿Estás seguro de desactivar esta aula o bodega?')">
                                                @csrf
                                                @method('PUT')
                                                <button type="submit" class="btn btn-sm btn-outline-warning" title="Desactivar">
                                                    <i class="bi bi-pause-circle"></i>
                                                </button>
                                            </form>
                                        @else
                                            <form action="{{ route('almacenes.toggle-status', $almacen) }}" method="POST"
                                                class="d-inline"
                                                onsubmit="return confirm('¿Estás seguro de activar esta aula o bodega?')">
                                                @csrf
                                                @method('PUT')
                                                <button type="submit" class="btn btn-sm btn-outline-success" title="Activar">
                                                    <i class="bi bi-play-circle"></i>
                                                </button>
                                            </form>
                                        @endif
                                        <form action="{{ route('almacenes.destroy', $almacen) }}" method="POST" class="d-inline"
                                            onsubmit="return confirm('¿Estás seguro de eliminar esta aula o bodega?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger" title="Eliminar">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Paginación -->
            <div class="mt-4">
                {{ $almacenes->withQueryString()->links() }}
            </div>
        @else
            <div class="card">
                <div class="card-body text-center py-5">
                    <i class="bi bi-building fs-1 text-muted"></i>
                    <h5 class="mt-3">No hay aulas o Ambientes</h5>
                    <p class="text-muted">Comienza agregando tu primer espacio físico</p>
                    <a href="{{ route('almacenes.create') }}" class="btn btn-primary">
                        <i class="bi bi-plus-circle me-2"></i>
                        Nueva Aula/Ambiente
                    </a>
                </div>
            </div>
        @endif
    </div>
@endsection