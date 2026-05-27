<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Sistema Inventario') }}</title>
    
    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Poppins:300,400,500,600,700" rel="stylesheet">
    
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
    
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: #f8f9fa;
        }
        
        .navbar {
            background: white !important;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
            padding: 15px 0;
        }
        
        .navbar-brand {
            font-weight: 700;
            color: #667eea !important;
            font-size: 1.5rem;
        }
        
        .sidebar {
            position: fixed;
            top: 0;
            bottom: 0;
            left: 0;
            z-index: 100;
            padding: 70px 0 0;
            box-shadow: 2px 0 10px rgba(0,0,0,0.05);
            background: white;
            width: 250px;
        }
        
        .sidebar .nav-link {
            color: #666;
            padding: 12px 20px;
            margin: 2px 10px;
            border-radius: 10px;
            font-weight: 500;
            transition: all 0.3s;
        }
        
        .sidebar .nav-link:hover {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            transform: translateX(5px);
        }
        
        .sidebar .nav-link:hover i {
            color: white;
        }
        
        .sidebar .nav-link i {
            margin-right: 10px;
            color: #667eea;
            transition: all 0.3s;
        }
        
        .sidebar .nav-link.active {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
        }
        
        .sidebar .nav-link.active i {
            color: white;
        }
        
        .main-content {
            margin-left: 250px;
            padding: 80px 20px 20px;
        }
        
        .user-dropdown {
            background: #f8f9fa;
            border-radius: 30px;
            padding: 5px 15px;
            display: flex;
            align-items: center;
        }
        
        .user-dropdown i {
            color: #667eea;
        }
        
        .card {
            border-radius: 15px;
            transition: transform 0.3s;
        }
        
        .card:hover {
            transform: translateY(-5px);
        }
        
        .badge {
            padding: 8px 12px;
            border-radius: 8px;
            font-weight: 500;
        }
        
        .btn-primary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border: none;
            padding: 10px 20px;
            border-radius: 10px;
            font-weight: 500;
        }
        
        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(102, 126, 234, 0.4);
        }

        .avatar-sm {
            width: 40px;
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .avatar-lg {
            width: 80px;
            height: 80px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        /* Estilos para las tablas */
        .table th {
            font-weight: 600;
            font-size: 0.85rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            color: #6c757d;
        }

        .table td {
            vertical-align: middle;
        }

        /* Paginación */
        .pagination {
            margin-bottom: 0;
        }

        .page-link {
            border: none;
            color: #667eea;
            padding: 0.5rem 1rem;
            margin: 0 2px;
            border-radius: 8px;
        }

        .page-item.active .page-link {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border: none;
        }

        .page-item.disabled .page-link {
            background: none;
            color: #dee2e6;
        }
        
    </style>
</head>
<body>
    <div id="app">
        <!-- Navbar -->
        <nav class="navbar navbar-expand-md fixed-top">
            <div class="container-fluid">
                <a class="navbar-brand" href="{{ url('/dashboard') }}">
                    <i class="bi bi-box-seam me-2"></i>
                    Sistema Inventario</a>
                
                <div class="ms-auto">
                    @auth
                        <div class="dropdown">
                            <button class="btn user-dropdown" type="button" data-bs-toggle="dropdown">
                                <i class="bi bi-person-circle me-2"></i>
                                {{ Auth::user()->name }}
                                <i class="bi bi-chevron-down ms-2"></i>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li>
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
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
                            <i class="bi bi-speedometer2"></i>
                            Dashboard
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('almacenes*') ? 'active' : '' }}" 
                           href="{{ route('almacenes.index') }}">
                            <i class="bi bi-buildings"></i>
                            Almacenes
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('productos*') ? 'active' : '' }}" 
                           href="{{ route('productos.index') }}">
                            <i class="bi bi-box"></i>
                            Productos
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('movimientos.entrada') ? 'active' : '' }}" 
                           href="{{ route('movimientos.entrada') }}">
                            <i class="bi bi-box-arrow-in-down"></i>
                            Entrada
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('movimientos.salida') ? 'active' : '' }}" 
                           href="{{ route('movimientos.salida') }}">
                            <i class="bi bi-box-arrow-up"></i>
                            Salida
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('movimientos.traslado') ? 'active' : '' }}" 
                           href="{{ route('movimientos.traslado') }}">
                            <i class="bi bi-arrow-left-right"></i>
                            Traslado
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
</body>
</html>