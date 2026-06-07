<?php

namespace Database\Seeders;

use App\Models\Folder;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class InitialDataSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::firstOrCreate(
            ['email' => 'admin@institucion.edu'],
            ['name' => 'Administrador', 'password' => Hash::make('password')]
        );

        $admin->assignRole('Administrador');

        $this->seedFolderTree($admin->id);
    }

    private function seedFolderTree(int $userId): void
    {
        $root = Folder::firstOrCreate(
            ['parent_id' => null, 'name' => 'UEA'],
            ['description' => 'Repositorio documental academico', 'created_by' => $userId]
        );

        $semesters = [
            'PRIMER_SEMESTRE' => [],
            'SEGUNDO_SEMESTRE' => [],
            'TERCER_SEMESTRE' => [
                'FUNDAMENTOS_DIGITALES' => ['PROYECTOS', 'TAREAS', 'EXAMENES', 'ARCHIVOS'],
                'ESTRUCTURA_DATOS' => [],
                'METODOLOGIA' => [],
                'INSTALACION_ELECTRICA_REDES' => [],
                'AD_SIS_OPER' => [],
            ],
            'CUARTO_SEMESTRE' => [],
            'QUINTO_SEMESTRE' => [],
            'SEXTO_SEMESTRE' => [],
        ];

        foreach ($semesters as $semesterName => $subjects) {
            $semester = Folder::firstOrCreate(
                ['parent_id' => $root->id, 'name' => $semesterName],
                ['created_by' => $userId]
            );

            foreach ($subjects as $subjectName => $children) {
                $subject = Folder::firstOrCreate(
                    ['parent_id' => $semester->id, 'name' => $subjectName],
                    ['created_by' => $userId]
                );

                foreach ($children as $childName) {
                    Folder::firstOrCreate(
                        ['parent_id' => $subject->id, 'name' => $childName],
                        ['created_by' => $userId]
                    );
                }
            }
        }
    }
}
