<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        app(PermissionRegistrar::class)->forgetCachedPermissions();

        $permissions = [
            'dashboard.ver',
            'explorer.view',
            'folders.create',
            'folders.rename',
            'folders.delete',
            'folders.restore',
            'folders.move',
            'documents.upload',
            'documents.rename',
            'documents.delete',
            'documents.restore',
            'documents.move',
            'documents.download',
            'documents.preview',
            'trash.view',
            'users.view',
            'users.create',
            'users.edit',
            'users.delete',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission, 'guard_name' => 'web']);
        }

        Role::firstOrCreate(['name' => 'Administrador', 'guard_name' => 'web'])
            ->syncPermissions($permissions);

        Role::firstOrCreate(['name' => 'Docente', 'guard_name' => 'web'])
            ->syncPermissions([
                'dashboard.ver',
                'explorer.view',
                'folders.create',
                'folders.rename',
                'folders.delete',
                'folders.restore',
                'folders.move',
                'documents.upload',
                'documents.rename',
                'documents.delete',
                'documents.restore',
                'documents.move',
                'documents.download',
                'documents.preview',
                'trash.view',
            ]);

        Role::firstOrCreate(['name' => 'Estudiante', 'guard_name' => 'web'])
            ->syncPermissions([
                'explorer.view',
                'documents.download',
                'documents.preview',
            ]);
    }
}
