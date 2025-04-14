<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;

class UpdateAdminPassword extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'admin:update-password {email} {newPassword}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Actualizar la contraseña de un administrador';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $email = $this->argument('email');
        $newPassword = $this->argument('newPassword');

        // Buscar el usuario
        $user = User::where('email', $email)->first();

        if (!$user) {
            $this->error('Usuario no encontrado.');
            return;
        }

        // Verificar si es un administrador
        if (!$user->hasRole('admin')) {
            $this->error('El usuario no es un administrador.');
            return;
        }

        // Actualizar la contraseña
        $user->password = Hash::make($newPassword);
        $user->save();

        $this->info('Contraseña actualizada exitosamente!');
    }
}
