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
                'semestres.ver',
                'carpetas.ver',
                'documentos.ver',
                'documentos.descargar',
            ]);
    }
}
