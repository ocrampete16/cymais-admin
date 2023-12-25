<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Enums\Permission;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class DatabaseSeeder extends Seeder
{
    public function __construct(private PermissionRegistrar $permissionRegistrar)
    {
    }

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->permissionRegistrar->forgetCachedPermissions();

        $role = Role::create(['name' => 'admin']);
        $role->givePermissionTo(Permission::APPROVE_USER_REGISTRATION);
        $role->givePermissionTo(Permission::ADD_USER);
        $role->givePermissionTo(Permission::REMOVE_USER);
    }
}
