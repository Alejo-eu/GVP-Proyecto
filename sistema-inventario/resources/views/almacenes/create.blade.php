@extends('layouts.app')

@section('content')
<style>
    @import url('https://fonts.googleapis.com/css2?family=Manrope:wght@600;700&family=Source+Sans+3:wght@400;600&display=swap');

    .create-wrapper {
        --primary: #2a6f97;
        --secondary: #a9d6e5;
        --tertiary: #ffb370;
        --surface: #ffffff;
        --background: #f8f9fa;
        --on-surface: #191c1d;
        --on-surface-variant: #40484e;
        --error: #ba1a1a;
        --input-bg: #f1f3f5;

        font-family: 'Source Sans 3', sans-serif;
    }

    .create-wrapper h2, .create-wrapper h5 {
        font-family: 'Manrope', sans-serif;
        color: var(--on-surface);
    }

    .create-wrapper .text-muted {
        color: var(--on-surface-variant) !important;
    }

    .custom-card {
        background-color: var(--surface);
        border: none;
        border-radius: 24px;
        box-shadow: 0px 12px 40px rgba(42, 111, 151, 0.12);
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
        background-color: rgba(42, 111, 151, 0.1);
        color: var(--primary);
        margin: 0 auto 16px;
    }

    .custom-form-label {
        font-weight: 600;
        color: var(--on-surface);
        margin-bottom: 8px;
    }

    .custom-form-control {
        background-color: var(--input-bg);
        border: 2px solid transparent;
        border-radius: 8px;
        padding: 12px 16px;
        color: var(--on-surface);
        transition: all 0.3s ease;
        font-family: 'Source Sans 3', sans-serif;
        width: 100%;
    }

    .custom-form-control:focus {
        background-color: var(--surface);
        border-color: var(--primary);
        box-shadow: 0 0 0 4px rgba(42, 111, 151, 0.1);
        outline: none;
    }

    .custom-btn-primary {
        background-color: var(--primary);
        color: white;
        border: none;
        border-radius: 12px;
        padding: 12px 24px;
        font-family: 'Manrope', sans-serif;
        font-weight: 600;
        transition: all 0.3s ease;
        display: inline-flex;
        align-items: center;
        gap: 8px;
    }

    .custom-btn-primary:hover {
        background-color: #1a4f6d;
        transform: translateY(-2px);
        box-shadow: 0 8px 24px rgba(42, 111, 151, 0.25);
        color: white;
    }

    .custom-btn-light {
        background-color: var(--input-bg);
        color: var(--on-surface);
        border: none;
        border-radius: 12px;
        padding: 12px 24px;
        font-family: 'Manrope', sans-serif;
        font-weight: 600;
        transition: all 0.3s ease;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        text-decoration: none;
    }

    .custom-btn-light:hover {
        background-color: #e2e6ea;
        transform: translateY(-2px);
        color: var(--on-surface);
    }
</style>

<div class="container-fluid px-4 create-wrapper">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold">
                <i class="bi bi-plus-circle me-2"></i>
                Nueva Aula o Ambiente
            </h2>
            <p class="text-muted">Ingresa los detalles del nuevo espacio</p>
        </div>
        <a href="{{ route('almacenes.index') }}" class="custom-btn-light">
            <i class="bi bi-arrow-left"></i>
            Volver
        </a>
    </div>

    <!-- Formulario -->
    <div class="card custom-card">
        <div class="card-body p-4">
            <form method="POST" action="{{ route('almacenes.store') }}">
                @csrf

                <div class="row">
                    <div class="col-md-8 mx-auto">
                        <div class="mb-5 text-center">
                            <div class="custom-icon-box">
                                <i class="bi bi-building"></i>
                            </div>
                            <h5>Información del Espacio</h5>
                            <p class="text-muted small">Completa todos los campos obligatorios</p>
                        </div>

                        <div class="mb-4">
                            <label class="custom-form-label">Nombre del Aula/Ambiente <span class="text-danger">*</span></label>
                            <input type="text" 
                                   class="form-control custom-form-control @error('nombre') is-invalid @enderror" 
                                   name="nombre" 
                                   value="{{ old('nombre') }}" 
                                   placeholder="Ej: Aula 101, Laboratorio de Química"
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
                                   value="{{ old('ubicacion') }}" 
                                   placeholder="Ej: Pabellón A, Primer Piso">
                            @error('ubicacion')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="text-muted mt-2 d-block">Ubicación física dentro de la institución</small>
                        </div>

                        <div class="mb-5">
                            <label class="custom-form-label">Descripción</label>
                            <textarea class="form-control custom-form-control @error('descripcion') is-invalid @enderror" 
                                      name="descripcion" 
                                      rows="4" 
                                      placeholder="Describe el propósito, equipos instalados o notas importantes sobre este ambiente...">{{ old('descripcion') }}</textarea>
                            @error('descripcion')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <hr class="mb-4" style="border-color: #E9ECEF;">

                        <div class="d-flex justify-content-end gap-3">
                            <a href="{{ route('almacenes.index') }}" class="custom-btn-light px-4">Cancelar</a>
                            <button type="submit" class="custom-btn-primary px-4">
                                <i class="bi bi-save"></i>
                                Guardar Ambiente
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
