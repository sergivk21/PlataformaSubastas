@extends('layouts.mobile.base')

@section('title', 'Editar Usuario')

@section('content')
<div style="min-height:100vh; background: #f1f5f9;">
  <div class="w-full max-w-md mx-auto mt-4 mb-4 px-2">
    <div class="bg-white rounded-2xl shadow-xl px-3 py-4 flex flex-col items-center">
      <h2 style="font-size:1.25rem;font-weight:700;color:#2563eb;margin-bottom:1.2rem;">Editar Usuario</h2>
      @if(session('success'))
        <div style="background:#d1fae5;color:#065f46;border-radius:0.6em;padding:0.7em 1em;margin-bottom:1em;text-align:center;font-size:0.99em;font-weight:500;box-shadow:0 1px 4px rgba(31,38,135,0.07);">
            {{ session('success') }}
        </div>
      @endif
      @if(session('error'))
        <div style="background:#fee2e2;color:#991b1b;border-radius:0.6em;padding:0.7em 1em;margin-bottom:1em;text-align:center;font-size:0.99em;font-weight:500;box-shadow:0 1px 4px rgba(31,38,135,0.07);">
            {{ session('error') }}
        </div>
      @endif
      <form action="{{ route('admin.mobile.users.update', $user->id) }}" method="POST" style="width:100%;" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div style="display:flex;flex-direction:column;gap:1.2em;">
          <div style="display:flex;flex-direction:column;align-items:center;gap:0.7em;">
            @php
              $photoExists = !empty($user->profile_photo) && file_exists(public_path('storage/' . $user->profile_photo));
            @endphp
            @if($photoExists)
              <img src="{{ asset('storage/' . $user->profile_photo) }}" alt="Foto de perfil" class="rounded-full object-cover border border-blue-200 shadow" style="width:60px;height:60px;min-width:60px;min-height:60px;max-width:60px;max-height:60px;">
            @elseif($user->profile_photo_path)
              <img src="{{ $user->profile_photo_url }}" alt="Foto de perfil" class="rounded-full object-cover border border-blue-200 shadow" style="width:60px;height:60px;min-width:60px;min-height:60px;max-width:60px;max-height:60px;">
            @else
              <span class="text-2xl font-bold text-gray-800 ml-3" style="font-weight:900; font-size:2rem;">{{ $user->name }}</span>
            @endif
          </div>
          <div>
            <label for="name" style="font-size:0.98em;font-weight:500;color:#2563eb;">Nombre</label>
            <input type="text" name="name" id="name" value="{{ old('name', $user->name) }}" style="width:100%;border-radius:0.5em;border:1px solid #cbd5e1;padding:0.6em 1em;font-size:1em;">
          </div>
          <div>
            <label for="email" style="font-size:0.98em;font-weight:500;color:#2563eb;">Correo electrónico</label>
            <input type="email" name="email" id="email" value="{{ old('email', $user->email) }}" style="width:100%;border-radius:0.5em;border:1px solid #cbd5e1;padding:0.6em 1em;font-size:1em;">
          </div>
          <div>
            <label for="roles" style="font-size:0.98em;font-weight:500;color:#2563eb;">Roles</label>
            <select name="roles[]" id="roles" multiple style="width:100%;border-radius:0.5em;border:1px solid #cbd5e1;padding:0.6em 1em;font-size:1em;">
              @foreach($roles as $role)
                <option value="{{ $role->name }}" {{ $user->roles->contains('name', $role->name) ? 'selected' : '' }}>{{ __("roles.roles.".$role->name) }}</option>
              @endforeach
            </select>
          </div>
        </div>
        <button type="submit" style="width:100%;background:#2563eb;color:white;font-weight:bold;padding:0.7em 0;border-radius:0.5em;margin-top:1.3em;box-shadow:0 4px 14px 0 rgba(31,38,135,0.12);font-size:1.09em;">Guardar cambios</button>
      </form>
    </div>
  </div>
</div>
@endsection
