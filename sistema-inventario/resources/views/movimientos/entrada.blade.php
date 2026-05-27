@extends('layouts.app')

@section('content')
<div class="container-fluid px-4">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold">
                <i class="bi bi-box-arrow-in-down me-2 text-success"></i>
                Registrar Entrada
            </h2>
            <p class="text-muted">Registra la recepción de productos en almacenes</p>
        </div>
        <a href="{{ route('movimientos.historial') }}" class="btn btn-outline-secondary">
            <i class="bi bi-clock-history me-2"></i>
            Ver Historial
        </a>
    </div>

    <!-- Formulario -->
    <div class="card border-0 shadow-sm">
        <div class="card-body p-4">
            <form method="POST" action="{{ route('movimientos.entrada.store') }}" id="formEntrada">
                @csrf
                
                <div class="row">
                    <div class="col-md-6 mx-auto">
                        <div class="mb-4 text-center">
                            <div class="avatar-lg bg-success bg-opacity-10 rounded-circle mx-auto mb-3 d-flex align-items-center justify-content-center" style="width: 80px; height: 80px;">
                                <i class="bi bi-box-arrow-in-down text-success" style="font-size: 2rem;"></i>
                            </div>
                            <h5>Entrada de Productos</h5>
                            <p class="text-muted small">Complete la información de la recepción</p>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Producto <span class="text-danger">*</span></label>
                            <select name="producto_id" id="producto_id" class="form-select select2" required>
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
                                <label class="form-label">Cantidad <span class="text-danger">*</span></label>
                                <input type="number" 
                                       name="cantidad" 
                                       id="cantidad"
                                       class="form-control @error('cantidad') is-invalid @enderror" 
                                       value="{{ old('cantidad') }}"
                                       min="1"
                                       required>
                                @error('cantidad')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="col-md-6">
                                <label class="form-label">Almacén Destino <span class="text-danger">*</span></label>
                                <select name="almacen_destino_id" class="form-select @error('almacen_destino_id') is-invalid @enderror" required>
                                    <option value="">Seleccionar almacén</option>
                                    @foreach($almacenes as $almacen)
                                        <option value="{{ $almacen->id }}" {{ old('almacen_destino_id', $almacenSeleccionado ?? '') == $almacen->id ? 'selected' : '' }}>
                                            {{ $almacen->nombre }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('almacen_destino_id')
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
                                   placeholder="Factura, guía, orden de compra...">
                            @error('referencia')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label class="form-label">Observaciones</label>
                            <textarea name="observaciones" 
                                      class="form-control @error('observaciones') is-invalid @enderror" 
                                      rows="3"
                                      placeholder="Notas adicionales sobre esta entrada...">{{ old('observaciones') }}</textarea>
                            @error('observaciones')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <hr>

                        <div class="d-flex justify-content-end gap-2 mt-4">
                            <a href="{{ route('movimientos.historial') }}" class="btn btn-light px-4">Cancelar</a>
                            <button type="submit" class="btn btn-success px-4">
                                <i class="bi bi-save me-2"></i>
                                Registrar Entrada
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection