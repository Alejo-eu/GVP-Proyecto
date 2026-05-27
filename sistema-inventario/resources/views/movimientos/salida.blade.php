@extends('layouts.app')

@section('content')
<div class="container-fluid px-4">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold">
                <i class="bi bi-box-arrow-up me-2 text-danger"></i>
                Registrar Salida
            </h2>
            <p class="text-muted">Registra la salida de productos de los almacenes</p>
        </div>
        <a href="{{ route('movimientos.historial') }}" class="btn btn-outline-secondary">
            <i class="bi bi-clock-history me-2"></i>
            Ver Historial
        </a>
    </div>

    <!-- Formulario -->
    <div class="card border-0 shadow-sm">
        <div class="card-body p-4">
            <form method="POST" action="{{ route('movimientos.salida.store') }}" id="formSalida">
                @csrf
                
                <div class="row">
                    <div class="col-md-6 mx-auto">
                        <div class="mb-4 text-center">
                            <div class="avatar-lg bg-danger bg-opacity-10 rounded-circle mx-auto mb-3 d-flex align-items-center justify-content-center" style="width: 80px; height: 80px;">
                                <i class="bi bi-box-arrow-up text-danger" style="font-size: 2rem;"></i>
                            </div>
                            <h5>Salida de Productos</h5>
                            <p class="text-muted small">Complete la información de la salida</p>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Producto <span class="text-danger">*</span></label>
                            <select name="producto_id" id="producto_id" class="form-select" required>
                                <option value="">Seleccionar producto</option>
                                @foreach($productos as $producto)
                                    <option value="{{ $producto->id }}" {{ old('producto_id') == $producto->id ? 'selected' : '' }}>
                                        [{{ $producto->codigo }}] {{ $producto->nombre }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label">Almacén Origen <span class="text-danger">*</span></label>
                                <select name="almacen_origen_id" id="almacen_origen_id" class="form-select" required>
                                    <option value="">Seleccionar almacén</option>
                                    @foreach($almacenes as $almacen)
                                        <option value="{{ $almacen->id }}" {{ old('almacen_origen_id', $almacenSeleccionado ?? '') == $almacen->id ? 'selected' : '' }}>
                                            {{ $almacen->nombre }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            
                            <div class="col-md-6">
                                <label class="form-label">Cantidad <span class="text-danger">*</span></label>
                                <input type="number" 
                                       name="cantidad" 
                                       id="cantidad"
                                       class="form-control @error('cantidad') is-invalid @enderror" 
                                       value="{{ old('cantidad') }}"
                                       min="1"
                                       required>
                                <small class="text-muted" id="stock-disponible"></small>
                                @error('cantidad')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">N° Referencia</label>
                            <input type="text" 
                                   name="referencia" 
                                   class="form-control @error('referencia') is-invalid @enderror" 
                                   value="{{ old('referencia') }}"
                                   placeholder="Factura, guía, orden de venta...">
                            @error('referencia')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label class="form-label">Observaciones</label>
                            <textarea name="observaciones" 
                                      class="form-control @error('observaciones') is-invalid @enderror" 
                                      rows="3"
                                      placeholder="Notas adicionales sobre esta salida...">{{ old('observaciones') }}</textarea>
                            @error('observaciones')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <hr>

                        <div class="d-flex justify-content-end gap-2 mt-4">
                            <a href="{{ route('movimientos.historial') }}" class="btn btn-light px-4">Cancelar</a>
                            <button type="submit" class="btn btn-danger px-4">
                                <i class="bi bi-save me-2"></i>
                                Registrar Salida
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
    document.getElementById('producto_id').addEventListener('change', verificarStock);
    document.getElementById('almacen_origen_id').addEventListener('change', verificarStock);
    
    function verificarStock() {
        const productoId = document.getElementById('producto_id').value;
        const almacenId = document.getElementById('almacen_origen_id').value;
        const stockSpan = document.getElementById('stock-disponible');
        
        if (productoId && almacenId) {
            fetch(`/movimientos/get-stock?producto_id=${productoId}&almacen_id=${almacenId}`)
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        stockSpan.innerHTML = `Stock disponible: ${data.stock} unidades`;
                        stockSpan.style.color = data.stock > 0 ? 'green' : 'red';
                        
                        const cantidadInput = document.getElementById('cantidad');
                        cantidadInput.max = data.stock;
                        cantidadInput.setAttribute('max', data.stock);
                    }
                });
        } else {
            stockSpan.innerHTML = '';
        }
    }
</script>
@endpush
@endsection