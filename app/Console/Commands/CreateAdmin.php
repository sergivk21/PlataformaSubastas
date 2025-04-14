<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class CreateAdmin extends Command
{
    protected $signature = 'admin:create {email} {password}';
    protected $description = 'Crear un nuevo administrador';

    public function handle(): void
    {
        $email = $this->argument('email');
        $password = $this->argument('password');

        // Verificar si el usuario ya existe
        if (User::where('email', $email)->exists()) {
            $this->error('El usuario ya existe.');
            return;
        }

        // Crear el usuario
        $user = User::create([
            'name' => 'Administrador',
            'email' => $email,
            'password' => Hash::make($password),
        ]);

        // Asignar el rol de admin
        $role = Role::findOrCreate('admin');
        $user->assignRole($role);

        $this->info('Administrador creado exitosamente!');
    }
}
