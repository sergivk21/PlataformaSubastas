@extends('layouts.base')

@section('content')
<div style="max-width: 1200px; margin: 0 auto; padding: 0 1rem;">
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

        <!-- Lista de subastas -->
        <div style="display: grid; gap: 1.5rem;">
            @forelse($auctions as $auction)
                <div style="background: white; border-radius: 1rem; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1); padding: 1.5rem; transition: all 0.3s ease;">
                    <div style="display: flex; flex-direction: column; gap: 1rem;">
                        <div style="display: flex; align-items: center; gap: 0.5rem;">
                            <i class="fas fa-clock" style="color: #64748b;"></i>
                            <span style="color: #64748b;">{{ $auction->end_date->diffForHumans() }}</span>
                        </div>
                        <div style="display: flex; align-items: center; gap: 0.5rem;">
                            <i class="fas fa-tag" style="color: #64748b;"></i>
                            <span style="color: #64748b;">{{ $auction->category ? $auction->category->name : 'Sin categoría' }}</span>
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
                        <div style="display: flex; align-items: center; gap: 0.5rem;">
                            <i class="fas fa-gavel" style="color: #64748b;"></i>
                            <span style="color: #64748b;">{{ $auction->bids_count }} pujas</span>
                        </div>
                        <div style="display: flex; align-items: center; gap: 0.5rem;">
                            <i class="fas fa-heart" style="color: #64748b;"></i>
                            <span style="color: #64748b;">{{ $auction->likes_count }} likes</span>
                        </div>
                        <a href="{{ route('auctions.show', $auction) }}" style="display: inline-block; padding: 0.5rem 1rem; background-color: #2563eb; color: white; border-radius: 0.5rem; text-decoration: none; transition: all 0.3s ease;">
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
