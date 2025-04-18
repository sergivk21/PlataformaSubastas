@extends('layouts.base')

@section('title', 'Gestión de Usuarios')

@section('content')
<div class="container-fluid px-4 px-md-5" style="max-width: 1200px; margin-left: auto; margin-right: auto;">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Gestión de Usuarios</h1>
    </div>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="card" style="border-radius: 1.2rem; box-shadow: 0 2px 16px 0 rgba(31,38,135,0.10); border: none;">
        <div class="card-body" style="padding: 2rem;">
            <div class="table-responsive">
                <table class="table table-hover align-middle" style="background: #fff; border-radius: 1rem; overflow: hidden;">
                    <thead style="background: #f3f4f6;">
                        <tr style="border-bottom: 2px solid #e5e7eb;">
                            <th style="padding: 1rem; color: #2563eb; font-weight: 700; letter-spacing: 0.03em;">Nombre</th>
                            <th style="padding: 1rem; color: #2563eb; font-weight: 700; letter-spacing: 0.03em;">Email</th>
                            <th style="padding: 1rem; color: #2563eb; font-weight: 700; letter-spacing: 0.03em;">Roles</th>
                            <th style="padding: 1rem; color: #2563eb; font-weight: 700; letter-spacing: 0.03em;">Última actividad</th>
                            <th style="padding: 1rem; color: #2563eb; font-weight: 700; letter-spacing: 0.03em;">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($users as $user)
                            <tr style="border-bottom: 1px solid #f1f5f9; transition: background 0.2s;">
                                <td style="padding: 0.8rem 1rem; vertical-align: middle; font-weight: 500; color: #1e293b;">{{ $user->name }}</td>
                                <td style="padding: 0.8rem 1rem; vertical-align: middle; color: #334155;">{{ $user->email }}</td>
                                <td style="padding: 0.8rem 1rem; vertical-align: middle;">
                                    @foreach($user->getRoleNames() as $role)
                                        <span style="background: #2563eb; color: #fff; border-radius: 0.5rem; padding: 0.35em 0.8em; font-size: 0.93em; margin-right: 0.2em; font-weight: 500;">{{ __('roles.roles.' . $role) }}</span>
                                    @endforeach
                                </td>
                                <td style="padding: 0.8rem 1rem; vertical-align: middle; color: #64748b; font-size: 0.98em;">
                                    {{ $user->last_activity ? $user->last_activity->diffForHumans() : 'Nunca' }}
                                </td>
                                <td style="padding: 0.8rem 1rem; vertical-align: middle;">
                                    <a href="{{ route('admin.users.edit', $user) }}" style="background: #2563eb; color: #fff; border: none; border-radius: 0.5rem; padding: 0.45em 1.1em; font-size: 0.98em; font-weight: 600; text-decoration: none; box-shadow: 0 1px 4px rgba(31,38,135,0.08); transition: background 0.2s;">
                                        <i class="fas fa-edit"></i> Editar
                                    </a>
                                    @if(auth()->user()->hasRole('admin'))
                                        <form action="{{ route('admin.users.delete', $user->id) }}" method="POST" style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" onclick="return confirm('¿Seguro que deseas eliminar este usuario?')" style="background:#e11d48;color:#fff;border:none;padding:0.35em 1em;border-radius:0.5em;font-size:0.97em;font-weight:600;margin-left:0.5em;box-shadow:0 1px 4px rgba(31,38,135,0.08);cursor:pointer;">Eliminar</button>
                                        </form>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div style="margin-top: 1.2rem; display: flex; justify-content: center;">
                {{ $users->links() }}
            </div>
        </div>
    </div>
</div>
@endsection
