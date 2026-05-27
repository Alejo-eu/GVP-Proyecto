@extends('layouts.app')

@section('content')
<div class="container-fluid px-4">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold">
                <i class="bi bi-box me-2"></i>
                Productos
            </h2>
            <p class="text-muted">Gestiona tu catálogo de productos</p>
        </div>
        <a href="{{ route('productos.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-circle me-2"></i>
            Nuevo Producto
        </a>
    </div>

    <!-- Filtros y búsqueda -->
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body">
            <form method="GET" action="{{ route('productos.index') }}" class="row g-3">
                <div class="col-md-5">
                    <div class="input-group">
                        <span class="input-group-text bg-white border-end-0">
                            <i class="bi bi-search"></i>
                        </span>
                        <input type="text" 
                               class="form-control border-start-0 ps-0" 
                               name="search" 
                               placeholder="Buscar por código, nombre o descripción..."
                               value="{{ request('search') }}">
                    </div>
                </div>
                <div class="col-md-3">
                    <select name="estado" class="form-select">
                        <option value="">Todos los estados</option>
                        <option value="1" {{ request('estado') === '1' ? 'selected' : '' }}>Activos</option>
                        <option value="0" {{ request('estado') === '0' ? 'selected' : '' }}>Inactivos</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="bi bi-funnel me-2"></i>
                        Filtrar
                    </button>
                </div>
                <div class="col-md-2">
                    <a href="{{ route('productos.index') }}" class="btn btn-outline-secondary w-100">
                        <i class="bi bi-arrow-counterclockwise me-2"></i>
                        Limpiar
                    </a>
                </div>
            </form>
        </div>
    </div>

    <!-- Tabla de productos -->
    <div class="card border-0 shadow-sm">
        <div class="card-body p-0">
            @if($productos->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="bg-light">
                            <tr>
                                <th class="ps-4">Código</th>
                                <th>Producto</th>
                                <th>Precios</th>
                                <th>Stock Total</th>
                                <th>Stock Mínimo</th>
                                <th>Estado</th>
                                <th class="text-end pe-4">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($productos as $producto)
                            <tr>
                                <td class="ps-4">
                                    <span class="badge bg-secondary bg-opacity-10 text-secondary px-3 py-2">
                                        {{ $producto->codigo }}
                                    </span>
                                </td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="avatar-sm bg-light rounded p-2 me-3">
                                            <i class="bi bi-box text-primary"></i>
                                        </div>
                                        <div>
                                            <h6 class="mb-1">{{ $producto->nombre }}</h6>
                                            <small class="text-muted">{{ Str::limit($producto->descripcion, 50) }}</small>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div>
                                        <small class="text-muted d-block">Compra: ${{ number_format($producto->precio_compra, 2) }}</small>
                                        <small class="text-muted">Venta: ${{ number_format($producto->precio_venta, 2) }}</small>
                                    </div>
                                </td>
                                <td>
                                    <span class="fw-bold">{{ $producto->stock_total }}</span>
                                </td>
                                <td>
                                    @if($producto->stock_total <= $producto->stock_minimo)
                                        <span class="badge bg-danger">Mínimo: {{ $producto->stock_minimo }}</span>
                                    @else
                                        <span class="badge bg-success">Mínimo: {{ $producto->stock_minimo }}</span>
                                    @endif
                                </td>
                                <td>
                                    @if($producto->activo)
                                        <span class="badge bg-success">Activo</span>
                                    @else
                                        <span class="badge bg-secondary">Inactivo</span>
                                    @endif
                                </td>
                                <td class="text-end pe-4">
                                    <div class="btn-group">
                                        <a href="{{ route('productos.show', $producto) }}" 
                                           class="btn btn-sm btn-outline-info" 
                                           title="Ver detalles">
                                            <i class="bi bi-eye"></i>
                                        </a>
                                        <a href="{{ route('productos.edit', $producto) }}" 
                                           class="btn btn-sm btn-outline-primary"
                                           title="Editar">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        <button type="button" 
                                                class="btn btn-sm btn-outline-warning"
                                                title="Ajustar stock"
                                                onclick="abrirModalStock({{ $producto->id }}, '{{ $producto->nombre }}')">
                                            <i class="bi bi-plus-minus"></i>
                                        </button>
                                        @if($producto->activo)
                                            <form action="{{ route('productos.toggle-status', $producto) }}" 
                                                  method="POST" 
                                                  class="d-inline"
                                                  onsubmit="return confirm('¿Estás seguro de desactivar este producto?')">
                                                @csrf
                                                @method('PUT')
                                                <button type="submit" class="btn btn-sm btn-outline-danger" title="Desactivar">
                                                    <i class="bi bi-x-circle"></i>
                                                </button>
                                            </form>
                                        @else
                                            <form action="{{ route('productos.toggle-status', $producto) }}" 
                                                  method="POST" 
                                                  class="d-inline"
                                                  onsubmit="return confirm('¿Estás seguro de activar este producto?')">
                                                @csrf
                                                @method('PUT')
                                                <button type="submit" class="btn btn-sm btn-outline-success" title="Activar">
                                                    <i class="bi bi-check-circle"></i>
                                                </button>
                                            </form>
                                        @endif
                                        <form action="{{ route('productos.destroy', $producto) }}" 
                                              method="POST" 
                                              class="d-inline"
                                              onsubmit="return confirm('¿Estás seguro de eliminar este producto?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger" title="Eliminar">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Paginación -->
                <div class="px-4 py-3 border-top">
                    {{ $productos->withQueryString()->links() }}
                </div>
            @else
                <div class="text-center py-5">
                    <i class="bi bi-box-seam fs-1 text-muted"></i>
                    <h5 class="mt-3">No hay productos</h5>
                    <p class="text-muted">Comienza agregando tu primer producto</p>
                    <a href="{{ route('productos.create') }}" class="btn btn-primary">
                        <i class="bi bi-plus-circle me-2"></i>
                        Nuevo Producto
                    </a>
                </div>
            @endif
        </div>
    </div>
</div>

<!-- Modal para ajustar stock -->
<div class="modal fade" id="modalAjustarStock" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="bi bi-plus-minus me-2"></i>
                    Ajustar Stock
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="formAjustarStock" method="POST">
                @csrf
                <div class="modal-body">
                    <p id="productoNombre" class="fw-bold mb-3"></p>
                    
                    <div class="mb-3">
                        <label class="form-label">Almacén</label>
                        <select name="almacen_id" id="almacen_id" class="form-select" required>
                            <option value="">Seleccionar almacén</option>
                            @foreach(\App\Models\Almacen::where('activo', true)->get() as $almacen)
                                <option value="{{ $almacen->id }}">{{ $almacen->nombre }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Tipo de ajuste</label>
                        <select name="tipo" id="tipo_ajuste" class="form-select" required>
                            <option value="sumar">Sumar stock</option>
                            <option value="restar">Restar stock</option>
                            <option value="establecer">Establecer cantidad exacta</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Cantidad</label>
                        <input type="number" name="cantidad" class="form-control" min="0" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Motivo</label>
                        <textarea name="motivo" class="form-control" rows="2" placeholder="Razón del ajuste..."></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary">Aplicar ajuste</button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
function abrirModalStock(productoId, productoNombre) {
    document.getElementById('productoNombre').textContent = 'Producto: ' + productoNombre;
    document.getElementById('formAjustarStock').action = `/productos/${productoId}/ajustar-stock`;
    new bootstrap.Modal(document.getElementById('modalAjustarStock')).show();
}

document.getElementById('formAjustarStock').addEventListener('submit', function(e) {
    e.preventDefault();
    
    fetch(this.action, {
        method: 'POST',
        body: new FormData(this),
        headers: {
            'X-Requested-With': 'XMLHttpRequest'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert(data.message);
            location.reload();
        } else {
            alert(data.message);
        }
    })
    .catch(error => {
        alert('Error al procesar la solicitud');
    });
});
</script>
@endpush
@endsection