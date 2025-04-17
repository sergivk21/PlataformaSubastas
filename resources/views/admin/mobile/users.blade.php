@extends('layouts.mobile.base')

@section('title', 'Gestionar Usuarios')

@section('content')
<div class="px-4 py-4">
    <h1 class="text-xl font-bold text-center mb-4">Gestionar Usuarios</h1>
    <div class="flex flex-col gap-3">
        @foreach($users as $user)
            <div class="bg-white rounded-lg shadow p-3 flex flex-col">
                <div class="flex items-center gap-2 mb-1">
                    <img src="{{ $user->profile_photo_url }}" class="rounded-full" style="width: 28px; height: 28px; object-fit: cover;">
                    <span class="font-semibold">{{ $user->name }}</span>
                    <span class="text-xs text-gray-400">{{ $user->email }}</span>
                </div>
                <div class="text-xs text-gray-500 mb-1">Roles: {{ implode(', ', $user->getRoleNames()->toArray()) }}</div>
                <div class="flex items-center gap-2">
                    <a href="{{ route('admin.users.edit', $user->id) }}" class="text-blue-600 text-xs underline">Editar</a>
                </div>
            </div>
        @endforeach
    </div>
    <div class="mt-4">{{ $users->links() }}</div>
</div>
@endsection
