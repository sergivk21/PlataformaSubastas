@extends('layouts.app')

@section('content')
<div class="home-desktop-wrapper" style="min-height:80vh;display:flex;align-items:center;justify-content:center;background:linear-gradient(135deg,#f3f4f6 0%,#e0e7ef 100%);">
    <div style="max-width:700px;width:100%;background:white;border-radius:1.5rem;box-shadow:0 8px 32px 0 rgba(31,38,135,0.12);padding:3rem 2rem;text-align:center;">
        <h1 style="font-size:2.5rem;font-weight:800;color:#2563eb;margin-bottom:1.2rem;">Bienvenido a la Plataforma de Subastas</h1>
        <p style="font-size:1.2rem;color:#334155;margin-bottom:2rem;">Gestiona, puja y vende artículos de forma segura y sencilla. Explora las subastas activas, revisa tu perfil o publica tus propios artículos.</p>
        <a href="{{ route('auctions.index') }}" class="btn btn-primary" style="padding:0.8rem 2.2rem;font-size:1.1rem;border-radius:0.7rem;background:#2563eb;color:white;font-weight:bold;">Ver Subastas</a>
    </div>
</div>
@endsection
