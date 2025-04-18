@extends('layouts.login')

@section('content')
<div style="min-height: 100vh; display: flex; align-items: center; justify-content: center; background-color: #f3f4f6; padding: 2rem;">
    <div style="max-width: 400px; width: 100%;">
        <div style="background-color: white; border-radius: 1rem; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1); padding: 2rem;">
            <div style="text-align: center; margin-bottom: 2rem;">
                <a href='{{ route('home') }}' style="display: block; margin-bottom: 1rem;">
                    <h1 style="font-size: 2rem; font-weight: 700; color: #1e293b;">Subastas</h1>
                </a>
                <h2 style="font-size: 1.5rem; font-weight: 600; color: #1e293b; margin-bottom: 0.5rem;">Recuperar contraseña</h2>
                <p style="color: #64748b;">Ingresa tu correo electrónico para recibir el enlace de recuperación</p>
            </div>
            @if (session('status'))
                <div style="background-color: #dcfce7; padding: 1rem; border-radius: 0.5rem;">
                    <p style="color: #16a34a; font-size: 0.875rem;">{{ session('status') }}</p>
                </div>
            @endif
            @if ($errors->any())
                <div style="background-color: #fee2e2; padding: 1rem; border-radius: 0.5rem;">
                    <p style="color: #dc2626; font-size: 0.875rem;">{{ $errors->first() }}</p>
                </div>
            @endif
            <form method="POST" action="{{ route('password.email') }}" style="display: flex; flex-direction: column; gap: 1.5rem;">
                @csrf
                <div style="margin-bottom: 1rem;">
                    <label for="email" style="display: block; margin-bottom: 0.5rem; color: #1e293b; font-size: 0.875rem;">Correo electrónico</label>
                    <input type="email" name="email" id="email" required autofocus autocomplete="email"
                        value="{{ old('email') }}"
                        style="width: 100%; padding: 0.75rem; border: 1px solid #e2e8f0; border-radius: 0.5rem; font-size: 0.875rem; color: #1e293b;">
                </div>
                <button type="submit" 
                    style="width: 100%; padding: 1rem; background-color: #2563eb; color: white; border: none; border-radius: 0.5rem; font-size: 1rem; cursor: pointer; transition: all 0.2s ease;">
                    Enviar enlace
                </button>
                <div style="text-align: center; margin-top: 1rem;">
                    <p style="color: #64748b; font-size: 0.875rem;">
                        <a href="{{ route('login') }}" style="color: #2563eb; text-decoration: none;">Volver a iniciar sesión</a>
                    </p>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
