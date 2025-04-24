@extends('layouts.mobile.base')

@section('content')
<style>
    .auction-mobile-details-card {
        max-width: 430px;
        margin: 1.5rem auto 1.5rem auto;
        background: #fff;
        border-radius: 1.1rem;
        box-shadow: 0 2px 10px 0 rgba(31,38,135,0.13);
        padding: 1.2rem 1rem 1.1rem 1rem;
        box-sizing: border-box;
        width: 100%;
    }
    .auction-mobile-image {
        width: 100%;
        max-width: 260px;
        height: auto;
        object-fit: cover;
        border-radius: 1em;
        box-shadow: 0 2px 10px rgba(31,38,135,0.09);
        margin: 0 auto 1.1em auto;
        display: block;
    }
    .auction-mobile-title {
        text-align: center;
        font-size: 1.17rem;
        font-weight: 800;
        color: #1e293b;
        margin-bottom: 0.7em;
        word-break: break-word;
    }
    .auction-mobile-description {
        color: #475569;
        font-size: 0.98em;
        text-align: center;
        margin-bottom: 0.9em;
        word-break: break-word;
    }
    .auction-mobile-price {
        background: #dbeafe;
        color: #2563eb;
        font-weight: 700;
        font-size: 1em;
        border-radius: 0.7em;
        padding: 0.5em 1.2em;
        margin-bottom: 0.5em;
        display: inline-block;
    }
    .auction-mobile-date {
        background: #f1f5f9;
        color: #334155;
        font-weight: 600;
        font-size: 0.93em;
        border-radius: 0.7em;
        padding: 0.4em 1em;
        margin-bottom: 0.5em;
        display: inline-block;
        border: 1.5px solid #2563eb33;
    }
    .auction-mobile-bids {
        background: #f1f5f9;
        color: #334155;
        font-size: 0.93em;
        border-radius: 0.7em;
        padding: 0.4em 1em;
        margin-bottom: 0.7em;
        display: inline-block;
    }
    .auction-mobile-section {
        margin-bottom: 1.1em;
        text-align: center;
    }
    .auction-mobile-bid-form {
        background: #f0f9ff;
        border-radius: 1em;
        padding: 1em 0.7em 0.7em 0.7em;
        margin-bottom: 0.8em;
        box-shadow: 0 1px 4px rgba(31,38,135,0.07);
    }
    .auction-mobile-bid-btn {
        background: linear-gradient(90deg, #2563eb 0%, #6366f1 100%);
        color: #fff;
        border: none;
        border-radius: 0.5em;
        padding: 0.6em 1.2em;
        font-size: 1em;
        font-weight: 700;
        box-shadow: 0 1px 4px rgba(31,38,135,0.09);
        transition: background 0.2s;
        width: 100%;
        margin-top: 0.5em;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.5em;
    }
    .auction-mobile-bid-btn:active, .auction-mobile-bid-btn:focus {
        background: #1d4ed8;
    }
    .auction-mobile-history {
        background: #f8fafc;
        border-radius: 0.8em;
        padding: 0.7em 0.5em;
        box-shadow: 0 1px 3px rgba(31,38,135,0.04);
        margin-bottom: 0.7em;
    }
    .auction-mobile-history-item {
        display: flex;
        justify-content: space-between;
        align-items: center;
        font-size: 0.93em;
        padding: 0.4em 0;
        border-bottom: 1px solid #e5e7eb;
    }
    .auction-mobile-history-item:last-child {
        border-bottom: none;
    }
</style>
<div class="auction-mobile-details-card">
    <img src="{{ $auction->imageUrl }}" alt="{{ $auction->title }}" class="auction-mobile-image" onerror="this.src='{{ asset('images/default-auction.jpg') }}'">
    <div class="auction-mobile-title">{{ $auction->title }}</div>
    <div class="auction-mobile-description">{{ $auction->description }}</div>
    <div class="auction-mobile-section">
        <span class="auction-mobile-price">Precio final: €{{ number_format($auction->current_price, 2) }}</span>
    </div>
    <div class="auction-mobile-section">
        <span class="auction-mobile-date">
            @if($auction->status === 'active')
                Finaliza el {{ $auction->end_date->format('d/m/Y') }} a las {{ $auction->end_date->format('H:i') }}
            @else
                Finalizó el {{ $auction->end_date->format('d/m/Y') }} a las {{ $auction->end_date->format('H:i') }}
            @endif
        </span>
    </div>
    <div class="auction-mobile-section">
        <span class="auction-mobile-bids">Pujas totales: {{ $auction->bids->count() }}</span>
    </div>
    @if($auction->status === 'active')
        @if(auth()->user() && auth()->user()->hasRole('admin'))
            <div class="auction-mobile-section" style="background:#f1f5f9;border-radius:0.7em;padding:0.8em 0.5em;">
                <div class="text-gray-700 text-xs mt-1">Como administrador, no puedes realizar pujas en las subastas.<br><span style="color:#64748b;">Esta restricción se aplica para mantener la integridad del sistema.</span></div>
            </div>
        @elseif(auth()->user() && !auth()->user()->hasRole('bidder'))
            <div class="auction-mobile-section" style="background:#fef2f2;border-radius:0.7em;padding:0.8em 0.5em;">
                <div class="text-red-700 text-xs mt-1"><i class="fas fa-ban mr-2"></i>Solo los usuarios con rol <b>pujador</b> pueden realizar pujas.<br><span style="color:#b91c1c;">Cambia tu rol a pujador para poder participar en las subastas.</span></div>
            </div>
        @else
            <div class="auction-mobile-bid-form">
                <form action="{{ route('auctions.bid', $auction) }}" method="POST" class="flex flex-col gap-2">
                    @csrf
                    <label for="amount" class="block text-xs font-medium text-gray-700">Monto de la Puja</label>
                    <div style="position:relative;">
                        <span style="position:absolute;left:10px;top:50%;transform:translateY(-50%);color:#64748b;font-size:1em;">€</span>
                        <input type="number" step="0.01" class="mobile-auction-create-input" style="padding-left:2em;" id="amount" name="amount" required min="{{ $auction->current_price + 1 }}">
                    </div>
                    <small class="text-gray-500">Mínimo: €{{ number_format($auction->current_price + 1, 2) }}</small>
                    <button type="submit" class="auction-mobile-bid-btn">
                        <i class="fas fa-gavel animate-pulse"></i> Pujar
                    </button>
                </form>
            </div>
        @endif
    @endif
    @if($auction->status === 'active')
        <div class="auction-mobile-section">
            <div class="auction-mobile-history">
                <div class="text-xs font-semibold mb-2 text-blue-800 text-center">Historial de Pujas</div>
                @forelse($auction->bids->sortByDesc('created_at')->take(5) as $bid)
                    <div class="auction-mobile-history-item">
                        <span style="font-weight:600;">{{ $bid->user->id === auth()->id() ? 'Tú' : $bid->user->name }}</span>
                        <span>€{{ number_format($bid->amount, 2) }}</span>
                        <span style="color:#64748b;font-size:0.93em;">{{ $bid->created_at->diffForHumans() }}</span>
                    </div>
                @empty
                    <div class="text-gray-500 text-center py-2 text-xs">No hay pujas aún.</div>
                @endforelse
            </div>
        </div>
    @endif
    @if($auction->status === 'finished' && $auction->winner_id === auth()->id() && !$auction->paid_at)
        <div class="auction-mobile-section" style="background:#fef9c3;border-radius:0.7em;padding:0.8em 0.5em;">
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="text-sm font-semibold text-yellow-700 mb-1">¡Felicidades! Has ganado esta subasta</h3>
                    <p class="text-gray-600 text-xs">Por favor, realiza el pago para completar la transacción.</p>
                </div>
                <div class="flex items-center">
                    <i class="fas fa-trophy text-xl text-yellow-500"></i>
                </div>
            </div>
        </div>
    @endif
    <a href="{{ route('auctions.mobile.index') }}" class="inline-block mt-4 text-blue-600 hover:underline text-xs font-semibold">
        <i class="fas fa-arrow-left mr-1"></i> Volver al listado
    </a>
    @if(auth()->user() && auth()->user()->hasRole('admin'))
    <form action="{{ route('auctions.mobile.destroy', $auction) }}" method="POST" style="margin-top: 1rem;" onsubmit="return confirm('¿Estás seguro de que deseas eliminar esta subasta? Esta acción no se puede deshacer.');">
        @csrf
        @method('DELETE')
        <button type="submit" style="display: flex; align-items: center; justify-content: center; width: 100%; background: linear-gradient(90deg, #dc2626 0%, #f43f5e 100%); color: white; padding: 0.5rem 1rem; border-radius: 0.5rem; text-decoration: none; font-weight: 700; font-size: 1rem; box-shadow: 0 4px 14px 0 rgba(220,38,38,0.15); border: none; transition: all 0.2s; gap: 0.5rem;">
            <i class="fas fa-trash-alt" style="margin-right: 0.5rem;"></i> Eliminar Subasta
        </button>
    </form>
    @endif
</div>
@endsection
