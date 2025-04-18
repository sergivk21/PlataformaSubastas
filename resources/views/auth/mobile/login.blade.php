@php($hideMobileMenu = true)
@extends('layouts.mobile.base')

@section('content')
<style>
    .login-mobile-wrapper {
        width: 100vw;
        min-height: 100vh;
        background: linear-gradient(135deg, #f3f4f6 0%, #e0e7ef 100%);
        display: flex;
        justify-content: center;
        align-items: center;
        padding: 0;
        margin: 0;
    }
    .login-mobile-card {
        background: #fff;
        border-radius: 1.5rem;
        box-shadow: 0 8px 32px 0 rgba(31, 38, 135, 0.15);
        padding: 2.5rem 1.5rem 2rem 1.5rem;
        max-width: 95vw;
        width: 370px;
        display: flex;
        flex-direction: column;
        align-items: center;
    }
    .login-mobile-header h1 {
        font-size: 2.1rem;
        font-weight: bold;
        color: #1e293b;
        margin-bottom: 0.3rem;
        letter-spacing: -1px;
    }
    .login-mobile-header h2 {
        font-size: 1.1rem;
        font-weight: 500;
        color: #1e293b;
        margin-bottom: 0.35rem;
    }
    .login-mobile-header p {
        color: #64748b;
        font-size: 0.98rem;
        margin-bottom: 0.2rem;
    }
    .login-mobile-label {
        font-size: 0.97rem;
        color: #334155;
        font-weight: 500;
        margin-bottom: 0.25rem;
    }
    .login-mobile-input {
        width: 100%;
        box-sizing: border-box;
        padding: 0.75rem 1rem;
        border-radius: 0.7rem;
        border: 1.5px solid #cbd5e1;
        font-size: 1rem;
        margin-bottom: 0.7rem;
        outline: none;
        transition: border 0.2s;
        background: #f8fafc;
        color: #1e293b;
        display: block;
    }
    .login-mobile-input:focus {
        border: 1.5px solid #2563eb;
        background: #fff;
    }
    .login-mobile-actions {
        width: 100%;
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 0.8rem;
    }
    .login-mobile-checkbox {
        margin-right: 0.45rem;
    }
    .login-mobile-link {
        color: #2563eb;
        text-decoration: none;
        font-size: 0.97rem;
        transition: text-decoration 0.2s;
    }
    .login-mobile-link:hover {
        text-decoration: underline;
    }
    .login-mobile-btn {
        width: 100%;
        background-color: #2563eb;
        color: white;
        font-weight: bold;
        padding: 0.75rem;
        border-radius: 0.7rem;
        box-shadow: 0 2px 4px rgba(0,0,0,0.08);
        font-size: 1.07rem;
        margin-top: 0.5rem;
        margin-bottom: 0.5rem;
        border: none;
        transition: background 0.2s;
        cursor: pointer;
    }
    .login-mobile-btn:hover {
        background-color: #1d4ed8;
    }
    .login-mobile-register {
        color: #64748b;
        font-size: 0.97rem;
        margin-top: 0.7rem;
    }
    .login-mobile-register a {
        color: #2563eb;
        text-decoration: none;
        font-weight: 500;
    }
    .login-mobile-register a:hover {
        text-decoration: underline;
    }
    .login-mobile-alert {
        width: 100%;
        border-radius: 0.6rem;
        padding: 0.7rem 1rem;
        margin-bottom: 0.7rem;
        font-size: 0.95rem;
        text-align: center;
    }
    .login-mobile-alert-success {
        background: #e6f9ed;
        color: #15803d;
        border: 1px solid #16a34a44;
    }
    .login-mobile-alert-error {
        background: #fee2e2;
        color: #dc2626;
        border: 1px solid #dc262644;
    }
</style>
<div class="login-mobile-wrapper">
    <div class="login-mobile-card">
        <div class="login-mobile-header" style="text-align:center;margin-bottom:1.5rem;">
            <a href="{{ route('home') }}" style="display:block;margin-bottom:0.5rem;text-decoration:none;">
                <h1>Subastas</h1>
            </a>
            <h2>Bienvenido de nuevo</h2>
            <p>Por favor, inicia sesión para continuar</p>
        </div>
        <form method="POST" action="{{ route('login') }}" style="width:100%;display:flex;flex-direction:column;align-items:center;">
            @csrf
            @if (session('status'))
                <div class="login-mobile-alert login-mobile-alert-success">
                    <span>{{ session('status') }}</span>
                </div>
            @endif
            @if ($errors->any())
                <div class="login-mobile-alert login-mobile-alert-error">
                    <ul style="margin:0;padding-left:1.2em;text-align:left;">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <div style="width:100%;box-sizing:border-box;">
                <label for="email" class="login-mobile-label">Correo electrónico</label>
                <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="email" class="login-mobile-input">
            </div>
            <div style="width:100%;box-sizing:border-box;">
                <label for="password" class="login-mobile-label">Contraseña</label>
                <input id="password" type="password" name="password" required autocomplete="current-password" class="login-mobile-input">
            </div>
            <div class="login-mobile-actions">
                <div style="display:flex;align-items:center;">
                    <input type="checkbox" id="remember_me" name="remember" class="login-mobile-checkbox">
                    <label for="remember_me" style="font-size:0.95rem;color:#334155;">Mantener sesión iniciada</label>
                </div>
                <a href="{{ route('password.request') }}" class="login-mobile-link">¿Olvidaste tu contraseña?</a>
            </div>
            <button type="submit" class="login-mobile-btn">Iniciar Sesión</button>
            <div class="login-mobile-register">
                ¿No tienes cuenta?
                <a href="{{ route('register') }}">Regístrate aquí</a>
            </div>
        </form>
    </div>
</div>
@endsection
