@extends('layouts.mobile.base')

@section('content')
<style>
    .auth-mobile-wrapper {
        width: 100vw;
        min-height: 100vh;
        background: linear-gradient(135deg, #f3f4f6 0%, #e0e7ef 100%);
        display: flex;
        justify-content: center;
        align-items: center;
        padding: 0;
        margin: 0;
    }
    .auth-mobile-card {
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
    .auth-mobile-header h2 {
        font-size: 1.7rem;
        font-weight: bold;
        color: #2563eb;
        margin-bottom: 1.2rem;
        text-align: center;
    }
    .auth-mobile-label {
        font-size: 0.97rem;
        color: #334155;
        font-weight: 500;
        margin-bottom: 0.25rem;
    }
    .auth-mobile-input {
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
    .auth-mobile-input:focus {
        border: 1.5px solid #2563eb;
        background: #fff;
    }
    .auth-mobile-btn {
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
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.5rem;
    }
    .auth-mobile-btn:hover {
        background-color: #1d4ed8;
    }
    .auth-mobile-link {
        color: #2563eb;
        text-decoration: none;
        font-size: 0.97rem;
        transition: text-decoration 0.2s;
    }
    .auth-mobile-link:hover {
        text-decoration: underline;
    }
    .auth-mobile-alert {
        width: 100%;
        border-radius: 0.6rem;
        padding: 0.7rem 1rem;
        margin-bottom: 0.7rem;
        font-size: 0.95rem;
        text-align: center;
    }
    .auth-mobile-alert-success {
        background: #e6f9ed;
        color: #15803d;
        border: 1px solid #16a34a44;
    }
    .auth-mobile-alert-error {
        background: #fee2e2;
        color: #dc2626;
        border: 1px solid #dc262644;
    }
</style>
<div class="auth-mobile-wrapper">
    <div class="auth-mobile-card">
        <div class="auth-mobile-header">
            <h2>Recuperar contraseña</h2>
        </div>
        @if (session('status'))
            <div class="auth-mobile-alert auth-mobile-alert-success">
                <span>{{ session('status') }}</span>
            </div>
        @endif
        @if ($errors->any())
            <div class="auth-mobile-alert auth-mobile-alert-error">
                <span>{{ $errors->first() }}</span>
            </div>
        @endif
        <form method="POST" action="{{ route('password.email') }}" style="width:100%;display:flex;flex-direction:column;align-items:center;">
            @csrf
            <div style="width:100%;box-sizing:border-box;">
                <label for="email" class="auth-mobile-label">Correo electrónico</label>
                <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="email" class="auth-mobile-input">
            </div>
            <button type="submit" class="auth-mobile-btn">
                <i class="fas fa-envelope"></i> Enviar enlace
            </button>
        </form>
        <div style="margin-top:1.2rem;text-align:center;">
            <a href="{{ route('login') }}" class="auth-mobile-link">Volver a iniciar sesión</a>
        </div>
    </div>
</div>
@endsection
