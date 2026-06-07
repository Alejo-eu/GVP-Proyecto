@extends('layouts.app')

@section('content')
<style>
    .edit-wrapper {
        font-family: var(--font-body);
    }

    .edit-wrapper h2, .edit-wrapper h5 {
        font-family: var(--font-heading);
        color: var(--text-main);
        letter-spacing: -0.02em;
    }

    .edit-wrapper .text-muted {
        color: var(--text-muted) !important;
    }

    .custom-card {
        background-color: var(--surface);
        border: 1px solid var(--border-color);
        border-radius: var(--radius-lg);
        box-shadow: var(--shadow-sm);
        padding: 16px;
    }

    .custom-icon-box {
        width: 80px;
        height: 80px;
        border-radius: 999px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 32px;
        background-color: var(--primary-light);
        color: var(--primary);
        margin: 0 auto 16px;
    }

    .custom-form-label {
        font-weight: 600;
        color: var(--text-main);
        margin-bottom: 8px;
    }

    .custom-form-control {
        background-color: #F8FAFC;
        border: 2px solid transparent;
        border-radius: 8px;
        padding: 12px 16px;
        color: var(--text-main);
        transition: all 0.3s ease;
        font-family: var(--font-body);
        width: 100%;
    }

    .custom-form-control:focus {
        background-color: var(--surface);
        border-color: var(--primary);
        box-shadow: 0 0 0 4px rgba(99, 102, 241, 0.15);
        outline: none;
    }

    .custom-btn-primary {
        background-color: var(--primary);
        color: white;
        border: none;
        border-radius: 12px;
        padding: 12px 24px;
        font-family: var(--font-heading);
        font-weight: 600;
        transition: all 0.3s ease;
        display: inline-flex;
        align-items: center;
        gap: 8px;
    }

    .custom-btn-primary:hover {
        background-color: var(--primary-hover);
        transform: translateY(-2px);
        box-shadow: 0 8px 24px rgba(99, 102, 241, 0.25);
        color: white;
    }

    .custom-btn-light {
        background-color: #F8FAFC;
        color: var(--text-main);
        border: 1px solid var(--border-color);
        border-radius: 12px;
        padding: 12px 24px;
        font-family: var(--font-heading);
        font-weight: 600;
        transition: all 0.3s ease;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        text-decoration: none;
    }

    .custom-btn-light:hover {
        background-color: #F1F5F9;
        transform: translateY(-2px);
        color: var(--text-main);
    }
    
    .badge-status {
        padding: 8px 16px;
        border-radius: 999px;
        font-weight: 600;
        font-size: 14px;
        display: inline-block;
    }
    .badge-active { background-color: var(--secondary-light); color: var(--secondary); }
    .badge-inactive { background-color: #FEE2E2; color: #EF4444; }
</style>

<div class="container-fluid px-4 edit-wrapper">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold">
                <i class="bi bi-pencil-square me-2"></i>
                Editar Aula o Ambiente
            </h2>
            <p class="text-muted">Actualiza la información del espacio</p>
        </div>
        <a href="{{ route('almacenes.index') }}" class="custom-btn-light">
            <i class="bi bi-arrow-left"></i>
            Volver
        </a>
    </div>

    <!-- Formulario -->
    <div class="card custom-card">
        <div class="card-body p-4">
            <form method="POST" action="{{ route('almacenes.update', $almacen) }}">
                @csrf
                @method('PUT')

                <div class="row">
                    <div class="col-md-8 mx-auto">
                        <div class="mb-5 text-center">
                            <div class="custom-icon-box">
                                <i class="bi bi-building"></i>
                            </div>
                            <h5>Información del Espacio</h5>
                            <p class="text-muted small">Modifica los campos necesarios</p>
                        </div>

                        <div class="mb-4">
                            <label class="custom-form-label">Nombre del Aula/Ambiente <span class="text-danger">*</span></label>
                            <input type="text" 
                                   class="form-control custom-form-control @error('nombre') is-invalid @enderror" 
                                   name="nombre" 
                                   value="{{ old('nombre', $almacen->nombre) }}" 
                                   required>
                            @error('nombre')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label class="custom-form-label">Ubicación</label>
                            <input type="text" 
                                   class="form-control custom-form-control @error('ubicacion') is-invalid @enderror" 
                                   name="ubicacion" 
                                   value="{{ old('ubicacion', $almacen->ubicacion) }}">
                            @error('ubicacion')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-5">
                            <label class="custom-form-label">Descripción</label>
                            <textarea class="form-control custom-form-control @error('descripcion') is-invalid @enderror" 
                                      name="descripcion" 
                                      rows="4">{{ old('descripcion', $almacen->descripcion) }}</textarea>
                            @error('descripcion')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Estado -->
                        <div class="mb-4">
                            <label class="custom-form-label">Estado Actual</label>
                            <div>
                                <span class="badge-status {{ $almacen->activo ? 'badge-active' : 'badge-inactive' }}">
                                    <i class="bi bi-{{ $almacen->activo ? 'check-circle' : 'x-circle' }} me-1"></i>
                                    {{ $almacen->activo ? 'Activo' : 'Inactivo' }}
                                </span>
                                @if(!$almacen->activo)
                                    <small class="text-muted ms-2 d-block mt-2">Este ambiente se encuentra desactivado.</small>
                                @endif
                            </div>
                        </div>

                        <hr class="mb-4" style="border-color: #E9ECEF;">

                        <div class="d-flex justify-content-end gap-3">
                            <a href="{{ route('almacenes.index') }}" class="custom-btn-light px-4">Cancelar</a>
                            <button type="submit" class="custom-btn-primary px-4">
                                <i class="bi bi-save"></i>
                                Actualizar Ambiente
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
