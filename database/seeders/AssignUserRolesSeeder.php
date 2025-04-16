<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Spatie\Permission\Models\Role;

class AssignUserRolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Obtener el rol de usuario
        $userRole = Role::where('name', 'user')->first();
        
        if (!$userRole) {
            $this->command->info('El rol de usuario no existe. Por favor, ejecuta el RoleSeeder primero.');
            return;
        }

        // Asignar el rol de usuario a todos los usuarios que no tengan un rol
        User::whereDoesntHave('roles')->get()->each(function ($user) use ($userRole) {
            $user->assignRole($userRole);
        });

        $this->command->info('Roles de usuario asignados exitosamente.');
    }
}
