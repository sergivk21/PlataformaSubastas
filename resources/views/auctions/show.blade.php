@extends('layouts.base')

@section('content')
<style>
    html, body {
        height: 100%;
    }
    body {
        min-height: 100vh;
        background: linear-gradient(135deg, #e0e7ff 0%, #f1f5f9 100%);
        margin: 0;
        padding: 0;
    }
</style>
<div style="min-height:100vh; display:flex; justify-content:center;">
    <div class="w-full max-w-lg mx-auto mt-16 mb-10">
        <div class="bg-white rounded-2xl shadow-xl px-8 py-10 flex flex-col items-center">
            <!-- Imagen -->
            <div class="w-full mb-6">
                <img src="{{ $auction->imageUrl }}" 
                     alt="{{ $auction->title }}"
                     class="w-full h-64 object-cover rounded-lg shadow-lg"
                     onerror="this.src='{{ asset('images/default-auction.jpg') }}'">
            </div>
            <!-- Título -->
            <h1 class="text-3xl font-extrabold text-gray-800 text-center mb-4">{{ $auction->title }}</h1>
            <!-- Descripción -->
            <p class="text-gray-600 text-base text-center mb-6">{{ $auction->description }}</p>
            <!-- Precio final -->
            <div class="w-full flex flex-col items-center mb-3">
                <span class="inline-block bg-blue-100 text-blue-700 text-xl font-bold px-6 py-2 rounded-full mb-2">Precio final: €{{ number_format($auction->current_price, 2) }}</span>
            </div>
            <!-- Cuando finalizó -->
            <div class="w-full flex flex-col items-center mb-3">
                <span class="inline-block bg-gray-100 text-gray-700 font-semibold px-5 py-1 rounded-full border-2 border-blue-400">
                    @if($auction->status === 'active')
                        Finaliza el {{ $auction->end_date->format('d/m/Y') }} a las {{ $auction->end_date->format('H:i') }}
                    @else
                        Finalizó el {{ $auction->end_date->format('d/m/Y') }} a las {{ $auction->end_date->format('H:i') }}
                    @endif
                </span>
            </div>
            <!-- Pujas totales -->
            <div class="w-full flex flex-col items-center mb-6">
                <span class="inline-block bg-gray-100 text-gray-700 font-semibold px-5 py-1 rounded-full">Pujas totales: {{ $auction->bids->count() }}</span>
            </div>
            @if($auction->status === 'active')
                @if(auth()->user()->hasRole('admin'))
                    <div class="bg-gray-50 rounded-xl p-6 flex flex-col gap-4 w-full max-w-md mx-auto mt-2 border border-gray-200 shadow-sm mb-6">
                        <div class="text-center">
                            <i class="fas fa-info-circle text-gray-500 text-2xl mb-2"></i>
                            <p class="text-gray-700">Como administrador, no puedes realizar pujas en las subastas.</p>
                            <p class="text-sm text-gray-500">Esta restricción se aplica para mantener la integridad del sistema.</p>
                        </div>
                    </div>
                @else
                    <div class="bg-blue-50 rounded-xl p-6 flex flex-col gap-4 w-full max-w-md mx-auto mt-2 border border-blue-200 shadow-sm mb-6">
                        <h2 class="text-lg font-semibold text-blue-800 mb-2 text-center"><i class="fas fa-gavel mr-2"></i>Realizar Puja</h2>
                        <form action="{{ route('auctions.bid', $auction) }}" method="POST" class="flex flex-col gap-3">
                            @csrf
                            <label for="amount" class="block text-sm font-medium text-gray-700">Monto de la Puja</label>
                            <div class="relative">
                                <span class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-500">€</span>
                                <input type="number" step="0.01" class="w-full pl-8 pr-4 py-2 border-2 border-blue-200 rounded-lg focus:ring-2 focus:ring-blue-400 focus:border-blue-400 transition" id="amount" name="amount" required min="{{ $auction->current_price + 1 }}">
                            </div>
                            <small class="text-gray-500">Mínimo: €{{ number_format($auction->current_price + 1, 2) }}</small>
                            <button type="submit" class="w-full bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white font-extrabold py-3 px-4 rounded-lg shadow-lg text-lg transition flex items-center justify-center gap-2">
                                <i class="fas fa-gavel animate-pulse"></i> Pujar
                            </button>
                        </form>
                    </div>
                @endif
            @endif
            @if($auction->status === 'active')
                <div class="w-full mt-4">
                    <h3 class="text-xl font-semibold text-gray-800 mb-4 text-center">Historial de Pujas</h3>
                    <div class="bg-gray-50 p-4 rounded-lg border border-gray-200 shadow-sm">
                        <div class="divide-y divide-gray-200">
                            @forelse($auction->bids->sortByDesc('created_at')->take(5) as $bid)
                                <div class="flex justify-between items-center py-2">
                                    <div class="flex items-center">
                                        <span class="text-gray-700 font-medium">{{ $bid->user->name }}</span>
                                        @if($bid->user->id === auth()->id())
                                            <span class="ml-2 text-xs text-blue-500 font-semibold">(Tú)</span>
                                        @endif
                                    </div>
                                    <div class="text-gray-700 font-semibold">€{{ number_format($bid->amount, 2) }}</div>
                                    <div class="text-xs text-gray-500">{{ $bid->created_at->diffForHumans() }}</div>
                                </div>
                            @empty
                                <div class="text-gray-500 text-center py-4">No hay pujas aún.</div>
                            @endforelse
                        </div>
                    </div>
                </div>
            @endif
            @if($auction->status === 'finished' && $auction->winner_id === auth()->id() && !$auction->paid_at)
                <div class="m-8 bg-yellow-50 p-6 rounded-lg">
                    <div class="flex items-center justify-between">
                        <div>
                            <h3 class="text-xl font-semibold text-yellow-700 mb-2">¡Felicidades! Has ganado esta subasta</h3>
                            <p class="text-gray-600">Por favor, realiza el pago para completar la transacción.</p>
                        </div>
                        <div class="flex items-center">
                            <i class="fas fa-trophy text-3xl text-yellow-500"></i>
                        </div>
                    </div>
                </div>
            @endif
        </div>
        <a href="{{ route('auctions.index') }}" class="inline-block mt-8 text-blue-600 hover:underline text-sm font-semibold">
            <i class="fas fa-arrow-left mr-1"></i> Volver al listado
        </a>
        @if(auth()->user() && auth()->user()->hasRole('admin'))
        <form action="{{ route('auctions.destroy', $auction) }}" method="POST" style="margin-top: 1.5rem;" onsubmit="return confirm('¿Estás seguro de que deseas eliminar esta subasta? Esta acción no se puede deshacer.');">
            @csrf
            @method('DELETE')
            <button type="submit" style="display: flex; align-items: center; justify-content: center; width: 100%; background: linear-gradient(90deg, #dc2626 0%, #f43f5e 100%); color: white; padding: 0.5rem 1rem; border-radius: 0.5rem; text-decoration: none; font-weight: 700; font-size: 1.1rem; box-shadow: 0 4px 14px 0 rgba(220,38,38,0.15); border: none; transition: all 0.2s; gap: 0.5rem;">
                <i class="fas fa-trash-alt" style="margin-right: 0.5rem;"></i> Eliminar Subasta
            </button>
        </form>
        @endif
    </div>
</div>
@endsection
