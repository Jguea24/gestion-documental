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
            'semestres.ver',
            'semestres.crear',
            'semestres.editar',
            'semestres.eliminar',
            'carpetas.ver',
            'carpetas.crear',
            'carpetas.editar',
            'carpetas.eliminar',
            'documentos.ver',
            'documentos.crear',
            'documentos.editar',
            'documentos.eliminar',
            'documentos.descargar',
            'usuarios.ver',
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
                'semestres.ver',
                'carpetas.ver',
                'carpetas.crear',
                'carpetas.editar',
                'documentos.ver',
                'documentos.crear',
                'documentos.editar',
                'documentos.descargar',
            ]);

        Role::firstOrCreate(['name' => 'Estudiante', 'guard_name' => 'web'])
            ->syncPermissions([
                'dashboard.ver',
                'explorer.view',
                'documents.download',
                'documents.preview',
                'semestres.ver',
                'carpetas.ver',
                'documentos.ver',
                'documentos.descargar',
            ]);
    }
}
