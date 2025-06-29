<?php

namespace Database\Seeders;

use App\Enums\PermissionsEnum;
use App\Models\Permission;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PermissionSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissions = PermissionsEnum::cases();

        foreach ($permissions as $permission) {
            Permission::create([
                'name' => $permission->value,
            ]);
        }
    }
}
