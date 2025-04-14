<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Crear roles
        $adminRole = Role::create(['name' => 'admin']);
        $sellerRole = Role::create(['name' => 'seller']);
        $bidderRole = Role::create(['name' => 'bidder']);

        // Crear permisos
        Permission::create(['name' => 'manage users']);
        Permission::create(['name' => 'manage auctions']);
        Permission::create(['name' => 'create auctions']);
        Permission::create(['name' => 'place bids']);

        // Asignar permisos a roles
        $adminRole->givePermissionTo(['manage users', 'manage auctions']);
        $sellerRole->givePermissionTo(['create auctions']);
        $bidderRole->givePermissionTo(['place bids']);

        // Crear usuario administrador si no existe
        $admin = User::where('email', 'admin@example.com')->first();
        
        if (!$admin) {
            $admin = User::create([
                'name' => 'Admin',
                'email' => 'admin@plataformasubastas.com',
                'password' => bcrypt('password'),
            ]);
        }

        // Asignar rol de administrador
        $admin->assignRole('admin');
    }
}
