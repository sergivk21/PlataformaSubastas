@extends('layouts.base')

@section('content')
<div style="height:32px;"></div>
<div class="container-fluid px-4 px-md-5">
    <div class="flex justify-center">
        <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf
            @method('PUT')
            <!-- Cabecera con foto y datos principales -->
            <div class="bg-white rounded-lg shadow-md flex flex-col items-center gap-2 p-6 mb-6" style="max-width:430px;margin:0 auto 2.2rem auto;">
                <div class="flex flex-col items-center justify-center mb-2" style="min-width:92px;">
                    @php
                        $photoExists = $user->profile_photo && file_exists(public_path('storage/' . $user->profile_photo));
                        $initial = strtoupper(mb_substr($user->name, 0, 1));
                    @endphp
                    <div style="display:flex;flex-direction:column;align-items:center;gap:0.7em;min-width:92px;">
                        @if($photoExists)
                            <img src="{{ asset('storage/' . $user->profile_photo) }}" alt="Foto de perfil" class="profile-desktop-avatar-img" id="profile-photo-preview">
                        @else
                            <div class="profile-desktop-avatar-initial" id="profile-photo-preview">
                                {{ $initial }}
                            </div>
                        @endif
                        <label for="profile_photo" class="profile-desktop-photo-btn mt-2">
                            <i class="fas fa-camera"></i> Cambiar foto
                        </label>
                        <input type="file" name="profile_photo" id="profile_photo" accept="image/*" class="hidden" style="display:none !important;">
                        <span id="selected-file-name" class="text-xs text-gray-500 mt-1"></span>
                        <span class="text-xs text-gray-500 mt-2">JPG, PNG, GIF. Máx: 5MB.</span>
                        @if ($errors->has('profile_photo'))
                            <div class="alert alert-danger" style="margin-bottom:1em;">
                                <span>{{ $errors->first('profile_photo') }}</span>
                            </div>
                        @endif
                        <!-- Nombre y correo debajo del botón -->
                        <h1 class="text-2xl md:text-3xl font-bold text-gray-800 mb-1 text-center" style="font-weight:900; margin-top:1.2em;">{{ $user->name }}</h1>
                        <p class="text-gray-500 mb-2 text-center" style="font-size:1.01rem;"><i class="fas fa-envelope me-1"></i> {{ $user->email }}</p>
                    </div>
                </div>
            </div>

            @if(session('success'))
                <div id="profile-success-toast" style="position:fixed;top:36px;left:50%;transform:translateX(-50%);z-index:9999;animation:fade-in-down 0.7s cubic-bezier(0.4,0,0.2,1);min-width:340px;max-width:95vw;">
                    <div style="background:#fff;border:2px solid #22c55e;color:#166534;padding:1.2em 2em;border-radius:1.2em;box-shadow:0 6px 32px 0 rgba(34,197,94,0.18);display:flex;align-items:center;gap:1.2em;">
                        <div style="display:flex;align-items:center;justify-content:center;width:3.2em;height:3.2em;border-radius:50%;background:#bbf7d0;">
                            <i class="fas fa-check-circle" style="font-size:2.2em;color:#22c55e;"></i>
                        </div>
                        <div>
                            <div style="font-weight:800;font-size:1.15em;margin-bottom:0.2em;">¡Perfil actualizado!</div>
                            <div style="font-size:0.98em;opacity:0.85;">Tus cambios se han guardado correctamente.</div>
                        </div>
                    </div>
                </div>
                <style>@keyframes fade-in-down{from{opacity:0;transform:translateY(-40px);}to{opacity:1;transform:translateY(0);}}</style>
                <script>
                    setTimeout(function(){
                        var toast = document.getElementById('profile-success-toast');
                        if(toast) toast.style.display = 'none';
                    }, 3000);
                </script>
            @endif

            @if(session('error'))
                <div id="profile-error-toast" style="position:fixed;top:36px;left:50%;transform:translateX(-50%);z-index:9999;animation:fade-in-down 0.7s cubic-bezier(0.4,0,0.2,1);min-width:340px;max-width:95vw;">
                    <div style="background:#fff;border:2px solid #ef4444;color:#991b1b;padding:1.2em 2em;border-radius:1.2em;box-shadow:0 6px 32px 0 rgba(239,68,68,0.18);display:flex;align-items:center;gap:1.2em;">
                        <div style="display:flex;align-items:center;justify-content:center;width:3.2em;height:3.2em;border-radius:50%;background:#fee2e2;">
                            <i class="fas fa-times-circle" style="font-size:2.2em;color:#ef4444;"></i>
                        </div>
                        <div>
                            <div style="font-weight:800;font-size:1.15em;margin-bottom:0.2em;">¡Acción no permitida!</div>
                            <div style="font-size:0.98em;opacity:0.85;">{{ session('error') }}</div>
                        </div>
                    </div>
                </div>
                <style>@keyframes fade-in-down{from{opacity:0;transform:translateY(-40px);}to{opacity:1;transform:translateY(0);}}</style>
            @endif

            <div class="flex justify-center w-full mt-10">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8 max-w-2xl">
                    <!-- Información personal -->
                    <div class="profile-desktop-card">
                        <h2 class="profile-desktop-card-title"><i class="fas fa-user-edit me-1"></i> Información Personal</h2>
                        <div class="w-full">
                            <label for="name" class="block text-sm font-medium text-gray-700">Nombre</label>
                            <input type="text" name="name" id="name" value="{{ old('name', $user->name) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm" required>
                        </div>
                        <div class="w-full">
                            <label for="email" class="block text-sm font-medium text-gray-700">Correo electrónico</label>
                            <input type="email" name="email" id="email" value="{{ old('email', $user->email) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm" required>
                        </div>
                    </div>
                    <!-- Cambiar contraseña -->
                    <div class="profile-desktop-card">
                        <h2 class="profile-desktop-card-title"><i class="fas fa-key me-1"></i> Cambiar Contraseña</h2>
                        <div class="w-full">
                            <label for="password" class="block text-sm font-medium text-gray-700">Nueva contraseña</label>
                            <input type="password" name="password" id="password" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                        </div>
                        <div class="w-full">
                            <label for="password_confirmation" class="block text-sm font-medium text-gray-700">Confirmar contraseña</label>
                            <input type="password" name="password_confirmation" id="password_confirmation" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                            <p style="font-size:13px; color:#bdbdbf; font-style:italic; margin-top:0.25rem;">(Dejar en blanco para mantener la contraseña actual)</p>
                        </div>
                    </div>
                    @if(!$user->role_changed)
                        <div class="profile-desktop-card">
                            <h2 class="profile-desktop-card-title"><i class="fas fa-user-tag me-1"></i> Cambiar Rol</h2>
                            <div class="w-full">
                                <div class="flex flex-row gap-5 mt-3 justify-center">
                                    <label class="flex flex-col items-center cursor-pointer">
                                        <input type="radio" name="role" value="bidder" {{ (old('role', $user->role ?? '') == 'bidder' || (!$user->role && $user->hasRole('bidder'))) ? 'checked' : '' }} class="accent-green-500 w-6 h-6 shadow-md">
                                        <span class="mt-2 text-sm font-bold text-green-700 bg-green-100 rounded-full px-3 py-1">Pujador</span>
                                    </label>
                                    <label class="flex flex-col items-center cursor-pointer">
                                        <input type="radio" name="role" value="seller" {{ (old('role', $user->role ?? '') == 'seller' || (!$user->role && $user->hasRole('seller'))) ? 'checked' : '' }} class="accent-green-500 w-6 h-6 shadow-md">
                                        <span class="mt-2 text-sm font-bold text-gray-600 bg-gray-100 rounded-full px-3 py-1">Vendedor</span>
                                    </label>
                                </div>
                                <div class="mt-3 text-xs text-yellow-700 bg-yellow-100 rounded-lg px-4 py-2 text-center font-semibold" style="margin-top:1.2em;">
                                    <i class="fas fa-exclamation-triangle mr-2"></i>
                                    Si cambias de rol una vez, <b>no podrás volver a cambiarlo nunca</b>.
                                </div>
                            </div>
                        </div>
                    @else
                        <div class="profile-desktop-card">
                            <h2 class="profile-desktop-card-title"><i class="fas fa-user-tag me-1"></i> Rol actual</h2>
                            <div class="flex flex-row gap-5 mt-3 justify-center">
                                <div class="flex flex-col items-center">
                                    <input type="radio" name="role" value="{{ $user->getRoleNames()[0] }}" checked disabled class="accent-green-500 w-6 h-6 shadow-md cursor-not-allowed">
                                    <span class="mt-2 text-sm font-bold text-green-700 bg-green-100 rounded-full px-3 py-1 text-center">
                                        @if($user->getRoleNames()[0] === 'bidder')
                                            Pujador
                                        @elseif($user->getRoleNames()[0] === 'seller')
                                            Vendedor
                                        @elseif($user->getRoleNames()[0] === 'admin')
                                            Administrador
                                        @else
                                            {{ ucfirst($user->getRoleNames()[0]) }}
                                        @endif
                                    </span>
                                </div>
                            </div>
                            <div class="mt-3 text-xs text-gray-500 text-center">Solo puedes cambiar tu rol una vez.</div>
                        </div>
                    @endif
                </div>
            </div>

            <!-- BOTÓN CENTRADO VERDE SIN TAILWIND NI CSS EXTERNO -->
            <div style="display:flex;justify-content:center;width:100%;margin-top:2rem;margin-bottom:3rem;">
                <button type="submit" style="margin:auto;display:inline-flex;align-items:center;gap:0.5em;padding:0.7em 2.1em;background:linear-gradient(90deg,#22c55e 0%,#16a34a 100%);color:#fff;font-weight:700;font-size:1.08em;border:none;border-radius:0.7em;box-shadow:0 2px 8px 0 rgba(34,197,94,0.10);cursor:pointer;outline:none;">
                    <i class="fas fa-save"></i> Guardar cambios
                </button>
            </div>
        </form>
    </div>
</div>
<style>
    .profile-desktop-btns {
        display: flex;
        flex-direction: row;
        justify-content: flex-start;
        gap: 1rem;
        margin-top: 1.5rem;
    }
    .profile-desktop-btns a, .profile-desktop-btns button {
        all: unset;
        box-sizing: border-box;
        display: inline-flex !important;
        align-items: center !important;
        justify-content: center !important;
        width: 170px !important;
        height: 44px !important;
        padding: 0 1.1rem !important;
        border-radius: 0.5rem !important;
        font-weight: 600 !important;
        font-size: 1rem !important;
        box-shadow: 0 4px 14px 0 rgba(34,197,94,0.10) !important;
        gap: 0.5rem !important;
        cursor: pointer !important;
        transition: background 0.2s, box-shadow 0.2s !important;
        text-align: center !important;
    }
    .profile-desktop-avatar-img {
        width: 92px;
        height: 92px;
        border-radius: 50%;
        object-fit: cover;
        border: 3px solid #2563eb;
        box-shadow: 0 2px 14px 0 rgba(37,99,235,0.13);
        background: #fff;
        transition: box-shadow 0.2s;
    }
    .profile-desktop-avatar-initial {
        width: 92px;
        height: 92px;
        border-radius: 50%;
        background: linear-gradient(135deg, #2563eb 60%, #1e40af 100%);
        color: #fff;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 2.8rem;
        font-weight: 800;
        border: 3px solid #2563eb;
        box-shadow: 0 2px 14px 0 rgba(37,99,235,0.13);
        text-transform: uppercase;
        letter-spacing: -1px;
        user-select: none;
    }
    .profile-desktop-card {
        background: #fff;
        border-radius: 1.2rem;
        box-shadow: 0 4px 16px 0 rgba(31,38,135,0.12);
        padding: 2.1rem 1.2rem 1.7rem 1.2rem;
        box-sizing: border-box;
        display: flex;
        flex-direction: column;
        gap: 1.3rem;
    }
    .profile-desktop-card-title {
        text-align: left;
        font-size: 1.25rem;
        font-weight: 800;
        color: #2563eb;
        margin-bottom: 0.7rem;
        letter-spacing: -0.5px;
        display: flex;
        align-items: center;
        gap: 0.5em;
    }
    .profile-desktop-photo-btn {
        margin-top: 0.5rem;
        display: inline-flex;
        align-items: center;
        gap: 0.5em;
        padding: 0.45em 1.2em;
        background: linear-gradient(90deg, #2563eb 0%, #1e40af 100%);
        color: #fff;
        font-weight: 700;
        font-size: 1em;
        border: none;
        border-radius: 0.7em;
        box-shadow: 0 2px 8px 0 rgba(37,99,235,0.10);
        cursor: pointer;
        transition: background 0.2s, box-shadow 0.2s;
    }
    .profile-desktop-photo-btn:hover, .profile-desktop-photo-btn:focus {
        background: linear-gradient(90deg, #1e40af 0%, #2563eb 100%);
        box-shadow: 0 4px 14px 0 rgba(37,99,235,0.13);
        outline: none;
    }
    .profile-toast {
        min-width: 340px;
        max-width: 95vw;
    }
    @keyframes fade-in-down {
        from { opacity: 0; transform: translateY(-40px); }
        to { opacity: 1; transform: translateY(0); }
    }
    .animate-fade-in-down {
        animation: fade-in-down 0.7s cubic-bezier(0.4,0,0.2,1);
    }
</style>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const label = document.querySelector('label[for="profile_photo"]');
        const input = document.getElementById('profile_photo');
        const fileNameSpan = document.getElementById('selected-file-name');
        let previewImg = document.getElementById('profile-photo-preview');
        console.log('JS cargado, previewImg:', previewImg);

        if(label && input) {
            label.addEventListener('click', function(e) {
                input.click();
            });
            input.addEventListener('change', function(e) {
                if (input.files && input.files[0]) {
                    fileNameSpan.textContent = input.files[0].name;
                    const reader = new FileReader();
                    reader.onload = function (e) {
                        previewImg = document.getElementById('profile-photo-preview');
                        console.log('Preview encontrado:', previewImg, 'Tag:', previewImg && previewImg.tagName);
                        if(previewImg && previewImg.tagName === 'IMG') {
                            previewImg.src = e.target.result;
                            console.log('Imagen actualizada');
                        } else if (previewImg && previewImg.tagName === 'DIV') {
                            // Reemplaza el div por una imagen real para la previsualización
                            const img = document.createElement('img');
                            img.src = e.target.result;
                            img.alt = 'Previsualización de foto';
                            img.id = 'profile-photo-preview';
                            img.style.width = '92px';
                            img.style.height = '92px';
                            img.style.borderRadius = '50%';
                            img.style.objectFit = 'cover';
                            img.style.border = '3px solid #22c55e';
                            img.style.boxShadow = '0 2px 14px 0 rgba(34,197,94,0.13)';
                            previewImg.parentNode.replaceChild(img, previewImg);
                            console.log('Div reemplazado por imagen');
                        } else {
                            console.log('No se encontró previewImg');
                        }
                    };
                    reader.readAsDataURL(input.files[0]);
                } else {
                    fileNameSpan.textContent = '';
                }
            });
        } else {
            console.log('No se encontró el label o el input de foto');
        }
    });
</script>
@endsection
