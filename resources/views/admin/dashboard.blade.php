@extends('layouts.app')

@section('title', 'Panel de Administración')

@section('content')
<div class="container-fluid">
    <div class="row">
        <!-- Sidebar -->
        <div class="col-md-3 col-lg-2 d-flex flex-column flex-shrink-0 p-3 bg-dark text-white border-end">
            <a href="{{ route('admin.dashboard') }}" class="d-flex align-items-center mb-3 mb-md-0 text-white text-decoration-none">
                <span class="fs-5 fw-bold">AuctionHub</span>
            </a>
            <hr class="border-light border-1 opacity-25">
            <ul class="nav nav-pills flex-column mb-auto">
                <li class="nav-item">
                    <a href="{{ route('admin.dashboard') }}" class="nav-link text-white active">
                        <i class="fas fa-home me-2"></i>
                        Dashboard
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.users') }}" class="nav-link text-white">
                        <i class="fas fa-users me-2"></i>
                        Usuarios
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.auctions') }}" class="nav-link text-white">
                        <i class="fas fa-gavel me-2"></i>
                        Subastas
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.reports') }}" class="nav-link text-white">
                        <i class="fas fa-chart-bar me-2"></i>
                        Reportes
                    </a>
                </li>
            </ul>
            <hr class="border-light border-1 opacity-25">
            <div class="dropdown">
                <a href="#" class="d-flex align-items-center text-white text-decoration-none dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                    <img src="{{ auth()->user()->profile_photo_url }}" alt="" width="32" height="32" class="rounded-circle me-2">
                    <strong>{{ auth()->user()->name }}</strong>
                </a>
                <ul class="dropdown-menu dropdown-menu-dark text-small shadow">
                    <li><a class="dropdown-item" href="{{ route('profile.edit') }}">Perfil</a></li>
                    <li><hr class="dropdown-divider"></li>
                    <li>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="dropdown-item">Cerrar Sesión</button>
                        </form>
                    </li>
                </ul>
            </div>
        </div>

        <!-- Main content -->
        <div class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h1 class="h2 text-primary fw-bold">Panel de Administración</h1>
                <div class="btn-toolbar mb-2 mb-md-0">
                    <div class="btn-group me-2">
                        <button type="button" class="btn btn-sm btn-outline-primary">
                            <i class="fas fa-download me-1"></i> Exportar
                        </button>
                    </div>
                    <a href="{{ route('auctions.index') }}" class="btn btn-sm btn-outline-primary">
                        <i class="fas fa-gavel me-1"></i> Ver Subastas
                    </a>
                </div>
            </div>

            <!-- Estadísticas -->
            <div class="row g-4 mb-4">
                <div class="col-md-3">
                    <div class="card h-100 border-0 shadow-sm hover-shadow-lg">
                        <div class="card-body d-flex flex-column">
                            <div class="d-flex align-items-center mb-2">
                                <div class="icon-circle bg-primary text-white me-3">
                                    <i class="fas fa-users fs-4"></i>
                                </div>
                                <h5 class="card-title mb-0">Usuarios Totales</h5>
                            </div>
                            <h2 class="display-6 mt-2">{{ $totalUsers }}</h2>
                            <div class="progress mt-2" style="height: 5px;">
                                <div class="progress-bar bg-primary" role="progressbar" style="width: 75%"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card h-100 border-0 shadow-sm hover-shadow-lg">
                        <div class="card-body d-flex flex-column">
                            <div class="d-flex align-items-center mb-2">
                                <div class="icon-circle bg-success text-white me-3">
                                    <i class="fas fa-gavel fs-4"></i>
                                </div>
                                <h5 class="card-title mb-0">Subastas Activas</h5>
                            </div>
                            <h2 class="display-6 mt-2">{{ $activeAuctions }}</h2>
                            <div class="progress mt-2" style="height: 5px;">
                                <div class="progress-bar bg-success" role="progressbar" style="width: 75%"></div>
                            </div>
                            <div class="mt-3">
                                <a href="{{ route('auctions.index') }}" class="btn btn-sm btn-outline-success">
                                    <i class="fas fa-eye me-1"></i> Ver Subastas
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card h-100 border-0 shadow-sm hover-shadow-lg">
                        <div class="card-body d-flex flex-column">
                            <div class="d-flex align-items-center mb-2">
                                <div class="icon-circle bg-info text-white me-3">
                                    <i class="fas fa-money-bill-wave fs-4"></i>
                                </div>
                                <h5 class="card-title mb-0">Total Pujas</h5>
                            </div>
                            <h2 class="display-6 mt-2">{{ $totalBids }}</h2>
                            <div class="progress mt-2" style="height: 5px;">
                                <div class="progress-bar bg-info" role="progressbar" style="width: 85%"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card h-100 border-0 shadow-sm hover-shadow-lg">
                        <div class="card-body d-flex flex-column">
                            <div class="d-flex align-items-center mb-2">
                                <div class="icon-circle bg-warning text-white me-3">
                                    <i class="fas fa-trophy fs-4"></i>
                                </div>
                                <h5 class="card-title mb-0">Subastas Finalizadas</h5>
                            </div>
                            <h2 class="display-6 mt-2">{{ $finishedAuctions }}</h2>
                            <div class="progress mt-2" style="height: 5px;">
                                <div class="progress-bar bg-warning" role="progressbar" style="width: 50%"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Estadísticas -->
            <div class="row g-4 mb-4">
                <div class="col-md-3">
                    <div class="card h-100 border-0 shadow-sm hover-shadow-lg">
                        <div class="card-body d-flex flex-column">
                            <div class="d-flex align-items-center mb-2">
                                <div class="icon-circle bg-primary text-white me-3">
                                    <i class="fas fa-users fs-4"></i>
                                </div>
                                <h5 class="card-title mb-0">Usuarios Totales</h5>
                            </div>
                            <h2 class="display-6 mt-2">{{ $totalUsers }}</h2>
                            <div class="progress mt-2" style="height: 5px;">
                                <div class="progress-bar bg-primary" role="progressbar" style="width: 75%"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card h-100 border-0 shadow-sm hover-shadow-lg">
                        <div class="card-body d-flex flex-column">
                            <div class="d-flex align-items-center mb-2">
                                <div class="icon-circle bg-success text-white me-3">
                                    <i class="fas fa-gavel fs-4"></i>
                                </div>
                                <h5 class="card-title mb-0">Subastas Activas</h5>
                            </div>
                            <h2 class="display-6 mt-2">{{ $activeAuctions }}</h2>
                            <div class="progress mt-2" style="height: 5px;">
                                <div class="progress-bar bg-success" role="progressbar" style="width: 75%"></div>
                            </div>
                            <div class="mt-3">
                                <a href="{{ route('auctions.index') }}" class="btn btn-sm btn-outline-success">
                                    <i class="fas fa-eye me-1"></i> Ver Subastas
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card h-100 border-0 shadow-sm hover-shadow-lg">
                        <div class="card-body d-flex flex-column">
                            <div class="d-flex align-items-center mb-2">
                                <div class="icon-circle bg-info text-white me-3">
                                    <i class="fas fa-clock fs-4"></i>
                                </div>
                                <h5 class="card-title mb-0">Subastas Finalizadas</h5>
                            </div>
                            <h2 class="display-6 mt-2">{{ $finishedAuctions }}</h2>
                            <div class="progress mt-2" style="height: 5px;">
                                <div class="progress-bar bg-info" role="progressbar" style="width: 75%"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card h-100 border-0 shadow-sm hover-shadow-lg">
                        <div class="card-body d-flex flex-column">
                            <div class="d-flex align-items-center mb-2">
                                <div class="icon-circle bg-warning text-white me-3">
                                    <i class="fas fa-server fs-4"></i>
                                </div>
                                <h5 class="card-title mb-0">Estado del Worker</h5>
                            </div>
                            <div id="worker-status"></div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Lista de subastas activas -->
            <div class="col-md-12 mt-4">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Subastas Activas</h5>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Id</th>
                                        <th>Título</th>
                                        <th>Estado</th>
                                        <th>Fecha Fin</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach(\App\Models\Auction::active()->get() as $auction)
                                        <tr>
                                            <td>{{ $auction->id }}</td>
                                            <td>{{ $auction->title }}</td>
                                            <td>
                                                <span class="badge bg-{{ $auction->status === 'active' ? 'success' : 'danger' }}">
                                                    {{ ucfirst($auction->status) }}
                                                </span>
                                            </td>
                                            <td>{{ $auction->end_date->format('d/m/Y H:i') }}</td>
                                            <td>
                                                <a href="{{ route('auctions.show', $auction) }}" 
                                                   class="btn btn-sm btn-primary">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Últimas Subastas -->
            <div class="row g-4">
                <div class="col-md-6">
                    <div class="card border-0 shadow-sm">
                        <div class="card-header bg-white d-flex justify-content-between align-items-center">
                            <h5 class="card-title mb-0">Últimas Subastas</h5>
                            <a href="{{ route('admin.auctions') }}" class="btn btn-sm btn-outline-primary">
                                <i class="fas fa-list me-1"></i> Ver Todas
                            </a>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-hover">
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
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        <div class="flex-shrink-0">
                                                            <div class="icon-circle bg-primary text-white">
                                                                <i class="fas fa-gavel"></i>
                                                            </div>
                                                        </div>
                                                        <div class="flex-grow-1 ms-3">
                                                            {{ $auction->title }}
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    <span class="badge bg-success">
                                                        ${{ number_format($auction->starting_price, 2) }}
                                                    </span>
                                                </td>
                                                <td>
                                                    <span class="badge bg-{{ $auction->status === 'active' ? 'success' : ($auction->status === 'finished' ? 'primary' : 'warning') }}">
                                                        {{ ucfirst($auction->status) }}
                                                    </span>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Últimas Pujas -->
                <div class="col-md-6">
                    <div class="card border-0 shadow-sm">
                        <div class="card-header bg-white d-flex justify-content-between align-items-center">
                            <h5 class="card-title mb-0">Últimas Pujas</h5>
                            <a href="#" class="btn btn-sm btn-outline-primary">
                                <i class="fas fa-chart-line me-1"></i> Ver Gráfico
                            </a>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-hover">
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
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        <div class="flex-shrink-0">
                                                            <img src="{{ $bid->user->profile_photo_url }}" 
                                                                 class="rounded-circle me-2" 
                                                                 style="width: 32px; height: 32px; object-fit: cover;">
                                                        </div>
                                                        <div class="flex-grow-1 ms-3">
                                                            {{ $bid->user->name }}
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>{{ $bid->auction->title }}</td>
                                                <td>
                                                    <span class="badge bg-success">
                                                        ${{ number_format($bid->amount, 2) }}
                                                    </span>
                                                </td>
                                                <td>{{ $bid->created_at->diffForHumans() }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
    .icon-circle {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.2rem;
    }
    .card {
        transition: transform 0.2s, box-shadow 0.2s;
    }
    .card:hover {
        transform: translateY(-5px);
        box-shadow: 0 4px 15px rgba(0,0,0,0.1);
    }
    .nav-pills .nav-link {
        color: rgba(255,255,255,0.9);
        padding: 0.5rem 1rem;
        border-radius: 0;
    }
    .nav-pills .nav-link:hover {
        color: #fff;
        background-color: rgba(255,255,255,0.1);
    }
    .nav-pills .nav-link.active {
        color: #fff;
        background-color: rgba(255,255,255,0.2);
    }
    .table td {
        vertical-align: middle;
    }
    .table thead th {
        font-weight: 500;
        color: #6c757d;
    }
    .table td {
        font-size: 0.9rem;
    }
    .table td .badge {
        padding: 0.35em 0.75em;
    }
    .hover-shadow-lg:hover {
        box-shadow: 0 4px 15px rgba(0,0,0,0.15) !important;
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
@endsection
