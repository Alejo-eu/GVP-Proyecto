<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Sistema Inventario') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600&family=Outfit:wght@400;500;600;700;800&display=swap"
        rel="stylesheet">

    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    @vite(['resources/sass/app.scss', 'resources/js/app.js'])

    <style>
        :root {
            --primary: #4338CA;
            /* Indigo 700 para más contraste */
            --primary-hover: #3730A3;
            --primary-light: #EEF2FF;
            /* Indigo 50 */
            --secondary: #059669;
            /* Emerald 600 */
            --secondary-hover: #047857;
            --secondary-light: #ECFDF5;
            --background: #F3F4F6;
            /* Gray 100 - Fondo principal más limpio */
            --surface: #FFFFFF;
            --text-main: #111827;
            /* Gray 900 */
            --text-muted: #6B7280;
            /* Gray 500 */
            --border-color: #E5E7EB;
            /* Gray 200 */
            --font-heading: 'Outfit', sans-serif;
            --font-body: 'Inter', sans-serif;
            --radius-md: 12px;
            --radius-lg: 16px;
            --radius-xl: 24px;
            --shadow-sm: 0 1px 2px 0 rgb(0 0 0 / 0.05);
            --shadow-md: 0 4px 6px -1px rgb(0 0 0 / 0.05), 0 2px 4px -2px rgb(0 0 0 / 0.05);
            --shadow-lg: 0 10px 15px -3px rgb(0 0 0 / 0.05), 0 4px 6px -4px rgb(0 0 0 / 0.05);
            --shadow-hover: 0 20px 25px -5px rgb(0 0 0 / 0.05), 0 8px 10px -6px rgb(0 0 0 / 0.05);
            --transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        body {
            font-family: var(--font-body);
            background: var(--background);
            color: var(--text-main);
            -webkit-font-smoothing: antialiased;
            letter-spacing: -0.01em;
        }

        h1,
        h2,
        h3,
        h4,
        h5,
        h6,
        .navbar-brand {
            font-family: var(--font-heading);
            font-weight: 600;
            letter-spacing: -0.02em;
        }

        /* NAVBAR */
        .navbar {
            background: rgba(255, 255, 255, 0.85) !important;
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            border-bottom: 1px solid rgba(229, 231, 235, 0.6);
            padding: 14px 0;
            z-index: 1030;
            box-shadow: var(--shadow-sm);
        }

        .navbar-brand {
            font-weight: 700;
            color: var(--text-main) !important;
            font-size: 1.35rem;
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .navbar-brand img.logo-institution {
            height: 40px;
            width: auto;
            border-radius: 10px;
            box-shadow: var(--shadow-sm);
        }

        /* SIDEBAR */
        .sidebar {
            position: fixed;
            top: 0;
            bottom: 0;
            left: 0;
            z-index: 100;
            padding: 85px 16px 20px;
            background: var(--surface);
            border-right: 1px solid var(--border-color);
            width: 270px;
            transition: var(--transition);
        }

        .sidebar .nav-link {
            color: var(--text-muted);
            padding: 12px 16px;
            margin-bottom: 4px;
            border-radius: var(--radius-md);
            font-weight: 500;
            transition: var(--transition);
            display: flex;
            align-items: center;
            font-size: 0.95rem;
        }

        .sidebar .nav-link:hover {
            background: var(--background);
            color: var(--text-main);
            transform: translateX(4px);
        }

        .sidebar .nav-link:hover i {
            color: var(--primary);
            transform: scale(1.15);
        }

        .sidebar .nav-link i {
            margin-right: 14px;
            font-size: 1.25rem;
            color: var(--text-muted);
            transition: var(--transition);
            display: flex;
            align-items: center;
            justify-content: center;
            width: 24px;
        }

        .sidebar .nav-link.active {
            background: var(--primary-light);
            color: var(--primary);
            font-weight: 600;
        }

        .sidebar .nav-link.active i {
            color: var(--primary);
        }

        /* MAIN CONTENT */
        .main-content {
            margin-left: 270px;
            padding: 100px 32px 32px;
            min-height: 100vh;
            max-width: 1600px;
            margin-right: auto;
        }

        /* USER DROPDOWN */
        .user-dropdown {
            background: var(--surface);
            border: 1px solid var(--border-color);
            border-radius: 100px;
            padding: 8px 20px;
            display: flex;
            align-items: center;
            font-weight: 500;
            font-size: 0.95rem;
            color: var(--text-main);
            transition: var(--transition);
            box-shadow: var(--shadow-sm);
        }

        .user-dropdown:hover,
        .user-dropdown:focus {
            background: var(--background);
            border-color: #D1D5DB;
            color: var(--primary);
            box-shadow: var(--shadow-md);
        }

        .user-dropdown i.bi-person-circle {
            color: var(--primary);
            font-size: 1.2rem;
        }

        .dropdown-menu {
            border: 1px solid var(--border-color);
            border-radius: var(--radius-md);
            box-shadow: var(--shadow-md);
            padding: 8px;
        }

        .dropdown-item {
            border-radius: 6px;
            padding: 8px 16px;
            font-weight: 500;
            font-size: 0.9rem;
            transition: var(--transition);
        }

        .dropdown-item:hover {
            background-color: #FEE2E2;
            color: #DC2626;
        }

        /* CARDS */
        .card {
            border: 1px solid rgba(229, 231, 235, 0.6);
            border-radius: var(--radius-lg);
            box-shadow: var(--shadow-sm);
            background: var(--surface);
            transition: var(--transition);
            overflow: hidden;
        }

        .card:hover {
            box-shadow: var(--shadow-hover);
            border-color: var(--border-color);
            transform: translateY(-2px);
        }

        .card-header {
            background: var(--surface);
            border-bottom: 1px solid var(--border-color);
            padding: 1.25rem 1.5rem;
            font-weight: 600;
        }

        .card-body {
            padding: 1.5rem;
        }

        /* BADGES */
        .badge {
            padding: 6px 12px;
            border-radius: 6px;
            font-weight: 600;
            font-size: 0.75rem;
            letter-spacing: 0.02em;
            text-transform: uppercase;
        }

        /* BUTTONS */
        .btn {
            border-radius: var(--radius-md);
            font-weight: 500;
            padding: 10px 22px;
            transition: var(--transition);
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
        }

        .btn-sm {
            padding: 6px 14px;
            font-size: 0.875rem;
            border-radius: 8px;
        }

        .btn i {
            font-size: 1.1em;
        }

        .btn-primary {
            background: var(--primary);
            border: none;
            color: white;
            box-shadow: 0 4px 6px -1px rgba(67, 56, 202, 0.2);
        }

        .btn-primary:hover,
        .btn-primary:focus {
            background: var(--primary-hover);
            transform: translateY(-2px);
            box-shadow: 0 10px 15px -3px rgba(67, 56, 202, 0.3);
            color: white;
        }

        .btn-success {
            background: var(--secondary);
            border: none;
            color: white;
            box-shadow: 0 4px 6px -1px rgba(5, 150, 105, 0.2);
        }

        .btn-success:hover,
        .btn-success:focus {
            background: var(--secondary-hover);
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 10px 15px -3px rgba(5, 150, 105, 0.3);
        }

        .btn-danger {
            background: #EF4444;
            border: none;
            color: white;
            box-shadow: 0 4px 6px -1px rgba(239, 68, 68, 0.2);
        }

        .btn-danger:hover {
            background: #DC2626;
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 10px 15px -3px rgba(239, 68, 68, 0.3);
        }

        .btn-warning {
            background: #F59E0B;
            border: none;
            color: white;
            box-shadow: 0 4px 6px -1px rgba(245, 158, 11, 0.2);
        }

        .btn-warning:hover {
            background: #D97706;
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 10px 15px -3px rgba(245, 158, 11, 0.3);
        }

        .btn-outline-primary {
            color: var(--primary);
            border-color: rgba(67, 56, 202, 0.3);
            background: transparent;
        }

        .btn-outline-primary:hover {
            background-color: var(--primary-light);
            color: var(--primary-hover);
            border-color: var(--primary);
            transform: translateY(-2px);
        }

        .btn-outline-info {
            color: #0284C7;
            border-color: rgba(2, 132, 199, 0.3);
            background: transparent;
        }

        .btn-outline-info:hover {
            background-color: #E0F2FE;
            color: #0369A1;
            border-color: #0284C7;
            transform: translateY(-2px);
        }

        .btn-outline-success {
            color: var(--secondary);
            border-color: rgba(5, 150, 105, 0.3);
            background: transparent;
        }

        .btn-outline-success:hover {
            background-color: var(--secondary-light);
            color: var(--secondary-hover);
            border-color: var(--secondary);
            transform: translateY(-2px);
        }

        .btn-outline-warning {
            color: #D97706;
            border-color: rgba(217, 119, 6, 0.3);
            background: transparent;
        }

        .btn-outline-warning:hover {
            background-color: #FEF3C7;
            color: #B45309;
            border-color: #D97706;
            transform: translateY(-2px);
        }

        .btn-outline-danger {
            color: #DC2626;
            border-color: rgba(220, 38, 38, 0.3);
            background: transparent;
        }

        .btn-outline-danger:hover {
            background-color: #FEE2E2;
            color: #B91C1C;
            border-color: #DC2626;
            transform: translateY(-2px);
        }

        /* FORMS */
        .form-control,
        .form-select {
            border-radius: var(--radius-md);
            border: 1px solid var(--border-color);
            padding: 12px 16px;
            transition: var(--transition);
            font-family: var(--font-body);
            background-color: #F9FAFB;
            color: var(--text-main);
            box-shadow: inset 0 1px 2px rgba(0, 0, 0, 0.02);
        }

        .form-control:focus,
        .form-select:focus {
            background-color: var(--surface);
            border-color: var(--primary);
            box-shadow: 0 0 0 4px var(--primary-light);
            outline: none;
        }

        .input-group-text {
            background-color: #F9FAFB;
            border-color: var(--border-color);
            color: var(--text-muted);
            border-radius: var(--radius-md);
        }

        .form-label {
            font-weight: 500;
            color: var(--text-main);
            margin-bottom: 0.5rem;
            font-size: 0.95rem;
        }

        /* TABLES */
        .table {
            --bs-table-bg: transparent;
            margin-bottom: 0;
            border-collapse: separate;
            border-spacing: 0;
        }

        .table th {
            font-weight: 600;
            font-size: 0.75rem;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            color: var(--text-muted);
            border-bottom: 1px solid var(--border-color);
            padding: 16px 20px;
            background: #F9FAFB;
        }

        .table th:first-child {
            border-top-left-radius: var(--radius-md);
        }

        .table th:last-child {
            border-top-right-radius: var(--radius-md);
        }

        .table td {
            vertical-align: middle;
            padding: 16px 20px;
            border-bottom: 1px solid rgba(229, 231, 235, 0.5);
            color: var(--text-main);
            font-size: 0.95rem;
        }

        .table tbody tr:last-child td {
            border-bottom: none;
        }

        .table tbody tr {
            transition: var(--transition);
        }

        .table tbody tr:hover {
            background-color: #F9FAFB;
        }

        /* PAGINATION */
        .pagination {
            margin-bottom: 0;
            gap: 6px;
        }

        .page-link {
            border: 1px solid var(--border-color);
            color: var(--text-muted);
            padding: 0.5rem 1rem;
            border-radius: var(--radius-md);
            font-weight: 500;
            transition: var(--transition);
            background: var(--surface);
        }

        .page-link:hover {
            background: #F3F4F6;
            color: var(--text-main);
            border-color: #D1D5DB;
        }

        .page-item.active .page-link {
            background: var(--primary);
            border-color: var(--primary);
            color: white;
            box-shadow: 0 4px 6px -1px rgba(67, 56, 202, 0.2);
        }

        .page-item.disabled .page-link {
            background: #F9FAFB;
            color: #9CA3AF;
            border-color: var(--border-color);
        }

        /* UTILITIES */
        .text-primary {
            color: var(--primary) !important;
        }

        .bg-primary {
            background-color: var(--primary) !important;
        }

        .bg-primary.bg-opacity-10 {
            background-color: var(--primary-light) !important;
            color: var(--primary) !important;
        }

        .text-success {
            color: var(--secondary) !important;
        }

        .bg-success {
            background-color: var(--secondary) !important;
        }

        .bg-success.bg-opacity-10 {
            background-color: var(--secondary-light) !important;
            color: var(--secondary) !important;
        }

        .text-info {
            color: #0284C7 !important;
        }

        .bg-info {
            background-color: #0EA5E9 !important;
        }

        .bg-info.bg-opacity-10 {
            background-color: #E0F2FE !important;
            color: #0284C7 !important;
        }

        .text-warning {
            color: #D97706 !important;
        }

        .bg-warning {
            background-color: #F59E0B !important;
        }

        .bg-warning.bg-opacity-10 {
            background-color: #FEF3C7 !important;
            color: #D97706 !important;
        }

        .text-danger {
            color: #DC2626 !important;
        }

        .bg-danger {
            background-color: #EF4444 !important;
        }

        .bg-danger.bg-opacity-10 {
            background-color: #FEE2E2 !important;
            color: #DC2626 !important;
        }

        /* SWEETALERT2 MODERNIZATION */
        .swal2-popup {
            font-family: var(--font-body) !important;
            border-radius: var(--radius-xl) !important;
            box-shadow: var(--shadow-hover) !important;
            border: 1px solid var(--border-color) !important;
            padding: 2em !important;
        }

        .swal2-title {
            font-family: var(--font-heading) !important;
            font-weight: 600 !important;
            color: var(--text-main) !important;
        }

        .swal2-html-container {
            color: var(--text-muted) !important;
        }

        .swal2-actions {
            gap: 12px;
            margin-top: 2em !important;
        }

        .swal2-confirm,
        .swal2-cancel {
            border-radius: var(--radius-md) !important;
            font-weight: 500 !important;
            padding: 12px 28px !important;
            transition: var(--transition) !important;
        }

        .swal2-confirm:hover,
        .swal2-cancel:hover {
            transform: translateY(-2px) !important;
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1) !important;
        }

        /* RESPONSIVE */
        /* RESPONSIVE */
        @media (max-width: 991px) {
            .sidebar {
                transform: translateX(-100%);
                z-index: 1040;
                padding-top: 90px;
                box-shadow: var(--shadow-lg);
            }

            .sidebar.show {
                transform: translateX(0);
            }

            .main-content {
                margin-left: 0;
                padding: 95px 16px 24px;
            }
        }

        /* Aviso emergente no-bloqueante para celulares (< 768px) */
        .mobile-warning-overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100vw;
            height: 100vh;
            background: rgba(17, 24, 39, 0.6);
            z-index: 99999;
            align-items: center;
            justify-content: center;
            padding: 24px;
            box-sizing: border-box;
            backdrop-filter: blur(8px);
            -webkit-backdrop-filter: blur(8px);
        }

        .mobile-warning-card {
            background: #FFFFFF;
            padding: 40px 28px;
            border-radius: var(--radius-xl);
            box-shadow: var(--shadow-hover);
            border: 1px solid rgba(229, 231, 235, 0.8);
            text-align: center;
            max-width: 400px;
            width: 100%;
            transform: translateY(20px);
            opacity: 0;
            animation: slideUpFade 0.5s cubic-bezier(0.16, 1, 0.3, 1) forwards;
        }

        .mobile-warning-icon {
            width: 76px;
            height: 76px;
            background: var(--primary-light);
            color: var(--primary);
            font-size: 2.5rem;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            margin: 0 auto 24px;
            box-shadow: 0 8px 20px -4px rgba(67, 56, 202, 0.15);
            animation: pulseIcon 2.5s infinite ease-in-out;
        }

        .mobile-warning-card h2 {
            color: var(--text-main);
            font-size: 1.45rem;
            font-weight: 700;
            margin-bottom: 12px;
            line-height: 1.3;
        }

        .mobile-warning-card p {
            color: var(--text-muted);
            font-size: 0.95rem;
            line-height: 1.6;
            margin-bottom: 24px;
        }

        .mobile-warning-card .btn-dismiss {
            background: var(--primary);
            color: #FFFFFF;
            border: none;
            width: 100%;
            padding: 12px;
            border-radius: var(--radius-md);
            font-weight: 600;
            font-size: 0.95rem;
            transition: var(--transition);
        }

        .mobile-warning-card .btn-dismiss:hover {
            background: var(--primary-hover);
            transform: translateY(-2px);
        }

        @keyframes slideUpFade {
            to {
                transform: translateY(0);
                opacity: 1;
            }
        }

        @keyframes pulseIcon {
            0%, 100% {
                transform: scale(1);
            }
            50% {
                transform: scale(1.06);
                box-shadow: 0 12px 24px -2px rgba(67, 56, 202, 0.25);
            }
        }
    </style>
</head>

<body>
    <!-- Aviso para pantallas pequeñas (Celulares) -->
    <div id="mobile-warning-popup" class="mobile-warning-overlay">
        <div class="mobile-warning-card">
            <div class="mobile-warning-icon">
                <i class="bi bi-phone-vibrate"></i>
            </div>
            <h2>Experiencia Optimizada</h2>
            <p>Para una mejor experiencia visual y de gestión del inventario, te recomendamos acceder desde una Laptop o Monitor.</p>
            <button class="btn btn-dismiss" onclick="dismissMobileWarning()">
                Entendido, continuar
            </button>
        </div>
    </div>

    <div id="app">
        <!-- Navbar -->
        <nav class="navbar navbar-expand-md fixed-top">
            <div class="container-fluid">
                @auth
                <button class="btn btn-outline-primary d-lg-none me-2" type="button" id="sidebar-toggle" style="padding: 6px 12px; border-radius: var(--radius-md); border: 1px solid rgba(67, 56, 202, 0.2);">
                    <i class="bi bi-list fs-5" style="vertical-align: middle;"></i>
                </button>
                @endauth
                <a class="navbar-brand" href="{{ url('/dashboard') }}">
                    <img src="{{ asset('images/logo.png') }}" alt="Logo" class="logo-institution"
                        onerror="this.src='https://ui-avatars.com/api/?name=Inst&background=4F46E5&color=fff&rounded=true&bold=true';">
                    Recursos Educativos</a>

                <div class="ms-auto d-flex align-items-center gap-3">
                    <div class="d-none d-md-flex align-items-center" style="background: var(--primary-light); color: var(--primary); padding: 8px 16px; border-radius: 100px; font-weight: 600; font-size: 0.9rem;">
                        <i class="bi bi-calendar-event me-2"></i>
                        {{ now()->format('d/m/Y') }}
                    </div>
                    @auth
                        <div class="dropdown">
                            <button class="btn user-dropdown" type="button" data-bs-toggle="dropdown">
                                <i class="bi bi-person-circle me-2"></i>
                                {{ Auth::user()->name }}
                                <i class="bi bi-chevron-down ms-2"></i>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li>
                                    <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();
                                                             document.getElementById('logout-form').submit();">
                                        <i class="bi bi-box-arrow-right me-2"></i>
                                        {{ __('Cerrar Sesión') }}
                                    </a>
                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                </li>
                            </ul>
                        </div>
                    @endauth
                </div>
            </div>
        </nav>

        @auth
            <!-- Sidebar -->
            <div class="sidebar">
                <ul class="nav flex-column">
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}"
                            href="{{ route('dashboard') }}">
                            <i class="bi bi-house-heart"></i>
                            Inicio
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('almacenes*') ? 'active' : '' }}"
                            href="{{ route('almacenes.index') }}">
                            <i class="bi bi-building"></i>
                            Aulas y Ambientes
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('productos*') ? 'active' : '' }}"
                            href="{{ route('productos.index') }}">
                            <i class="bi bi-journals"></i>
                            Materiales
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('movimientos.entrada') ? 'active' : '' }}"
                            href="{{ route('movimientos.entrada') }}">
                            <i class="bi bi-box-arrow-in-right"></i>
                            Ingresos
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('movimientos.salida') ? 'active' : '' }}"
                            href="{{ route('movimientos.salida') }}">
                            <i class="bi bi-box-arrow-right"></i>
                            Salidas
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('movimientos.traslado') ? 'active' : '' }}"
                            href="{{ route('movimientos.traslado') }}">
                            <i class="bi bi-arrow-left-right"></i>
                            Traslados
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('movimientos.historial') ? 'active' : '' }}"
                            href="{{ route('movimientos.historial') }}">
                            <i class="bi bi-clock-history"></i>
                            Historial
                        </a>
                    </li>
                </ul>
            </div>

            <!-- Main Content -->
            <main class="main-content">
                @yield('content')
            </main>
        @else
            <main>
                @yield('content')
            </main>
        @endauth
    </div>

    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        function dismissMobileWarning() {
            document.getElementById('mobile-warning-popup').style.display = 'none';
            sessionStorage.setItem('dismissedMobileWarning', 'true');
        }

        document.addEventListener('DOMContentLoaded', function () {
            // Mobile warning check
            if (window.innerWidth < 768 && !sessionStorage.getItem('dismissedMobileWarning')) {
                document.getElementById('mobile-warning-popup').style.display = 'flex';
            }

            // Sidebar toggle logic
            const sidebarToggle = document.getElementById('sidebar-toggle');
            const sidebar = document.querySelector('.sidebar');
            if (sidebarToggle && sidebar) {
                sidebarToggle.addEventListener('click', function (e) {
                    e.stopPropagation();
                    sidebar.classList.toggle('show');
                });
            }

            // Close sidebar when clicking outside
            document.addEventListener('click', function (e) {
                const sidebar = document.querySelector('.sidebar');
                const toggle = document.getElementById('sidebar-toggle');
                if (sidebar && sidebar.classList.contains('show')) {
                    if (!sidebar.contains(e.target) && (!toggle || !toggle.contains(e.target))) {
                        sidebar.classList.remove('show');
                    }
                }
            });

            // Configuración general para Toasts
            window.Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true,
                didOpen: (toast) => {
                    toast.addEventListener('mouseenter', Swal.stopTimer)
                    toast.addEventListener('mouseleave', Swal.resumeTimer)
                }
            });

            // Mostrar notificaciones flash (éxito, error, info)
            @if(session('success'))
                window.Toast.fire({
                    icon: 'success',
                    title: "{!! session('success') !!}"
                });
            @endif

            @if(session('error'))
                Swal.fire({
                    icon: 'error',
                    title: '¡Atención!',
                    text: "{!! session('error') !!}",
                    confirmButtonColor: 'var(--primary)'
                });
            @endif

            @if(session('info'))
                window.Toast.fire({
                    icon: 'info',
                    title: "{!! session('info') !!}"
                });
            @endif

            // Interceptar todos los botones y formularios que usan el confirm nativo
            const formsWithConfirm = document.querySelectorAll('form[onsubmit*="return confirm"]');

            formsWithConfirm.forEach(form => {
                const onsubmitAttr = form.getAttribute('onsubmit');
                const match = onsubmitAttr.match(/return confirm\(['"](.*?)['"]\)/);
                const confirmMessage = match ? match[1] : '¿Estás seguro de realizar esta acción?';

                // Removemos el evento nativo
                form.removeAttribute('onsubmit');

                // Interceptamos el evento de envío
                form.addEventListener('submit', function (e) {
                    e.preventDefault();

                    Swal.fire({
                        title: '¿Confirmar acción?',
                        text: confirmMessage,
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: 'var(--secondary)',
                        cancelButtonColor: '#E11D48',
                        confirmButtonText: 'Sí, confirmar',
                        cancelButtonText: 'Cancelar',
                        reverseButtons: true
                    }).then((result) => {
                        if (result.isConfirmed) {
                            form.submit();
                        }
                    });
                });
            });
        });
    </script>
</body>

</html>