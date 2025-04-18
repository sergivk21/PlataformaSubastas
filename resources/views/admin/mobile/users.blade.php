@extends('layouts.mobile.base')

@section('title', 'Gestionar Usuarios')

@section('content')
<style>
    .mobile-user-card {
        background: #fff;
        border-radius: 1.2rem;
        box-shadow: 0 2px 16px 0 rgba(31,38,135,0.09);
        padding: 1.2rem 1rem 1rem 1rem;
        margin-bottom: 1.1rem;
        display: flex;
        flex-direction: column;
        gap: 0.5rem;
    }
    .mobile-user-header {
        display: flex;
        align-items: center;
        gap: 0.7rem;
        margin-bottom: 0.2rem;
    }
    .mobile-user-avatar {
        width: 34px;
        height: 34px;
        border-radius: 50%;
        object-fit: cover;
        border: 2px solid #e0e7ef;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.1rem;
        font-weight: bold;
        background: #2563eb;
        color: #fff;
        text-transform: uppercase;
        overflow: hidden;
    }
    .mobile-user-name {
        font-weight: 600;
        color: #1e293b;
        font-size: 1.07rem;
    }
    .mobile-user-email {
        font-size: 0.93rem;
        color: #64748b;
        margin-left: auto;
    }
    .mobile-user-roles {
        font-size: 0.92rem;
        color: #2563eb;
        font-weight: 500;
        margin-bottom: 0.15rem;
        display: flex;
        flex-wrap: wrap;
        gap: 0.3rem;
    }
    .mobile-user-role-badge {
        background: #2563eb;
        color: #fff;
        border-radius: 0.5rem;
        padding: 0.18em 0.7em;
        font-size: 0.92em;
        font-weight: 500;
        margin-right: 0.1em;
    }
    .mobile-user-activity {
        font-size: 0.91rem;
        color: #64748b;
        margin-bottom: 0.2rem;
    }
    .mobile-user-actions {
        display: flex;
        gap: 0.6rem;
        margin-top: 0.2rem;
    }
    .mobile-user-edit-btn {
        background: #2563eb;
        color: #fff;
        border: none;
        border-radius: 0.5rem;
        padding: 0.38em 1em;
        font-size: 0.97em;
        font-weight: 600;
        text-decoration: none;
        box-shadow: 0 1px 4px rgba(31,38,135,0.08);
        transition: background 0.2s;
        display: flex;
        align-items: center;
        gap: 0.4em;
    }
    .mobile-user-edit-btn:hover {
        background: #1d4ed8;
    }
</style>
<div class="px-4 py-4">
    <h1 style="font-size:1.25rem;font-weight:700;text-align:center;margin-bottom:1.1rem;color:#2563eb;">Gestionar Usuarios</h1>
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
    <div style="display:flex;flex-direction:column;gap:0.6rem;">
        @foreach($users as $user)
            <div class="mobile-user-card">
                <div class="mobile-user-header">
                    @php
                        $hasCustomPhoto = false;
                        $photoUrl = null;
                        // 1. Foto personalizada subida en mobile (profile_photo en storage)
                        if (!empty($user->profile_photo) && file_exists(public_path('storage/' . $user->profile_photo))) {
                            $hasCustomPhoto = true;
                            $photoUrl = asset('storage/' . $user->profile_photo);
                        } 
                        // 2. Foto Jetstream (profile_photo_path)
                        elseif (!empty($user->profile_photo_path)) {
                            $hasCustomPhoto = true;
                            $photoUrl = $user->profile_photo_url;
                        }
                    @endphp
                    @if($hasCustomPhoto)
                        <img src="{{ $photoUrl }}" class="mobile-user-avatar" alt="{{ $user->name }}">
                    @else
                        <div class="mobile-user-avatar">{{ strtoupper(mb_substr($user->name,0,1)) }}</div>
                    @endif
                    <span class="mobile-user-name">{{ $user->name }}</span>
                    <span class="mobile-user-email">{{ $user->email }}</span>
                </div>
                <div class="mobile-user-roles">
                    @foreach($user->getRoleNames() as $role)
                        <span class="mobile-user-role-badge">{{ __('roles.roles.' . $role) }}</span>
                    @endforeach
                </div>
                <div class="mobile-user-activity">
                    Última actividad: {{ $user->last_activity ? $user->last_activity->diffForHumans() : 'Nunca' }}
                </div>
                <div class="mobile-user-actions">
                    <a href="{{ route('admin.mobile.users.edit', $user->id) }}" class="mobile-user-edit-btn">
                        <i class="fas fa-edit"></i> Editar
                    </a>
                    @if(auth()->user()->hasRole('admin'))
                        <form action="{{ route('admin.users.delete', $user->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <input type="hidden" name="origin" value="mobile">
                            <button type="submit" onclick="return confirm('¿Seguro que deseas eliminar este usuario?')" style="background:#e11d48;color:#fff;border:none;padding:0.38em 1em;border-radius:0.5rem;font-size:0.97em;font-weight:600;box-shadow:0 1px 4px rgba(31,38,135,0.08);margin-left:0.5em;">Eliminar</button>
                        </form>
                    @endif
                </div>
            </div>
        @endforeach
    </div>
    <div style="margin-top:1.5rem;display:flex;justify-content:center;">
        {{ $users->links() }}
    </div>
</div>
@endsection
