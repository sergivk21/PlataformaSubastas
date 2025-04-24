@extends('layouts.mobile.base')

@section('content')
<style>
    body, .profile-mobile-bg {
        background: #f1f5f9 !important;
    }
    .profile-mobile-card {
        max-width: 430px;
        margin: 2.2rem auto 2.2rem auto;
        background: #fff;
        border-radius: 1.2rem;
        box-shadow: 0 4px 16px 0 rgba(31,38,135,0.12);
        padding: 2.1rem 1.2rem 1.7rem 1.2rem;
        box-sizing: border-box;
        width: 100%;
        display: flex;
        flex-direction: column;
        align-items: center;
    }
    .profile-mobile-title {
        text-align: center;
        font-size: 1.3rem;
        font-weight: 800;
        color: #2563eb;
        margin-bottom: 1.3rem;
        letter-spacing: -0.5px;
    }
    .profile-mobile-label {
        display: block;
        font-size: 1em;
        font-weight: 700;
        color: #2563eb;
        margin-bottom: 0.35em;
        letter-spacing: 0.01em;
    }
    .profile-mobile-input {
        width: 100%;
        border-radius: 0.9em;
        border: 1.5px solid #dbeafe;
        box-shadow: 0 1px 4px rgba(31,38,135,0.07);
        padding: 1em 1.1em;
        font-size: 1.08em;
        background: #f8fafc;
        margin-bottom: 1.1em;
        font-weight: 500;
        transition: border 0.2s, box-shadow 0.2s;
    }
    .profile-mobile-input:focus {
        border: 1.5px solid #2563eb;
        outline: none;
        box-shadow: 0 2px 8px 0 rgba(37,99,235,0.10);
        background: #fff;
    }
    .profile-mobile-avatar {
        margin-bottom: 1.1rem;
        display: flex;
        align-items: center;
        justify-content: center;
        width: 100%;
    }
    .profile-mobile-avatar-img {
        width: 84px;
        height: 84px;
        border-radius: 50%;
        object-fit: cover;
        border: 3px solid #2563eb;
        box-shadow: 0 2px 8px 0 rgba(37,99,235,0.13);
        background: #fff;
        transition: box-shadow 0.2s;
    }
    .profile-mobile-avatar-initial {
        width: 84px;
        height: 84px;
        border-radius: 50%;
        background: linear-gradient(135deg, #2563eb 60%, #1e40af 100%);
        color: #fff;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 2.6rem;
        font-weight: 800;
        border: 3px solid #2563eb;
        box-shadow: 0 2px 8px 0 rgba(37,99,235,0.13);
        text-transform: uppercase;
        letter-spacing: -1px;
        user-select: none;
    }
    .profile-mobile-photo-area {
        display: flex;
        flex-direction: column;
        align-items: center;
        margin-bottom: 1.2rem;
        width: 100%;
    }
    .profile-mobile-photo-btn {
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
    .profile-mobile-photo-btn:hover, .profile-mobile-photo-btn:focus {
        background: linear-gradient(90deg, #1e40af 0%, #2563eb 100%);
        box-shadow: 0 4px 14px 0 rgba(37,99,235,0.13);
        outline: none;
    }
    .profile-mobile-photo-filename {
        display: block;
        margin-top: 0.4em;
        color: #64748b;
        font-size: 0.95em;
        font-style: italic;
    }
    input[type="file"].hidden {
        display: none !important;
    }
    .profile-mobile-main-btn { display:unset !important; }

    /* Reset total para <a> y <button> dentro del perfil móvil */
    #profile-mobile-btns a, #profile-mobile-btns button {
      all: unset;
      display: flex !important;
      align-items: center !important;
      justify-content: center !important;
      width: 100% !important;
      min-height: 40px !important;
      padding: 0.45rem 0 !important;
      border-radius: 0.5rem !important;
      font-size: 0.98rem !important;
      font-weight: bold !important;
      box-shadow: 0 4px 14px 0 rgba(34,197,94,0.15) !important;
      gap: 0.4rem !important;
      margin-top: 1rem !important;
      cursor: pointer !important;
      text-decoration: none !important;
      border: none !important;
      transition: background 0.2s, box-shadow 0.2s !important;
    }
    #profile-mobile-btns .save-btn {
      background: linear-gradient(90deg,#22c55e 0%,#16a34a 100%) !important;
      color: white !important;
      margin-top: 0.5rem !important;
    }
    #profile-mobile-btns .logout-btn {
      background: linear-gradient(90deg,#dc2626 0%,#b91c1c 100%) !important;
      color: white !important;
    }
    #profile-mobile-btns i {
      font-size: 1.05em !important;
    }
    body, input, button, textarea, select {
        font-family: 'Figtree', Arial, sans-serif !important;
    }
</style>
<div class="profile-mobile-bg" style="min-height:100vh; background: #f1f5f9;">
  <div class="profile-mobile-card">
    <div class="profile-mobile-avatar">
      @php
        $photoExists = $user->profile_photo && file_exists(public_path('storage/' . $user->profile_photo));
        $initial = strtoupper(mb_substr($user->name, 0, 1));
      @endphp
      @if($photoExists)
        <img src="{{ asset('storage/' . $user->profile_photo) }}" alt="Foto de perfil" class="profile-mobile-avatar-img" id="profile-photo-preview">
      @else
        <div class="profile-mobile-avatar-initial" id="profile-photo-preview">
          {{ $initial }}
        </div>
      @endif
    </div>
    <div class="profile-mobile-name" style="text-align:center;margin-bottom:0.5rem;">
      <span class="text-2xl font-bold text-gray-800" style="font-weight:900; font-size:2rem;">{{ $user->name }}</span>
    </div>
    @if(session('success'))
      <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-2 rounded relative mb-4 text-xs w-full text-center" role="alert">
        <span>{{ session('success') }}</span>
      </div>
    @endif
    @if(session('error'))
      <div id="profile-mobile-error-toast" style="position:fixed;top:36px;left:50%;transform:translateX(-50%);z-index:9999;animation:fade-in-down 0.7s cubic-bezier(0.4,0,0.2,1);min-width:320px;max-width:95vw;">
        <div style="background:#fff;border:2px solid #ef4444;color:#991b1b;padding:1.1em 1.4em;border-radius:1.2em;box-shadow:0 6px 32px 0 rgba(239,68,68,0.18);display:flex;align-items:center;gap:1.1em;">
          <div style="display:flex;align-items:center;justify-content:center;width:2.8em;height:2.8em;border-radius:50%;background:#fee2e2;">
            <i class="fas fa-times-circle" style="font-size:2em;color:#ef4444;"></i>
          </div>
          <div>
            <div style="font-weight:800;font-size:1.07em;margin-bottom:0.2em;">¡Acción no permitida!</div>
            <div style="font-size:0.98em;opacity:0.85;">{{ session('error') }}</div>
          </div>
        </div>
      </div>
      <style>@keyframes fade-in-down{from{opacity:0;transform:translateY(-40px);}to{opacity:1;transform:translateY(0);}}</style>
    @endif
    <form method="POST" action="{{ route('profile.mobile.update') }}" enctype="multipart/form-data">
      @csrf
      @method('PUT')
      <div class="profile-mobile-photo-area">
        <button type="button" class="profile-mobile-photo-btn" id="photo-upload-btn">
          <i class="fas fa-camera"></i> Cambiar foto
        </button>
        <input type="file" name="profile_photo" id="profile_photo" accept="image/*" class="hidden" style="display:none;">
        <span id="selected-file-name" class="profile-mobile-photo-filename"></span>
        <span class="text-xs text-gray-500 mt-2">JPG, PNG, GIF. Máx: 5MB.</span>
        @if ($errors->has('profile_photo'))
            <div class="auth-mobile-alert auth-mobile-alert-error" style="margin-bottom:1em;">
                <span>{{ $errors->first('profile_photo') }}</span>
            </div>
        @endif
      </div>
      <div class="flex flex-col gap-3">
        <div>
          <label for="name" class="profile-mobile-label">Nombre</label>
          <input type="text" name="name" id="name" value="{{ old('name', $user->name) }}" class="profile-mobile-input" required>
        </div>
        <div>
          <label for="email" class="profile-mobile-label">Correo electrónico</label>
          <input type="email" name="email" id="email" value="{{ old('email', $user->email) }}" class="profile-mobile-input" required>
        </div>
        <div>
          <label for="password" class="profile-mobile-label">Contraseña</label>
          <input type="password" name="password" id="password" class="profile-mobile-input" placeholder="Nueva contraseña">
        </div>
        <div>
          <label for="password_confirmation" class="profile-mobile-label">Confirmar contraseña</label>
          <input type="password" name="password_confirmation" id="password_confirmation" class="profile-mobile-input" placeholder="Repite la contraseña">
          <p style="margin:0;padding:0;line-height:1;font-size:13px;color:#9ca3af;font-style:italic;">(Dejar en blanco para mantener la contraseña actual)</p>
        </div>
      </div>
      <!-- Tarjeta de cambio de rol (móvil, pill horizontal, sin explicación) -->
      @if(!$user->role_changed)
        <div class="profile-mobile-card" style="margin-bottom:1.5rem;">
          <h2 class="profile-mobile-title" style="margin-bottom:0.7rem;"><i class="fas fa-user-tag me-1"></i> Rol</h2>
          <div class="flex flex-row gap-4 justify-center mt-2">
            @if($user->hasRole('admin'))
              <div class="flex flex-col items-center">
                <input type="radio" name="role" value="admin" checked disabled class="accent-blue-500 w-7 h-7 shadow-md cursor-not-allowed">
                <span class="mt-2 text-sm font-bold text-blue-700 bg-blue-100 rounded-full px-4 py-1">Administrador</span>
              </div>
              <div class="flex flex-col items-center">
                <input type="radio" name="role" value="seller" disabled class="accent-blue-500 w-7 h-7 shadow-md cursor-not-allowed">
                <span class="mt-2 text-sm font-bold text-gray-600 bg-gray-100 rounded-full px-4 py-1">Vendedor</span>
              </div>
            @else
              <label class="flex flex-col items-center cursor-pointer">
                <input type="radio" name="role" value="bidder" {{ (old('role', $user->role ?? '') == 'bidder' || (!$user->role && $user->hasRole('bidder'))) ? 'checked' : '' }} class="accent-blue-500 w-7 h-7 shadow-md">
                <span class="mt-2 text-sm font-bold text-blue-700 bg-blue-100 rounded-full px-4 py-1">Pujador</span>
              </label>
              <label class="flex flex-col items-center cursor-pointer">
                <input type="radio" name="role" value="seller" {{ (old('role', $user->role ?? '') == 'seller' || (!$user->role && $user->hasRole('seller'))) ? 'checked' : '' }} class="accent-blue-500 w-7 h-7 shadow-md">
                <span class="mt-2 text-sm font-bold text-gray-600 bg-gray-100 rounded-full px-4 py-1">Vendedor</span>
              </label>
            @endif
          </div>
          <div class="mt-3 text-xs text-yellow-700 bg-yellow-100 rounded-lg px-4 py-2 text-center font-semibold" style="margin-top:1.2em;">
            <i class="fas fa-exclamation-triangle mr-2"></i>
            Si cambias de rol una vez, <b>no podrás volver a cambiarlo nunca</b>.
          </div>
        </div>
      @else
        <div class="profile-mobile-card" style="margin-bottom:1.5rem;">
          <h2 class="profile-mobile-title" style="margin-bottom:0.7rem;"><i class="fas fa-user-tag me-1"></i> Rol actual</h2>
          <div class="flex flex-row gap-4 justify-center mt-2">
            <div class="flex flex-col items-center">
              <input type="radio" name="role" value="{{ $user->getRoleNames()[0] }}" checked disabled class="accent-blue-500 w-7 h-7 shadow-md cursor-not-allowed">
              <span class="mt-2 text-sm font-bold text-blue-700 bg-blue-100 rounded-full px-4 py-1 text-center">
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
      <div style="height: 1.25rem;"></div>
      <div id="profile-mobile-btns">
        <button type="submit" class="save-btn">
          <i class="fas fa-save"></i> Guardar Cambios
        </button>
      </div>
    </form>
    <form method="POST" action="{{ route('logout') }}" style="width:100%;margin:0;padding:0;">
      @csrf
      <button type="submit" class="logout-btn" style="all:unset;display:flex;align-items:center;justify-content:center;width:100%;min-height:40px;padding:0.45rem 0;border-radius:0.5rem;font-size:0.98rem;font-weight:bold;box-shadow:0 4px 14px 0 rgba(34,197,94,0.15);gap:0.4rem;margin-top:1rem;cursor:pointer;text-decoration:none;border:none;transition:background 0.2s,box-shadow 0.2s;background:linear-gradient(90deg,#dc2626 0%,#b91c1c 100%);color:white;">
        <i class="fas fa-sign-out-alt" style="font-size:1.05em;"></i> Cerrar Sesión
      </button>
    </form>
  </div>
</div>
@endsection

@section('scripts')
<script>
  document.addEventListener('DOMContentLoaded', function() {
    const btn = document.getElementById('photo-upload-btn');
    const input = document.getElementById('profile_photo');
    const fileNameSpan = document.getElementById('selected-file-name');
    let previewImg = document.getElementById('profile-photo-preview');

    if(btn && input) {
      btn.addEventListener('click', function(e) {
        console.log('Botón cambiar foto pulsado');
        input.click();
      });
      input.addEventListener('change', function(e) {
        if (input.files && input.files[0]) {
          fileNameSpan.textContent = input.files[0].name;
          const reader = new FileReader();
          reader.onload = function (e) {
            previewImg = document.getElementById('profile-photo-preview');
            if(previewImg && previewImg.tagName === 'IMG') {
              previewImg.src = e.target.result;
            } else if (previewImg && previewImg.tagName === 'DIV') {
              previewImg.style.background = `url('${e.target.result}') center center/cover no-repeat, linear-gradient(135deg, #2563eb 60%, #1e40af 100%)`;
              previewImg.textContent = '';
            }
          };
          reader.readAsDataURL(input.files[0]);
        } else {
          fileNameSpan.textContent = '';
        }
      });
    } else {
      console.error('No se encontró el botón o el input de foto');
    }
  });
</script>
@endsection
