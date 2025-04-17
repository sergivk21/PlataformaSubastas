@extends('layouts.base')

@section('title', 'Panel de Administración')

@section('content')
<div class="container-fluid px-4 px-md-5" style="max-width: 1200px; margin-left: auto; margin-right: auto;">
    <div class="row justify-content-center">
        <!-- Botón Usuarios centrado, igual que 'Ver Todas las subastas' -->
        <div class="w-100 d-flex justify-content-center" style="margin-top: 2.5rem; margin-bottom: 2.5rem;">
            <a href="{{ route('admin.users') }}" class="btn btn-sm btn-outline-primary">
                <i class="fas fa-users me-1"></i> Usuarios
            </a>
        </div>

        <!-- Main content centrado con margen -->
        <div class="col-12">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h1 class="h2 text-primary fw-bold">Panel de Administración</h1>

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


            <!-- Últimas Subastas -->
            <div class="row g-4">
                <div class="col-md-6">
                    <div class="card border-0 shadow-sm">
                        <div class="card-header bg-white d-flex justify-content-between align-items-center">
                            <a href="{{ route('admin.auctions') }}" class="btn btn-sm btn-outline-primary">
                                <i class="fas fa-list me-1"></i> Ver Todas las subastas
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
