<?php

namespace Database\Seeders;

use App\Enums\PermissionsEnum;
use App\Enums\RolesEnum;
use App\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\PermissionRegistrar;

class RoleSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        $permissions = PermissionsEnum::cases();

        $roles = RolesEnum::cases();

        foreach ($roles as $role) {
            $createdRole = Role::create([
                'name' => $role->value,
            ]);

            if ($createdRole->name == RolesEnum::SUPER_ADMIN->value) {
                foreach ($permissions as $permission) {
                    $createdRole->givePermissionTo($permission);
                }
            }
        }
    }
}
