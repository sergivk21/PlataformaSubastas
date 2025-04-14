@extends('layouts.app')

@section('title', 'Gestión de Subastas')

@section('content')
<div class="container">
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
                                <td>${{ number_format($auction->starting_price, 2) }}</td>
                                <td>{{ $auction->user->name }}</td>
                                <td>
                                    <span class="badge bg-{{ $auction->status === 'active' ? 'success' : ($auction->status === 'finished' ? 'primary' : 'warning') }}">
                                        {{ ucfirst($auction->status) }}
                                    </span>
                                </td>
                                <td>{{ $auction->ends_at->format('d/m/Y H:i') }}</td>
                                <td>{{ $auction->bids_count }}</td>
                                <td>
                                    <a href="{{ route('admin.auctions.edit', $auction) }}" class="btn btn-sm btn-primary me-1">
                                        <i class="fas fa-edit"></i> Editar
                                    </a>
                                    @if($auction->status !== 'active')
                                        <form action="{{ route('admin.auctions.update', $auction) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('PUT')
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
