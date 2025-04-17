@extends('layouts.base')

@section('content')
<div style="height:32px;"></div>
<div class="container-fluid px-4 px-md-5" style="max-width: 1200px; margin-left: auto; margin-right: auto;">
    <div class="mx-auto max-w-3xl">
        <!-- Cabecera con foto y datos principales -->
        <div class="bg-white rounded-lg shadow-md flex flex-row items-center gap-4 p-4 mb-6" style="gap:1rem;">
            <div class="flex flex-col items-center justify-center" style="min-width:60px;">
                @php
                    $photoExists = $user->profile_photo && file_exists(public_path('storage/' . $user->profile_photo));
                @endphp
                @if($photoExists)
                    <img src="{{ asset('storage/' . $user->profile_photo) }}" alt="Foto de perfil" class="rounded-full object-cover border border-blue-200 shadow mb-2" id="profile-photo-preview" style="width:60px;height:60px;min-width:60px;min-height:60px;max-width:60px;max-height:60px;">
                @else
                    <div class="rounded-full flex items-center justify-center bg-gray-200 text-gray-500 border border-blue-100 shadow mb-2" id="profile-photo-preview" style="width:60px;height:60px;min-width:60px;min-height:60px;max-width:60px;max-height:60px;">
                        <i class="fas fa-user" style="font-size:2rem;"></i>
                    </div>
                @endif
            </div>
            <div class="flex-1 flex flex-col justify-center text-left">
                <h1 class="text-3xl font-bold text-gray-800 mb-1">{{ $user->name }}</h1>
                <p class="text-gray-600 mb-2"><i class="fas fa-envelope me-1"></i> {{ $user->email }}</p>
            </div>
        </div>

        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4 flex items-center gap-2" role="alert">
                <i class="fas fa-check-circle"></i>
                <span class="block sm:inline">{{ session('success') }}</span>
            </div>
        @endif

        <!-- Formulario en tarjetas -->
        <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf
            @method('PUT')
            <div class="flex flex-col items-center mb-4">
                <label for="profile_photo" class="mt-2 text-sm font-medium text-blue-700 cursor-pointer hover:underline flex items-center gap-2">
                    <i class="fas fa-camera"></i> Cambiar foto
                </label>
                <input type="file" name="profile_photo" id="profile_photo" accept="image/*" class="hidden">
                <span id="selected-file-name" class="text-xs text-gray-500 mt-1"></span>
                <span class="text-xs text-gray-500 mt-1">JPG, PNG, GIF. Máx: 2MB.</span>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Información personal -->
                <div class="bg-white rounded-lg shadow p-6 flex flex-col gap-4">
                    <h2 class="text-lg font-semibold text-blue-700 mb-2"><i class="fas fa-user-edit me-1"></i> Información Personal</h2>
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700">Nombre</label>
                        <input type="text" name="name" id="name" value="{{ old('name', $user->name) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm" required>
                    </div>
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700">Correo electrónico</label>
                        <input type="email" name="email" id="email" value="{{ old('email', $user->email) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm" required>
                    </div>
                </div>
                <!-- Cambiar contraseña -->
                <div class="bg-white rounded-lg shadow p-6 flex flex-col gap-4">
                    <h2 class="text-lg font-semibold text-blue-700 mb-2"><i class="fas fa-key me-1"></i> Cambiar Contraseña</h2>
                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-700">Nueva contraseña</label>
                        <input type="password" name="password" id="password" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                    </div>
                    <div>
                        <label for="password_confirmation" class="block text-sm font-medium text-gray-700">Confirmar contraseña</label>
                        <input type="password" name="password_confirmation" id="password_confirmation" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                        <p style="font-size:13px; color:#bdbdbf; font-style:italic; margin-top:0.25rem;">(Dejar en blanco para mantener la contraseña actual)</p>
                    </div>
                </div>
            </div>
            <div class="flex justify-end mt-6">
                <button type="submit" style="background-color: #22c55e; color: white; padding: 0.5rem 1rem; border-radius: 0.5rem; text-decoration: none; transition: all 0.2s ease; display: inline-flex; align-items: center; font-weight: 600; font-size: 1rem; box-shadow: 0 4px 14px 0 rgba(34,197,94,0.15); gap: 0.5rem; border: none; cursor:pointer;" onmouseover="this.style.backgroundColor='#16a34a'" onmouseout="this.style.backgroundColor='#22c55e'">
                    <i class="fas fa-save" style="margin-right: 0.5rem;"></i> Guardar cambios
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const label = document.querySelector('label[for="profile_photo"]');
        const input = document.getElementById('profile_photo');
        const fileNameSpan = document.getElementById('selected-file-name');
        const previewImg = document.getElementById('profile-photo-preview');

        if(label && input) {
            label.addEventListener('click', function(e) {
                input.click();
            });
            input.addEventListener('change', function(e) {
                if (input.files && input.files[0]) {
                    fileNameSpan.textContent = input.files[0].name;
                    const reader = new FileReader();
                    reader.onload = function (e) {
                        if(previewImg.tagName === 'IMG')
                            previewImg.src = e.target.result;
                    };
                    reader.readAsDataURL(input.files[0]);
                } else {
                    fileNameSpan.textContent = '';
                }
            });
        }
    });
</script>
@endsection
