@extends('layouts.mobile.base')

@section('content')
<div style="min-height:100vh; display:flex; justify-content:center; background: #f1f5f9;">
    <div class="w-full max-w-md mx-auto mt-4 mb-4 px-2">
        <div class="bg-white rounded-2xl shadow-xl px-2 py-4 flex flex-col items-center">
            <!-- Imagen -->
            <div class="w-full mb-3 flex justify-center">
                <img src="{{ $auction->imageUrl }}"
                     alt="{{ $auction->title }}"
                     class="w-full max-w-xs h-auto object-cover rounded-lg shadow-lg"
                     style="max-height: 240px;"
                     onerror="this.src='{{ asset('images/default-auction.jpg') }}'">
            </div>
            <!-- Título -->
            <h1 class="text-xl font-extrabold text-gray-800 text-center mb-1" style="overflow-wrap: break-word;">{{ $auction->title }}</h1>
            <!-- Descripción -->
            <p class="text-gray-600 text-sm text-center mb-3" style="overflow-wrap: break-word;">{{ $auction->description }}</p>
            <!-- Precio final -->
            <div class="w-full flex flex-col items-center mb-2">
                <span class="inline-block bg-blue-100 text-blue-700 text-base font-bold px-3 py-1 rounded-full mb-1">Precio final: €{{ number_format($auction->current_price, 2) }}</span>
            </div>
            <!-- Cuando finalizó -->
            <div class="w-full flex flex-col items-center mb-2">
                <span class="inline-block bg-gray-100 text-gray-700 font-semibold px-3 py-1 rounded-full border-2 border-blue-400 text-xs">
                    @if($auction->status === 'active')
                        Finaliza el {{ $auction->end_date->format('d/m/Y') }} a las {{ $auction->end_date->format('H:i') }}
                    @else
                        Finalizó el {{ $auction->end_date->format('d/m/Y') }} a las {{ $auction->end_date->format('H:i') }}
                    @endif
                </span>
            </div>
            <!-- Pujas totales -->
            <div class="w-full flex flex-col items-center mb-3">
                <span class="inline-block bg-gray-100 text-gray-700 font-semibold px-3 py-1 rounded-full text-xs">Pujas totales: {{ $auction->bids->count() }}</span>
            </div>
            @if($auction->status === 'active')
                @if(auth()->user() && auth()->user()->hasRole('admin'))
                    <div class="bg-gray-50 rounded-xl p-3 flex flex-col gap-2 w-full max-w-xs mx-auto mt-2 border border-gray-200 shadow-sm mb-3">
                        <div class="text-center">
                            <i class="fas fa-info-circle text-gray-500 text-lg mb-1"></i>
                            <p class="text-gray-700 text-xs">Como administrador, no puedes realizar pujas en las subastas.</p>
                            <p class="text-xs text-gray-500">Esta restricción se aplica para mantener la integridad del sistema.</p>
                        </div>
                    </div>
                @else
                    <div class="bg-blue-50 rounded-xl p-3 flex flex-col gap-2 w-full max-w-xs mx-auto mt-2 border border-blue-200 shadow-sm mb-3">
                        <h2 class="text-sm font-semibold text-blue-800 mb-2 text-center"><i class="fas fa-gavel mr-2"></i>Realizar Puja</h2>
                        <form action="{{ route('auctions.bid', $auction) }}" method="POST" class="flex flex-col gap-2">
                            @csrf
                            <label for="amount" class="block text-xs font-medium text-gray-700">Monto de la Puja</label>
                            <div class="relative">
                                <span class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-500">€</span>
                                <input type="number" step="0.01" class="w-full pl-8 pr-4 py-2 border-2 border-blue-200 rounded-lg focus:ring-2 focus:ring-blue-400 focus:border-blue-400 transition text-xs" id="amount" name="amount" required min="{{ $auction->current_price + 1 }}">
                            </div>
                            <small class="text-gray-500">Mínimo: €{{ number_format($auction->current_price + 1, 2) }}</small>
                            <button type="submit" class="w-full bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white font-extrabold py-2 px-2 rounded-lg shadow-lg text-sm transition flex items-center justify-center gap-2">
                                <i class="fas fa-gavel animate-pulse"></i> Pujar
                            </button>
                        </form>
                    </div>
                @endif
            @endif
            @if($auction->status === 'active')
                <div class="w-full mt-2">
                    <h3 class="text-sm font-semibold text-gray-800 mb-2 text-center">Historial de Pujas</h3>
                    <div class="bg-gray-50 p-2 rounded-lg border border-gray-200 shadow-sm">
                        <div class="divide-y divide-gray-200">
                            @forelse($auction->bids->sortByDesc('created_at')->take(5) as $bid)
                                <div class="flex justify-between items-center py-1">
                                    <div class="flex items-center">
                                        <span class="text-gray-700 font-medium text-xs">{{ $bid->user->name }}</span>
                                        @if($bid->user->id === auth()->id())
                                            <span class="ml-1 text-xs text-blue-500 font-semibold">(Tú)</span>
                                        @endif
                                    </div>
                                    <div class="text-gray-700 font-semibold text-xs">€{{ number_format($bid->amount, 2) }}</div>
                                    <div class="text-xs text-gray-500">{{ $bid->created_at->diffForHumans() }}</div>
                                </div>
                            @empty
                                <div class="text-gray-500 text-center py-2 text-xs">No hay pujas aún.</div>
                            @endforelse
                        </div>
                    </div>
                </div>
            @endif
            @if($auction->status === 'finished' && $auction->winner_id === auth()->id() && !$auction->paid_at)
                <div class="m-2 bg-yellow-50 p-3 rounded-lg">
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
        </div>
        <a href="{{ route('auctions.mobile.index') }}" class="inline-block mt-4 text-blue-600 hover:underline text-xs font-semibold">
            <i class="fas fa-arrow-left mr-1"></i> Volver al listado
        </a>
        @if(auth()->user() && auth()->user()->hasRole('admin'))
        <form action="{{ route('auctions.destroy', $auction) }}" method="POST" style="margin-top: 1rem;" onsubmit="return confirm('¿Estás seguro de que deseas eliminar esta subasta? Esta acción no se puede deshacer.');">
            @csrf
            @method('DELETE')
            <button type="submit" style="display: flex; align-items: center; justify-content: center; width: 100%; background: linear-gradient(90deg, #dc2626 0%, #f43f5e 100%); color: white; padding: 0.5rem 1rem; border-radius: 0.5rem; text-decoration: none; font-weight: 700; font-size: 1rem; box-shadow: 0 4px 14px 0 rgba(220,38,38,0.15); border: none; transition: all 0.2s; gap: 0.5rem;">
                <i class="fas fa-trash-alt" style="margin-right: 0.5rem;"></i> Eliminar Subasta
            </button>
        </form>
        @endif
    </div>
</div>
@endsection
