@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-7xl mx-auto">
        <div class="bg-white rounded-lg shadow-md overflow-hidden">
            <div class="p-6">
                <div class="flex items-center justify-between mb-8">
                    <h1 class="text-3xl font-bold text-gray-800">Mi Perfil</h1>
                </div>

                @if(session('success'))
                    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                        <span class="block sm:inline">{{ session('success') }}</span>
                    </div>
                @endif

                <form action="{{ route('profile.update') }}" method="POST" class="space-y-6">
                    @csrf
                    @method('PUT')

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <div class="space-y-4">
                                <div>
                                    <label for="name" class="block text-sm font-medium text-gray-700">Nombre</label>
                                    <input type="text" 
                                        name="name" 
                                        id="name" 
                                        value="{{ old('name', $user->name) }}" 
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm" 
                                        required>
                                </div>

                                <div>
                                    <label for="email" class="block text-sm font-medium text-gray-700">Correo electrónico</label>
                                    <input type="email" 
                                        name="email" 
                                        id="email" 
                                        value="{{ old('email', $user->email) }}" 
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm" 
                                        required>
                                </div>

                                <div>
                                    <label for="password" class="block text-sm font-medium text-gray-700">Contraseña</label>
                                    <input type="password" 
                                        name="password" 
                                        id="password" 
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                                    <p class="mt-1 text-sm text-gray-500">Dejar en blanco para mantener la contraseña actual</p>
                                </div>

                                <div>
                                    <label for="password_confirmation" class="block text-sm font-medium text-gray-700">Confirmar contraseña</label>
                                    <input type="password" 
                                        name="password_confirmation" 
                                        id="password_confirmation" 
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                                </div>
                            </div>
                        </div>

                        <div>
                            <div class="space-y-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Subastas activas</label>
                                    <div class="mt-1">
                                        <a href="{{ route('auctions.index') }}" class="text-blue-600 hover:text-blue-800">
                                            Ver todas las subastas
                                        </a>
                                    </div>
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Historial de pujas</label>
                                    <div class="mt-1">
                                        <a href="{{ route('auctions.index') }}" class="text-blue-600 hover:text-blue-800">
                                            Ver historial de pujas
                                        </a>
                                    </div>
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Subastas ganadas</label>
                                    <div class="mt-1">
                                        <a href="{{ route('auctions.index') }}" class="text-blue-600 hover:text-blue-800">
                                            Ver subastas ganadas
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="flex justify-end">
                        <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                            <i class="fas fa-save mr-2"></i> Guardar Cambios
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
