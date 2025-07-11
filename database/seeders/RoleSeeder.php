<?php

namespace Database\Seeders;

use App\Enums\PermissionEnum;
use App\Enums\RoleEnum;
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

        $permissions = PermissionEnum::cases();

        $roles = RoleEnum::cases();

        foreach ($roles as $role) {
            $createdRole = Role::create([
                'name' => $role->value,
            ]);

            if ($createdRole->name == RoleEnum::SUPER_ADMIN->value) {
                foreach ($permissions as $permission) {
                    $createdRole->givePermissionTo($permission);
                }
            }
        }
    }
}
