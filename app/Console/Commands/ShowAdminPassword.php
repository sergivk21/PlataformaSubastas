<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;

class ShowAdminPassword extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'admin:show-password {email}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Mostrar la contraseña actual de un administrador';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $email = $this->argument('email');

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

        // Mostrar la contraseña actual
        $this->info('Contraseña actual: ' . $user->password);
        $this->warn('¡Importante! La contraseña está hasheada y no se puede leer en texto plano.');
        $this->line('Para acceder al sistema, usa la contraseña que ingresaste al crear el usuario.');
    }
}
