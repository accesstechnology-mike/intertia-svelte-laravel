<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use App\Models\User;

class PermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // create permissions
        $arrayOfPermissionNames = [
            //clients
            'create clients',
            'read clients',
            'update clients',
            'delete clients',
            //invoices
            'export invoices',
            //expenses
            'create expenses',
            'read expenses',
            'update expenses',
            'delete expenses',
            //addresses
            'create addresses',
            'read addresses',
            'update addresses',
            'delete addresses',
            //logs
            'create logs',
            'read logs',
            'update logs',
            'delete logs',
            //users
            'create users',
            'read users',
            'update users',
            'delete users',
            //contacts
            'create contacts',
            'read contacts',
            'update contacts',
            'delete contacts',
        ];

        $permissions = collect($arrayOfPermissionNames)->map(function (
            $permission
        ) {
            return [
                'name' => $permission,
                'guard_name' => 'web',
            ];
        });

        Permission::insert($permissions->toArray());

        // create roles and assign existing permissions
        Role::create(['name' => 'super admin'])->givePermissionTo(
            Permission::all()
        );

        Role::create(['name' => 'director'])->givePermissionTo(
            Permission::all()
        );

        Role::create(['name' => 'admin'])->givePermissionTo(
            Permission::all()
        );

        Role::create(['name' => 'senior at consultant'])->givePermissionTo(
            Permission::all()
        );

        Role::create(['name' => 'at consultant'])->givePermissionTo(
            Permission::all()
        );

        Role::create(['name' => 'at assistant'])->givePermissionTo(
            Permission::all()
        );

        Role::create(['name' => 'at technician'])->givePermissionTo(
            Permission::all()
        );

        User::find(1)->assignRole('super admin');
    }
}
