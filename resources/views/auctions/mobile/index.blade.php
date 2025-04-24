@extends('layouts.mobile.base')

@section('content')
<div style="max-width: 100%; margin: 0 auto; padding: 0 1rem;">
    <div style="margin-bottom: 2rem;">
        <!-- Mensajes -->
        @if(session('success'))
            <div style="background-color: #dcfce7; color: #16a34a; padding: 1rem; border-radius: 0.5rem; margin-bottom: 1rem; display: flex; align-items: center; gap: 0.5rem;">
                <i class="fas fa-check-circle" style="color: #16a34a;"></i>
                <span>{{ session('success') }}</span>
            </div>
        @endif

        @if(session('error'))
            <div style="background-color: #fee2e2; color: #dc2626; padding: 1rem; border-radius: 0.5rem; margin-bottom: 1rem; display: flex; align-items: center; gap: 0.5rem;">
                <i class="fas fa-exclamation-circle" style="color: #dc2626;"></i>
                <span>{{ session('error') }}</span>
            </div>
        @endif

        <!-- Botón Crear Subasta para seller o admin -->
        @auth
            @if(auth()->user()->hasRole('seller') || auth()->user()->hasRole('admin'))
                <a href="{{ route('auctions.mobile.create') }}" style="display:block;width:100%;margin-bottom:2rem;padding:0.9rem 0;background:linear-gradient(90deg,#2563eb 0%,#1e40af 100%);color:#fff;font-weight:700;font-size:1.08rem;border-radius:0.8rem;text-align:center;box-shadow:0 2px 8px 0 rgba(37,99,235,0.10);text-decoration:none;">
                    <i class="fas fa-plus" style="margin-right:0.5em;"></i> Crear Subasta
                </a>
            @endif
        @endauth

        <!-- Lista de subastas -->
        <div style="display: block; margin-top: 2rem;">
            @forelse($auctions as $auction)
                <div style="background: white; border-radius: 1rem; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1); padding: 1.5rem; margin-bottom: 1.5rem; transition: all 0.3s ease;">
                    <!-- Imagen de la subasta -->
                    <div style="text-align: center; margin-bottom: 1rem;">
                        <div style="width: 200px; height: 200px; margin: 0 auto; border-radius: 0.5rem; background-color: #f3f4f6;">
                            <img src="{{ $auction->imageUrl }}" 
                                 alt="{{ $auction->title }}"
                                 style="width: 100%; height: 100%; object-fit: contain;"
                                 onerror="this.src='{{ asset('images/default-auction.jpg') }}'">
                        </div>
                    </div>
                    <!-- Información de la subasta -->
                    <div>
                        <h3 style="font-size: 1.2rem; margin: 0 0 0.5rem 0; color: #1e293b; text-align: center;">{{ $auction->title }}</h3>
                        
                        <div style="display: flex; flex-direction: column; align-items: center; gap: 0.5rem;">
                            <div style="display: flex; align-items: center; gap: 0.5rem;">
                                <i class="fas fa-clock" style="color: #64748b;"></i>
                                <span style="color: #64748b;">{{ $auction->end_date->diffForHumans() }}</span>
                            </div>

                            @if($auction->user)
                                <div style="display: flex; align-items: center; gap: 0.5rem;">
                                    <i class="fas fa-user" style="color: #64748b;"></i>
                                    <span style="color: #64748b;">{{ $auction->user->name }}</span>
                                </div>
                            @endif

                            <div style="display: flex; align-items: center; gap: 0.5rem;">
                                <i class="fas fa-money-bill-wave" style="color: #64748b;"></i>
                                <span style="font-size: 1.5rem; font-weight: bold; color: #2563eb;">{{ number_format($auction->current_price, 2) }} €</span>
                            </div>
                        </div>

                        <a href="{{ route('auctions.mobile.show', $auction) }}" 
                           style="display: block; width: 100%; padding: 0.75rem; background-color: #2563eb; color: white; border-radius: 0.5rem; text-decoration: none; text-align: center; margin-top: 1rem;">
                            Ver Detalles
                        </a>
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
