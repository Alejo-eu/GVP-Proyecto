<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Sistema Inventario') }} - Login</title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600&family=Outfit:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
    
    <style>
        :root {
            --primary: #6366F1;
            --primary-hover: #4F46E5;
            --secondary: #EEF2FF;
            --background: #F8FAFC;
            --surface: #FFFFFF;
            --surface-variant: #E2E8F0;
            --on-surface: #0F172A;
            --on-surface-variant: #64748B;
            --error: #EF4444;
            --input-bg: #F1F5F9;
        }

        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(135deg, rgba(15, 23, 42, 0.85) 0%, rgba(30, 27, 75, 0.7) 100%), url('https://i.postimg.cc/NM4BndJh/Gaston.jpg') no-repeat center center;
            background-size: cover;
            color: var(--on-surface);
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0;
            padding: 20px;
            animation: fadeInPage 0.8s cubic-bezier(0.16, 1, 0.3, 1) forwards;
        }

        @keyframes fadeInPage {
            0% { opacity: 0; }
            100% { opacity: 1; }
        }
        
        .login-container {
            width: 100%;
            max-width: 420px;
        }
        
        .card {
            background-color: rgba(255, 255, 255, 0.92);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            border: 1px solid rgba(255, 255, 255, 0.4);
            border-radius: 24px;
            box-shadow: 0px 24px 50px rgba(0, 0, 0, 0.3), inset 0px 0px 0px 1px rgba(255,255,255,0.2);
            overflow: hidden;
            padding: 40px 32px;
        }
        
        .card-header-custom {
            text-align: center;
            margin-bottom: 32px;
        }
        
        .brand-icon {
            font-size: 48px;
            color: var(--primary);
            margin-bottom: 16px;
            display: inline-block;
            background: var(--secondary);
            width: 80px;
            height: 80px;
            line-height: 80px;
            border-radius: 999px;
        }
        
        h3 {
            font-family: 'Outfit', sans-serif;
            margin: 0 0 8px 0;
            font-weight: 700;
            font-size: 28px;
            color: var(--on-surface);
            letter-spacing: -0.02em;
        }
        
        p.subtitle {
            margin: 0;
            color: var(--on-surface-variant);
            font-size: 16px;
        }
        
        .form-group {
            margin-bottom: 24px;
            position: relative;
        }
        
        .form-label {
            display: block;
            margin-bottom: 8px;
            font-weight: 600;
            font-size: 14px;
            color: var(--on-surface);
        }
        
        .input-icon-wrapper {
            position: relative;
        }
        
        .input-icon-wrapper i {
            position: absolute;
            left: 16px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--on-surface-variant);
            font-size: 18px;
            pointer-events: none;
            transition: color 0.3s ease;
        }
        
        .form-control {
            background-color: var(--input-bg);
            border: 2px solid transparent;
            border-radius: 12px;
            height: 52px;
            padding: 12px 16px 12px 48px;
            font-size: 16px;
            font-family: 'Inter', sans-serif;
            color: var(--on-surface);
            transition: all 0.3s ease;
            width: 100%;
        }
        
        .form-control::placeholder {
            color: #8c97a1;
        }
        
        .form-control:focus {
            background-color: var(--surface);
            border-color: var(--primary);
            box-shadow: 0 0 0 4px rgba(99, 102, 241, 0.15);
            outline: none;
        }

        .form-control:focus + i {
            color: var(--primary);
        }
        
        .form-check {
            display: flex;
            align-items: center;
            margin-bottom: 32px;
        }
        
        .form-check-input {
            width: 20px;
            height: 20px;
            border-radius: 4px;
            border: 2px solid var(--surface-variant);
            background-color: var(--surface);
            margin-top: 0;
            margin-right: 12px;
            cursor: pointer;
        }
        
        .form-check-input:checked {
            background-color: var(--primary);
            border-color: var(--primary);
        }
        
        .form-check-label {
            color: var(--on-surface-variant);
            font-size: 14px;
            cursor: pointer;
        }
        
        .btn-login {
            background-color: var(--primary);
            color: white;
            border: none;
            height: 56px;
            border-radius: 12px;
            font-family: 'Outfit', sans-serif;
            font-weight: 600;
            font-size: 18px;
            width: 100%;
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
        }
        
        .btn-login:hover {
            background-color: var(--primary-hover);
            transform: translateY(-2px);
            box-shadow: 0 8px 24px rgba(99, 102, 241, 0.25);
        }
        
        .btn-login:active {
            transform: translateY(0);
        }
        
        .alert-danger {
            background-color: #ffdad6;
            color: var(--error);
            border: none;
            border-radius: 8px;
            padding: 16px;
            margin-bottom: 24px;
            font-size: 14px;
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .alert-danger i {
            font-size: 20px;
        }
        
        .invalid-feedback {
            font-size: 12px;
            margin-top: 6px;
            color: var(--error);
            display: block;
        }
        
        .loading-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100vw;
            height: 100vh;
            background: rgba(15, 23, 42, 0.9);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            z-index: 9999;
            display: flex;
            align-items: center;
            justify-content: center;
            opacity: 0;
            visibility: hidden;
            transition: all 0.4s ease;
        }

        .loading-overlay.active {
            opacity: 1;
            visibility: visible;
        }

        .loader-content {
            text-align: center;
            transform: translateY(20px);
            transition: all 0.4s ease;
        }

        .loading-overlay.active .loader-content {
            transform: translateY(0);
        }

        .spinner-custom {
            width: 50px;
            height: 50px;
            border: 4px solid rgba(255, 255, 255, 0.1);
            border-left-color: var(--primary);
            border-radius: 50%;
            animation: spin 1s linear infinite;
            margin: 0 auto 16px;
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
    </style>
</head>
<body>
    <!-- Loading Overlay -->
    <div id="loading-overlay" class="loading-overlay">
        <div class="loader-content">
            <div class="spinner-custom"></div>
            <h4 style="color: white; font-family: 'Outfit', sans-serif; margin: 0 0 8px 0; font-size: 24px;">Autenticando...</h4>
            <p style="color: rgba(255,255,255,0.7); margin: 0; font-size: 15px;">Preparando tu espacio de trabajo</p>
        </div>
    </div>

    <div class="login-container">
        <div class="card">
            <div class="card-header-custom">
                <img src="https://gastonvidalporturas.edu.pe/wp-content/uploads/2024/06/Logo-colegio-gaston-vidal.png" alt="Logo Colegio Gastón Vidal" style="height: 90px; width: auto; border-radius: 12px; margin-bottom: 20px; box-shadow: 0 4px 12px rgba(0,0,0,0.08);">
                <h3>Recursos Educativos</h3>
                <p class="subtitle">Gestión de Inventario Escolar</p>
            </div>
            
            <div class="card-body-custom">
                @if($errors->any())
                    <div class="alert alert-danger">
                        <i class="bi bi-exclamation-octagon-fill"></i>
                        <div>{{ $errors->first() }}</div>
                    </div>
                @endif
                
                <form id="login-form" method="POST" action="{{ route('login') }}">
                    @csrf
                    
                    <div class="form-group">
                        <label class="form-label" for="email">Correo Electrónico</label>
                        <div class="input-icon-wrapper">
                            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" 
                                   name="email" value="{{ old('email') }}" required autocomplete="email" 
                                   placeholder="tu@escuela.edu" autofocus>
                            <i class="bi bi-envelope"></i>
                        </div>
                        @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label" for="password">Contraseña</label>
                        <div class="input-icon-wrapper">
                            <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" 
                                   name="password" required autocomplete="current-password" 
                                   placeholder="Ingresa tu contraseña">
                            <i class="bi bi-lock"></i>
                        </div>
                        @error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                        <label class="form-check-label" for="remember">
                            Mantener sesión iniciada
                        </label>
                    </div>
                    
                    <button type="submit" class="btn-login">
                        Ingresar
                        <i class="bi bi-arrow-right"></i>
                    </button>
                </form>
            </div>
        </div>
    </div>

    <script>
        document.getElementById('login-form').addEventListener('submit', function(e) {
            // Check HTML5 validity before showing loader
            if (this.checkValidity()) {
                document.getElementById('loading-overlay').classList.add('active');
                
                // Disable button to prevent double clicks (visually)
                const btn = document.querySelector('.btn-login');
                btn.style.opacity = '0.7';
                btn.style.pointerEvents = 'none';
            }
        });
    </script>
</body>
</html>
