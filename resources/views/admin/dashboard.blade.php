@extends('layouts.base')

@section('title', 'Panel de Administración')

@section('content')
<style>
    .admin-mobile-bg {
        min-height: 100vh;
        background: #f1f5f9 !important;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: flex-start;
    }
    .admin-mobile-card {
        max-width: 820px;
        margin: 2.2rem auto 2.2rem auto;
        background: #fff;
        border-radius: 1.2rem;
        box-shadow: 0 4px 16px 0 rgba(31,38,135,0.12);
        padding: 2.1rem 2.5rem 1.7rem 2.5rem;
        box-sizing: border-box;
        width: 100%;
        display: flex;
        flex-direction: column;
        align-items: center;
    }
    .admin-mobile-title {
        text-align: center;
        font-size: 1.6rem;
        font-weight: 900;
        color: #2563eb;
        margin-bottom: 1.5rem;
        letter-spacing: -1px;
    }
    .admin-mobile-avatar {
        width: 84px;
        height: 84px;
        border-radius: 50%;
        background: linear-gradient(135deg, #2563eb 60%, #1e40af 100%);
        color: #fff;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 2.6rem;
        font-weight: 800;
        border: 3px solid #2563eb;
        box-shadow: 0 2px 8px 0 rgba(37,99,235,0.13);
        margin-bottom: 1.1rem;
    }
    .admin-mobile-section-title {
        font-size: 1.08em;
        font-weight: 700;
        color: #64748b;
        margin-bottom: 0.6em;
        text-align: center;
    }
    .admin-mobile-stat {
        background: #f1f5f9;
        border-radius: 0.7em;
        padding: 1.2em 0.8em;
        margin-bottom: 1.2em;
        width: 100%;
        display: flex;
        flex-direction: column;
        align-items: center;
    }
    .admin-mobile-stat-label {
        font-size: 1.08em;
        color: #2563eb;
        font-weight: 700;
        margin-bottom: 0.1em;
    }
    .admin-mobile-stat-value {
        font-size: 2.1em;
        font-weight: 900;
        color: #1e293b;
    }
    .admin-mobile-btn {
        background: linear-gradient(90deg,#2563eb 0%,#1e40af 100%);
        color: #fff;
        font-weight: 700;
        padding: 0.8em 2.2em;
        font-size: 1.1em;
        border-radius: 0.9em;
        box-shadow: 0 2px 8px rgba(37,99,235,0.13);
        display: inline-flex;
        align-items: center;
        gap: 0.7em;
        text-decoration: none;
        border: none;
        margin-bottom: 1.4em;
        transition: background 0.2s;
        width: 100%;
        justify-content: center;
        cursor: pointer;
    }
    .admin-mobile-btn:active, .admin-mobile-btn:hover {
        background: linear-gradient(90deg,#1e40af 0%,#2563eb 100%);
    }
    .admin-mobile-table {
        width: 100%;
        border-collapse: separate;
        border-spacing: 0 0.4em;
        background: none;
    }
    .admin-mobile-table th {
        background: #f1f5f9;
        color: #2563eb;
        font-size: 1em;
        font-weight: 700;
        border: none;
        padding: 0.7em 1em;
        text-align: left;
        border-radius: 0.7em 0.7em 0 0;
    }
    .admin-mobile-table td {
        background: #fff;
        font-size: 1em;
        color: #1e293b;
        border: none;
        padding: 0.7em 1em;
        border-radius: 0.7em;
        vertical-align: middle;
    }
    .admin-mobile-badge {
        display: inline-block;
        padding: 0.32em 0.85em;
        border-radius: 1.2em;
        font-size: 0.98em;
        font-weight: 700;
        margin-right: 0.2em;
    }
    .bg-cyan-100 { background: #cffafe !important; }
    .text-cyan-800 { color: #155e75 !important; }
    .bg-green-100 { background: #bbf7d0 !important; }
    .text-green-800 { color: #166534 !important; }
    .bg-gray-100 { background: #f3f4f6 !important; }
    .text-gray-800 { color: #1e293b !important; }
    .admin-mobile-avatar-img {
        width: 32px;
        height: 32px;
        border-radius: 50%;
        object-fit: cover;
        box-shadow: 0 2px 8px 0 rgba(37,99,235,0.10);
        margin-right: 0.3em;
    }
    @media (max-width: 900px) {
        .admin-mobile-card { max-width: 98vw; padding: 1.2rem 0.5rem; }
    }
</style>
<div class="admin-mobile-bg">
    <div class="admin-mobile-card">
        <div class="admin-mobile-avatar"><i class="fas fa-cogs"></i></div>
        <div class="admin-mobile-title">Panel de Administración</div>
        <a href="{{ route('admin.users') }}" class="admin-mobile-btn"><i class="fas fa-users"></i> Usuarios</a>
        <div class="admin-mobile-section-title">Estadísticas</div>
        <div class="admin-mobile-stat">
            <span class="admin-mobile-stat-label">Usuarios Totales</span>
            <span class="admin-mobile-stat-value">{{ $totalUsers }}</span>
        </div>
        <div class="admin-mobile-stat">
            <span class="admin-mobile-stat-label">Subastas Activas</span>
            <span class="admin-mobile-stat-value">{{ $activeAuctions }}</span>
        </div>
        <div class="admin-mobile-stat">
            <span class="admin-mobile-stat-label">Total Pujas</span>
            <span class="admin-mobile-stat-value">{{ $totalBids }}</span>
        </div>
        <div class="admin-mobile-stat">
            <span class="admin-mobile-stat-label">Subastas Finalizadas</span>
            <span class="admin-mobile-stat-value">{{ $finishedAuctions }}</span>
        </div>
        <div class="admin-mobile-section-title" style="margin-top:2em;">Últimas Subastas</div>
        <div style="width:100%;margin-bottom:2em;">
            <div class="table-responsive">
                <table class="admin-mobile-table">
                    <thead>
                        <tr>
                            <th>Nombre</th>
                            <th>Precio Inicial</th>
                            <th>Estado</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($latestAuctions as $auction)
                            <tr>
                                <td>{{ $auction->title }}</td>
                                <td><span class="admin-mobile-badge bg-cyan-100 text-cyan-800">${{ number_format($auction->starting_price, 2) }}</span></td>
                                <td>
                                    @if($auction->is_active)
                                        <span class="admin-mobile-badge bg-green-100 text-green-800">Activa</span>
                                    @else
                                        <span class="admin-mobile-badge bg-gray-100 text-gray-800">Finalizada</span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <div class="admin-mobile-section-title">Últimas Pujas</div>
        <div style="width:100%;">
            <div class="table-responsive">
                <table class="admin-mobile-table">
                    <thead>
                        <tr>
                            <th>Usuario</th>
                            <th>Subasta</th>
                            <th>Cantidad</th>
                            <th>Fecha</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($latestBids as $bid)
                            <tr>
                                <td style="display:flex;align-items:center;gap:0.6em;">
                                    @php
                                        $photo = $bid->user->profile_photo_url;
                                        if(empty($photo) && !empty($bid->user->profile_photo)) {
                                            $photo = asset('storage/' . $bid->user->profile_photo);
                                        }
                                        $name = $bid->user->name;
                                        $initial = strtoupper(mb_substr($name, 0, 1));
                                    @endphp
                                    @if($photo)
                                        <img src="{{ $photo }}" class="admin-mobile-avatar-img" alt="avatar">
                                    @else
                                        <div style="width:32px;height:32px;border-radius:50%;background:linear-gradient(135deg,#2563eb 60%,#1e40af 100%);color:#fff;display:flex;align-items:center;justify-content:center;font-size:1.1rem;font-weight:800;box-shadow:0 2px 8px 0 rgba(37,99,235,0.10);margin-right:0.3em;">{{ $initial }}</div>
                                    @endif
                                    {{ $name }}
                                </td>
                                <td>{{ $bid->auction->title }}</td>
                                <td><span class="admin-mobile-badge bg-green-100 text-green-800">${{ number_format($bid->amount, 2) }}</span></td>
                                <td>{{ $bid->created_at->diffForHumans() }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .admin-bg { background: #f1f5f9; }
    .admin-card-stat {
        background: #fff;
        border-radius: 1.1em;
        box-shadow: 0 4px 16px 0 rgba(31,38,135,0.10);
        padding: 2.1em 2em 1.7em 2em;
        display: flex;
        flex-direction: column;
        align-items: center;
        min-width: 220px;
        max-width: 260px;
        flex: 1 1 220px;
        margin-bottom: 0.7em;
        transition: box-shadow 0.2s, transform 0.2s;
    }
    .admin-card-stat:hover {
        box-shadow: 0 8px 32px 0 rgba(37,99,235,0.17);
        transform: translateY(-4px) scale(1.03);
    }
    .admin-card-icon {
        width: 56px;
        height: 56px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 2rem;
        margin-bottom: 0.7em;
        color: #fff;
    }
    .bg-blue-500 { background: linear-gradient(90deg,#2563eb 0%,#1e40af 100%) !important; }
    .bg-green-500 { background: linear-gradient(90deg,#22c55e 0%,#16a34a 100%) !important; }
    .bg-cyan-500 { background: linear-gradient(90deg,#06b6d4 0%,#0ea5e9 100%) !important; }
    .bg-yellow-500 { background: linear-gradient(90deg,#facc15 0%,#eab308 100%) !important; }
    .admin-card-label {
        font-size: 1.08em;
        font-weight: 700;
        color: #64748b;
        margin-bottom: 0.2em;
    }
    .admin-card-value {
        font-size: 2.1em;
        font-weight: 900;
        color: #1e293b;
    }
    .admin-table-card {
        background: #fff;
        border-radius: 1.1em;
        box-shadow: 0 4px 16px 0 rgba(31,38,135,0.10);
        padding: 1.4em 1.2em 1.2em 1.2em;
        min-width: 340px;
        max-width: 520px;
        flex: 1 1 340px;
        margin-bottom: 2em;
        display: flex;
        flex-direction: column;
    }
    .admin-table-title {
        font-size: 1.2em;
        font-weight: 800;
        color: #2563eb;
        margin-bottom: 1em;
        display: flex;
        align-items: center;
        gap: 0.6em;
    }
    .admin-table {
        width: 100%;
        border-collapse: separate;
        border-spacing: 0 0.4em;
        background: none;
    }
    .admin-table th {
        background: #f1f5f9;
        color: #2563eb;
        font-size: 1em;
        font-weight: 700;
        border: none;
        padding: 0.7em 1em;
        text-align: left;
        border-radius: 0.7em 0.7em 0 0;
    }
    .admin-table td {
        background: #fff;
        font-size: 1em;
        color: #1e293b;
        border: none;
        padding: 0.7em 1em;
        border-radius: 0.7em;
        vertical-align: middle;
    }
    .admin-badge {
        display: inline-block;
        padding: 0.32em 0.85em;
        border-radius: 1.2em;
        font-size: 0.98em;
        font-weight: 700;
        margin-right: 0.2em;
    }
    .bg-cyan-100 { background: #cffafe !important; }
    .text-cyan-800 { color: #155e75 !important; }
    .bg-green-100 { background: #bbf7d0 !important; }
    .text-green-800 { color: #166534 !important; }
    .bg-gray-100 { background: #f3f4f6 !important; }
    .text-gray-800 { color: #1e293b !important; }
    .admin-avatar {
        width: 32px;
        height: 32px;
        border-radius: 50%;
        object-fit: cover;
        box-shadow: 0 2px 8px 0 rgba(37,99,235,0.10);
        margin-right: 0.3em;
    }
    @media (max-width: 900px) {
        .admin-card-stat, .admin-table-card { min-width: 200px; max-width: 100%; padding: 1.2em 0.7em; }
        .admin-table th, .admin-table td { font-size: 0.98em; padding: 0.6em 0.5em; }
    }
</style>
@endpush

@push('scripts')
<script src="{{ mix('js/app.js') }}"></script>
<script>
    new Vue({
        el: '#worker-status',
        components: {
            WorkerStatus: () => import(/* webpackChunkName: "worker-status" */ '../js/components/WorkerStatus.vue')
        }
    });
</script>
@endpush
