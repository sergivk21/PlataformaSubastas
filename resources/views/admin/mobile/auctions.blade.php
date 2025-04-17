@extends('layouts.mobile.base')

@section('title', 'Gestionar Subastas')

@section('content')
<div class="px-4 py-4">
    <h1 class="text-xl font-bold text-center mb-4">Gestionar Subastas</h1>
    <div class="flex flex-col gap-3">
        @foreach($auctions as $auction)
            <div class="bg-white rounded-lg shadow p-3 flex flex-col">
                <div class="flex items-center justify-between mb-1">
                    <span class="font-semibold">{{ $auction->title }}</span>
                    <span class="text-xs text-gray-400">${{ number_format($auction->starting_price, 2) }}</span>
                </div>
                <div class="text-xs text-gray-500 mb-1">{{ $auction->status }}</div>
                <div class="flex items-center gap-2">
                    <a href="{{ route('auctions.show', $auction->id) }}" class="text-blue-600 text-xs underline">Ver</a>
                </div>
            </div>
        @endforeach
    </div>
    <div class="mt-4">{{ $auctions->links() }}</div>
</div>
@endsection
