@extends('layouts.base')

@section('title', 'Gestión de Subastas')

@section('content')
<div class="container-fluid px-4 px-md-5" style="max-width: 1200px; margin-left: auto; margin-right: auto;">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Gestión de Subastas</h1>
        <a href="{{ route('admin.dashboard') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Volver al Dashboard
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Nombre</th>
                            <th>Precio Inicial</th>
                            <th>Vendedor</th>
                            <th>Estado</th>
                            <th>Fecha de Finalización</th>
                            <th>Pujas</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($auctions as $auction)
                            <tr>
                                <td>{{ $auction->title }}</td>
                                <td>${{ number_format($auction->starting_price ?? 0, 2) }}</td>
                                <td>{{ $auction->user ? $auction->user->name : 'Usuario eliminado' }}</td>
                                <td>
                                    <span class="badge bg-{{ 
                                        match($auction->status) {
                                            'active' => 'success',
                                            'finished' => 'primary',
                                            'cancelled' => 'danger',
                                            default => 'warning'
                                        } }}">
                                        {{ ucfirst($auction->status) }}
                                    </span>
                                </td>
                                <td>{{ $auction->ends_at ? $auction->ends_at->format('d/m/Y H:i') : 'Sin fecha' }}</td>
                                <td>{{ $auction->bids_count ?? 0 }}</td>
                                <td>
                                    <a href="{{ route('admin.auctions.edit', $auction) }}" class="btn btn-sm btn-primary me-1">
                                        <i class="fas fa-edit"></i> Editar
                                    </a>
                                    @if($auction->status === 'pending')
                                        <form action="{{ route('admin.auctions.update', $auction) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('PUT')
                                            <input type="hidden" name="status" value="active">
                                            <button type="submit" class="btn btn-sm btn-success" 
                                                    onclick="return confirm('¿Estás seguro de que quieres activar esta subasta?')">
                                                <i class="fas fa-play"></i> Activar
                                            </button>
                                        </form>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            {{ $auctions->links() }}
        </div>
    </div>
</div>
@endsection
