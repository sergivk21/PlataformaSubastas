@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-7xl mx-auto">
        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                <span class="block sm:inline">{{ session('success') }}</span>
            </div>
        @endif

        @if(session('error'))
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                <span class="block sm:inline">{{ session('error') }}</span>
            </div>
        @endif

        <div class="bg-white rounded-lg shadow-md overflow-hidden">
            <div class="p-6">
                <div class="flex items-center justify-between mb-8">
                    <h1 class="text-3xl font-bold text-gray-800">{{ $auction->title }}</h1>
                    <div class="text-2xl font-bold text-blue-600">
                        €{{ number_format($auction->current_price, 2) }}
                    </div>
                </div>

                <div class="mb-8">
                    <p class="text-gray-600 leading-relaxed">{{ $auction->description }}</p>
                </div>

                <div class="grid grid-cols-2 gap-6">
                    <div>
                        <div class="bg-gray-50 p-4 rounded-lg">
                            <h3 class="text-lg font-semibold text-gray-800 mb-4">Información de la Subasta</h3>
                            <div class="space-y-4">
                                <div class="flex items-center">
                                    <span class="text-gray-500">Estado:</span>
                                    <span class="ml-2 @if($auction->status === 'active') text-green-600 @else text-red-600 @endif">
                                        {{ ucfirst($auction->status) }}
                                    </span>
                                </div>
                                <div class="flex items-center">
                                    <span class="text-gray-500">Finaliza:</span>
                                    <span class="ml-2 text-gray-700">{{ $auction->end_date->format('d/m/Y H:i') }}</span>
                                </div>
                                <div class="flex items-center">
                                    <span class="text-gray-500">Pujas:</span>
                                    <span class="ml-2 text-gray-700">{{ $auction->bids->count() }}</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div>
                        @if($auction->status === 'active')
                            <div class="bg-gray-50 p-4 rounded-lg">
                                <h3 class="text-lg font-semibold text-gray-800 mb-4">Realizar Puja</h3>
                                <form action="{{ route('auctions.bid', $auction) }}" method="POST" class="space-y-4">
                                    @csrf
                                    <div>
                                        <label for="amount" class="block text-sm font-medium text-gray-700 mb-2">Monto de la Puja</label>
                                        <div class="relative">
                                            <div class="absolute left-3 top-1/2 transform -translate-y-1/2">
                                                <span class="text-gray-500">€</span>
                                            </div>
                                            <input type="number" 
                                                step="0.01" 
                                                class="w-full pl-8 pr-4 py-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500" 
                                                id="amount" 
                                                name="amount" 
                                                required
                                                min="{{ $auction->current_price + 1 }}">
                                        </div>
                                        <small class="text-gray-500">Mínimo: €{{ number_format($auction->current_price + 1, 2) }}</small>
                                    </div>
                                    <button type="submit" class="w-full bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                        <i class="fas fa-gavel mr-2"></i> Realizar Puja
                                    </button>
                                </form>
                            </div>
                        @endif
                    </div>
                </div>

                @if($auction->status === 'active')
                    <div class="mt-8">
                        <h3 class="text-xl font-semibold text-gray-800 mb-4">Historial de Pujas</h3>
                        <div class="bg-gray-50 p-4 rounded-lg">
                            <div class="space-y-2">
                                @foreach($auction->bids->sortByDesc('created_at')->take(5) as $bid)
                                    <div class="flex justify-between items-center py-2 border-b border-gray-200">
                                        <div class="flex items-center">
                                            <span class="text-gray-700">{{ $bid->user->name }}</span>
                                            @if($bid->user->id === auth()->id())
                                                <span class="ml-2 text-sm text-blue-500">(Tú)</span>
                                            @endif
                                        </div>
                                        <div class="text-gray-700">€{{ number_format($bid->amount, 2) }}</div>
                                        <div class="text-sm text-gray-500">
                                            {{ $bid->created_at->diffForHumans() }}
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                @endif

                @if($auction->status === 'finished' && $auction->winner_id === auth()->id() && !$auction->paid_at)
                    <div class="mt-8 bg-yellow-50 p-6 rounded-lg">
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
        </div>
    </div>
</div>
@endsection
