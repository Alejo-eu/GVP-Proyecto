@extends('layouts.app')

@section('content')
<div class="container-fluid px-4">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold">
                <i class="bi bi-pencil-square me-2"></i>
                Editar Almacén
            </h2>
            <p class="text-muted">Actualiza la información del almacén</p>
        </div>
        <a href="{{ route('almacenes.index') }}" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left me-2"></i>
            Volver
        </a>
    </div>

    <!-- Formulario -->
    <div class="card border-0 shadow-sm">
        <div class="card-body p-4">
            <form method="POST" action="{{ route('almacenes.update', $almacen) }}">
                @csrf
                @method('PUT')

                <div class="row">
                    <div class="col-md-8 mx-auto">
                        <div class="mb-4 text-center">
                            <div class="avatar-lg bg-light rounded-circle mx-auto mb-3 d-flex align-items-center justify-content-center" style="width: 100px; height: 100px;">
                                <i class="bi bi-building text-primary" style="font-size: 3rem;"></i>
                            </div>
                            <h5>Información del Almacén</h5>
                            <p class="text-muted small">Modifica los campos necesarios</p>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Nombre del Almacén <span class="text-danger">*</span></label>
                            <input type="text" 
                                   class="form-control form-control-lg @error('nombre') is-invalid @enderror" 
                                   name="nombre" 
                                   value="{{ old('nombre', $almacen->nombre) }}" 
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
                                   value="{{ old('ubicacion', $almacen->ubicacion) }}">
                            @error('ubicacion')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label class="form-label">Descripción</label>
                            <textarea class="form-control @error('descripcion') is-invalid @enderror" 
                                      name="descripcion" 
                                      rows="4">{{ old('descripcion', $almacen->descripcion) }}</textarea>
                            @error('descripcion')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Estado -->
                        <div class="mb-4">
                            <label class="form-label">Estado</label>
                            <div>
                                <span class="badge bg-{{ $almacen->activo ? 'success' : 'secondary' }} p-2">
                                    {{ $almacen->activo ? 'Activo' : 'Inactivo' }}
                                </span>
                                @if(!$almacen->activo)
                                    <small class="text-muted ms-2">Almacén desactivado</small>
                                @endif
                            </div>
                        </div>

                        <hr class="my-4">

                        <div class="d-flex justify-content-end gap-2">
                            <a href="{{ route('almacenes.index') }}" class="btn btn-light px-4">Cancelar</a>
                            <button type="submit" class="btn btn-primary px-4">
                                <i class="bi bi-save me-2"></i>
                                Actualizar Almacén
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection