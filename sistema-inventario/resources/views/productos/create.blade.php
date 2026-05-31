@extends('layouts.app')

@section('content')
<div class="container-fluid px-4">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold">
                <i class="bi bi-plus-circle me-2"></i>
                Nuevo Producto
            </h2>
            <p class="text-muted">Ingresa los detalles del nuevo producto</p>
        </div>
        <a href="{{ route('productos.index') }}" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left me-2"></i>
            Volver
        </a>
    </div>

    <!-- Formulario -->
    <div class="card">
        <div class="card-body p-4">
            <form method="POST" action="{{ route('productos.store') }}">
                @csrf

                <div class="row">
                    <!-- Columna izquierda -->
                    <div class="col-md-6">
                        <h5 class="mb-3">Información Básica</h5>
                        
                        <div class="mb-3">
                            <label class="form-label">Código <span class="text-danger">*</span></label>
                            <input type="text" 
                                   class="form-control @error('codigo') is-invalid @enderror" 
                                   name="codigo" 
                                   value="{{ old('codigo') }}" 
                                   required>
                            @error('codigo')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Nombre <span class="text-danger">*</span></label>
                            <input type="text" 
                                   class="form-control @error('nombre') is-invalid @enderror" 
                                   name="nombre" 
                                   value="{{ old('nombre') }}" 
                                   required>
                            @error('nombre')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Descripción</label>
                            <textarea class="form-control @error('descripcion') is-invalid @enderror" 
                                      name="descripcion" 
                                      rows="3">{{ old('descripcion') }}</textarea>
                            @error('descripcion')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!-- Columna derecha -->
                    <div class="col-md-6">
                        <h5 class="mb-3">Precios y Stocks</h5>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label">Precio Compra <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text">$</span>
                                    <input type="number" 
                                           class="form-control @error('precio_compra') is-invalid @enderror" 
                                           name="precio_compra" 
                                           value="{{ old('precio_compra') }}" 
                                           step="0.01" 
                                           min="0" 
                                           required>
                                </div>
                                @error('precio_compra')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Precio Venta <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text">$</span>
                                    <input type="number" 
                                           class="form-control @error('precio_venta') is-invalid @enderror" 
                                           name="precio_venta" 
                                           value="{{ old('precio_venta') }}" 
                                           step="0.01" 
                                           min="0" 
                                           required>
                                </div>
                                @error('precio_venta')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label">Stock Mínimo <span class="text-danger">*</span></label>
                                <input type="number" 
                                       class="form-control @error('stock_minimo') is-invalid @enderror" 
                                       name="stock_minimo" 
                                       value="{{ old('stock_minimo', 0) }}" 
                                       min="0" 
                                       required>
                                @error('stock_minimo')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Stock Máximo</label>
                                <input type="number" 
                                       class="form-control @error('stock_maximo') is-invalid @enderror" 
                                       name="stock_maximo" 
                                       value="{{ old('stock_maximo') }}" 
                                       min="0">
                                @error('stock_maximo')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <hr class="my-4">

                        <h5 class="mb-3">Stock Inicial por Almacén</h5>
                        
                        @foreach($almacenes as $almacen)
                            <div class="row mb-2 align-items-center">
                                <div class="col-md-8">
                                    <label class="form-label mb-0">{{ $almacen->nombre }}</label>
                                </div>
                                <div class="col-md-4">
                                    <input type="number" 
                                           class="form-control" 
                                           name="stock_inicial[{{ $almacen->id }}]" 
                                           value="0" 
                                           min="0"
                                           placeholder="Cantidad">
                                </div>
                            </div>
                        @endforeach
                        <small class="text-muted">Deja en 0 si no quieres stock inicial en ese almacén</small>
                    </div>
                </div>

                <hr class="my-4">

                <div class="d-flex justify-content-end gap-2">
                    <a href="{{ route('productos.index') }}" class="btn btn-light px-4">Cancelar</a>
                    <button type="submit" class="btn btn-primary px-4">
                        <i class="bi bi-save me-2"></i>
                        Guardar Producto
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
