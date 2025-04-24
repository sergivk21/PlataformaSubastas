@extends('layouts.mobile.base')

@section('content')
<div class="home-mobile-bg" style="min-height:100vh;display:flex;align-items:center;justify-content:center;background:linear-gradient(135deg,#f1f5f9 0%,#e0e7ef 100%);">
    <div class="home-mobile-card" style="width:95vw;max-width:400px;background:white;border-radius:1.2rem;box-shadow:0 4px 16px 0 rgba(31,38,135,0.12);padding:2.2rem 1.2rem;text-align:center;">
        <h1 style="font-size:2rem;font-weight:800;color:#2563eb;margin-bottom:1.1rem;">Bienvenido a la Plataforma</h1>
        <p style="font-size:1.07rem;color:#334155;margin-bottom:1.5rem;">Gestiona, puja y vende artículos fácilmente desde tu móvil. Accede a las subastas, tu perfil o publica nuevos artículos.</p>
        <a href="{{ route('auctions.mobile.index') }}" class="profile-mobile-main-btn profile-mobile-btn" style="padding:0.7rem 1.7rem;font-size:1.07rem;border-radius:0.7rem;background:#2563eb;color:white;font-weight:bold;">Ver Subastas</a>
    </div>
</div>
@endsection
