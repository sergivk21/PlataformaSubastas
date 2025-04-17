@extends('layouts.mobile.base')

@section('title', 'Panel de Administración')

@section('content')
<div class="px-4 py-4">
    <h1 class="text-2xl font-bold text-center text-primary mb-6">Panel de Administración</h1>

    <!-- Estadísticas principales -->
    <div class="grid grid-cols-2 gap-4 mb-6">
        <div class="bg-white rounded-xl shadow p-4 flex flex-col items-center">
            <div class="bg-blue-500 text-white rounded-full w-10 h-10 flex items-center justify-center mb-2">
                <i class="fas fa-users"></i>
            </div>
            <div class="text-xs text-gray-500">Usuarios</div>
            <div class="text-lg font-bold">{{ $totalUsers }}</div>
        </div>
        <div class="bg-white rounded-xl shadow p-4 flex flex-col items-center">
            <div class="bg-green-500 text-white rounded-full w-10 h-10 flex items-center justify-center mb-2">
                <i class="fas fa-gavel"></i>
            </div>
            <div class="text-xs text-gray-500">Subastas activas</div>
            <div class="text-lg font-bold">{{ $activeAuctions }}</div>
        </div>
        <div class="bg-white rounded-xl shadow p-4 flex flex-col items-center">
            <div class="bg-cyan-500 text-white rounded-full w-10 h-10 flex items-center justify-center mb-2">
                <i class="fas fa-money-bill-wave"></i>
            </div>
            <div class="text-xs text-gray-500">Ingresos</div>
            <div class="text-lg font-bold">${{ number_format($totalRevenue, 2) }}</div>
        </div>
        <div class="bg-white rounded-xl shadow p-4 flex flex-col items-center">
            <div class="bg-yellow-500 text-white rounded-full w-10 h-10 flex items-center justify-center mb-2">
                <i class="fas fa-gavel"></i>
            </div>
            <div class="text-xs text-gray-500">Total pujas</div>
            <div class="text-lg font-bold">{{ $totalBids }}</div>
        </div>
    </div>

    <!-- Accesos directos -->
    <div class="flex flex-col gap-3 mb-6">
        <a href="{{ route('admin.mobile.users') }}"
           style="display: block; max-width: 320px; margin: 0 auto; padding: 0.75rem 1.5rem; background-color: #2563eb; color: white; border-radius: 0.5rem; text-decoration: none; text-align: center; font-weight: bold;">
            <i class="fas fa-users" style="margin-right: 0.5rem;"></i>
            Gestionar Usuarios
        </a>
    </div>

    <!-- Últimas subastas -->
    <div class="mb-6">
        <h2 class="text-lg font-semibold mb-2">Últimas subastas</h2>
        <div class="flex flex-col gap-2">
            @foreach($latestAuctions as $auction)
                <div class="bg-white rounded-lg shadow p-3 flex flex-col">
                    <div class="flex items-center gap-2 mb-1">
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
    </div>

    <!-- Últimas pujas -->
    <div class="mb-4">
        <h2 class="text-lg font-semibold mb-2">Últimas pujas</h2>
        <div class="flex flex-col gap-2">
            @foreach($latestBids as $bid)
                <div class="bg-white rounded-lg shadow p-3 flex flex-col">
                    <div class="flex items-center gap-2 mb-1">
                        <img src="{{ $bid->user->profile_photo_url }}" class="rounded-full" style="width: 28px; height: 28px; object-fit: cover;">
                        <span class="font-semibold">{{ $bid->user->name }}</span>
                        <span class="text-xs text-gray-400">${{ number_format($bid->amount, 2) }}</span>
                    </div>
                    <div class="text-xs text-gray-500 mb-1">{{ $bid->auction->title }}</div>
                    <div class="text-xs text-gray-400">{{ $bid->created_at->diffForHumans() }}</div>
                </div>
            @endforeach
        </div>
    </div>
</div>
@endsection
