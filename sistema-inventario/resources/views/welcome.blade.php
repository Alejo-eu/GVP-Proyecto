@extends('layouts.app')

@section('content')
<div class="container-fluid px-4 py-5">
    <div class="row align-items-center g-5 py-5 min-vh-75">
        <div class="col-lg-6 text-center text-lg-start">
            <span class="badge bg-primary bg-opacity-10 text-primary mb-3 px-3 py-2 rounded-pill shadow-sm">
                <i class="bi bi-stars me-1"></i> Sistema Moderno
            </span>
            <h1 class="display-4 fw-bold lh-1 mb-4 text-dark" style="font-family: var(--font-heading); letter-spacing: -0.03em;">
                Gestión Inteligente de <span class="text-primary">Recursos Educativos</span>
            </h1>
            <p class="lead fw-normal text-muted mb-5" style="font-size: 1.15rem; max-width: 600px;">
                Administra el inventario de aulas, ambientes y materiales de forma intuitiva. Mantén el control total de los movimientos, ingresos y salidas en tiempo real.
            </p>
            <div class="d-flex flex-column flex-md-row gap-3 justify-content-center justify-content-lg-start">
                @auth
                    <a href="{{ route('dashboard') }}" class="btn btn-primary btn-lg px-5 py-3 rounded-pill shadow-lg" style="font-weight: 600;">
                        <i class="bi bi-speedometer2 me-2"></i> Ir al Dashboard
                    </a>
                @else
                    <a href="{{ route('login') }}" class="btn btn-primary btn-lg px-5 py-3 rounded-pill shadow-lg" style="font-weight: 600;">
                        <i class="bi bi-box-arrow-in-right me-2"></i> Iniciar Sesión
                    </a>
                    @if (Route::has('register'))
                        <a href="{{ route('register') }}" class="btn btn-outline-primary btn-lg px-5 py-3 rounded-pill" style="font-weight: 600;">
                            Registrarse
                        </a>
                    @endif
                @endauth
            </div>
        </div>
        <div class="col-lg-6">
            <div class="position-relative">
                <div class="position-absolute top-50 start-50 translate-middle w-100 h-100 bg-primary bg-opacity-10 rounded-circle" style="filter: blur(60px); z-index: -1;"></div>
                <div class="card border-0 shadow-hover bg-white p-4" style="border-radius: var(--radius-xl); z-index: 1;">
                    <div class="card-body text-center p-5">
                        <div class="mb-4">
                            <div class="d-inline-flex align-items-center justify-content-center bg-primary bg-opacity-10 text-primary rounded-circle mb-3" style="width: 80px; height: 80px;">
                                <i class="bi bi-box-seam" style="font-size: 2.5rem;"></i>
                            </div>
                        </div>
                        <h3 class="h4 fw-bold mb-3" style="font-family: var(--font-heading);">Control Total</h3>
                        <p class="text-muted mb-0">Visualiza el estado de tu inventario con métricas precisas y una interfaz diseñada para la productividad.</p>
                        
                        <div class="row mt-5 g-4">
                            <div class="col-6">
                                <div class="p-3 bg-light rounded-4">
                                    <i class="bi bi-building text-primary fs-3 mb-2"></i>
                                    <h4 class="h6 fw-bold mb-0">Ambientes</h4>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="p-3 bg-light rounded-4">
                                    <i class="bi bi-journals text-success fs-3 mb-2"></i>
                                    <h4 class="h6 fw-bold mb-0">Materiales</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
