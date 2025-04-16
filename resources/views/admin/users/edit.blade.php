@extends('layouts.base')

@section('title', 'Editar Usuario')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Editar Usuario</h1>
        <a href="{{ route('admin.users') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Volver
        </a>
    </div>

    <div class="card">
        <div class="card-body">
            <form action="{{ route('admin.users.update', $user) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label for="name" class="form-label">Nombre</label>
                    <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name', $user->name) }}" required>
                    @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email', $user->email) }}" required>
                    @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Roles</label>
                    <div class="form-check">
                        @foreach($roles as $role)
                            <input class="form-check-input" type="checkbox" name="roles[]" id="role_{{ $role->id }}" value="{{ $role->name }}" {{ $user->hasRole($role->name) ? 'checked' : '' }}>
                            <label class="form-check-label" for="role_{{ $role->id }}">
                                {{ __('roles.roles.' . $role->name) }}
                            </label>
                        @endforeach
                    </div>
                    @error('roles')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="d-flex justify-content-end">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Guardar Cambios
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
