@extends('layouts.app')

@section('content')
<div class="container-fluid px-4">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold">
                <i class="bi bi-plus-circle me-2"></i>
                Nuevo Almacén
            </h2>
            <p class="text-muted">Ingresa los detalles del nuevo almacén</p>
        </div>
        <a href="{{ route('almacenes.index') }}" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left me-2"></i>
            Volver
        </a>
    </div>

    <!-- Formulario -->
    <div class="card border-0 shadow-sm">
        <div class="card-body p-4">
            <form method="POST" action="{{ route('almacenes.store') }}">
                @csrf

                <div class="row">
                    <div class="col-md-8 mx-auto">
                        <div class="mb-4 text-center">
                            <div class="avatar-lg bg-light rounded-circle mx-auto mb-3 d-flex align-items-center justify-content-center" style="width: 100px; height: 100px;">
                                <i class="bi bi-building text-primary" style="font-size: 3rem;"></i>
                            </div>
                            <h5>Información del Almacén</h5>
                            <p class="text-muted small">Completa todos los campos obligatorios</p>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Nombre del Almacén <span class="text-danger">*</span></label>
                            <input type="text" 
                                   class="form-control form-control-lg @error('nombre') is-invalid @enderror" 
                                   name="nombre" 
                                   value="{{ old('nombre') }}" 
                                   placeholder="Ej: Almacén Central"
                                   required>
                            @error('nombre')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Ubicación</label>
                            <input type="text" 
                                   class="form-control @error('ubicacion') is-invalid @enderror" 
                                   name="ubicacion" 
                                   value="{{ old('ubicacion') }}" 
                                   placeholder="Ej: Av. Principal #123, Zona Industrial">
                            @error('ubicacion')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="text-muted">Dirección física del almacén</small>
                        </div>

                        <div class="mb-4">
                            <label class="form-label">Descripción</label>
                            <textarea class="form-control @error('descripcion') is-invalid @enderror" 
                                      name="descripcion" 
                                      rows="4" 
                                      placeholder="Describe el propósito, características o notas importantes sobre este almacén...">{{ old('descripcion') }}</textarea>
                            @error('descripcion')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <hr class="my-4">

                        <div class="d-flex justify-content-end gap-2">
                            <a href="{{ route('almacenes.index') }}" class="btn btn-light px-4">Cancelar</a>
                            <button type="submit" class="btn btn-primary px-4">
                                <i class="bi bi-save me-2"></i>
                                Guardar Almacén
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection