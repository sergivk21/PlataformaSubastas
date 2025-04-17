@extends('layouts.mobile.base')

@section('content')
<div style="min-height:100vh; background: #f1f5f9;">
  <div class="w-full max-w-md mx-auto mt-4 mb-4 px-2">
    <div class="bg-white rounded-2xl shadow-xl px-3 py-4 flex flex-col items-center">
      <div class="w-full flex items-center justify-center mb-2 gap-3">
        @php
          $photoExists = $user->profile_photo && file_exists(public_path('storage/' . $user->profile_photo));
        @endphp
        @if($photoExists)
          <img src="{{ asset('storage/' . $user->profile_photo) }}" alt="Foto de perfil" class="rounded-full object-cover border border-blue-200 shadow" id="profile-photo-preview" style="width:60px;height:60px;min-width:60px;min-height:60px;max-width:60px;max-height:60px;">
        @else
          <div class="rounded-full flex items-center justify-center bg-gray-200 text-gray-500 border border-blue-100 shadow" id="profile-photo-preview" style="width:60px;height:60px;min-width:60px;min-height:60px;max-width:60px;max-height:60px;">
            <i class="fas fa-user" style="font-size:2rem;"></i>
          </div>
        @endif
        <span class="text-2xl font-bold text-gray-800 ml-3" style="font-weight:900; font-size:2rem;">{{ $user->name }}</span>
      </div>

      @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-2 rounded relative mb-4 text-xs w-full text-center" role="alert">
          <span>{{ session('success') }}</span>
        </div>
      @endif

      <div class="w-full flex flex-col items-center mb-4">
        <div class="flex flex-col items-center mt-2">
          <label for="profile_photo" class="text-xs font-medium text-blue-700 cursor-pointer hover:underline">Cambiar foto</label>
          <input type="file" name="profile_photo" id="profile_photo" accept="image/*" class="hidden">
          <span id="selected-file-name" class="text-xs text-gray-500 mt-1"></span>
        </div>
        <span class="text-xs text-gray-500 mt-2">JPG, PNG, GIF. Máx: 2MB.</span>
        <div style="height: 1.25rem;"></div>
      </div>

      <form action="{{ route('profile.update') }}" method="POST" class="w-full flex flex-col gap-3" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="flex flex-col gap-3">
          <div>
            <label for="name" class="block text-xs font-medium text-gray-700 mb-1">Nombre</label>
            <input type="text" name="name" id="name" value="{{ old('name', $user->name) }}" class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-xs py-2 px-3" required>
          </div>
          <div>
            <label for="email" class="block text-xs font-medium text-gray-700 mb-1">Correo electrónico</label>
            <input type="email" name="email" id="email" value="{{ old('email', $user->email) }}" class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-xs py-2 px-3" required>
          </div>
          <div style="height: 1.25rem;"></div>
          <div>
            <label for="password" class="block text-xs font-medium text-gray-700 mb-1">Contraseña</label>
            <input type="password" name="password" id="password" class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-xs py-2 px-3">
          </div>
          <div>
            <label for="password_confirmation" class="block text-xs font-medium text-gray-700 mb-1">Confirmar contraseña</label>
            <input type="password" name="password_confirmation" id="password_confirmation" class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-xs py-2 px-3"><p style="margin:0;padding:0;line-height:1;font-size:13px;color:#9ca3af;font-style:italic;">(Dejar en blanco para mantener la contraseña actual)</p>
          </div>
        </div>
        <div style="height: 1.25rem;"></div>
        <button type="submit"
          style="width:100%;background:linear-gradient(90deg,#22c55e 0%,#16a34a 100%);color:white;font-weight:bold;padding:0.5rem 0;border-radius:0.5rem;margin-top:0.5rem;box-shadow:0 4px 14px 0 rgba(34,197,94,0.15);display:flex;align-items:center;justify-content:center;gap:0.5rem;font-size:1rem;transition:background 0.2s;"
          onmouseover="this.style.background='linear-gradient(90deg,#16a34a 0%,#059669 100%)'"
          onmouseout="this.style.background='linear-gradient(90deg,#22c55e 0%,#16a34a 100%)'"
        >
          <i class="fas fa-save"></i> Guardar Cambios
        </button>
      </form>

      <div class="w-full flex flex-col gap-3" style="margin-top:2rem;">
        <a href="{{ route('auctions.mobile.index') }}"
           style="display:flex;align-items:center;justify-content:center;width:100%;padding:0.75rem 0;border-radius:0.75rem;background:linear-gradient(90deg,#2563eb 0%,#1e40af 100%);color:white;font-weight:700;font-size:1rem;box-shadow:0 4px 14px 0 rgba(37,99,235,0.12);margin-bottom:0.25rem;gap:0.5rem;transition:background 0.2s;"
           onmouseover="this.style.background='linear-gradient(90deg,#1e40af 0%,#2563eb 100%)'"
           onmouseout="this.style.background='linear-gradient(90deg,#2563eb 0%,#1e40af 100%)'"
        >
          <i class="fas fa-gavel"></i> Ver todas las subastas
        </a>
        <a href="{{ route('auctions.mobile.index') }}"
           style="display:flex;align-items:center;justify-content:center;width:100%;padding:0.75rem 0;border-radius:0.75rem;background:linear-gradient(90deg,#64748b 0%,#334155 100%);color:white;font-weight:700;font-size:1rem;box-shadow:0 4px 14px 0 rgba(100,116,139,0.10);margin-bottom:0.25rem;gap:0.5rem;transition:background 0.2s;"
           onmouseover="this.style.background='linear-gradient(90deg,#334155 0%,#64748b 100%)'"
           onmouseout="this.style.background='linear-gradient(90deg,#64748b 0%,#334155 100%)'"
        >
          <i class="fas fa-history"></i> Ver historial de pujas
        </a>
        <a href="{{ route('auctions.mobile.index') }}"
           style="display:flex;align-items:center;justify-content:center;width:100%;padding:0.75rem 0;border-radius:0.75rem;background:linear-gradient(90deg,#facc15 0%,#eab308 100%);color:#92400e;font-weight:700;font-size:1rem;box-shadow:0 4px 14px 0 rgba(250,204,21,0.13);gap:0.5rem;transition:background 0.2s;"
           onmouseover="this.style.background='linear-gradient(90deg,#eab308 0%,#facc15 100%)'"
           onmouseout="this.style.background='linear-gradient(90deg,#facc15 0%,#eab308 100%)'"
        >
          <i class="fas fa-trophy"></i> Ver subastas ganadas
        </a>
      </div>

      <form method="POST" action="{{ route('logout') }}" style="margin-top:2.5rem;">
        @csrf
        <button type="submit"
          style="width:100%;background:linear-gradient(90deg,#dc2626 0%,#b91c1c 100%);color:white;font-weight:bold;padding:0.75rem 0;border-radius:0.75rem;box-shadow:0 4px 14px 0 rgba(220,38,38,0.13);display:flex;align-items:center;justify-content:center;gap:0.5rem;font-size:1rem;transition:background 0.2s;"
          onmouseover="this.style.background='linear-gradient(90deg,#b91c1c 0%,#dc2626 100%)'"
          onmouseout="this.style.background='linear-gradient(90deg,#dc2626 0%,#b91c1c 100%)'"
        >
          <i class="fas fa-sign-out-alt"></i> Cerrar Sesión
        </button>
      </form>
    </div>
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
