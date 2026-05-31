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
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@600;700&family=Source+Sans+3:wght@400;600&display=swap" rel="stylesheet">
    
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
    
    <style>
        :root {
            --primary: #2a6f97;
            --primary-hover: #1a4f6d;
            --secondary: #a9d6e5;
            --background: #f8f9fa;
            --surface: #ffffff;
            --surface-variant: #e1e3e4;
            --on-surface: #191c1d;
            --on-surface-variant: #40484e;
            --error: #ba1a1a;
            --input-bg: #f1f3f5;
        }

        body {
            font-family: 'Source Sans 3', sans-serif;
            background-color: var(--background);
            color: var(--on-surface);
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0;
            padding: 20px;
        }
        
        .login-container {
            width: 100%;
            max-width: 420px;
        }
        
        .card {
            background-color: var(--surface);
            border: none;
            border-radius: 24px;
            box-shadow: 0px 12px 40px rgba(42, 111, 151, 0.12);
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
            font-family: 'Manrope', sans-serif;
            margin: 0 0 8px 0;
            font-weight: 700;
            font-size: 28px;
            color: var(--on-surface);
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
            border-radius: 8px;
            height: 52px;
            padding: 12px 16px 12px 48px;
            font-size: 16px;
            font-family: 'Source Sans 3', sans-serif;
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
            box-shadow: 0 0 0 4px rgba(42, 111, 151, 0.1);
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
            font-family: 'Manrope', sans-serif;
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
            box-shadow: 0 8px 24px rgba(42, 111, 151, 0.25);
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
    </style>
</head>
<body>
    <div class="login-container">
        <div class="card">
            <div class="card-header-custom">
                <div class="brand-icon">
                    <i class="bi bi-book"></i>
                </div>
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
                
                <form method="POST" action="{{ route('login') }}">
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
</body>
</html>
