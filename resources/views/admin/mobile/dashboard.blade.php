@extends('layouts.mobile.base')

@section('title', 'Panel de Administración')

@section('content')
<style>
    .admin-mobile-dashboard {
        max-width: 430px;
        margin: 1.5rem auto 1.5rem auto;
        background: #fff;
        border-radius: 1.1rem;
        box-shadow: 0 2px 10px 0 rgba(31,38,135,0.13);
        padding: 1.6rem 1.1rem 1.3rem 1.1rem;
        box-sizing: border-box;
        width: 100%;
    }
    .admin-mobile-dashboard-title {
        text-align: center;
        font-size: 1.22rem;
        font-weight: 800;
        color: #2563eb;
        margin-bottom: 1.2rem;
        letter-spacing: -0.5px;
    }
    .admin-mobile-dashboard-stats {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 1.1em;
        margin-bottom: 1.5em;
    }
    .admin-mobile-dashboard-stat {
        background: #f1f5f9;
        border-radius: 0.8em;
        box-shadow: 0 1px 4px rgba(31,38,135,0.09);
        padding: 1em 0.7em;
        text-align: center;
        display: flex;
        flex-direction: column;
        align-items: center;
    }
    .admin-mobile-dashboard-stat-icon {
        border-radius: 50%;
        width: 2.4em;
        height: 2.4em;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 0.5em;
        font-size: 1.3em;
        color: #fff;
    }
    .admin-mobile-dashboard-stat-users { background: #2563eb; }
    .admin-mobile-dashboard-stat-auctions { background: #16a34a; }
    .admin-mobile-dashboard-stat-revenue { background: #0891b2; }
    .admin-mobile-dashboard-stat-bids { background: #f59e0b; }
    .admin-mobile-dashboard-stat-label {
        font-size: 0.92em;
        color: #64748b;
        margin-bottom: 0.1em;
    }
    .admin-mobile-dashboard-stat-value {
        font-size: 1.13em;
        font-weight: 700;
        color: #1e293b;
    }
    .admin-mobile-dashboard-link {
        display: block;
        width: 100%;
        padding: 0.8em 0;
        background: #2563eb;
        color: #fff;
        border-radius: 0.7em;
        text-align: center;
        font-weight: 700;
        text-decoration: none;
        margin-bottom: 1.5em;
        box-shadow: 0 1px 4px rgba(31,38,135,0.09);
        transition: background 0.18s;
    }
    .admin-mobile-dashboard-link:active, .admin-mobile-dashboard-link:focus {
        background: #1d4ed8;
    }
    .admin-mobile-dashboard-section-title {
        font-size: 1.04em;
        font-weight: 700;
        color: #2563eb;
        margin-bottom: 0.7em;
        margin-top: 1.5em;
    }
    .admin-mobile-dashboard-list {
        display: flex;
        flex-direction: column;
        gap: 0.7em;
    }
    .admin-mobile-dashboard-list-item {
        background: #fff;
        border-radius: 0.7em;
        box-shadow: 0 1px 4px rgba(31,38,135,0.08);
        padding: 0.8em 0.9em;
        display: flex;
        flex-direction: column;
        font-size: 0.97em;
    }
    .admin-mobile-dashboard-list-item-title {
        font-weight: 600;
        color: #2563eb;
        margin-bottom: 0.1em;
    }
    .admin-mobile-dashboard-list-item-meta {
        font-size: 0.93em;
        color: #64748b;
        margin-bottom: 0.1em;
    }
    .admin-mobile-dashboard-list-item-link {
        color: #2563eb;
        font-size: 0.92em;
        text-decoration: underline;
        margin-top: 0.2em;
    }
    .admin-mobile-dashboard-bid-user {
        display: flex;
        align-items: center;
        gap: 0.5em;
        font-weight: 600;
        color: #0891b2;
    }
    .admin-mobile-dashboard-bid-avatar {
        width: 28px;
        height: 28px;
        border-radius: 50%;
        object-fit: cover;
        border: 1px solid #e2e8f0;
    }
    .admin-mobile-dashboard-footer {
        margin-top: 2em;
        text-align: center;
        color: #94a3b8;
        font-size: 0.93em;
    }
</style>
<div class="admin-mobile-dashboard">
    <div class="admin-mobile-dashboard-title">Panel de Administración</div>
    <div class="admin-mobile-dashboard-stats">
        <div class="admin-mobile-dashboard-stat">
            <div class="admin-mobile-dashboard-stat-icon admin-mobile-dashboard-stat-users"><i class="fas fa-users"></i></div>
            <div class="admin-mobile-dashboard-stat-label">Usuarios</div>
            <div class="admin-mobile-dashboard-stat-value">{{ $totalUsers }}</div>
        </div>
        <div class="admin-mobile-dashboard-stat">
            <div class="admin-mobile-dashboard-stat-icon admin-mobile-dashboard-stat-auctions"><i class="fas fa-gavel"></i></div>
            <div class="admin-mobile-dashboard-stat-label">Subastas activas</div>
            <div class="admin-mobile-dashboard-stat-value">{{ $activeAuctions }}</div>
        </div>
        <div class="admin-mobile-dashboard-stat">
            <div class="admin-mobile-dashboard-stat-icon admin-mobile-dashboard-stat-revenue"><i class="fas fa-money-bill-wave"></i></div>
            <div class="admin-mobile-dashboard-stat-label">Ingresos</div>
            <div class="admin-mobile-dashboard-stat-value">${{ number_format($totalRevenue, 2) }}</div>
        </div>
        <div class="admin-mobile-dashboard-stat">
            <div class="admin-mobile-dashboard-stat-icon admin-mobile-dashboard-stat-bids"><i class="fas fa-gavel"></i></div>
            <div class="admin-mobile-dashboard-stat-label">Total pujas</div>
            <div class="admin-mobile-dashboard-stat-value">{{ $totalBids }}</div>
        </div>
    </div>
    <a href="{{ route('admin.mobile.users') }}" class="admin-mobile-dashboard-link">
        <i class="fas fa-users" style="margin-right:0.5em;"></i>Gestionar Usuarios
    </a>

    <div class="admin-mobile-dashboard-section-title">Últimas subastas</div>
    <div class="admin-mobile-dashboard-list">
        @foreach($latestAuctions as $auction)
            <div class="admin-mobile-dashboard-list-item">
                <div class="admin-mobile-dashboard-list-item-title">{{ $auction->title }}</div>
                <div class="admin-mobile-dashboard-list-item-meta">${{ number_format($auction->starting_price, 2) }} | {{ $auction->status }}</div>
                <a href="{{ route('auctions.mobile.show', $auction->id) }}" class="admin-mobile-dashboard-list-item-link">Ver</a>
            </div>
        @endforeach
    </div>

    <div class="admin-mobile-dashboard-section-title">Últimas pujas</div>
    <div class="admin-mobile-dashboard-list">
        @foreach($latestBids as $bid)
            <div class="admin-mobile-dashboard-list-item">
                <div class="admin-mobile-dashboard-bid-user">
                    @php
                        $hasCustomPhoto = false;
                        $photoUrl = null;
                        // 1. Foto personalizada subida en mobile (profile_photo en storage)
                        if (!empty($bid->user->profile_photo) && file_exists(public_path('storage/' . $bid->user->profile_photo))) {
                            $hasCustomPhoto = true;
                            $photoUrl = asset('storage/' . $bid->user->profile_photo);
                        }
                        // 2. Foto Jetstream (profile_photo_path)
                        elseif (!empty($bid->user->profile_photo_path)) {
                            $hasCustomPhoto = true;
                            $photoUrl = $bid->user->profile_photo_url;
                        }
                        $initial = strtoupper(mb_substr($bid->user->name, 0, 1));
                    @endphp
                    @if($hasCustomPhoto)
                        <img src="{{ $photoUrl }}" class="admin-mobile-dashboard-bid-avatar" alt="{{ $bid->user->name }}">
                    @else
                        <span style="display:flex;justify-content:center;align-items:center;width:28px;height:28px;border-radius:50%;background:#e0e7ef;color:#2563eb;font-weight:700;font-size:1em;border:1px solid #e2e8f0;">{{ $initial }}</span>
                    @endif
                    {{ $bid->user->name }}
                    <span style="font-weight:400;color:#64748b;font-size:0.95em;">${{ number_format($bid->amount, 2) }}</span>
                </div>
                <div class="admin-mobile-dashboard-list-item-meta">{{ $bid->auction->title }}</div>
                <div class="admin-mobile-dashboard-list-item-meta">{{ $bid->created_at->diffForHumans() }}</div>
            </div>
        @endforeach
    </div>
    <div class="admin-mobile-dashboard-footer">&copy; {{ date('Y') }} {{ config('app.name', 'Laravel') }}</div>
</div>
@endsection
