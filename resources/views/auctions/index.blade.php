@extends('layouts.base')

@section('content')
<div style="max-width: 1200px; margin: 0 auto; padding: 0 1rem;">
    <div style="margin-bottom: 2rem;">
        <!-- Mensajes -->
        @if(session('success'))
            <div style="background-color: #dcfce7; color: #16a34a; padding: 1rem; border-radius: 0.5rem; margin-bottom: 1rem; display: flex; align-items: center; gap: 0.5rem;">
                <i class="fas fa-check-circle" style="color: #16a34a;"></i>
                <span>{{ session('success') }}</span>
    <script src="{{ asset('js/app.js') }}" defer></script>
            </div>
        @endif

        @if(session('error'))
            <div style="background-color: #fee2e2; color: #dc2626; padding: 1rem; border-radius: 0.5rem; margin-bottom: 1rem; display: flex; align-items: center; gap: 0.5rem;">
                <i class="fas fa-exclamation-circle" style="color: #dc2626;"></i>
                <span>{{ session('error') }}</span>
            </div>
        @endif

        <!-- Lista de subastas -->
        <div style="display: grid; gap: 1.5rem; margin-top: 2rem;">
            @forelse($auctions as $auction)
                <div style="background: white; border-radius: 1rem; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1); padding: 1.5rem; transition: all 0.3s ease;">
                    <div style="display: flex; gap: 1rem;">
                        <!-- Imagen de la subasta -->
                        <div style="width: 100px; height: 100px; border-radius: 0.5rem; background-color: #f3f4f6;">
                            <img src="{{ $auction->imageUrl }}" 
                                 alt="{{ $auction->title }}"
                                 style="width: 100%; height: 100%; object-fit: contain;"
                                 onerror="this.src='{{ asset('images/default-auction.jpg') }}'">
                        </div>
                        <!-- Información de la subasta -->
                        <div style="flex: 1;">
                            <h3 style="font-size: 1.1rem; margin: 0; color: #1e293b;">{{ $auction->title }}</h3>
                            <div style="display: flex; align-items: center; gap: 0.5rem; margin-top: 0.5rem;">
                            <i class="fas fa-clock" style="color: #64748b;"></i>
                            <span style="color: #64748b;">{{ $auction->end_date->diffForHumans() }}</span>
                        </div>
                        @if($auction->user)
                            <div style="display: flex; align-items: center; gap: 0.5rem; margin-top: 0.5rem;">
                                <i class="fas fa-user" style="color: #64748b;"></i>
                                <span style="color: #64748b;">{{ $auction->user->name }}</span>
                            </div>
                        @endif
                        <div style="display: flex; align-items: center; gap: 0.5rem; margin-top: 0.5rem;">
                            <i class="fas fa-money-bill-wave" style="color: #64748b;"></i>
                            <span style="font-size: 1.5rem; font-weight: bold; color: #2563eb;">{{ number_format($auction->current_price, 2) }} €</span>
                        </div>
                        <a href="{{ route('auctions.show', $auction) }}" style="display: inline-block; padding: 0.5rem 1rem; background-color: #2563eb; color: white; border-radius: 0.5rem; text-decoration: none; transition: all 0.3s ease; margin-top: 0.5rem;">
                            Ver Detalles
                        </a>
                        </div>
                    </div>
                </div>
            @empty
                <div style="text-align: center; padding: 3rem;">
                    <p style="color: #64748b;">No hay subastas disponibles en este momento.</p>
                </div>
            @endforelse
        </div>

        <!-- Paginación -->
        {{ $auctions->links() }}
    </div>
</div>
@endsection
