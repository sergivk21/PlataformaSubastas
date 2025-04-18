@extends('layouts.base')

@section('content')
<style>
    .auction-desktop-details-card {
        max-width: 650px;
        margin: 2.5rem auto 2.5rem auto;
        background: #fff;
        border-radius: 1.2rem;
        box-shadow: 0 4px 24px 0 rgba(31,38,135,0.13);
        padding: 2.3rem 2.1rem 2rem 2.1rem;
        box-sizing: border-box;
        width: 100%;
    }
    .auction-desktop-image {
        width: 100%;
        max-width: 340px;
        height: auto;
        object-fit: cover;
        border-radius: 1em;
        box-shadow: 0 2px 16px rgba(31,38,135,0.09);
        margin: 0 auto 1.4em auto;
        display: block;
    }
    .auction-desktop-title {
        text-align: center;
        font-size: 2.1rem;
        font-weight: 900;
        color: #1e293b;
        margin-bottom: 0.7em;
        word-break: break-word;
    }
    .auction-desktop-description {
        color: #475569;
        font-size: 1.1em;
        text-align: center;
        margin-bottom: 1.1em;
        word-break: break-word;
    }
    .auction-desktop-price {
        background: #dbeafe;
        color: #2563eb;
        font-weight: 700;
        font-size: 1.27em;
        border-radius: 0.7em;
        padding: 0.6em 1.7em;
        margin-bottom: 0.7em;
        display: inline-block;
    }
    .auction-desktop-date {
        background: #f1f5f9;
        color: #334155;
        font-weight: 600;
        font-size: 1.05em;
        border-radius: 0.7em;
        padding: 0.5em 1.4em;
        margin-bottom: 0.7em;
        display: inline-block;
        border: 2px solid #2563eb33;
    }
    .auction-desktop-bids {
        background: #f1f5f9;
        color: #334155;
        font-size: 1.05em;
        border-radius: 0.7em;
        padding: 0.5em 1.4em;
        margin-bottom: 1.1em;
        display: inline-block;
    }
    .auction-desktop-section {
        margin-bottom: 1.3em;
        text-align: center;
    }
    .auction-desktop-bid-form {
        background: #f0f9ff;
        border-radius: 1em;
        padding: 1.2em 1.1em 1em 1.1em;
        margin-bottom: 1.1em;
        box-shadow: 0 2px 8px rgba(31,38,135,0.07);
    }
    .auction-desktop-bid-btn {
        background: linear-gradient(90deg, #2563eb 0%, #6366f1 100%);
        color: #fff;
        border: none;
        border-radius: 0.5em;
        padding: 0.8em 1.7em;
        font-size: 1.1em;
        font-weight: 800;
        box-shadow: 0 1px 4px rgba(31,38,135,0.09);
        transition: background 0.2s;
        width: 100%;
        margin-top: 0.7em;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.7em;
    }
    .auction-desktop-bid-btn:active, .auction-desktop-bid-btn:focus {
        background: #1d4ed8;
    }
    .auction-desktop-history {
        background: #f8fafc;
        border-radius: 0.8em;
        padding: 1em 0.7em;
        box-shadow: 0 1px 3px rgba(31,38,135,0.04);
        margin-bottom: 1.1em;
    }
    .auction-desktop-history-item {
        display: flex;
        justify-content: space-between;
        align-items: center;
        font-size: 1.08em;
        padding: 0.6em 0;
        border-bottom: 1px solid #e5e7eb;
    }
    .auction-desktop-history-item:last-child {
        border-bottom: none;
    }
</style>
<div class="auction-desktop-details-card">
    <img src="{{ $auction->imageUrl }}" alt="{{ $auction->title }}" class="auction-desktop-image" onerror="this.src='{{ asset('images/default-auction.jpg') }}'">
    <div class="auction-desktop-title">{{ $auction->title }}</div>
    <div class="auction-desktop-description">{{ $auction->description }}</div>
    <div class="auction-desktop-section">
        <span class="auction-desktop-price">Precio final: €{{ number_format($auction->current_price, 2) }}</span>
    </div>
    <div class="auction-desktop-section">
        <span class="auction-desktop-date">
            @if($auction->status === 'active')
                Finaliza el {{ $auction->end_date->format('d/m/Y') }} a las {{ $auction->end_date->format('H:i') }}
            @else
                Finalizó el {{ $auction->end_date->format('d/m/Y') }} a las {{ $auction->end_date->format('H:i') }}
            @endif
        </span>
    </div>
    <div class="auction-desktop-section">
        <span class="auction-desktop-bids">Pujas totales: {{ $auction->bids->count() }}</span>
    </div>
    @if($auction->status === 'active')
        @if(auth()->user()->hasRole('admin'))
            <div class="auction-desktop-section" style="background:#f1f5f9;border-radius:0.7em;padding:1.1em 0.7em;">
                <i class="fas fa-info-circle text-gray-500 text-2xl mb-2"></i>
                <div class="text-gray-700 text-sm mt-1">Como administrador, no puedes realizar pujas en las subastas.<br><span style="color:#64748b;">Esta restricción se aplica para mantener la integridad del sistema.</span></div>
            </div>
        @else
            <div class="auction-desktop-bid-form">
                <form action="{{ route('auctions.bid', $auction) }}" method="POST" class="flex flex-col gap-3">
                    @csrf
                    <label for="amount" class="block text-sm font-medium text-gray-700">Monto de la Puja</label>
                    <div style="position:relative;">
                        <span style="position:absolute;left:15px;top:50%;transform:translateY(-50%);color:#64748b;font-size:1.1em;">€</span>
                        <input type="number" step="0.01" class="mobile-auction-create-input" style="padding-left:2.3em;" id="amount" name="amount" required min="{{ $auction->current_price + 1 }}">
                    </div>
                    <small class="text-gray-500">Mínimo: €{{ number_format($auction->current_price + 1, 2) }}</small>
                    <button type="submit" class="auction-desktop-bid-btn">
                        <i class="fas fa-gavel animate-pulse"></i> Pujar
                    </button>
                </form>
            </div>
        @endif
    @endif
    @if($auction->status === 'active')
        <div class="auction-desktop-section">
            <div class="auction-desktop-history">
                <div class="text-sm font-semibold mb-2 text-blue-800 text-center">Historial de Pujas</div>
                @forelse($auction->bids->sortByDesc('created_at')->take(5) as $bid)
                    <div class="auction-desktop-history-item">
                        <span style="font-weight:600;">{{ $bid->user->id === auth()->id() ? 'Tú' : $bid->user->name }}</span>
                        <span>€{{ number_format($bid->amount, 2) }}</span>
                        <span style="color:#64748b;font-size:0.96em;">{{ $bid->created_at->diffForHumans() }}</span>
                    </div>
                @empty
                    <div class="text-gray-500 text-center py-2 text-sm">No hay pujas aún.</div>
                @endforelse
            </div>
        </div>
    @endif
    @if($auction->status === 'finished' && $auction->winner_id === auth()->id() && !$auction->paid_at)
        <div class="auction-desktop-section" style="background:#fef9c3;border-radius:0.7em;padding:1.1em 0.7em;">
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="text-lg font-semibold text-yellow-700 mb-2">¡Felicidades! Has ganado esta subasta</h3>
                    <p class="text-gray-600">Por favor, realiza el pago para completar la transacción.</p>
                </div>
                <div class="flex items-center">
                    <i class="fas fa-trophy text-3xl text-yellow-500"></i>
                </div>
            </div>
        </div>
    @endif
    <a href="{{ route('auctions.index') }}" class="inline-block mt-8 text-blue-600 hover:underline text-base font-semibold">
        <i class="fas fa-arrow-left mr-1"></i> Volver al listado
    </a>
    @if(auth()->user() && auth()->user()->hasRole('admin'))
    <form action="{{ route('auctions.destroy', $auction) }}" method="POST" style="margin-top: 2rem;" onsubmit="return confirm('¿Estás seguro de que deseas eliminar esta subasta? Esta acción no se puede deshacer.');">
        @csrf
        @method('DELETE')
        <button type="submit" style="display: flex; align-items: center; justify-content: center; width: 100%; background: linear-gradient(90deg, #dc2626 0%, #f43f5e 100%); color: white; padding: 0.7rem 1.2rem; border-radius: 0.5rem; text-decoration: none; font-weight: 700; font-size: 1.2rem; box-shadow: 0 4px 14px 0 rgba(220,38,38,0.15); border: none; transition: all 0.2s; gap: 0.7rem;">
            <i class="fas fa-trash-alt" style="margin-right: 0.7rem;"></i> Eliminar Subasta
        </button>
    </form>
    @endif
</div>
@endsection
