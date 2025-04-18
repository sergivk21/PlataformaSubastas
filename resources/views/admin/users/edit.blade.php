@extends('layouts.base')

@section('title', 'Editar Usuario')

@section('content')
<style>
    .edit-user-card {
        max-width: 510px;
        margin: 0 auto;
        background: #fff;
        border-radius: 1.3rem;
        box-shadow: 0 2px 16px 0 rgba(31,38,135,0.11);
        padding: 2.2rem 2.1rem 2rem 2.1rem;
        margin-bottom: 2.2rem;
    }
    .edit-user-avatar {
        width: 70px;
        height: 70px;
        border-radius: 50%;
        object-fit: cover;
        border: 2.5px solid #2563eb;
        margin-bottom: 0.7rem;
        display: block;
        margin-left: auto;
        margin-right: auto;
        background: #f1f5f9;
    }
    .edit-user-name {
        text-align: center;
        font-size: 1.25rem;
        font-weight: 700;
        color: #1e293b;
        margin-bottom: 0.7rem;
    }
    .edit-user-roles {
        text-align: center;
        margin-bottom: 1.1rem;
    }
    .edit-user-role-badge {
        background: #2563eb;
        color: #fff;
        border-radius: 0.5rem;
        padding: 0.22em 0.9em;
        font-size: 0.98em;
        font-weight: 500;
        margin-right: 0.3em;
        margin-bottom: 0.2em;
        display: inline-block;
    }
    .edit-user-form-label {
        font-weight: 600;
        color: #2563eb;
        font-size: 1em;
    }
    .edit-user-form-input, .edit-user-form-select {
        width: 100%;
        border-radius: 0.5em;
        border: 1px solid #cbd5e1;
        padding: 0.6em 1em;
        font-size: 1em;
        margin-bottom: 0.7em;
    }
    .edit-user-form-checkbox {
        accent-color: #2563eb;
        margin-right: 0.5em;
    }
    .edit-user-save-btn {
        background: #2563eb;
        color: #fff;
        border: none;
        border-radius: 0.5rem;
        padding: 0.65em 1.5em;
        font-size: 1.07em;
        font-weight: 600;
        text-decoration: none;
        box-shadow: 0 1px 4px rgba(31,38,135,0.09);
        transition: background 0.2s;
        display: flex;
        align-items: center;
        gap: 0.5em;
        margin-left: auto;
    }
    .edit-user-save-btn:hover {
        background: #1d4ed8;
    }
</style>
<div class="container-fluid px-4 px-md-5" style="max-width: 1200px; margin-left: auto; margin-right: auto;">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Editar Usuario</h1>
        <a href="{{ route('admin.users') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Volver
        </a>
    </div>
    <div class="edit-user-card">
        @php
            $photoExists = !empty($user->profile_photo) && file_exists(public_path('storage/' . $user->profile_photo));
        @endphp
        @if($photoExists)
            <img src="{{ asset('storage/' . $user->profile_photo) }}" alt="Foto de perfil" class="edit-user-avatar">
        @elseif($user->profile_photo_path)
            <img src="{{ $user->profile_photo_url }}" alt="Foto de perfil" class="edit-user-avatar">
        @else
            <div class="edit-user-avatar" style="display:flex;align-items:center;justify-content:center;background:#2563eb;color:#fff;font-size:2.2rem;font-weight:700;">{{ strtoupper(mb_substr($user->name,0,1)) }}</div>
        @endif
        <div class="edit-user-name">{{ $user->name }}</div>
        <div class="edit-user-roles">
            @foreach($user->getRoleNames() as $role)
                <span class="edit-user-role-badge">{{ __('roles.roles.' . $role) }}</span>
            @endforeach
        </div>
        <form action="{{ route('admin.users.update', $user) }}" method="POST">
            @csrf
            @method('PUT')
            <div>
                <label for="name" class="edit-user-form-label">Nombre</label>
                <input type="text" class="edit-user-form-input @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name', $user->name) }}" required>
                @error('name')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div>
                <label for="email" class="edit-user-form-label">Email</label>
                <input type="email" class="edit-user-form-input @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email', $user->email) }}" required>
                @error('email')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div>
                <label class="edit-user-form-label">Roles</label>
                <div style="display: flex; flex-wrap: wrap; gap: 1.2em 1.7em; align-items: center; margin-bottom: 0.5em;">
                    @foreach($roles as $role)
                        <label for="role_{{ $role->id }}" style="display: flex; align-items: center; gap: 0.5em; margin-bottom: 0; cursor:pointer;">
                            <input class="edit-user-form-checkbox" type="checkbox" name="roles[]" id="role_{{ $role->id }}" value="{{ $role->name }}" {{ $user->hasRole($role->name) ? 'checked' : '' }}>
                            {{ __('roles.roles.' . $role->name) }}
                        </label>
                    @endforeach
                </div>
                @error('roles')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div style="display:flex;justify-content:flex-end;margin-top:1.5em;">
                <button type="submit" class="edit-user-save-btn">
                    <i class="fas fa-save"></i> Guardar Cambios
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
