<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Sistema Inventario') }} - Login</title>
    
    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Poppins:300,400,500,600,700" rel="stylesheet">
    
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
    
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0;
            padding: 0;
        }
        
        .login-container {
            width: 100%;
            max-width: 400px;
            padding: 20px;
        }
        
        .card {
            border: none;
            border-radius: 15px;
            box-shadow: 0 10px 40px rgba(0,0,0,0.2);
            overflow: hidden;
        }
        
        .card-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            text-align: center;
            padding: 30px 20px;
            border: none;
        }
        
        .card-header h3 {
            margin: 0;
            font-weight: 600;
            font-size: 24px;
        }
        
        .card-header p {
            margin: 10px 0 0;
            opacity: 0.9;
            font-size: 14px;
        }
        
        .card-body {
            padding: 40px 30px;
            background: white;
        }
        
        .form-group {
            margin-bottom: 25px;
            position: relative;
        }
        
        .form-group i {
            position: absolute;
            left: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: #999;
            font-size: 18px;
        }
        
        .form-control {
            height: 50px;
            padding: 10px 15px 10px 45px;
            border: 2px solid #e0e0e0;
            border-radius: 10px;
            font-size: 14px;
            transition: all 0.3s ease;
        }
        
        .form-control:focus {
            border-color: #667eea;
            box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
        }
        
        .form-check {
            margin-bottom: 25px;
        }
        
        .form-check-label {
            color: #666;
            font-size: 14px;
        }
        
        .btn-login {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border: none;
            height: 50px;
            border-radius: 10px;
            color: white;
            font-weight: 600;
            font-size: 16px;
            text-transform: uppercase;
            letter-spacing: 1px;
            width: 100%;
            cursor: pointer;
            transition: transform 0.3s ease;
        }
        
        .btn-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 20px rgba(102, 126, 234, 0.4);
        }
        
        .btn-login:active {
            transform: translateY(0);
        }
        
        .alert-danger {
            border-radius: 10px;
            border: none;
            background: #fee;
            color: #c33;
            padding: 15px;
            margin-bottom: 25px;
            font-size: 14px;
        }
        
        .invalid-feedback {
            font-size: 12px;
            margin-top: 5px;
            color: #dc3545;
        }
        
        .footer-links {
            text-align: center;
            margin-top: 25px;
        }
        
        .footer-links a {
            color: #666;
            text-decoration: none;
            font-size: 13px;
            transition: color 0.3s ease;
        }
        
        .footer-links a:hover {
            color: #667eea;
        }
        
        .brand-icon {
            font-size: 50px;
            color: white;
            margin-bottom: 15px;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <div class="card">
            <div class="card-header">
                <i class="bi bi-box-seam brand-icon"></i>
                <h3>Sistema de Inventario</h3>
                <p>Ingresa con tus credenciales</p>
            </div>
            
            <div class="card-body">
                @if($errors->any())
                    <div class="alert alert-danger">
                        <i class="bi bi-exclamation-triangle-fill me-2"></i>
                        {{ $errors->first() }}
                    </div>
                @endif
                
                <form method="POST" action="{{ route('login') }}">
                    @csrf
                    
                    <div class="form-group">
                        <i class="bi bi-envelope"></i>
                        <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" 
                               name="email" value="{{ old('email') }}" required autocomplete="email" 
                               placeholder="Correo electrónico" autofocus>
                        @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    
                    <div class="form-group">
                        <i class="bi bi-lock"></i>
                        <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" 
                               name="password" required autocomplete="current-password" 
                               placeholder="Contraseña">
                        @error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                        <label class="form-check-label" for="remember">
                            Recordarme
                        </label>
                    </div>
                    
                    <button type="submit" class="btn-login">
                        <i class="bi bi-box-arrow-in-right me-2"></i>
                        Ingresar
                    </button>
                    
                    <!-- 
                    <div class="footer-links">
                        @if (Route::has('password.request'))
                            <a href="{{ route('password.request') }}">
                                <i class="bi bi-question-circle me-1"></i>
                                ¿Olvidaste tu contraseña?
                            </a>
                        @endif
                    </div>
                    -->
                </form>
            </div>
        </div>
    </div>
</body>
</html>