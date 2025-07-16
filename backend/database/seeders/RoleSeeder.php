<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create admin role for sanctum guard if it doesn't exist
        $adminRole = Role::firstOrCreate(['name' => 'admin', 'guard_name' => 'sanctum']);
        
        // Create basic permissions for sanctum guard if they don't exist
        $permissions = [
            'view users',
            'manage users',
            'view sensors',
            'manage sensors'
        ];
        
        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission, 'guard_name' => 'sanctum']);
        }
        
        // Assign all permissions to admin role
        $adminRole->givePermissionTo($permissions);
        
        $this->command->info('Roles and permissions seeded successfully for sanctum guard!');
    }
} 